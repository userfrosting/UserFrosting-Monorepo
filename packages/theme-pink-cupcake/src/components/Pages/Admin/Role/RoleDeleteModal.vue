<script setup lang="ts">
import UIkit from 'uikit'
import { useRoleDeleteApi } from '@userfrosting/sprinkle-admin/composables'
import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'

// Variables
const { deleteRole } = useRoleDeleteApi()

// Props
const props = defineProps<{
    role: RoleInterface
}>()

// Emits
const emits = defineEmits(['deleted'])

// Methods
const deleteConfirmed = () => {
    deleteRole(props.role.slug)
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
    <a href="#" v-bind="$attrs" :uk-toggle="'target: #confirm-role-delete-' + props.role.slug">
        <slot><font-awesome-icon icon="trash" fixed-width /> {{ $t('ROLE.DELETE') }}</slot>
    </a>

    <!-- This is the modal -->
    <UFModalConfirmation
        :id="'confirm-role-delete-' + props.role.slug"
        :title="$t('ROLE.DELETE')"
        @confirmed="deleteConfirmed()"
        :acceptLabel="$t('ROLE.DELETE_YES')"
        acceptIcon="trash"
        :rejectIcon="null"
        :acceptSeverity="Severity.Danger">
        <template #prompt>
            <div v-html="$t('ROLE.DELETE_CONFIRM', role)"></div>
        </template>
    </UFModalConfirmation>
</template>
