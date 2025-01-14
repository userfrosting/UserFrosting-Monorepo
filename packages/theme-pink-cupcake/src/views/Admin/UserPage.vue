<script setup lang="ts">
import { useRoute } from 'vue-router'
import { watch } from 'vue'
import { usePageMeta } from '@userfrosting/sprinkle-core/composables'
import { useUserApi } from '@userfrosting/sprinkle-admin/composables'
import UserInfo from '../../components/Pages/Admin/User/UserInfo.vue'
import UserActivities from '../../components/Pages/Admin/User/UserActivities.vue'
import UserRoles from '../../components/Pages/Admin/User/UserRoles.vue'
import UserPermissions from '../../components/Pages/Admin/User/UserPermissions.vue'

/**
 * Variables and composables
 */
const route = useRoute()
const page = usePageMeta()
const { user, error, fetchUser } = useUserApi(() => route.params.user_name)

/**
 * Watcher - Match page title to the user full name
 */
watch(
    () => user.value.full_name,
    () => {
        page.title = user.value.full_name
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
                <UserInfo :user="user" @updated="fetchUser()" />
            </div>
            <div class="uk-width-2-3">
                <UserRoles :user="user" />
            </div>
        </div>

        <div class="uk-child-width-1-1" uk-grid>
            <div>
                <UserPermissions :user_name="user.user_name" />
            </div>
            <div>
                <UserActivities :user_name="user.user_name" />
            </div>
        </div>
    </template>
</template>
