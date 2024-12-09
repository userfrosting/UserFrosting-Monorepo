<script setup lang="ts">
import { inject } from 'vue'
import type { Sprunjer } from '@userfrosting/sprinkle-core/interfaces'

interface Props {
    rowsPerPageOptions?: number[]
}

withDefaults(defineProps<Props>(), {
    rowsPerPageOptions: () => [5, 10, 20, 50]
})

const sprunjer = inject('sprunjer') as Sprunjer
const { size, page, totalPages, countFiltered, first, last } = sprunjer

function goToPage(goToPage: number) {
    page.value = goToPage
}
</script>

<template>
    <div class="uk-child-width-auto" uk-grid>
        <div class="uk-text-left uk-text-meta">
            <span>Showing {{ first }} - {{ last }} of {{ countFiltered }}</span>
        </div>
        <div class="uk-text-center uk-width-expand">
            <select
                class="uk-select uk-form-small uk-form-width-small"
                aria-label="Select per page"
                v-model="size">
                <option v-for="option in rowsPerPageOptions" :key="option" :value="option">
                    {{ option }} per page
                </option>
            </select>
        </div>
        <div class="uk-text-right">
            <nav aria-label="Pagination">
                <ul class="uk-pagination uk-flex-right" uk-margin>
                    <li>
                        <a
                            @click="goToPage(0)"
                            class="uk-icon-link"
                            :class="{ 'uk-disabled': page === 0 }">
                            <font-awesome-icon icon="angles-left" fixed-width />
                        </a>
                    </li>
                    <li>
                        <a
                            @click="goToPage(page - 1)"
                            class="uk-icon-link"
                            :class="{ 'uk-disabled': page === 0 }">
                            <font-awesome-icon icon="angle-left" fixed-width />
                        </a>
                    </li>
                    <li>Page {{ page + 1 }} of {{ totalPages + 1 }}</li>
                    <li>
                        <a
                            @click="goToPage(page + 1)"
                            class="uk-icon-link"
                            :class="{ 'uk-disabled': page === totalPages }">
                            <font-awesome-icon icon="angle-right" fixed-width />
                        </a>
                    </li>
                    <li>
                        <a
                            @click="goToPage(totalPages)"
                            class="uk-icon-link"
                            :class="{ 'uk-disabled': page === totalPages }">
                            <font-awesome-icon icon="angles-right" fixed-width />
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>
