import { GroupInterface } from '@userfrosting/sprinkle-account/types';
import { AlertInterface } from '@userfrosting/sprinkle-core/types';
/**
 * Create GroupAPI interface, based on GroupInterface
 */
interface GroupApi extends GroupInterface {
    users_count: number;
}
/**
 * API Composable
 */
export declare function useGroupApi(route: any): {
    group: import('vue').Ref<{
        users_count: number;
        id: number;
        slug: string;
        name: string;
        description: string;
        icon: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }, GroupApi | {
        users_count: number;
        id: number;
        slug: string;
        name: string;
        description: string;
        icon: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }>;
    error: import('vue').Ref<AlertInterface | null | undefined, AlertInterface | null | undefined>;
    loading: import('vue').Ref<boolean, boolean>;
};
export type { GroupApi };
