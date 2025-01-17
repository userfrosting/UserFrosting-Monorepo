<script setup lang="ts">
import UIkit from 'uikit'
import { useUserUpdateApi } from '@userfrosting/sprinkle-admin/composables'
import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'

// Variables
const { submitUserUpdate } = useUserUpdateApi()

// Props
const props = defineProps<{
    user: UserInterface
}>()

// Emits
const emits = defineEmits(['saved'])

// Methods
const updateUser = (fieldName: string, value: string) => {
    // Assign the field name and value to the payload
    const payload: Record<string, any> = {}
    payload[fieldName] = value

    submitUserUpdate(props.user.user_name, fieldName, payload)
        .then((response) => {
            emits('saved')
            UIkit.notification({
                message: response.message,
                status: 'success',
                pos: 'top-right',
                timeout: 4000
            })
        })
        .catch((error) => {
            UIkit.notification({
                message: error.description,
                status: 'danger',
                pos: 'top-right',
                timeout: 4000
            })
        })
}
</script>

<template>
    <a
        href="#"
        v-bind="$attrs"
        :uk-toggle="'target: #confirm-user-activate-' + props.user.user_name"
        v-if="user.flag_verified == false">
        <slot><font-awesome-icon icon="bolt" fixed-width /> Activate user</slot>
    </a>

    <a
        href="#"
        v-bind="$attrs"
        :uk-toggle="'target: #confirm-user-disable-' + props.user.user_name"
        v-else-if="user.flag_enabled">
        <slot><font-awesome-icon icon="minus-circle" fixed-width /> Disable user</slot>
    </a>

    <a
        href="#"
        v-bind="$attrs"
        :uk-toggle="'target: #confirm-user-enable-' + props.user.user_name"
        v-else>
        <slot><font-awesome-icon icon="plus-circle" fixed-width /> Enable user</slot>
    </a>

    <!-- This is the modal -->
    <UFModalConfirmation
        :id="'confirm-user-activate-' + props.user.user_name"
        title="Activate User ?"
        @confirmed="updateUser('flag_verified', '1')"
        acceptLabel="Yes, Activate User"
        acceptIcon="check"
        :rejectIcon="null"
        :acceptSeverity="Severity.Success">
        <template #prompt>
            Are you sure you want to activate <strong>{{ props.user.user_name }}</strong> ?
        </template>
    </UFModalConfirmation>

    <UFModalConfirmation
        :id="'confirm-user-disable-' + props.user.user_name"
        title="Disable User ?"
        @confirmed="updateUser('flag_enabled', '0')"
        acceptLabel="Yes, Disable User"
        acceptIcon="check"
        :rejectIcon="null"
        :acceptSeverity="Severity.Success">
        <template #prompt>
            Are you sure you want to disable <strong>{{ props.user.user_name }}</strong> ?
        </template>
    </UFModalConfirmation>

    <UFModalConfirmation
        :id="'confirm-user-enable-' + props.user.user_name"
        title="Disable User ?"
        @confirmed="updateUser('flag_enabled', '1')"
        acceptLabel="Yes, Enable User"
        acceptIcon="check"
        :rejectIcon="null"
        :acceptSeverity="Severity.Success">
        <template #prompt>
            Are you sure you want to enable <strong>{{ props.user.user_name }}</strong> ?
        </template>
    </UFModalConfirmation>
</template>
