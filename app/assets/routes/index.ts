export default [
    {
        path: '/account/sign-in',
        name: 'account.login',
        meta: {
            guest: {
                redirect: { name: 'home' }
            }
        },
        component: () => import('../views/LoginView.vue')
    },
    {
        path: '/account/register',
        name: 'account.register',
        meta: {
            guest: {
                redirect: { name: 'home' }
            }
        },
        component: () => import('../views/RegisterView.vue')
    },
    {
        path: '/account/forgot-password',
        name: 'account.forgot-password',
        meta: {
            guest: {
                redirect: { name: 'home' }
            }
        },
        component: () => import('../views/ForgotPasswordView.vue')
    },
    {
        path: '/account/resend-verification',
        name: 'account.resend-verification',
        meta: {
            guest: {
                redirect: { name: 'home' }
            }
        },
        component: () => import('../views/ResendVerificationView.vue')
    }
]
