import { watchEffect } from 'vue'
import { useAuthStore } from '../stores/auth'
import type { Router } from 'vue-router'

export function useAuthGuard(router: Router) {
    const auth = useAuthStore()

    /**
     * Return the auth RouteGuard
     */
    const getRouteAuth = () => {
        return router.currentRoute.value.meta.auth ?? null
    }

    /**
     * Return the guest RouteGuard
     */
    const getRouteGuest = () => {
        return router.currentRoute.value.meta.guest ?? null
    }

    /**
     * Apply auth route guard
     */
    const applyAuthGuard = () => {
        const authGuard = getRouteAuth()
        if (authGuard !== null && !auth.isAuthenticated) {
            const redirectTo = authGuard.redirect ?? '/login'
            redirect(redirectTo)
        }
    }

    /**
     * Apply guest route guard
     */
    const applyGuestGuard = () => {
        const guestGuard = getRouteGuest()
        if (guestGuard !== null && auth.isAuthenticated) {
            const redirectTo = guestGuard.redirect ?? '/'
            redirect(redirectTo)
        }
    }

    /**
     * Redirect to the specified route
     */
    const redirect = (redirectTo: string | { name: string }) => {
        router.push(redirectTo)
    }

    watchEffect(() => {
        applyAuthGuard()
        applyGuestGuard()
    })
}
