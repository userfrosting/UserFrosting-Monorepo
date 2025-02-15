<script setup lang="ts">
import type { PermissionResponse } from '@userfrosting/sprinkle-admin/interfaces'

const { permission } = defineProps<{
    permission: PermissionResponse
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
            <dt>{{ $t('PERMISSION.ID') }}</dt>
            <dd>
                <pre><code>{{ permission.id }}</code></pre>
            </dd>
            <dt>{{ $t('SLUG') }}</dt>
            <dd>
                <pre><code>{{ permission.slug }}</code></pre>
            </dd>
            <dt>{{ $t('PERMISSION.HOOK_CONDITION') }}</dt>
            <dd>
                <pre style="text-wrap: wrap"><code>{{ permission.conditions }}</code></pre>
            </dd>
        </dl>
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
