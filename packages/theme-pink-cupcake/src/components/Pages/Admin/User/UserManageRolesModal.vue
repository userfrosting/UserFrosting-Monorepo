<script setup lang="ts">
import { computed, ref } from 'vue'
import UIkit from 'uikit'
import axios from 'axios'
import type { RoleInterface, UserInterface } from '@userfrosting/sprinkle-account/interfaces'
import { useUserUpdateApi } from '@userfrosting/sprinkle-admin/composables'
import type {
    RolesSprunjeResponse,
    UserRoleSprunjeResponse
} from '@userfrosting/sprinkle-admin/interfaces'

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Props - The user to edit.
 */
const { user } = defineProps<{
    user: UserInterface
}>()

/**
 * Variables - All roles, loading state and selected roles.
 */
const roles = ref<RoleInterface[]>([])
const loading = ref<boolean>(false)
const selected = ref<Number[]>([])

/**
 * Methods - Fetch roles, fetch user's roles and submit the form.
 */
// TODO : Move to a composable in Admin Sprinkle
async function fetchRoles() {
    loading.value = true
    axios
        .get<RolesSprunjeResponse>('/api/roles')
        .then((response) => {
            roles.value = response.data.rows
            fetchUserRoles()
        })
        .catch((err) => {
            loading.value = false
            // TODO : User toast alert, or export alert
            console.error(err)
        })
}

// TODO : Move to a composable in Admin Sprinkle
async function fetchUserRoles() {
    loading.value = true
    axios
        .get<UserRoleSprunjeResponse>('/api/users/u/' + user.user_name + '/roles')
        .then((response) => {
            const userRoles: RoleInterface[] = response.data.rows
            selected.value.splice(0)
            userRoles.forEach((userRole) => {
                let record = roles.value.find((element) => element.id === userRole.id)
                if (record) {
                    selected.value.push(userRole.id)
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

const { submitUserUpdate } = useUserUpdateApi()
const submitForm = () => {
    submitUserUpdate(user.user_name, 'roles', { roles: selected.value })
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
 * Computed - Check if all roles are selected and handle change of the
 * selectAll checkbox.
 */
const allSelected = computed({
    get: () => (roles.value ? selected.value.length == roles.value.length : false),
    set: (allSelected: string) => {
        selected.value.splice(0)
        if (allSelected) {
            roles.value.forEach(function (role) {
                selected.value.push(role.id)
            })
        }
    }
})

const modalName = computed(() => 'modal-user-manage-roles-' + user.user_name)
</script>

<template>
    <a v-bind="$attrs" :uk-toggle="'target: #' + modalName" @click="fetchRoles()">
        <slot><font-awesome-icon icon="address-card" /> Manage Roles</slot>
    </a>

    <!-- This is the modal -->
    <UFModal :id="modalName" class="uk-modal-container" closable>
        <template #header>Manage Roles - {{ user.full_name }}</template>
        <template #default>
            <p>The selected roles will be assigned to the user.</p>
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
                                <th>Role</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td>
                                    <input
                                        class="uk-checkbox"
                                        type="checkbox"
                                        :value="role.id"
                                        v-model="selected" />
                                </td>
                                <td>{{ role.name }}</td>
                                <td>{{ role.description }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="uk-text-right" uk-margin>
                        <button class="uk-button uk-button-default uk-modal-close" type="button">
                            Cancel
                        </button>
                        <button class="uk-button uk-button-primary" type="submit" tabindex="2">
                            Update Roles
                        </button>
                    </div>
                </fieldset>
            </form>
        </template>
    </UFModal>
</template>
