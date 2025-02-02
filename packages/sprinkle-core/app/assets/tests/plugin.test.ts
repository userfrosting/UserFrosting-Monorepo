import { describe, expect, test, vi } from 'vitest'
import { useConfigStore } from '../stores/config'
import plugin from '..'
import * as Config from '../stores/config'
import * as Translator from '../stores/useTranslator'

const mockConfigStore = {
    load: vi.fn()
}

const mockTranslatorStore = {
    load: vi.fn()
}

describe('Plugin', () => {
    test('should install the plugin and initiate load', () => {
        vi.spyOn(Config, 'useConfigStore').mockReturnValue(mockConfigStore as any)
        vi.spyOn(Translator, 'useTranslator').mockReturnValue(mockTranslatorStore as any)

        plugin.install()

        expect(useConfigStore).toHaveBeenCalled()
        expect(mockConfigStore.load).toHaveBeenCalled()
    })
})
