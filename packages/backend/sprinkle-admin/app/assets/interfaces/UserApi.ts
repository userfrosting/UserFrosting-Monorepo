import type { UserInterface, GroupInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Create UserApi interface, based on UserInterface
 */
export interface UserApi extends UserInterface {
    locale_name: string
    group: GroupInterface | null
}
