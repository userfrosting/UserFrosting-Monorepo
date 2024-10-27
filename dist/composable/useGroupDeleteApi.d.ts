import { Severity, AlertInterface } from '@userfrosting/sprinkle-core/types';
interface GroupDeleteResponse {
    success: boolean;
    message: string;
}
/**
 * API Composable
 */
export declare function useGroupDeleteApi(): {
    loadingState: import('vue').Ref<{
        valueOf: () => boolean;
    }, Boolean | {
        valueOf: () => boolean;
    }>;
    apiError: import('vue').Ref<{
        title?: string | undefined;
        description?: string | undefined;
        style?: (Severity | keyof typeof Severity) | undefined;
        closeBtn?: boolean | undefined;
        hideIcon?: boolean | undefined;
    } | null, AlertInterface | {
        title?: string | undefined;
        description?: string | undefined;
        style?: (Severity | keyof typeof Severity) | undefined;
        closeBtn?: boolean | undefined;
        hideIcon?: boolean | undefined;
    } | null>;
    deleteGroup: (slug: string) => Promise<{
        success: boolean;
        message: string;
    }>;
};
export type { GroupDeleteResponse };
