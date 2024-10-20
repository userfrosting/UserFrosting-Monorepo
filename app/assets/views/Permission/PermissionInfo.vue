<script setup lang="ts">
import type { PermissionApi } from '../../composable/permission'
import { defineProps } from 'vue'

const { permission } = defineProps<{
    permission: PermissionApi
}>()
</script>

<template>
    <UFCardBox>
        <div class="uk-text-center">
            <font-awesome-icon icon="key" class="fa-5x" />
        </div>
        <h3 class="uk-text-center uk-margin-remove">{{ permission.name }}</h3>
        <p class="uk-text-meta">
            {{ permission.description }}
        </p>
        <hr />
        <!-- TODO : Find a way to slot the description list -->
        <dl class="uk-description-list">
            <dt>Slug</dt>
            <dd>
                <pre><code>{{ permission.slug }}</code></pre>
            </dd>
            <dt>Conditions</dt>
            <dd>
                <pre style="text-wrap: wrap"><code>{{ permission.conditions }}</code></pre>
            </dd>
        </dl>
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
