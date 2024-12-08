import { defineStore } from 'pinia'
import axios from 'axios'
import { type AlertInterface, Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { DashboardApi } from '../interfaces'

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
