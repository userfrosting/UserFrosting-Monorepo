<script setup lang="ts">
/**
 * Modal Alert Component - A simple modal with a message and an OK button
 */
import { useTemplateRef } from 'vue'

/**
 * Emits - While not explicitly declare in the component, the modal component
 * supports UiKit's defined events.
 * @see https://getuikit.com/docs/modal#events
 */

/**
 * Prompt value. Use this to get the value of the input field. It can also be
 * used to set the default value of the input field. N.B.: This field is **not**
 * reset when the modal is shown/closed. It is the responsibility of the parent
 * component to reset the value (e.g. using the 'show' event) if needed.
 */
const value = defineModel()

/**
 * Props :
 * - btnLabel (string; Default: 'Ok'): Label for the main button
 * - title (string; Default: ''): Title of the modal
 * - prompt (string; Default: ''): Prompt message
 * - placeholder (string; Default: ''): Placeholder for the input field
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
        default: ''
    },
    placeholder: {
        type: String,
        default: ''
    }
})

/**
 * Hacky way to close the modal when the user presses enter in the input field.
 * Reference the button element using a template ref, and trigger a click event
 * when the user presses enter.
 */
const okBtn = useTemplateRef('ok-btn')
function submitPrompt() {
    if (okBtn.value) {
        okBtn.value.click()
    }
}
</script>

<template>
    <UFModal>
        <template #header v-if="title || $slots.header">
            <slot name="header">{{ title }}</slot>
        </template>
        <slot>
            <form class="uk-form-stacked" @submit="submitPrompt()">
                <label class="uk-form-label" for="prompt-text">{{ prompt }}</label>
                <div class="uk-form-controls">
                    <input
                        type="text"
                        class="uk-input"
                        id="prompt-text"
                        :placeholder="placeholder"
                        v-model="value"
                        autofocus
                        tabindex="1" />
                </div>
            </form>
        </slot>
        <template #footer>
            <slot name="footer">
                <button
                    class="uk-button uk-button-primary uk-modal-close"
                    type="button"
                    tabindex="2"
                    ref="ok-btn">
                    {{ btnLabel }}
                </button>
            </slot>
        </template>
    </UFModal>
</template>
