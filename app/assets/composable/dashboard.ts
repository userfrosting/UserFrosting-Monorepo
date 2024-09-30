import axios from 'axios'
import type { UserInterface } from '@userfrosting/sprinkle-account/types'
import { AlertStyle, type AlertInterface } from '@userfrosting/sprinkle-core/types'

interface SprinkleList {
    [name: string]: string
}

interface DatabaseInfo {
    connection: string
    name: string
    type: string
    version: string
}

interface SystemInfo {
    frameworkVersion: string
    phpVersion: string
    database: DatabaseInfo
    server: string
    projectPath: string
}

interface DashboardApi {
    counter: {
        users: number
        roles: number
        groups: number
    }
    info: SystemInfo
    sprinkles: SprinkleList[]
    users: UserInterface[]
}

// TODO : Change to pinia (non-persisting) to avoid reactivity issues

// Actions
async function useDashboardApi() {
    return axios
        .get<DashboardApi>('/api/dashboard')
        .then((response) => {
            return response.data
        })
        .catch((err) => {
            const error: AlertInterface = {
                ...{
                    description: 'An error as occurred',
                    style: AlertStyle.Danger,
                    closeBtn: true
                },
                ...err.response.data
            }

            throw error
        })
}

export default useDashboardApi
export type { DashboardApi, SprinkleList, DatabaseInfo, SystemInfo }
