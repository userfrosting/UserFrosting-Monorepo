const AdminDashboardRoutes = [
    {
        path: 'dashboard',
        name: 'admin.dashboard',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        component: () => import('../views/DashboardView.vue')
    }
]

const AdminActivitiesRoutes = [
    {
        path: 'activities',
        name: 'admin.activities',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        component: () => import('../views/ActivitiesView.vue')
    }
]

const AdminGroupsRoutes = [
    {
        path: 'groups',
        name: 'admin.groups',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        component: () => import('../views/GroupsView.vue'),
        children: [
            {
                path: 'g/:slug', // groups/g/{slug}
                name: 'admin.group',
                component: () => import('../views/GroupView.vue')
            }
        ]
    }
]

const AdminPermissionsRoutes = [
    {
        path: 'permissions',
        name: 'admin.permissions',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        component: () => import('../views/PermissionsView.vue'),
        children: [
            {
                path: 'p/:id', // permissions/p/{id}
                name: 'admin.permission',
                component: () => import('../views/PermissionView.vue')
            }
        ]
    }
]
const AdminRolesRoutes = [
    {
        path: 'roles',
        name: 'admin.roles',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        component: () => import('../views/RolesView.vue'),
        children: [
            {
                path: 'r/:slug', // roles/r/{slug}
                name: 'admin.role',
                component: () => import('../views/RoleView.vue')
            }
        ]
    }
]

const AdminUsersRoutes = [
    {
        path: 'users',
        name: 'admin.users',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        component: () => import('../views/UsersView.vue'),
        children: [
            {
                path: 'u/:user_name', // users/u/{user_name}
                name: 'admin.user',
                component: () => import('../views/UserView.vue')
            }
        ]
    }
]

const AdminRoutes = [
    ...AdminDashboardRoutes,
    ...AdminActivitiesRoutes,
    ...AdminGroupsRoutes,
    ...AdminPermissionsRoutes,
    ...AdminRolesRoutes,
    ...AdminUsersRoutes
]

export default AdminRoutes

export {
    AdminDashboardRoutes,
    AdminActivitiesRoutes,
    AdminGroupsRoutes,
    AdminPermissionsRoutes,
    AdminRolesRoutes,
    AdminUsersRoutes
}
