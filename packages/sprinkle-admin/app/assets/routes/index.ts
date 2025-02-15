import AdminUsersRoutes from './UserRoutes'

const AdminDashboardRoutes = [
    {
        path: 'dashboard',
        name: 'admin.dashboard',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            },
            title: 'DASHBOARD'
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
            },
            title: 'ACTIVITY.PAGE',
            description: 'ACTIVITY.PAGE_DESCRIPTION'
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
            },
            title: 'GROUP.PAGE',
            description: 'GROUP.PAGE_DESCRIPTION'
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
                component: () => import('../views/GroupView.vue'),
                meta: {
                    description: 'GROUP.INFO_PAGE'
                }
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
            },
            title: 'PERMISSION.PAGE',
            description: 'PERMISSION.PAGE_DESCRIPTION'
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
                component: () => import('../views/PermissionView.vue'),
                meta: {
                    description: 'PERMISSION.INFO_PAGE'
                }
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
            },
            title: 'ROLE.PAGE',
            description: 'ROLE.PAGE_DESCRIPTION'
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
                component: () => import('../views/RoleView.vue'),
                meta: {
                    description: 'ROLE.INFO_PAGE'
                }
            }
        ]
    }
]

const AdminRoutes = [
    { path: '', redirect: { name: 'admin.dashboard' } },
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
