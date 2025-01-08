import type { PermissionInterface } from '@userfrosting/sprinkle-account/interfaces'
import type { SprunjerResponse } from '@userfrosting/sprinkle-core/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `PermissionsSprunje` API, accessed at the
 * GET `/api/permissions` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface PermissionSprunjeResponse extends Omit<SprunjerResponse, 'rows'> {
    rows: PermissionInterface[]
}
