import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'
import type { SprunjerResponse } from '@userfrosting/sprinkle-core/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `RolesSprunje` API, accessed at the
 * GET `/api/roles` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface RolesSprunjeResponse extends Omit<SprunjerResponse, 'rows'> {
    rows: RoleInterface[]
}
