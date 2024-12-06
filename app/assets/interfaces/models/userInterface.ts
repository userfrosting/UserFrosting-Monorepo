/**
 * User Model
 *
 * By default, the frontend user will have the same interface as the PHP user.
 * Note that any Sprinkle can (and should!) extend this interface.
 *
 * Example:
 * - id: 1
 * - user_name: "admin"
 * - first_name: "Admin"
 * - last_name: "Istrator"
 * - full_name: "Admin Istrator"
 * - email: "charette.louis@gmail.com"
 * - avatar: "https://www.gravatar.com/avatar/e309fbab15a5420dbd7cb41e9273cf29?d=mm"
 * - flag_enabled: true
 * - flag_verified: true
 * - group_id: null
 * - locale: "en_US"
 * - created_at: "2023-09-16T19:23:59.000000Z"
 * - updated_at: "2023-09-16T19:23:59.000000Z"
 * - deleted_at: null
 */
export interface UserInterface {
    id: number
    user_name: string
    first_name: string
    last_name: string
    full_name: string
    email: string
    avatar: string
    flag_enabled: boolean
    flag_verified: boolean
    group_id: number | null
    locale: string
    created_at: Date | string
    updated_at: Date | string
    deleted_at: Date | string | null
}
