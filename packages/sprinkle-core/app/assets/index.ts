import { useConfigStore, useTranslator } from './stores'

/**
 * Core Sprinkle initialization recipe.
 *
 * This recipe is responsible for loading the configuration from the api.
 */
export default {
    install: () => {
        useConfigStore().load()
        useTranslator().load()
    }
}
