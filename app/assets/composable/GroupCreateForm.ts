import axios from 'axios'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/types'

// Interfaces
interface GroupCreateForm {
    slug: string
    name: string
    description: string
    icon: string
}

// Variables
function getDefaultForm(): GroupCreateForm {
    return {
        slug: '',
        name: '',
        description: '',
        icon: 'users'
    }
}

// TODO : Add validation
// 'schema://requests/group/create.yaml'

// Actions
async function sendForm(form: GroupCreateForm) {
    return axios
        .post('/api/groups', form)
        .then((response) => {
            return response.data.message
        })
        .catch((err) => {
            const error: AlertInterface = {
                ...{
                    description: 'An error as occurred',
                    style: Severity.Danger,
                    closeBtn: true
                },
                ...err.response.data
            }

            throw error
        })
}

export type { GroupCreateForm }
export { getDefaultForm, sendForm }
