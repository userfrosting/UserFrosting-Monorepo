import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `RoleCreateAction` API, accessed at the
 * POST `/api/roles` endpoint.
 */
export interface RoleCreateRequest {
    name: string
    slug: string
    description: string
}

export interface RoleCreateResponse {
    message: string
    role: RoleInterface
}
