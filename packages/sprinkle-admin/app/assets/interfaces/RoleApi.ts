import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `RoleApi` API, accessed at the
 * GET `/api/roles/r/{slug}` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface RoleResponse extends RoleInterface {
    users_count: number
}
