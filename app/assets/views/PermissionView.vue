<script setup lang="ts">
import { useRoute } from 'vue-router'
import { usePermissionApi } from '../composable/permission'
import PermissionInfo from './Permission/PermissionInfo.vue'
import PermissionUsers from './Permission/PermissionUsers.vue'

const route = useRoute()
const { permission, error } = usePermissionApi(route)
</script>

<template>
    <UFHeaderPage title="Permission details" caption="Permission information page" />
    <template v-if="error">
        <UFCardBox>
            <UFAlert :alert="error" />
        </UFCardBox>
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <PermissionInfo :permission="permission" />
            </div>
            <div class="uk-width-2-3">
                <PermissionUsers :slug="$route.params.slug.toString()" />
            </div>
        </div>
    </template>
</template>
