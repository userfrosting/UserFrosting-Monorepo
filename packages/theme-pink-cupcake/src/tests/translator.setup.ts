import { config } from '@vue/test-utils'

/**
 * Global mock of the $t and $tdate functions from the i18n plugin
 * @see https://stackoverflow.com/a/73424634/445757
 */
config.global.mocks = {
    $t: (tKey: string): string => tKey, // just return translation key
    $tdate: (date: string): string => date // just return translation key
}
