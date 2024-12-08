<script setup lang="ts">
export interface Props {
    label?: string
}

withDefaults(defineProps<Props>(), {
    label: ''
})
</script>

<template>
    <li>
        <a data-test="label">
            <slot name="label">{{ label }}</slot> <span uk-navbar-parent-icon></span>
        </a>
        <div class="uk-navbar-dropdown" uk-dropdown="offset: 0px">
            <ul class="uk-nav uk-navbar-dropdown-nav" data-test="slot">
                <slot></slot>
            </ul>
        </div>
    </li>
</template>
