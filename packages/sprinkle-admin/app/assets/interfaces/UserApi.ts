import type { UserInterface, GroupInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `UserApi` API, accessed at the
 * GET `/api/users/u/{user_name}` endpoint.
 *
 * This api doesn't have a corresponding Request data interface.
 */
export interface UserResponse extends UserInterface {
    locale_name: string
    group: GroupInterface | null
}
