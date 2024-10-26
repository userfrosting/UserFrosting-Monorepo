import { defineStore } from 'pinia'
import axios from 'axios'
import type { UserInterface } from '@userfrosting/sprinkle-account/types'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/types'

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
    sprinkles: SprinkleList
    users: UserInterface[]
}

const defaultDashboardApi: DashboardApi = {
    counter: {
        users: 0,
        roles: 0,
        groups: 0
    },
    info: {
        frameworkVersion: '',
        phpVersion: '',
        database: {
            connection: '',
            name: '',
            type: '',
            version: ''
        },
        server: '',
        projectPath: ''
    },
    sprinkles: {},
    users: []
}

export const useDashboardApi = defineStore('dashboardApi', {
    state: () => {
        return {
            data: defaultDashboardApi
        }
    },
    actions: {
        async load() {
            return axios
                .get<DashboardApi>('/api/dashboard')
                .then((response) => {
                    this.data = response.data

                    return this.data
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
    }
})

export type { DashboardApi, SprinkleList, DatabaseInfo, SystemInfo }
