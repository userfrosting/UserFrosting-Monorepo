/**
 * Register every component globally
 * See : https://vuejs.org/guide/components/registration
 */
import type { App } from 'vue'

import UFAdminDashboardPage from './DashboardPage.vue'
import UFAdminActivitiesPage from './ActivitiesPage.vue'
import UFAdminGroupsPage from './GroupsPage.vue'
import UFAdminGroupPage from './GroupPage.vue'
import UFAdminPermissionsPage from './PermissionsPage.vue'
import UFAdminPermissionPage from './PermissionPage.vue'
import UFAdminRolePage from './RolePage.vue'
import UFAdminRolesPage from './RolesPage.vue'
import UFAdminUserPage from './UserPage.vue'
import UFAdminUsersPage from './UsersPage.vue'

export {
    UFAdminDashboardPage,
    UFAdminActivitiesPage,
    UFAdminGroupsPage,
    UFAdminGroupPage,
    UFAdminPermissionsPage,
    UFAdminPermissionPage,
    UFAdminRolePage,
    UFAdminRolesPage,
    UFAdminUserPage,
    UFAdminUsersPage
}

export default {
    install: (app: App) => {
        app.component('UFAdminDashboardPage', UFAdminDashboardPage)
            .component('UFAdminActivitiesPage', UFAdminActivitiesPage)
            .component('UFAdminGroupsPage', UFAdminGroupsPage)
            .component('UFAdminGroupPage', UFAdminGroupPage)
            .component('UFAdminPermissionsPage', UFAdminPermissionsPage)
            .component('UFAdminPermissionPage', UFAdminPermissionPage)
            .component('UFAdminRolePage', UFAdminRolePage)
            .component('UFAdminRolesPage', UFAdminRolesPage)
            .component('UFAdminUserPage', UFAdminUserPage)
            .component('UFAdminUsersPage', UFAdminUsersPage)
    }
}

declare module 'vue' {
    export interface GlobalComponents {
        UFAdminDashboardPage: typeof UFAdminDashboardPage
        UFAdminActivitiesPage: typeof UFAdminActivitiesPage
        UFAdminGroupsPage: typeof UFAdminGroupsPage
        UFAdminGroupPage: typeof UFAdminGroupPage
        UFAdminPermissionsPage: typeof UFAdminPermissionsPage
        UFAdminPermissionPage: typeof UFAdminPermissionPage
        UFAdminRolePage: typeof UFAdminRolePage
        UFAdminRolesPage: typeof UFAdminRolesPage
        UFAdminUserPage: typeof UFAdminUserPage
        UFAdminUsersPage: typeof UFAdminUsersPage
    }
}
