<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'

const emit = defineEmits(['close'])

/**
 * N.B.: This component uses a complex prop type instead of individual props
 * because the common use case for it is to display an alert from an API.
 * Using a single object makes it easier to pass data from the API.
 *
 * @see https://vuejs.org/guide/typescript/composition-api#complex-prop-types
 */
const { alert } = defineProps<{
    alert: AlertInterface
}>()

const isVisible = ref(true)

// When the alert prop changes, show the alert
watch(
    () => alert,
    () => {
        showAlert()
    }
)

/**
 * Defines style class to use
 */
const alertClass = computed(() => {
    switch (alert.style) {
        case Severity.Success: {
            return 'uk-alert-success'
        }
        case Severity.Warning: {
            return 'uk-alert-warning'
        }
        case Severity.Danger: {
            return 'uk-alert-danger'
        }
        case Severity.Info: {
            return 'uk-alert-info'
        }
        case Severity.Secondary: {
            return 'uk-alert-secondary'
        }
        case Severity.Muted: {
            return 'uk-alert-muted'
        }
        default: {
            return 'uk-alert-primary'
        }
    }
})

const iconClass = computed(() => {
    switch (alert.style) {
        case Severity.Success: {
            return 'fa-solid fa-circle-check'
        }
        case Severity.Warning: {
            return 'fa-solid fa-circle-exclamation'
        }
        case Severity.Danger: {
            return 'fa-solid fa-triangle-exclamation'
        }
        default: {
            return 'fa-solid fa-circle-info'
        }
    }
})

const closeAlert = () => {
    emit('close')
    isVisible.value = false
}

const showAlert = () => {
    isVisible.value = true
}

/**
 * TODO : Closing an alert using the button will remove the HTML from the DOM.
 * This means the component can't be reused with a different variable. If used
 * in a collection of alerts, it won't be removed from the collection.
 */
</script>

<template>
    <div :class="alertClass" class="uk-alert" uk-alert v-if="isVisible">
        <h3 v-if="alert.title" data-test="title">
            <font-awesome-icon v-if="!alert.hideIcon" :icon="iconClass" class="uk-icon" />
            {{ alert.title }}
            <a
                v-if="alert.closeBtn"
                data-test="closeBtn"
                @click="closeAlert"
                class="uk-alert-close">
                <font-awesome-icon icon="xmark" />
            </a>
        </h3>
        <p v-if="$slots.default" data-test="description">
            <slot></slot>
        </p>
        <p v-else-if="alert.description" v-html="alert.description" data-test="description"></p>
    </div>
</template>
