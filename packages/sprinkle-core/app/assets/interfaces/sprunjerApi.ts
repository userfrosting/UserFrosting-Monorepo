import type { AssociativeArray, SprunjerListable } from '.'

/**
 * Sprunje API Interfaces - What the API expects and what it returns.
 */

/**
 * Sprunjer Response. All the data that is returned from any Sprunjer API.
 * Note listable, sortable and filterable are optional when dealing with the API.
 *
 * N.B.: "rows" uses a generic array. It can contain any object, and should
 * actually be can be extended for each Sprunjer
 */
export interface SprunjerResponse {
    count: number
    count_filtered: number
    rows: any[]
    listable?: SprunjerListable
    sortable?: string[]
    filterable?: string[]
}

/**
 * Sprunjer Request. All the parameters that can be passed to a Sprunjer.
 * All parameters are optional.
 */
export interface SprunjerRequest {
    size?: number
    page?: number
    sorts?: AssociativeArray
    filters?: AssociativeArray
    format?: string
}
