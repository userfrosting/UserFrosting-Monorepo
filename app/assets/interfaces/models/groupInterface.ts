/**
 * Group Model
 *
 * By default, the frontend group object will have the same interface as the PHP user.
 * Note that any Sprinkle can (and should!) extend this interface.
 *
 * Example:
 * - id: 1
 * - slug: "hippo"
 * - name: "Hippopotamus"
 * - description: "The group dedicated to the hippopotamus family."
 * - icon: "hippo"
 * - created_at: "2023-09-16T19:23:59.000000Z"
 * - updated_at: "2023-09-16T19:23:59.000000Z"
 * - deleted_at: null
 */
export interface GroupInterface {
    id: number
    slug: string
    name: string
    description: string
    icon: string
    created_at: Date | string
    updated_at: Date | string
    deleted_at: Date | string | null
}
