<script lang="ts" setup>
import { useDashboardApi } from '../composable/dashboard'
import DashboardStats from './Dashboard/DashboardStats.vue'
import DashboardRecentUsers from './Dashboard/DashboardRecentUsers.vue'
import DashboardSystemInfo from './Dashboard/DashboardSystemInfo.vue'
import DashboardActivities from './Dashboard/DashboardActivities.vue'

const dashboard = useDashboardApi()
dashboard.load()
</script>

<template>
    <UFHeaderPage title="Dashboard" />
    <div class="uk-child-width-expand" uk-grid>
        <DashboardStats
            :users="dashboard.data.counter.users"
            :roles="dashboard.data.counter.roles"
            :groups="dashboard.data.counter.groups" />
    </div>
    <div class="uk-child-width-1-2" uk-grid>
        <div>
            <div class="uk-child-width-1-1" uk-grid>
                <div>
                    <DashboardRecentUsers :users="dashboard.data.users" />
                </div>
                <div>
                    <DashboardSystemInfo
                        :info="dashboard.data.info"
                        :sprinkles="dashboard.data.sprinkles" />
                </div>
            </div>
        </div>
        <div>
            <DashboardActivities />
        </div>
    </div>
</template>
