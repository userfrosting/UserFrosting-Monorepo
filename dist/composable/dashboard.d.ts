import { UserInterface } from '@userfrosting/sprinkle-account/types';
interface SprinkleList {
    [name: string]: string;
}
interface DatabaseInfo {
    connection: string;
    name: string;
    type: string;
    version: string;
}
interface SystemInfo {
    frameworkVersion: string;
    phpVersion: string;
    database: DatabaseInfo;
    server: string;
    projectPath: string;
}
interface DashboardApi {
    counter: {
        users: number;
        roles: number;
        groups: number;
    };
    info: SystemInfo;
    sprinkles: SprinkleList;
    users: UserInterface[];
}
export type { DashboardApi, SprinkleList, DatabaseInfo, SystemInfo };
export declare const useDashboardApi: import('pinia').StoreDefinition<"dashboardApi", {
    data: DashboardApi;
}, {}, {
    load(): Promise<{
        counter: {
            users: number;
            roles: number;
            groups: number;
        };
        info: {
            frameworkVersion: string;
            phpVersion: string;
            database: {
                connection: string;
                name: string;
                type: string;
                version: string;
            };
            server: string;
            projectPath: string;
        };
        sprinkles: SprinkleList;
        users: {
            id: number;
            user_name: string;
            first_name: string;
            last_name: string;
            full_name: string;
            email: string;
            avatar: string;
            flag_enabled: boolean;
            flag_verified: boolean;
            group_id: number | null;
            locale: string;
            created_at: Date | string;
            updated_at: Date | string;
            deleted_at: Date | string | null;
        }[];
    }>;
}>;
