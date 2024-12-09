<script setup lang="ts">
withDefaults(
    defineProps<{
        title: string
        caption?: string
    }>(),
    {
        caption: ''
    }
)
</script>

<template>
    <div class="uf-page-header">
        <h3 class="uk-margin-remove">{{ title }}</h3>
        <p v-if="caption" class="uk-text-meta uk-margin-remove">{{ caption }}</p>
    </div>
</template>
