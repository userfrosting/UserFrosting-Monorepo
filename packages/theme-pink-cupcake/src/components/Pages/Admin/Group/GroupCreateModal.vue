<script setup lang="ts">
import UIkit from 'uikit'
import { ref } from 'vue'
import { useTranslator } from '@userfrosting/sprinkle-core/stores'
import { useGroupCreateApi } from '@userfrosting/sprinkle-admin/composables'
import type { GroupCreateRequest } from '@userfrosting/sprinkle-admin/interfaces'
import GroupForm from './GroupForm.vue'

/**
 * Variables - Copy the group data to a reactive variable.
 */
const formData = ref<GroupCreateRequest>({
    slug: '',
    name: '',
    description: '',
    icon: 'users'
})

/**
 * API - Use the group edit API.
 */
const { submitGroupCreate } = useGroupCreateApi()

/**
 * Emits - Define the saved event. This event is emitted when the form is saved
 * to notify the parent component to refresh the data.
 */
const emits = defineEmits(['saved'])

/**
 * Methods - Submit the form to the API and handle the response.
 */
const submitForm = () => {
    submitGroupCreate(formData.value)
        .then((response) => {
            // Emit the saved event
            emits('saved')

            // Close the modal
            UIkit.modal('#modal-group-create').hide()

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
    <a v-bind="$attrs" :uk-toggle="'target: #modal-group-create'">
        <slot><font-awesome-icon icon="plus" fixed-width /> {{ $t('GROUP.CREATE') }}</slot>
    </a>

    <!-- This is the modal -->
    <UFModal id="modal-group-create" closable>
        <template #header>{{ $t('GROUP.CREATE') }}</template>
        <template #default>
            <GroupForm v-model="formData" @submit="submitForm()" />
        </template>
    </UFModal>
</template>
