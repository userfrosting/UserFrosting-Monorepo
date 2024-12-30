<script setup lang="ts">
import UIkit from 'uikit'
import { useUserPasswordResetApi } from '@userfrosting/sprinkle-admin/composables'
import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'

// Variables
const { passwordReset } = useUserPasswordResetApi()

// Props
const props = defineProps<{
    user: UserInterface
}>()

// Methods
const confirmed = () => {
    passwordReset(props.user.user_name)
        .then((response) => {
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
        :uk-toggle="'target: #confirm-user-reset-password-' + props.user.user_name">
        <slot><font-awesome-icon icon="key" fixed-width /> Reset Password</slot>
    </a>

    <!-- This is the modal -->
    <UFModalConfirmation
        :id="'confirm-user-reset-password-' + props.user.user_name"
        title="Confirm Action"
        @confirmed="confirmed()"
        acceptLabel="Yes"
        acceptIcon="check"
        :rejectIcon="null"
        :acceptSeverity="Severity.Danger">
        <template #prompt>
            Are you sure you want to send <strong>{{ props.user.user_name }}</strong> a link that
            will allow them to reset their password ?
        </template>
    </UFModalConfirmation>
</template>
