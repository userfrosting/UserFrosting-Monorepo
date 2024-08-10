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
                            redirect: { name: 'login' },
                        }
                    },
                    component: () => import('../views/AboutView.vue')
                },
                {
                    path: '/auth',
                    name: 'auth',
                    component: () => import('../views/AuthView.vue')
                },
                {
                    path: '/login',
                    name: 'login',
                    meta: {
                        guest: {
                            redirect: { name: 'home' }
                        }
                    },
                    component: () => import('../views/LoginView.vue')
                },
                {
                    path: '/register',
                    name: 'register',
                    meta: {
                        guest: {
                            redirect: { name: 'home' }
                        }
                    },
                    component: () => import('../views/RegisterView.vue')
                }
            ]
        }
    ]
})

export default router
