<script setup lang="ts">
/**
 * Modal Alert Component - A simple modal with a message and an OK button
 */
import { defineProps } from 'vue'

/**
 * Emits - While not explicitly declare in the component, the modal component
 * supports UiKit's defined events.
 * @see https://getuikit.com/docs/modal#events
 */

/**
 * Props :
 * - closable (bool; Default: false): Shows a button allowing the modal to be closed by the user
 * - escClose (bool; Default: true): Allows the modal to be closed by pressing the ESC key
 * - bgClose (bool; Default: true): Allows the modal to be closed by clicking the background
 * - icon (string; Default: 'triangle-exclamation'): Icon to display in the modal
 * - acceptIcon (string; Default: 'check'): Icon to display on the accept button. Null to disable
 * - rejectIcon (string; Default: 'xmark'): Icon to display on the reject button. Null to disable
 * - acceptLabel (string; Default: 'Confirm'): Label for the accept button
 * - rejectLabel (string; Default: 'Cancel'): Label for the reject button
 * - cancelBtn (bool; Default: true): Show the cancel button
 * - title (string; Default: 'Confirmation'): Title of the modal
 * - prompt (string; Default: 'Please confirm to proceed moving forward.'): Prompt message
 */
defineProps({
    btnLabel: {
        type: String,
        default: 'Ok'
    },
    title: {
        type: [String, null],
        default: ''
    },
    prompt: {
        type: String,
        default: 'Something happened that requires your attention.'
    }
})
</script>

<template>
    <UFModal>
        <template #header v-if="title || $slots.header">
            <slot name="header">{{ title }}</slot>
        </template>
        <slot>
            <div class="uk-text-center">{{ prompt }}</div>
        </slot>
        <template #footer>
            <slot name="footer">
                <button class="uk-button uk-button-primary uk-modal-close" type="button" autofocus>
                    {{ btnLabel }}
                </button>
            </slot>
        </template>
    </UFModal>
</template>
