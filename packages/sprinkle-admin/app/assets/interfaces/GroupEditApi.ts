/**
 * Interfaces - What the API expects and what it returns
 */
export interface GroupEditRequest {
    slug: string
    name: string
    description: string
    icon: string
}

export interface GroupEditResponse {
    success: boolean
    message: string
    group: GroupEditRequest
}
