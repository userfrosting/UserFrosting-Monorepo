<script lang="ts" setup>
import type { UserInterface } from '@userfrosting/sprinkle-account/types'
import moment from 'moment'

defineProps<{
    users?: UserInterface[]
}>()
</script>

<template>
    <!-- TODO : Create user Card template -->
    <UFCardBox title="Latest Users">
        <div class="uk-grid uk-flex-center" uk-grid>
            <div v-for="user in users" :key="user.id" class="uk-text-center">
                <RouterLink
                    :to="{ name: 'admin.user', params: { user_name: user.user_name } }"
                    class="uk-text-decoration-none uk-link-text">
                    <img :src="user.avatar" alt="User Image" class="uk-border-circle" />
                    <p class="uk-margin-remove">{{ user.full_name }}</p>
                    <p class="uk-margin-remove uk-text-meta">
                        {{ moment(user.created_at).fromNow() }}
                    </p>
                </RouterLink>
            </div>
        </div>
        <template #footer>
            <center>
                <RouterLink :to="{ name: 'admin.users' }"> View All Users </RouterLink>
            </center>
        </template>
    </UFCardBox>
</template>
