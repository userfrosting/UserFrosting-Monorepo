import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Interfaces - What the API expects and what it returns
 */
export interface UserEditRequest {
    user_name: string
    group_id: number | null
    first_name: string
    last_name: string
    email: string
    locale: string
}

export interface UserEditResponse {
    success: boolean
    message: string
    user: UserInterface
}
