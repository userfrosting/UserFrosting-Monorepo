import { Severity, AlertInterface } from '@userfrosting/sprinkle-core/types';
/**
 * Interfaces - What the API expects and what it returns
 */
interface GroupCreateForm {
    slug: string;
    name: string;
    description: string;
    icon: string;
}
interface GroupCreateResponse {
    success: boolean;
    message: string;
    group: GroupCreateForm;
}
/**
 * API Composable
 */
export declare function useGroupCreateApi(): {
    submitGroupCreate: (data: GroupCreateForm) => Promise<{
        success: boolean;
        message: string;
        group: GroupCreateForm;
    }>;
    apiLoading: import('vue').Ref<{
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
};
export type { GroupCreateForm, GroupCreateResponse };
