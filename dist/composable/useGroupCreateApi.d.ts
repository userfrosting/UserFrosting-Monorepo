import { Severity, AlertInterface } from '@userfrosting/sprinkle-core/types';
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
    sendForm: () => Promise<{
        success: boolean;
        message: string;
        group: GroupCreateForm;
    }>;
    resetForm: () => void;
    formData: import('vue').Ref<{
        slug: string;
        name: string;
        description: string;
        icon: string;
    }, GroupCreateForm | {
        slug: string;
        name: string;
        description: string;
        icon: string;
    }>;
    loadingState: import('vue').Ref<{
        valueOf: () => boolean;
    }, Boolean | {
        valueOf: () => boolean;
    }>;
    formError: import('vue').Ref<{
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
