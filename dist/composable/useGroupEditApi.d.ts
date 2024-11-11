import { Severity, AlertInterface } from '@userfrosting/sprinkle-core/types';
/**
 * Interfaces - What the API expects and what it returns
 */
interface GroupEditForm {
    slug: string;
    name: string;
    description: string;
    icon: string;
}
interface GroupEditResponse {
    success: boolean;
    message: string;
    group: GroupEditForm;
}
/**
 * API Composable
 */
export declare function useGroupEditApi(): {
    submitGroupEdit: (slug: string, data: GroupEditForm) => Promise<{
        success: boolean;
        message: string;
        group: GroupEditForm;
    }>;
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
};
export type { GroupEditForm, GroupEditResponse };
