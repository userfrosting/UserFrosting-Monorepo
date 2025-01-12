<script setup lang="ts">
import { usePageMeta } from '@userfrosting/sprinkle-core/composables'
const page = usePageMeta()
</script>

<template>
    <div
        class="uf-page-header"
        v-if="page.title || page.description || page.breadcrumbs.length > 1">
        <nav
            aria-label="Breadcrumb"
            v-if="page.breadcrumbs.length > 1 && page.hideBreadcrumbs === false">
            <ul class="uk-breadcrumb uk-align-right">
                <li v-for="(crumb, index) in page.breadcrumbs" :key="index">
                    <span aria-current="page" v-if="index + 1 === page.breadcrumbs.length">
                        {{ page.title }}
                    </span>
                    <router-link v-else :to="crumb.to">
                        <font-awesome-icon icon="house" fixed-width v-if="index === 0" />
                        {{ crumb.label }}
                    </router-link>
                </li>
            </ul>
        </nav>
        <h3 v-if="page.title && page.hideTitle === false" class="uk-margin-remove">
            {{ page.title }}
        </h3>
        <p
            v-if="page.description && page.hideTitle === false"
            class="uk-text-meta uk-margin-remove">
            {{ page.description }}
        </p>
    </div>
</template>
