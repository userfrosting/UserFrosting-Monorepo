export default [
    {
        path: 'users',
        meta: {
            auth: {
                redirect: { name: 'account.login' }
            },
            title: 'Users',
            description: 'USER.PAGE_DESCRIPTION'
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
                    description: 'USER.INFO_PAGE'
                }
            }
        ]
    }
]
