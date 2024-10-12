<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useGroupApi } from '../composable/group'
import GroupInfo from './Group/GroupInfo.vue'
import GroupUsers from './Group/GroupUsers.vue'

const route = useRoute()
const { group, error } = useGroupApi(route)
</script>

<template>
    <UFHeaderPage title="Group details" caption="Group information page" />
    <template v-if="error">
        <UFAlertContainer :alert="error" />
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <GroupInfo :group="group" />
            </div>
            <div class="uk-width-2-3">
                <GroupUsers :slug="group.slug" />
            </div>
        </div>
    </template>
</template>
