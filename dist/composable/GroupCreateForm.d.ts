interface GroupCreateForm {
    slug: string;
    name: string;
    description: string;
    icon: string;
}
declare function getDefaultForm(): GroupCreateForm;
declare function sendForm(form: GroupCreateForm): Promise<any>;
export type { GroupCreateForm };
export { getDefaultForm, sendForm };
