import { PermissionInterface } from '@userfrosting/sprinkle-account/types';
import { AlertInterface } from '@userfrosting/sprinkle-core/types';
/**
 * Create PermissionApi interface, based on PermissionInterface
 */
interface PermissionApi extends PermissionInterface {
}
/**
 * API Composable
 */
export declare function usePermissionApi(route: any): {
    permission: import('vue').Ref<{
        id: number;
        slug: string;
        name: string;
        conditions: string;
        description: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }, PermissionApi | {
        id: number;
        slug: string;
        name: string;
        conditions: string;
        description: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }>;
    error: import('vue').Ref<AlertInterface | null | undefined, AlertInterface | null | undefined>;
    loading: import('vue').Ref<boolean, boolean>;
};
export type { PermissionApi };
