import { Ref, ComputedRef } from 'vue';
interface AssociativeArray {
    [key: string]: string | null;
}
interface Sprunjer {
    dataUrl: any;
    size: Ref<number>;
    page: Ref<number>;
    totalPages: ComputedRef<number>;
    countFiltered: ComputedRef<number>;
    first: ComputedRef<number>;
    last: ComputedRef<number>;
    sorts: Ref<AssociativeArray>;
    filters: Ref<AssociativeArray>;
    data: Ref<any>;
    loading: Ref<boolean>;
    count: ComputedRef<number>;
    rows: ComputedRef<any>;
    fetch: () => void;
    toggleSort: (column: string) => void;
    downloadCsv: () => void;
}
declare const useSprunjer: (dataUrl: any, defaultSorts?: AssociativeArray, defaultFilters?: AssociativeArray, defaultSize?: number, defaultPage?: number) => {
    dataUrl: any;
    size: Ref<number, number>;
    page: Ref<number, number>;
    sorts: Ref<AssociativeArray, AssociativeArray>;
    filters: Ref<AssociativeArray, AssociativeArray>;
    data: Ref<any, any>;
    fetch: () => Promise<void>;
    loading: Ref<boolean, boolean>;
    downloadCsv: () => void;
    totalPages: ComputedRef<number>;
    countFiltered: ComputedRef<any>;
    count: ComputedRef<any>;
    rows: ComputedRef<any>;
    first: ComputedRef<number>;
    last: ComputedRef<number>;
    toggleSort: (column: string) => void;
};
export { useSprunjer, type Sprunjer, type AssociativeArray };
