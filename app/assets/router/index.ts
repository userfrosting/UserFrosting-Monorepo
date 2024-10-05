import AccountRoutes from '@userfrosting/sprinkle-account/routes'
import AdminRoutes from '@userfrosting/sprinkle-admin/routes'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '',
            redirect: { name: 'home' },
            component: () => import('../layouts/LayoutPage.vue'),
            children: [
                {
                    path: '/',
                    name: 'home',
                    component: () => import('../views/HomeView.vue')
                },
                {
                    path: '/about',
                    name: 'about',
                    meta: {
                        auth: {
                            redirect: { name: 'account.login' }
                        }
                    },
                    component: () => import('../views/AboutView.vue')
                },
                {
                    path: '/auth',
                    name: 'auth',
                    component: () => import('../views/AuthView.vue')
                },
                // Include sprinkles routes
                ...AccountRoutes
            ]
        },
        {
            path: '',
            component: () => import('../layouts/LayoutDashboard.vue'),
            children: [
                ...AdminRoutes
            ]
        }
    ]
})

export default router
