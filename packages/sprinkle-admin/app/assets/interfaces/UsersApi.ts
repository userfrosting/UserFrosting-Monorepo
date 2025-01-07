import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'
import type { SprunjerResponse } from '@userfrosting/sprinkle-core/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `UsersSprunjeAction` API, accessed at the
 * GET `/api/users` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface UsersSprunjerResponse extends Omit<SprunjerResponse, 'rows'> {
    rows: UserInterface[]
}
