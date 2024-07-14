import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@userfrosting/sprinkle-account/stores'

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
                    component: () => import('../views/LoginView.vue'),
                    beforeEnter: () => {
                        const auth = useAuthStore()
                        if (auth.isAuthenticated) {
                            return { name: 'home' }
                        }
                    }
                }
            ]
        }
    ]
})

export default router
