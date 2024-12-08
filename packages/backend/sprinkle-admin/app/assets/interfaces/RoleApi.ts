import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Create RoleApi interface, based on RoleInterface
 */
export interface RoleApi extends RoleInterface {
    users_count: number
}
