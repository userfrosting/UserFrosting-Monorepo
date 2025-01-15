<script setup lang="ts">
import UIkit from 'uikit'
import { defineEmits, ref, watch } from 'vue'
import { useGroupEditApi } from '@userfrosting/sprinkle-admin/composables'
import type { GroupEditRequest } from '@userfrosting/sprinkle-admin/interfaces'
import type { GroupInterface } from '@userfrosting/sprinkle-account/interfaces'
import GroupForm from './GroupForm.vue'

/**
 * Props - The group to edit.
 */
const props = defineProps<{
    group: GroupInterface
}>()

/**
 * Variables - Copy the group data to a reactive variable.
 */
const formData = ref<GroupEditRequest>({
    slug: props.group.slug,
    name: props.group.name,
    description: props.group.description,
    icon: props.group.icon
})

/**
 * Watchers - Watch for changes in the group prop and update formData
 * accordingly. Useful when the group prop is updated from the parent component,
 * or the modal is reused.
 */
watch(
    () => props.group,
    (newGroup: GroupInterface) => {
        formData.value = {
            slug: newGroup.slug,
            name: newGroup.name,
            description: newGroup.description,
            icon: newGroup.icon
        }
    },
    { deep: true }
)

/**
 * API - Use the group edit API.
 */
const { submitGroupEdit } = useGroupEditApi()

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Methods - Submit the form to the API and handle the response.
 */
const submitForm = () => {
    submitGroupEdit(props.group.slug, formData.value)
        .then((response) => {
            // Emit the saved event
            emits('saved', response.group)

            // Close the modal
            UIkit.modal('#modal-group-edit-' + props.group.slug).hide()

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
                message: error.description ?? 'An error occurred while saving the group.',
                status: 'danger',
                pos: 'top-right',
                timeout: 4000
            })
        })
}
</script>

<template>
    <a href="#" v-bind="$attrs" :uk-toggle="'target: #modal-group-edit-' + props.group.slug">
        <slot> <font-awesome-icon icon="pen-to-square" fixed-width /> Edit Group </slot>
    </a>

    <!-- This is the modal -->
    <UFModal :id="'modal-group-edit-' + props.group.slug" closable>
        <template #header> Edit Group </template>
        <template #default>
            <GroupForm v-model="formData" @submit="submitForm()" />
        </template>
    </UFModal>
</template>
