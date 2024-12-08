/**
 * Sprunjer Interface
 *
 * Represents the interface for the Sprunjer composable.
 */
import type { Ref, ComputedRef } from 'vue'
import type { AssociativeArray } from '../interfaces'

export interface Sprunjer {
    dataUrl: any
    size: Ref<number>
    page: Ref<number>
    sorts: Ref<AssociativeArray>
    filters: Ref<AssociativeArray>
    data: Ref<any>
    fetch: () => void
    loading: Ref<boolean>
    totalPages: ComputedRef<number>
    downloadCsv: () => void
    countFiltered: ComputedRef<number>
    count: ComputedRef<number>
    rows: ComputedRef<any[]>
    first: ComputedRef<number>
    last: ComputedRef<number>
    toggleSort: (column: string) => void
}
