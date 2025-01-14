export default [
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
