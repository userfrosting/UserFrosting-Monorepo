import type { GroupInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Interfaces - What the API expects and what it returns
 */
export interface GroupCreateRequest {
    slug: string
    name: string
    description: string
    icon: string
}

export interface GroupCreateResponse {
    success: boolean
    message: string
    group: GroupInterface
}
