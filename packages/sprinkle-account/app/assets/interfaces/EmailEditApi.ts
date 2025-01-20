/**
 * API Interfaces - What the API expects and what it returns
 *
 * This interface is tied to the `ProfileEmailEditAction` API, accessed at the
 * POST `/account/settings/email` endpoint.
 *
 * This api doesn't have a corresponding Response data interface.
 * The General API Response interface is used.
 */
// TODO : Email should be it's own form
export interface EmailEditRequest {
    email: string
    passwordcheck: string
}
