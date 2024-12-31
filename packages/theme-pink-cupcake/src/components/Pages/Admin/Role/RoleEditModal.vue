<script setup lang="ts">
import UIkit from 'uikit'
import { defineEmits, ref, watch } from 'vue'
import { useRoleEditApi } from '@userfrosting/sprinkle-admin/composables'
import type { RoleEditRequest } from '@userfrosting/sprinkle-admin/interfaces'
import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'
import RoleForm from './RoleForm.vue'

/**
 * Props - The role to edit.
 */
const props = defineProps<{
    role: RoleInterface
}>()

/**
 * Variables - Copy the role data to a reactive variable.
 */
const formData = ref<RoleEditRequest>({
    name: props.role.name,
    slug: props.role.slug,
    description: props.role.description
})

/**
 * Watchers - Watch for changes in the role prop and update formData
 * accordingly. Useful when the role prop is updated from the parent component,
 * or the modal is reused.
 */
watch(
    () => props.role,
    (newRole: RoleInterface) => {
        formData.value = {
            slug: newRole.slug,
            name: newRole.name,
            description: newRole.description
        }
    },
    { deep: true }
)

/**
 * API - Use the role edit API.
 */
const { submitRoleEdit } = useRoleEditApi()

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Methods - Submit the form to the API and handle the response.
 */
const submitForm = () => {
    submitRoleEdit(props.role.slug, formData.value)
        .then((response) => {
            // Emit the saved event
            emits('saved', response.role)

            // Close the modal
            UIkit.modal('#modal-role-edit-' + props.role.slug).hide()

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
                message: error.description ?? 'An error occurred while saving the role.',
                status: 'danger',
                pos: 'top-right',
                timeout: 4000
            })
        })
}
</script>

<template>
    <a href="#" v-bind="$attrs" :uk-toggle="'target: #modal-role-edit-' + props.role.slug">
        <slot> <font-awesome-icon icon="pen-to-square" fixed-width /> Edit Role </slot>
    </a>

    <!-- This is the modal -->
    <UFModal :id="'modal-role-edit-' + props.role.slug" closable>
        <template #header> Edit Role </template>
        <template #default>
            <RoleForm v-model="formData" @submit="submitForm()" />
        </template>
    </UFModal>
</template>
