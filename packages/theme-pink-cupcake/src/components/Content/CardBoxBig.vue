<script setup lang="ts">
defineProps({
    title: String
})
</script>

<template>
    <div class="uk-flex uk-flex-center uk-flex-middle">
        <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
            <UFCardBox>
                <template #header v-if="$slots.header || title">
                    <slot name="header">{{ title }}</slot>
                </template>
                <slot />
                <template #footer v-if="$slots.footer">
                    <slot name="footer"></slot>
                </template>
            </UFCardBox>
        </div>
    </div>
</template>
