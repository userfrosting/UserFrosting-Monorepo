<script setup lang="ts">
import { inject, computed } from 'vue'
import type { Sprunjer } from '@userfrosting/sprinkle-core/interfaces'

const sprunjer = inject('sprunjer') as Sprunjer
const { data, filters } = sprunjer

const filterable = computed(() => {
    return data.value.filterable
})

const listable = computed(() => {
    return data.value.listable
})

const resetFilters = () => {
    filters.value = {}
}

const isListable = (column: string) => {
    return listable.value[column] !== undefined
}

const listableOptions = (column: string) => {
    return listable.value[column]
}
</script>

<template>
    <h3 class="uk-heading-divider">Filters</h3>
    <dl class="uk-description-list" v-for="(column, index) in filterable" :key="index">
        <dt>{{ column }}</dt>
        <dd>
            <select v-if="isListable(column)" v-model="filters[column]" class="uk-select">
                <option value=""></option>
                <option
                    v-for="option in listableOptions(column)"
                    :key="option.value"
                    :value="option.value">
                    {{ option.text }}
                </option>
            </select>
            <input
                v-else
                class="uk-input"
                type="text"
                :placeholder="column"
                v-model="filters[column]" />
        </dd>
    </dl>
    <button class="uk-button uk-button-default uk-button-small" @click="resetFilters">
        <font-awesome-icon icon="xmark" fixed-width /> Clear filters
    </button>
</template>
