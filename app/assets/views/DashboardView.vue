<script lang="ts" setup>
import { useDashboardApi } from '../composable/dashboard'
import DashboardStats from './Dashboard/DashboardStats.vue'
import DashboardRecentUsers from './Dashboard/DashboardRecentUsers.vue'
import DashboardSystemInfo from './Dashboard/DashboardSystemInfo.vue'

const dashboard = useDashboardApi()
dashboard.load()
</script>

<template>
    <UFHeaderPage title="Dashboard" />
    <div class="uk-grid uk-child-width-expand" uk-grid>
        <DashboardStats
            :users="dashboard.data.counter.users"
            :roles="dashboard.data.counter.roles"
            :groups="dashboard.data.counter.groups" />
    </div>
    <div class="uk-grid uk-child-width-1-2" uk-grid>
        <div>
            <DashboardRecentUsers :users="dashboard.data.users" />
            <DashboardSystemInfo
                :info="dashboard.data.info"
                :sprinkles="dashboard.data.sprinkles" />
        </div>
        <div>
            <UFCardBox title="Activities"></UFCardBox>
        </div>
    </div>
</template>
