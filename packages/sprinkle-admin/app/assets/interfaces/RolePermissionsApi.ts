import type { PermissionInterface } from '@userfrosting/sprinkle-account/interfaces'
import type { SprunjerResponse } from '@userfrosting/sprinkle-core/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `RolePermissionsSprunje` API, accessed at the
 * GET `/api/roles/r/{slug}/permissions` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface RolePermissionsSprunjeResponse extends Omit<SprunjerResponse, 'rows'> {
    rows: PermissionInterface[]
}
