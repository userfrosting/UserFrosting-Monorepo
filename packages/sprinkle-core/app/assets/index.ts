import type { App } from 'vue'
import { useConfigStore, useTranslator } from './stores'

/**
 * Core Sprinkle initialization recipe.
 *
 * This recipe is responsible for loading the configuration from the api.
 */
export default {
    install: (app: App) => {
        useConfigStore().load()

        // Load translations & add $t to global properties
        const { translate, translateDate, load } = useTranslator()
        load()
        app.config.globalProperties.$t = translate
        app.config.globalProperties.$tdate = translateDate
    }
}
