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
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        children: [
            {
                path: '',
                name: 'admin.groups',
                component: () => import('../views/GroupsView.vue')
            },
            {
                path: 'g/:slug',
                name: 'admin.group',
                component: () => import('../views/GroupView.vue')
            }
        ]
    }
]

const AdminPermissionsRoutes = [
    {
        path: 'permissions',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        children: [
            {
                path: '',
                name: 'admin.permissions',
                component: () => import('../views/PermissionsView.vue')
            },
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
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        children: [
            {
                path: '',
                name: 'admin.roles',
                component: () => import('../views/RolesView.vue')
            },
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
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            }
        },
        children: [
            {
                path: '',
                name: 'admin.users',
                component: () => import('../views/UsersView.vue')
            },
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
