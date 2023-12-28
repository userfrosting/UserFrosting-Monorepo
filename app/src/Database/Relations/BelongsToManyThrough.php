<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use UserFrosting\Sprinkle\Core\Database\Relations\Concerns\Unique;

/**
 * A BelongsToMany relationship that queries through an additional intermediate model.
 *
 * @see https://github.com/illuminate/database/blob/10.x/Eloquent/Relations/BelongsToMany.php
 */
class BelongsToManyThrough extends BelongsToMany
{
    use Unique;

    /**
     * The relation through which we are joining.
     *
     * @var BelongsToMany
     */
    protected BelongsToMany $intermediateRelation;

    /**
     * Create a new belongs to many relationship instance.
     *
     * @param Builder                                                  $query
     * @param Model                                                    $parent
     * @param BelongsToMany                                            $intermediateRelation
     * @param string|class-string<\Illuminate\Database\Eloquent\Model> $table
     * @param string                                                   $foreignPivotKey
     * @param string                                                   $relatedPivotKey
     * @param string                                                   $parentKey
     * @param string                                                   $relatedKey
     * @param string|null                                              $relationName
     */
    public function __construct(
        Builder $query,
        Model $parent,
        BelongsToMany $intermediateRelation,
        string $table,
        string $foreignPivotKey,
        string $relatedPivotKey,
        string $parentKey,
        string $relatedKey,
        ?string $relationName = null
    ) {
        $this->intermediateRelation = $intermediateRelation;

        parent::__construct($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }

    /**
     * Use the intermediate relationship to determine the "parent" pivot key name.
     *
     * This is a crazy roundabout way to get the name of the intermediate relation's foreign key.
     * It would be better if BelongsToMany had a simple accessor for its foreign key.
     *
     * @return string
     */
    public function getParentKeyName(): string
    {
        return $this->intermediateRelation->newExistingPivot()->getForeignKey();
    }

    /**
     * Get the key for comparing against the parent key in "has" query.
     *
     * @see \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @return string
     */
    public function getExistenceCompareKey(): string
    {
        return $this->intermediateRelation->getQualifiedForeignPivotKeyName();
    }

    /**
     * Add a "via" query to load the intermediate models through which the child models are related.
     *
     * @param string|null $viaRelationName
     * @param callable    $viaCallback
     *
     * @return self
     */
    public function withVia(?string $viaRelationName = null, callable $viaCallback = null): self
    {
        $this->tertiaryRelated = $this->intermediateRelation->getRelated();

        // Set tertiary key and related model
        $this->tertiaryKey = $this->foreignPivotKey;

        $this->tertiaryRelationName = is_null($viaRelationName) ? $this->intermediateRelation->getRelationName() . '_via' : $viaRelationName;

        $this->tertiaryCallback = is_null($viaCallback)
                            ? function () {
                                //
                            }
        : $viaCallback;

        return $this;
    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param Model[] $models
     */
    // @phpstan-ignore-next-line - Issue is on Laravel's side
    public function addEagerConstraints(array $models)
    {
        // Constraint to only load models where the intermediate relation's foreign key matches the parent model
        $intermediateForeignKeyName = $this->intermediateRelation->getQualifiedForeignPivotKeyName();

        // @phpstan-ignore-next-line - Laravel limitation
        $this->query->whereIn($intermediateForeignKeyName, $this->getKeys($models));
    }

    /**
     * Set the where clause for the relation query.
     *
     * @return $this
     */
    protected function addWhereConstraints(): self
    {
        $parentKeyName = $this->getParentKeyName();

        $this->query->where(
            $parentKeyName,
            '=',
            $this->parent->getKey()
        );

        return $this;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param Model[]                $models
     * @param Collection<int, Model> $results
     * @param string                 $relation
     *
     * @return Model[]
     */
    // @phpstan-ignore-next-line - Issue is on Laravel's side
    public function match(array $models, Collection $results, $relation): array
    {
        // Build dictionary of parent (e.g. user) to related (e.g. permission) models
        list($dictionary, $nestedViaDictionary) = $this->buildDictionary($results, $this->getParentKeyName());

        // Once we have an array dictionary of child objects we can easily match the
        // children back to their parent using the dictionary and the keys on the
        // the parent models. Then we will return the hydrated models back out.
        foreach ($models as $model) {
            if (isset($dictionary[$key = $model->getKey()])) {
                /** @var Model[] */
                $items = $dictionary[$key];

                // Eliminate any duplicates
                $items = $this->related->newCollection($items)->unique();

                // If set, match up the via models to the models in the related collection
                if (!is_null($nestedViaDictionary)) {
                    $this->matchTertiaryModels($nestedViaDictionary[$key], $items);
                }

                // Remove the tertiary pivot key from the condensed models
                foreach ($items as $relatedModel) {
                    // @phpstan-ignore-next-line
                    unset($relatedModel->pivot->{$this->foreignPivotKey});
                }

                $model->setRelation(
                    $relation,
                    $items
                );
            }
        }

        return $models;
    }

    /**
     * Unset tertiary pivots on a collection or array of models.
     *
     * @param Collection<int, Model> $models
     */
    protected function unsetTertiaryPivots(Collection $models): void
    {
        foreach ($models as $model) {
            // @phpstan-ignore-next-line
            unset($model->pivot->{$this->foreignPivotKey});
        }
    }

    /**
     * Set the join clause for the relation query.
     *
     * @param Builder|null $query
     *
     * @return $this
     */
    protected function performJoin($query = null): self
    {
        $query = $query ?? $this->query;

        parent::performJoin($query);

        // We need to join to the intermediate table on the related model's primary
        // key column with the intermediate table's foreign key for the related
        // model instance. Then we can set the "where" for the parent models.
        $intermediateTable = $this->intermediateRelation->getTable();

        $key = $this->intermediateRelation->getQualifiedRelatedPivotKeyName();

        // @phpstan-ignore-next-line - Laravel magic functions
        $query->join($intermediateTable, $key, '=', $this->getQualifiedForeignPivotKeyName());

        return $this;
    }

    /**
     * Get the pivot columns for the relation.
     *
     * "pivot_" is prefixed to each column for easy removal later.
     *
     * @return string[]
     */
    protected function aliasedPivotColumns(): array
    {
        $defaults = [$this->foreignPivotKey, $this->relatedPivotKey];
        $aliasedPivotColumns = collect(array_merge($defaults, $this->pivotColumns))->map(function ($column) {
            return $this->table . '.' . $column . ' as pivot_' . $column;
        });

        $parentKeyName = $this->getParentKeyName();

        // Add pivot column for the intermediate relation
        $aliasedPivotColumns[] = "{$this->intermediateRelation->getQualifiedForeignPivotKeyName()} as pivot_$parentKeyName";

        return $aliasedPivotColumns->unique()->all();
    }
}
