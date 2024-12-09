import { describe, expect, test, vi } from 'vitest'
import { createApp } from 'vue'
import plugins from '..'
import Components from '../components'

describe('plugins.ts', () => {
    test('should initiate the plugin', () => {
        const app = createApp({})
        vi.spyOn(Components, 'install')
        plugins.install(app)
        expect(Components.install).toHaveBeenCalled()
    })
})
