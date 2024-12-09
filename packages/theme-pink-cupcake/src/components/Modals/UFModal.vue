<script setup lang="ts">
/**
 * Modal Component
 */
import { defineProps } from 'vue'

/**
 * Emits - While not explicitly declare in the component, the modal component
 * supports UiKit's defined events.
 * @see https://getuikit.com/docs/modal#events
 *
 * - beforeshow : Fires before an item is shown.
 * - show : Fires after an item is shown.
 * - shown : Fires after the item's show animation has been completed.
 * - beforehide : Fires before an item is hidden.
 * - hide : Fires after an item's hide animation has started.
 * - hidden : Fires after an item is hidden.
 */

/**
 * Props :
 * - closable (bool; Default: false): Shows a button allowing the modal to be closed by the user
 * - escClose (bool; Default: true): Allows the modal to be closed by pressing the ESC key
 * - bgClose (bool; Default: true): Allows the modal to be closed by clicking the background
 */
defineProps({
    closable: {
        type: Boolean,
        default: false
    },
    escClose: {
        type: Boolean,
        default: true
    },
    bgClose: {
        type: Boolean,
        default: true
    }
})
</script>

<template>
    <div ref="modal" uk-modal :esc-close="escClose" :bg-close="bgClose">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close v-if="closable"></button>
            <div class="uk-modal-header" v-if="$slots.header">
                <h2 class="uk-modal-title">
                    <!-- Slot : Modal header -->
                    <slot name="header" />
                </h2>
            </div>
            <div class="uk-modal-body">
                <!-- Default Slot : Modal content -->
                <slot />
            </div>
            <div class="uk-modal-footer uk-text-right" v-if="$slots.footer">
                <!-- Slot : Modal footer -->
                <slot name="footer" />
            </div>
        </div>
    </div>
</template>
