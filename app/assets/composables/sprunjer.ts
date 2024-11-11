import { ref, toValue, watchEffect, computed, type Ref, type ComputedRef } from 'vue'
import axios from 'axios'

interface AssociativeArray {
    [key: string]: string | null
}

interface Sprunjer {
    dataUrl: any
    size: Ref<number>
    page: Ref<number>
    totalPages: ComputedRef<number>
    countFiltered: ComputedRef<number>
    first: ComputedRef<number>
    last: ComputedRef<number>
    sorts: Ref<AssociativeArray>
    filters: Ref<AssociativeArray>
    data: Ref<any>
    loading: Ref<boolean>
    count: ComputedRef<number>
    rows: ComputedRef<any>
    fetch: () => void
    toggleSort: (column: string) => void
    downloadCsv: () => void
}

const useSprunjer = (
    dataUrl: any,
    defaultSorts: AssociativeArray = {},
    defaultFilters: AssociativeArray = {},
    defaultSize: number = 10,
    defaultPage: number = 0
) => {
    // Sprunje parameters
    const size = ref<number>(defaultSize)
    const page = ref<number>(defaultPage)
    const sorts = ref<AssociativeArray>(defaultSorts)
    const filters = ref<AssociativeArray>(defaultFilters)

    // Raw data
    const data = ref<any>({})

    // State
    const loading = ref<boolean>(false)

    /**
     * Api fetch function
     */
    async function fetch() {
        loading.value = true
        axios
            .get(toValue(dataUrl), {
                params: {
                    size: size.value,
                    page: page.value,
                    sorts: sorts.value,
                    filters: filters.value
                }
            })
            .then((response) => {
                data.value = response.data
                loading.value = false
            })
            .catch((err) => {
                // TODO : User toast alert, or export alert
                console.error(err)
            })
    }

    /**
     * Computed properties
     */
    const totalPages = computed(() => {
        // N.B.: Sprunjer page starts at 0, not 1
        // Make sure page is never negative
        return Math.max(Math.ceil((data.value.count_filtered ?? 0) / size.value) - 1, 0)
    })

    const count = computed(() => {
        return data.value.count ?? 0
    })

    const first = computed(() => {
        return Math.min(page.value * size.value + 1, data.value.count ?? 0)
    })

    const last = computed(() => {
        return Math.min((page.value + 1) * size.value, data.value.count_filtered ?? 0)
    })

    const countFiltered = computed(() => {
        return data.value.count_filtered ?? 0
    })

    const rows = computed(() => {
        return data.value.rows ?? []
    })

    /**
     * Download the data as a CSV file
     */
    function downloadCsv() {
        console.log('Not yet implemented')
    }

    /**
     * Apply sorting to a column, cycling from the previous sort order.
     * Order goes : asc -> desc -> null -> asc
     * Used to toggle the sort order of a column when the column header is clicked
     * @param column The column to sort
     */
    function toggleSort(column: string) {
        let newOrder: string | null
        if (sorts.value[column] === 'asc') {
            newOrder = 'desc'
        } else if (sorts.value[column] === 'desc') {
            newOrder = null
        } else {
            newOrder = 'asc'
        }

        sorts.value[column] = newOrder
    }

    /**
     * Automatically fetch the data when any parameters change
     */
    watchEffect(() => {
        fetch()
    })

    /**
     * Export the functions and data
     */
    return {
        dataUrl,
        size,
        page,
        sorts,
        filters,
        data,
        fetch,
        loading,
        downloadCsv,
        totalPages,
        countFiltered,
        count,
        rows,
        first,
        last,
        toggleSort
    }
}

export { useSprunjer, type Sprunjer, type AssociativeArray }
