/**
 * Interfaces - What the API expects and what it returns
 */
export interface GroupCreateForm {
    slug: string
    name: string
    description: string
    icon: string
}

export interface GroupCreateResponse {
    success: boolean
    message: string
    group: GroupCreateForm
}
