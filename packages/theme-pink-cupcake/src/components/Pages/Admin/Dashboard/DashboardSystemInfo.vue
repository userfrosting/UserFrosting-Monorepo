<script lang="ts" setup>
import type { SystemInfo, SprinkleList } from '@userfrosting/sprinkle-admin/interfaces'

defineProps<{
    info: SystemInfo
    sprinkles: SprinkleList
}>()
</script>

<template>
    <UFCardBox :title="$t('SYSTEM_INFO')">
        <dl class="uk-description-list">
            <dt>{{ $t('SYSTEM_INFO.UF_VERSION') }}</dt>
            <dd>
                <pre><code>{{ info.frameworkVersion }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.PHP_VERSION') }}</dt>
            <dd>
                <pre><code>{{ info.phpVersion }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.SERVER') }}</dt>
            <dd>
                <pre><code>{{ info.server }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.DB_CONNECTION') }}</dt>
            <dd>
                <pre><code>{{ info.database.connection }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.DB_VERSION') }}</dt>
            <dd>
                <pre><code>{{ info.database.type }} {{ info.database.version }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.DB_NAME') }}</dt>
            <dd>
                <pre><code>{{ info.database.name }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.DIRECTORY') }}</dt>
            <dd>
                <pre><code>{{ info.projectPath }}</code></pre>
            </dd>

            <dt>{{ $t('SYSTEM_INFO.SPRINKLES') }}</dt>
            <dd>
                <ul class="uk-list uk-list-disc uk-list-collapse">
                    <li v-for="sprinkle in sprinkles" :key="sprinkle">
                        {{ sprinkle }}
                    </li>
                </ul>
            </dd>
        </dl>
    </UFCardBox>
</template>
