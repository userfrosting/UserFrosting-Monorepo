// Unit tests for: useAuthGuard
import { afterEach, beforeEach, describe, expect, test, vi } from 'vitest'
import { useAuthGuard } from '../../guards/authGuard'
import * as Auth from '../../stores/auth'

// Default mock for the auth store and router
const mockAuthStore = {
    isAuthenticated: false,
    check: vi.fn()
}

const mockRouter = {
    currentRoute: {
        value: {
            meta: {
                auth: null as null | { redirect?: string },
                guest: null as null | { redirect?: string }
            }
        }
    },
    push: vi.fn()
}

describe('authGuard useAuthGuard() method', () => {
    beforeEach(() => {
        // Apply the mock to the auth store
        vi.spyOn(Auth, 'useAuthStore').mockReturnValue(mockAuthStore as any)
    })

    afterEach(() => {
        // Reset all mocks and "once" implementations
        vi.resetAllMocks()
    })

    test('should not do anything if both path are null (default)', () => {
        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).not.toHaveBeenCalled()
    })

    test('should redirect to login if route requires auth and user is not authenticated', () => {
        // Arrange
        mockRouter.currentRoute.value.meta.auth = { redirect: '/login' }
        mockRouter.currentRoute.value.meta.guest = null
        mockAuthStore.isAuthenticated = false

        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).toHaveBeenCalledWith('/login')
    })

    test('should not redirect if route requires auth and user is authenticated', () => {
        // Arrange
        mockRouter.currentRoute.value.meta.auth = { redirect: '/login' }
        mockRouter.currentRoute.value.meta.guest = null
        mockAuthStore.isAuthenticated = true

        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).not.toHaveBeenCalled()
    })

    test('should not redirect if route is for guests and user is not authenticated', () => {
        // Arrange
        mockRouter.currentRoute.value.meta.auth = null
        mockRouter.currentRoute.value.meta.guest = { redirect: '/' }
        mockAuthStore.isAuthenticated = false

        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).not.toHaveBeenCalled()
    })

    test('should redirect to home if route is for guests and user is authenticated', () => {
        // Arrange
        mockRouter.currentRoute.value.meta.auth = null
        mockRouter.currentRoute.value.meta.guest = { redirect: '/' }
        mockAuthStore.isAuthenticated = true

        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).toHaveBeenCalledWith('/')
    })

    test('should use default redirect for auth guard if no redirect specified', () => {
        // Arrange
        mockRouter.currentRoute.value.meta.auth = {}
        mockAuthStore.isAuthenticated = false

        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).toHaveBeenCalledWith('/login')
    })

    test('should use default redirect for guest guard if no redirect specified', () => {
        // Arrange
        mockRouter.currentRoute.value.meta.guest = {}
        mockAuthStore.isAuthenticated = true

        // Act
        useAuthGuard(mockRouter as any)

        // Assert
        expect(mockRouter.push).toHaveBeenCalledWith('/')
    })
})
