<script setup lang="ts">
import { computed, ref } from 'vue'
import UIkit from 'uikit'
import axios from 'axios'
import type { PermissionInterface, RoleInterface } from '@userfrosting/sprinkle-account/interfaces'
import { useRoleUpdateApi } from '@userfrosting/sprinkle-admin/composables'

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Props - The role to edit.
 */
const props = defineProps<{
    role: RoleInterface
}>()

/**
 * Variables - All permissions, loading state and selected permissions.
 */
const permissions = ref<PermissionInterface[]>([])
const loading = ref<boolean>(false)
const selected = ref<Number[]>([])

/**
 * Methods - Fetch permissions, fetch role permissions and submit the form.
 */
// TODO : Move to a composable in Admin Sprinkle
async function fetchPermission() {
    loading.value = true
    axios
        .get('/api/permissions')
        .then((response) => {
            permissions.value = response.data.rows
            fetchRolePermissions()
        })
        .catch((err) => {
            loading.value = false
            // TODO : User toast alert, or export alert
            console.error(err)
        })
}

// TODO : Move to a composable in Admin Sprinkle
async function fetchRolePermissions() {
    loading.value = true
    axios
        .get('/api/roles/r/' + props.role.slug + '/permissions')
        .then((response) => {
            const rolePermissions: PermissionInterface[] = response.data.rows
            selected.value.splice(0)
            rolePermissions.forEach((rolePermission) => {
                let record = permissions.value.find((element) => element.id === rolePermission.id)
                if (record) {
                    selected.value.push(rolePermission.id)
                }
            })
        })
        .catch((err) => {
            // TODO : User toast alert, or export alert
            console.error(err)
        })
        .then(() => {
            loading.value = false
        })
}

const { submitRoleUpdate } = useRoleUpdateApi()
const submitForm = () => {
    submitRoleUpdate(props.role.slug, 'permissions', { permissions: selected.value })
        .then((response) => {
            // Emit the saved event
            emits('saved')

            // Close the modal
            UIkit.modal('#' + modalName.value).hide()

            // Display a success notification
            UIkit.notification({
                message: response.message,
                status: 'success',
                pos: 'top-right',
                timeout: 4000
            })
        })
        .catch((error) => {
            // Display an error notification
            UIkit.notification({
                message: error.description ?? 'An error occurred while creating the user.',
                status: 'danger',
                pos: 'top-right',
                timeout: 4000
            })
        })
}

/**
 * Computed - Check if all permissions are selected and handle change of the
 * selectAll checkbox.
 */
const allSelected = computed({
    get: () => (permissions.value ? selected.value.length == permissions.value.length : false),
    set: (allSelected: string) => {
        selected.value.splice(0)
        if (allSelected) {
            permissions.value.forEach(function (permission) {
                selected.value.push(permission.id)
            })
        }
    }
})

const modalName = computed(() => 'modal-role-manage-permission-' + props.role.slug)
</script>

<template>
    <a v-bind="$attrs" :uk-toggle="'target: #' + modalName" @click="fetchPermission()">
        <slot><font-awesome-icon icon="key" /> Manage Permissions</slot>
    </a>

    <!-- This is the modal -->
    <UFModal :id="modalName" class="uk-modal-container" closable>
        <template #header>Manage Permissions - {{ role.name }}</template>
        <template #default>
            <p>The selected permissions will be assigned to the role.</p>
            <div class="uk-text-center" v-if="loading">
                <font-awesome-icon icon="spinner" spin size="2xl" />
            </div>
            <form v-on:submit.prevent="submitForm()" v-if="!loading">
                <fieldset class="uk-fieldset uk-form-stacked">
                    <table class="uk-table uk-table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <input
                                        class="uk-checkbox"
                                        type="checkbox"
                                        v-model="allSelected" />
                                </th>
                                <th>Permission</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="permission in permissions" :key="permission.id">
                                <td>
                                    <input
                                        class="uk-checkbox"
                                        type="checkbox"
                                        :value="permission.id"
                                        v-model="selected" />
                                </td>
                                <td>{{ permission.name }}</td>
                                <td>
                                    {{ permission.description }}
                                    <!-- <div>
                                        <code>{{permission.slug}}</code>
                                    </div>
                                    <div>
                                        ↳ <code>{{permission.conditions}}</code>
                                    </div> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="uk-text-right" uk-margin>
                        <button class="uk-button uk-button-default uk-modal-close" type="button">
                            Cancel
                        </button>
                        <button class="uk-button uk-button-primary" type="submit" tabindex="2">
                            Update Permissions
                        </button>
                    </div>
                </fieldset>
            </form>
        </template>
    </UFModal>
</template>
