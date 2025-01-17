<script setup lang="ts">
import UIkit from 'uikit'
import { ref } from 'vue'
import { useUserCreateApi } from '@userfrosting/sprinkle-admin/composables'
import type { UserCreateRequest } from '@userfrosting/sprinkle-admin/interfaces'
import UserForm from './UserForm.vue'

/**
 * Variables - Copy the group data to a reactive variable.
 */
const formData = ref<UserCreateRequest>({
    user_name: '',
    group_id: 0,
    first_name: '',
    last_name: '',
    email: '',
    locale: 'users'
})

/**
 * API - Use the group edit API.
 */
const { submitUserCreate } = useUserCreateApi()

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Methods - Submit the form to the API and handle the response.
 */
const submitForm = () => {
    submitUserCreate(formData.value)
        .then((response) => {
            // Emit the saved event
            emits('saved')

            // Close the modal
            UIkit.modal('#modal-user-create').hide()

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
</script>

<template>
    <a v-bind="$attrs" :uk-toggle="'target: #modal-user-create'">
        <slot><font-awesome-icon icon="user-plus" /> Create user</slot>
    </a>

    <!-- This is the modal -->
    <UFModal id="modal-user-create" closable>
        <template #header>Create User</template>
        <template #default>
            <UserForm v-model="formData" @submit="submitForm()" />
        </template>
    </UFModal>
</template>
