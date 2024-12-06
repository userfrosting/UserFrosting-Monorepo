import { describe, expect, test, vi } from 'vitest'
import { createApp } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useAuthGuard } from '../guards/authGuard'
import { useRouter } from 'vue-router'
import plugin from '../'
import * as Auth from '../stores/auth'
import * as AuthGuard from '../guards/authGuard'

const mockAuthStore = {
    check: vi.fn()
}

describe('Plugin', () => {
    test('should install the plugin with the provided options', () => {
        const app = createApp({})
        const router = useRouter()

        vi.spyOn(Auth, 'useAuthStore').mockReturnValue(mockAuthStore as any)
        vi.spyOn(AuthGuard, 'useAuthGuard').mockReturnValue({} as any)

        plugin.install(app, { router })

        expect(useAuthStore).toHaveBeenCalled()
        expect(mockAuthStore.check).toHaveBeenCalled()
        expect(useAuthGuard).toHaveBeenCalledWith(router)
    })
})
