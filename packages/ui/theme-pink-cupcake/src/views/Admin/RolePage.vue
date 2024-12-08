<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useRoleApi } from '@userfrosting/sprinkle-admin/composables'
import RoleInfo from '../../components/Pages/Admin/Role/RoleInfo.vue'
import RoleUsers from '../../components/Pages/Admin/Role/RoleUsers.vue'
import RolePermissions from '../../components/Pages/Admin/Role/RolePermissions.vue'

const route = useRoute()
const { role, error } = useRoleApi(route)
</script>

<template>
    <UFHeaderPage title="Role details" caption="Role information page" />
    <template v-if="error">
        <UFCardBox>
            <UFAlert :alert="error" />
        </UFCardBox>
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <RoleInfo :role="role" />
            </div>
            <div class="uk-width-2-3">
                <RoleUsers :slug="role.slug" />
            </div>
        </div>
        <div class="uk-child-width-1-1" uk-grid>
            <div>
                <RolePermissions :role="$route.params.slug.toString()" />
            </div>
        </div>
    </template>
</template>
