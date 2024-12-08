<script setup lang="ts">
import { computed } from 'vue'
import { RouterLink } from 'vue-router'

const link = withDefaults(
    defineProps<{
        to: string | { name: string }
        label?: string
    }>(),
    {
        to: '',
        label: ''
    }
)

const isExternalLink = computed(() => {
    return typeof link.to === 'string' && link.to.startsWith('http')
})

// Wrap in compute to suppress a warning. An external link will alway be a string
// because of the previous computed value.
const externalLink = computed((): string => {
    return link.to as string
})

const toIsEmpty = computed(() => {
    return link.to === ''
})
</script>

<template>
    <a v-if="isExternalLink" :href="externalLink" target="_blank">
        <slot>{{ label }}</slot>
    </a>
    <div v-else-if="toIsEmpty">
        <slot>{{ label }}</slot>
    </div>
    <RouterLink v-else :to="to">
        <slot>{{ label }}</slot>
    </RouterLink>
</template>
