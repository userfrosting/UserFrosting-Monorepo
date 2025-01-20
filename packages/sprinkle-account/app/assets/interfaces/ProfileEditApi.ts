/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `ProfileEditAction` API, accessed at the
 * POST `/account/settings/profile` endpoint.
 *
 * This api doesn't have a corresponding Response data interface.
 * The General API Response interface is used.
 */
export interface ProfileEditRequest {
    first_name: string
    last_name: string
    locale: string
}
