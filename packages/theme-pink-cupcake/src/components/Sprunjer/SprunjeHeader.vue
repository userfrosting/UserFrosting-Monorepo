<script setup lang="ts">
import { inject } from 'vue'
import type { Sprunjer } from '@userfrosting/sprinkle-core/interfaces'

defineProps<{
    sort?: string
}>()

const sprunjer = inject('sprunjer') as Sprunjer
const { sorts, toggleSort } = sprunjer
</script>

<template>
    <th class="uk-table-link uk-padding-small" v-if="sort">
        <a class="uk-link-reset" @click="toggleSort(sort)">
            <slot />
            <font-awesome-icon
                v-if="sorts[sort] === 'asc'"
                :icon="['fas', 'sort-up']"
                fixed-width
                class="uk-align-right uk-margin-remove" />
            <font-awesome-icon
                v-else-if="sorts[sort] === 'desc'"
                :icon="['fas', 'sort-down']"
                fixed-width
                class="uk-align-right uk-margin-remove" />
            <font-awesome-icon
                v-else
                :icon="['fas', 'sort']"
                fixed-width
                class="uk-align-right uk-margin-remove" />
        </a>
    </th>
    <th v-else class="uk-padding-small">
        <slot />
    </th>
</template>
