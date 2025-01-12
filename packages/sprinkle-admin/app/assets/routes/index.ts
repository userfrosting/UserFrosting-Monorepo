const AdminDashboardRoutes = [
    {
        path: 'dashboard',
        name: 'admin.dashboard',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            },
            title: 'Dashboard'
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
            title: 'Activities',
            description: 'List of all activities'
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
            title: 'Groups',
            description:
                'A listing of the groups for your site. Provides management tools for editing and deleting groups.'
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
                    title: 'Group Details',
                    description: 'View and edit group details.'
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
            title: 'Permissions',
            description:
                'A listing of the permissions for your site. Provides management tools for editing and deleting permissions.'
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
                    title: 'Permission details',
                    description: 'View and edit permission details.'
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
            title: 'Roles',
            description:
                'A listing of the roles for your site. Provides management tools for editing and deleting roles.'
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
                    title: 'Role details',
                    description: 'View and edit role details.'
                }
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
            },
            title: 'Users',
            description:
                'A listing of the users for your site. Provides management tools including the ability to edit user details, manually activate users, enable/disable users, and more.'
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
                component: () => import('../views/UserView.vue'),
                meta: {
                    title: 'User Details',
                    description: 'View and edit user details.'
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
