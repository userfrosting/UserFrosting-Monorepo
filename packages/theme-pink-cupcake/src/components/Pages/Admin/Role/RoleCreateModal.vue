<script setup lang="ts">
import UIkit from 'uikit'
import { ref } from 'vue'
import { useTranslator } from '@userfrosting/sprinkle-core/stores'
import { useRoleCreateApi } from '@userfrosting/sprinkle-admin/composables'
import type { RoleCreateRequest } from '@userfrosting/sprinkle-admin/interfaces'
import RoleForm from './RoleForm.vue'

/**
 * Variables - Copy the group data to a reactive variable.
 */
const formData = ref<RoleCreateRequest>({
    name: '',
    slug: '',
    description: ''
})

/**
 * API - Use the group edit API.
 */
const { submitRoleCreate } = useRoleCreateApi()

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Methods - Submit the form to the API and handle the response.
 */
const submitForm = () => {
    submitRoleCreate(formData.value)
        .then((response) => {
            // Emit the saved event
            emits('saved')

            // Close the modal
            UIkit.modal('#modal-role-create').hide()

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
            const { translate } = useTranslator()
            UIkit.notification({
                message: error.description ?? translate('ERROR.MISC'),
                status: 'danger',
                pos: 'top-right',
                timeout: 4000
            })
        })
}
</script>

<template>
    <a v-bind="$attrs" :uk-toggle="'target: #modal-role-create'">
        <slot><font-awesome-icon icon="plus" /> {{ $t('ROLE.CREATE') }}</slot>
    </a>

    <!-- This is the modal -->
    <UFModal id="modal-role-create" closable>
        <template #header>{{ $t('ROLE.CREATE') }}</template>
        <template #default>
            <RoleForm v-model="formData" @submit="submitForm()" />
        </template>
    </UFModal>
</template>
