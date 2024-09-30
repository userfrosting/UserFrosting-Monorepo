<script lang="ts" setup>
import { ref } from 'vue'
import type { DashboardApi } from '../composable/dashboard'
import useDashboardApi from '../composable/dashboard'
import DashboardStats from './Dashboard/DashboardStats.vue'
import DashboardRecentUsers from './Dashboard/DashboardRecentUsers.vue'
import DashboardSystemInfo from './Dashboard/DashboardSystemInfo.vue'

const data = ref<DashboardApi>()

await useDashboardApi().then((apiData) => {
    data.value = apiData
})
</script>

<template>
    <UFHeaderPage title="Dashboard" />

    <div class="uk-grid uk-child-width-expand" uk-grid>
        <DashboardStats
            :users="data?.counter.users ?? 0"
            :roles="data?.counter.roles ?? 0"
            :groups="data?.counter.groups ?? 0" />
    </div>
    <div class="uk-grid uk-child-width-1-2" uk-grid>
        <div>
            <DashboardRecentUsers :users="data?.users" />
            <br />
            <DashboardSystemInfo :data="data?.info" :sprinkles="data?.sprinkles" />
        </div>
        <div>
            <UFCardBox title="Activities"></UFCardBox>
        </div>
    </div>
</template>
