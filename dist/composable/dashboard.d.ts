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
    sprinkles: SprinkleList[];
    users: UserInterface[];
}
declare function useDashboardApi(): Promise<DashboardApi>;
export default useDashboardApi;
export type { DashboardApi, SprinkleList, DatabaseInfo, SystemInfo };
