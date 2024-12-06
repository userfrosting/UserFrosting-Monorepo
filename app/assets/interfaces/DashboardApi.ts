import type { UserInterface } from '@userfrosting/sprinkle-account/interfaces'

export interface SprinkleList {
    [name: string]: string
}

export interface DatabaseInfo {
    connection: string
    name: string
    type: string
    version: string
}

export interface SystemInfo {
    frameworkVersion: string
    phpVersion: string
    database: DatabaseInfo
    server: string
    projectPath: string
}

export interface DashboardApi {
    counter: {
        users: number
        roles: number
        groups: number
    }
    info: SystemInfo
    sprinkles: SprinkleList
    users: UserInterface[]
}
