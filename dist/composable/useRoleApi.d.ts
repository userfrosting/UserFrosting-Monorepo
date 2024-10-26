import { RoleInterface } from '@userfrosting/sprinkle-account/types';
import { AlertInterface } from '@userfrosting/sprinkle-core/types';
/**
 * Create RoleApi interface, based on RoleInterface
 */
interface RoleApi extends RoleInterface {
    users_count: number;
}
/**
 * API Composable
 */
export declare function useRoleApi(route: any): {
    role: import('vue').Ref<{
        users_count: number;
        id: number;
        slug: string;
        name: string;
        description: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }, RoleApi | {
        users_count: number;
        id: number;
        slug: string;
        name: string;
        description: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }>;
    error: import('vue').Ref<AlertInterface | null | undefined, AlertInterface | null | undefined>;
    loading: import('vue').Ref<boolean, boolean>;
};
export type { RoleApi };
