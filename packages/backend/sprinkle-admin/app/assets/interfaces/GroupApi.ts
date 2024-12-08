import type { GroupInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Create GroupAPI interface, based on GroupInterface
 */
export interface GroupApi extends GroupInterface {
    users_count: number
}
