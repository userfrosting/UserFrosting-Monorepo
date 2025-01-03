import type { GroupInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `GroupApi` API, accessed at the
 * GET `/api/groups/g/{slug}` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface GroupResponse extends GroupInterface {
    users_count: number
}
