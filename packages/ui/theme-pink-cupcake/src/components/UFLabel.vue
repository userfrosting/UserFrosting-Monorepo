<script setup lang="ts">
import { defineProps, computed } from 'vue'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'

const { severity = '' } = defineProps<{
    severity?: Severity | keyof typeof Severity
}>()

/**
 * Defines style class to use
 */
const styleClass = computed(() => {
    switch (severity) {
        case Severity.Success: {
            return 'uk-label-success'
        }
        case Severity.Warning: {
            return 'uk-label-warning'
        }
        case Severity.Danger: {
            return 'uk-label-danger'
        }
        case Severity.Info: {
            return 'uk-label-info'
        }
        case Severity.Muted: {
            return 'uk-label-muted'
        }
        case Severity.Secondary: {
            return 'uk-label-secondary'
        }
        case Severity.Primary:
        default: {
            return 'uk-label-primary'
        }
    }
})
</script>

<template>
    <span class="uk-label" :class="styleClass">
        <slot />
    </span>
</template>
