<script setup lang="ts">
/**
 * Modal Confirmation Component
 */
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import { useTranslator } from '@userfrosting/sprinkle-core/stores'
const { translate } = useTranslator()

/**
 * Emits - Events emitted by the component buttons. Note closing the modal with
 * backdrop click will not emit cancelled. If cancelled must be catch, disable
 * backdrop / esc close.
 * - confirmed: Emits when the user confirms the action
 * - cancelled: Emits when the user cancels the action
 *
 * While not explicitly declare in the component, the modal component alse
 * supports UiKit's defined events.
 * @see https://getuikit.com/docs/modal#events
 */
defineEmits(['confirmed', 'cancelled'])

/**
 * Props :
 * - closable (bool; Default: false): Shows a button allowing the modal to be closed by the user
 * - escClose (bool; Default: true): Allows the modal to be closed by pressing the ESC key
 * - bgClose (bool; Default: true): Allows the modal to be closed by clicking the background
 * - icon (string; Default: 'triangle-exclamation'): Icon to display in the modal. Null to disable
 * - acceptIcon (string; Default: 'check'): Icon to display on the accept button. Null to disable
 * - rejectIcon (string; Default: 'xmark'): Icon to display on the reject button. Null to disable
 * - acceptLabel (string; Default: 'Confirm'): Label for the accept button
 * - rejectLabel (string; Default: 'Cancel'): Label for the reject button
 * - cancelBtn (bool; Default: true): Show the cancel button
 * - acceptSeverity (Severity; Default: Severity.Primary): Severity of the accept button
 * - rejectSeverity (Severity; Default: Severity.Default): Severity of the reject button
 * - title (string; Default: 'Confirmation'): Title of the modal
 * - prompt (string; Default: 'Please confirm to proceed moving forward.'): Prompt message
 */
interface Props {
    closable?: boolean
    escClose?: boolean
    bgClose?: boolean
    icon?: string | null
    acceptIcon?: string | null
    rejectIcon?: string | null
    acceptLabel?: string
    rejectLabel?: string
    acceptSeverity?: Severity
    rejectSeverity?: Severity
    cancelBtn?: boolean
    title?: string | null
    prompt?: string
}
const {
    closable = false,
    escClose = true,
    bgClose = true,
    icon = 'triangle-exclamation',
    acceptIcon = 'check',
    rejectIcon = 'xmark',
    acceptLabel = 'CONFIRM',
    rejectLabel = 'CANCEL',
    acceptSeverity = Severity.Primary,
    rejectSeverity = Severity.Default,
    cancelBtn = true,
    title = 'CONFIRMATION',
    prompt = 'CONFIRM_ACTION'
} = defineProps<Props>()

/**
 * Translates the severity props to a button class
 */
const btnClass = (severity: Severity) => {
    switch (severity) {
        case Severity.Success: {
            return 'uk-button-success'
        }
        case Severity.Warning: {
            return 'uk-button-warning'
        }
        case Severity.Danger: {
            return 'uk-button-danger'
        }
        case Severity.Info: {
            return 'uk-button-info'
        }
        case Severity.Secondary: {
            return 'uk-button-secondary'
        }
        case Severity.Muted: {
            return 'uk-button-muted'
        }
        case Severity.Primary: {
            return 'uk-button-primary'
        }
        default: {
            return 'uk-button-default'
        }
    }
}
</script>

<template>
    <UFModal :closable="closable" :bgClose="bgClose" :escClose="escClose">
        <template #header v-if="title || $slots.header">
            <slot name="header">{{ $t(title) }}</slot>
        </template>
        <slot>
            <div class="uk-text-center">
                <p v-if="icon"><font-awesome-icon :icon="icon" class="uk-text-warning fa-4x" /></p>
                <slot name="prompt">{{ $t(prompt) }}</slot>
            </div>
        </slot>
        <template #footer>
            <slot name="footer">
                <button
                    class="uk-button uk-modal-close"
                    :class="btnClass(rejectSeverity)"
                    type="button"
                    @click="$emit('cancelled')"
                    v-if="cancelBtn">
                    <font-awesome-icon :icon="rejectIcon" v-if="rejectIcon" /> {{ $t(rejectLabel) }}
                </button>
                <button
                    class="uk-button uk-modal-close"
                    :class="btnClass(acceptSeverity)"
                    type="button"
                    @click="$emit('confirmed')"
                    autofocus>
                    <font-awesome-icon :icon="acceptIcon" v-if="acceptIcon" /> {{ $t(acceptLabel) }}
                </button>
            </slot>
        </template>
    </UFModal>
</template>
