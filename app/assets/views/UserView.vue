<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useUserAdminApi } from '../composable/user'
import UserInfo from './User/UserInfo.vue'
import UserActivities from './User/UserActivities.vue'
import UserRoles from './User/UserRoles.vue'
import UserPermissions from './User/UserPermissions.vue'

const route = useRoute()
const { user, error } = useUserAdminApi(route)
</script>

<template>
    <UFHeaderPage title="User details" caption="User information page" />
    <template v-if="error">
        <UFCardBox>
            <UFAlert :alert="error" />
        </UFCardBox>
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <UserInfo :user="user" />
            </div>
            <div class="uk-width-2-3">
                <UserRoles :slug="user.user_name" />
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
