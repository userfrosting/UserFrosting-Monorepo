<script setup lang="ts">
import { inject, computed } from 'vue'
import type { Sprunjer } from '@userfrosting/sprinkle-core/interfaces'

const props = defineProps({
    column: {
        type: String,
        required: true
    },
    label: {
        type: String
    }
})

const sprunjer = inject('sprunjer') as Sprunjer
const { filters } = sprunjer

const searchLabel = computed(() => {
    return props.label ? 'Search ' + props.label + '...' : 'Search ' + props.column + '...'
})
</script>

<template>
    <div class="uk-search uk-search-default" v-if="column">
        <input
            class="uk-search-input uk-form-small"
            type="search"
            :placeholder="searchLabel"
            aria-label="Search"
            v-model="filters[column]" />
        <span class="uk-search-icon-flip" uk-search-icon></span>
    </div>
</template>
