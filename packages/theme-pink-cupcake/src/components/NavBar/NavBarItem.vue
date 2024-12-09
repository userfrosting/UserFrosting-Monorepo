<script setup lang="ts">
/**
 * Allow external + internal links in same component, plus add active class to
 * li instead of a element
 * @see https://router.vuejs.org/guide/advanced/extending-router-link
 */
import { computed } from 'vue'
import { RouterLink } from 'vue-router'

const props = withDefaults(
    defineProps<{
        to?: string | { name: string }
        label?: string
    }>(),
    {
        to: '',
        label: ''
    }
)

const isExternalLink = computed(() => {
    return props.to === '' || (typeof props.to === 'string' && props.to.startsWith('http'))
})
</script>

<template>
    <li v-if="isExternalLink">
        <a :href="to.toString()" target="_blank">
            <slot>{{ label }}</slot>
        </a>
    </li>
    <RouterLink v-else :to="to" v-bind="$props" custom v-slot="{ isActive, href, navigate }">
        <li :class="{ 'uk-active': isActive }">
            <a v-bind="$attrs" :href="href" @click="navigate">
                <slot>{{ label }}</slot>
            </a>
        </li>
    </RouterLink>
</template>
