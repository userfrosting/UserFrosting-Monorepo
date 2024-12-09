<script setup lang="ts">
import { useRoute } from 'vue-router'
import { usePermissionApi } from '@userfrosting/sprinkle-admin/composables'
import PermissionInfo from '../../components/Pages/Admin/Permission/PermissionInfo.vue'
import PermissionUsers from '../../components/Pages/Admin/Permission/PermissionUsers.vue'

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
                <PermissionUsers :id="$route.params.id.toString()" />
            </div>
        </div>
    </template>
</template>
