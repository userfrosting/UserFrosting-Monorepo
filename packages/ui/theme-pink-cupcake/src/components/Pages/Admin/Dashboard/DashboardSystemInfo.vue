<script lang="ts" setup>
import type { SystemInfo, SprinkleList } from '@userfrosting/sprinkle-admin/interfaces'

defineProps<{
    info: SystemInfo
    sprinkles: SprinkleList
}>()
</script>

<template>
    <UFCardBox title="System Information">
        <dl class="uk-description-list">
            <dt>Framework version</dt>
            <dd>
                <pre><code>{{ info.frameworkVersion }}</code></pre>
            </dd>

            <dt>PHP version</dt>
            <dd>
                <pre><code>{{ info.phpVersion }}</code></pre>
            </dd>

            <dt>Webserver software</dt>
            <dd>
                <pre><code>{{ info.server }}</code></pre>
            </dd>

            <dt>Database connection</dt>
            <dd>
                <pre><code>{{ info.database.connection }}</code></pre>
            </dd>

            <dt>Database version</dt>
            <dd>
                <pre><code>{{ info.database.type }} {{ info.database.version }}</code></pre>
            </dd>

            <dt>Database name</dt>
            <dd>
                <pre><code>{{ info.database.name }}</code></pre>
            </dd>

            <dt>Project directory</dt>
            <dd>
                <pre><code>{{ info.projectPath }}</code></pre>
            </dd>

            <dt>Loaded sprinkles</dt>
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
