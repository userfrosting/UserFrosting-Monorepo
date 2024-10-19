import { UserInterface, GroupInterface } from '@userfrosting/sprinkle-account/types';
import { AlertInterface } from '@userfrosting/sprinkle-core/types';
/**
 * Create UserApi interface, based on UserInterface
 */
interface UserApi extends UserInterface {
    locale_name: string;
    group: GroupInterface | null;
}
/**
 * API Composable
 */
export declare function useUserAdminApi(route: any): {
    user: import('vue').Ref<{
        locale_name: string;
        group: {
            id: number;
            slug: string;
            name: string;
            description: string;
            icon: string;
            created_at: Date | string;
            updated_at: Date | string;
            deleted_at: Date | string | null;
        } | null;
        id: number;
        user_name: string;
        first_name: string;
        last_name: string;
        full_name: string;
        email: string;
        avatar: string;
        flag_enabled: boolean;
        flag_verified: boolean;
        group_id: number | null;
        locale: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }, UserApi | {
        locale_name: string;
        group: {
            id: number;
            slug: string;
            name: string;
            description: string;
            icon: string;
            created_at: Date | string;
            updated_at: Date | string;
            deleted_at: Date | string | null;
        } | null;
        id: number;
        user_name: string;
        first_name: string;
        last_name: string;
        full_name: string;
        email: string;
        avatar: string;
        flag_enabled: boolean;
        flag_verified: boolean;
        group_id: number | null;
        locale: string;
        created_at: Date | string;
        updated_at: Date | string;
        deleted_at: Date | string | null;
    }>;
    error: import('vue').Ref<AlertInterface | null | undefined, AlertInterface | null | undefined>;
    loading: import('vue').Ref<boolean, boolean>;
};
export type { UserApi };
