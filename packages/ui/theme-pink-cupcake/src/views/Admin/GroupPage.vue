<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useGroupApi } from '@userfrosting/sprinkle-admin/composables'
import GroupInfo from '../../components/Pages/Admin/Group/GroupInfo.vue'
import GroupUsers from '../../components/Pages/Admin/Group/GroupUsers.vue'

const route = useRoute()
const { group, error, fetchApi } = useGroupApi(route)
</script>

<template>
    <UFHeaderPage title="Group details" caption="Group information page" />
    <template v-if="error">
        <UFAlert :alert="error" />
    </template>
    <template v-else>
        <div uk-grid>
            <div class="uk-width-1-3">
                <GroupInfo :group="group" @groupUpdated="fetchApi()" />
            </div>
            <div class="uk-width-2-3">
                <GroupUsers :slug="$route.params.slug.toString()" />
            </div>
        </div>
    </template>
</template>
