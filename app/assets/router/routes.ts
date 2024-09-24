const AdminDashboardRoutes = [
    {
        path: 'dashboard',
        name: 'admin.dashboard',
        component: () => import('../views/DashboardView.vue')
    }
]

const AdminActivitiesRoutes = [
    {
        path: 'activities',
        name: 'admin.activities',
        meta: {
            auth: {
                redirect: { name: 'account.login' },
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
                redirect: { name: 'account.login' },
            }
        },
        component: () => import('../views/GroupsView.vue'),
        children: [
            {
                path: 'g/:slug', // groups/g/{slug}
                name: 'account.group',
                meta: {
                    guest: {
                        redirect: { name: 'home' }
                    }
                },
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
                redirect: { name: 'account.login' },
            }
        },
        component: () => import('../views/PermissionsView.vue'),
        children: [
            {
                path: 'p/:id', // permissions/p/{id}
                name: 'account.permission',
                meta: {
                    guest: {
                        redirect: { name: 'home' }
                    }
                },
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
                redirect: { name: 'account.login' },
            }
        },
        component: () => import('../views/RolesView.vue'),
        children: [
            {
                path: 'r/:slug', // roles/r/{slug}
                name: 'account.role',
                meta: {
                    guest: {
                        redirect: { name: 'home' }
                    }
                },
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
                redirect: { name: 'account.login' },
            }
        },
        component: () => import('../views/UsersView.vue'),
        children: [
            {
                path: 'u/:user_name', // users/u/{user_name}
                name: 'account.user',
                meta: {
                    guest: {
                        redirect: { name: 'home' }
                    }
                },
                component: () => import('../views/UserView.vue')
            }
        ]
    }
]

export default [
    AdminDashboardRoutes,
    AdminActivitiesRoutes,
    AdminGroupsRoutes,
    AdminPermissionsRoutes,
    AdminRolesRoutes,
    AdminUsersRoutes,
]

export {
    AdminDashboardRoutes,
    AdminActivitiesRoutes,
    AdminGroupsRoutes,
    AdminPermissionsRoutes,
    AdminRolesRoutes,
    AdminUsersRoutes
}
