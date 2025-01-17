<script setup lang="ts">
import { useRoute } from 'vue-router'
import { watch } from 'vue'
import { usePageMeta } from '@userfrosting/sprinkle-core/composables'
import { useRoleApi } from '@userfrosting/sprinkle-admin/composables'
import RoleInfo from '../../components/Pages/Admin/Role/RoleInfo.vue'
import RoleUsers from '../../components/Pages/Admin/Role/RoleUsers.vue'
import RolePermissions from '../../components/Pages/Admin/Role/RolePermissions.vue'

/**
 * Variables and composables
 */
const route = useRoute()
const page = usePageMeta()
const { role, error, fetchRole } = useRoleApi(() => route.params.slug)

/**
 * Watcher - Match page title to the user full name
 */
watch(
    () => role.value.slug,
    () => {
        page.title = role.value.name
    },
    { immediate: true }
)
</script>

<template>
    <template v-if="error">
        <UFCardBox>
            <UFAlert :alert="error" />
        </UFCardBox>
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <RoleInfo :role="role" @updated="fetchRole()" />
            </div>
            <div class="uk-width-2-3">
                <RoleUsers :slug="role.slug" />
            </div>
        </div>
        <div class="uk-child-width-1-1" uk-grid>
            <div>
                <RolePermissions :role="role" />
            </div>
        </div>
    </template>
</template>
