import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Interfaces - What the API expects and what it returns
 */
export interface UserCreateRequest {
    user_name: string
    group_id: number
    first_name: string
    last_name: string
    email: string
    locale: string
}

export interface UserCreateResponse {
    success: boolean
    message: string
    user: UserInterface
}
