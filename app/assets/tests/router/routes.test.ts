import { describe, expect, test, vi } from 'vitest'

import AdminRoutes from '../../router/routes'

describe('routes.test.ts', () => {
    test('AdminRoutes should contain all the individual routes', () => {
        expect(AdminRoutes.length).toBe(6)
    })
})
