/**
 * Interfaces - What the API expects and what it returns
 */
export interface GroupEditForm {
    slug: string
    name: string
    description: string
    icon: string
}

export interface GroupEditResponse {
    success: boolean
    message: string
    group: GroupEditForm
}
