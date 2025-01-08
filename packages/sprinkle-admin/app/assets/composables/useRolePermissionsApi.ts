import { ref } from 'vue'
import axios from 'axios'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { PermissionInterface } from '@userfrosting/sprinkle-account/interfaces'
import type { PermissionSprunjeResponse, RolePermissionsSprunjeResponse } from '../interfaces'

/**
 * API used to fetch a match between all available permissions and the role's
 * permissions, in a single component
 *
 * This API is tied to the `PermissionsSprunje` and `RolePermissionsSprunje` API,
 *  accessed at the GET `/api/permissions` and
 * `/api/roles/r/{slug}/permissions` endpoints.
 *
 * This composable accept a {roleSlug} to select the permissions of a specific
 * role.
 */
export function useRolePermissionsApi() {
    const loading = ref(false)
    const error = ref<AlertInterface | null>()
    const selected = ref<Number[]>([])
    const permissions = ref<PermissionInterface[]>([])

    // Step 1 - Fetch all permissions
    async function fetch(roleSlug: string) {
        loading.value = true
        axios
            .get<PermissionSprunjeResponse>('/api/permissions')
            .then((response) => {
                permissions.value = response.data.rows
                fetchRolePermissions(roleSlug)
            })
            .catch((err) => {
                loading.value = false
                error.value = {
                    ...{
                        description: 'An error as occurred',
                        style: Severity.Danger
                    },
                    ...err.response.data
                }
            })
    }

    // Step 2 - Fetch role permissions and match them with the permissions
    async function fetchRolePermissions(roleSlug: string) {
        axios
            .get<RolePermissionsSprunjeResponse>('/api/roles/r/' + roleSlug + '/permissions')
            .then((response) => {
                // Empty the selected array
                selected.value.splice(0)

                // Match the permissions with the role permissions
                const rolePermissions: PermissionInterface[] = response.data.rows
                rolePermissions.forEach((rolePermission) => {
                    const record = permissions.value.find(
                        (element) => element.id === rolePermission.id
                    )
                    if (record) {
                        selected.value.push(rolePermission.id)
                    }
                })
            })
            .catch((err) => {
                error.value = {
                    ...{
                        description: 'An error as occurred',
                        style: Severity.Danger
                    },
                    ...err.response.data
                }
            })
            .finally(() => {
                loading.value = false
            })
    }

    return { error, loading, fetch, selected, permissions }
}
