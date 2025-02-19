<script setup lang="ts">
import UIkit from 'uikit'
import { useUserDeleteApi } from '@userfrosting/sprinkle-admin/composables'
import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'

// Variables
const { deleteUser } = useUserDeleteApi()

// Props
const props = defineProps<{
    user: UserInterface
}>()

// Emits
const emits = defineEmits(['deleted'])

// Methods
const deleteConfirmed = () => {
    deleteUser(props.user.user_name)
        .then((response) => {
            emits('deleted')
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
    <a href="#" v-bind="$attrs" :uk-toggle="'target: #confirm-user-delete-' + props.user.user_name">
        <slot><font-awesome-icon icon="trash" fixed-width /> {{ $t('USER.DELETE') }}</slot>
    </a>

    <!-- This is the modal -->
    <UFModalConfirmation
        :id="'confirm-user-delete-' + props.user.user_name"
        title="USER.DELETE"
        @confirmed="deleteConfirmed()"
        acceptLabel="USER.DELETE"
        acceptIcon="trash"
        :rejectIcon="null"
        :acceptSeverity="Severity.Danger">
        <template #prompt>
            <div v-html="$t('USER.DELETE_CONFIRM', props.user)"></div>
        </template>
    </UFModalConfirmation>
</template>
