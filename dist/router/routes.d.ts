declare const AdminDashboardRoutes: {
    path: string;
    name: string;
    component: () => Promise<typeof import("../views/DashboardView.vue")>;
}[];
declare const AdminActivitiesRoutes: {
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    component: () => Promise<typeof import("../views/ActivitiesView.vue")>;
}[];
declare const AdminGroupsRoutes: {
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    component: () => Promise<typeof import("../views/GroupsView.vue")>;
    children: {
        path: string;
        name: string;
        meta: {
            guest: {
                redirect: {
                    name: string;
                };
            };
        };
        component: () => Promise<typeof import("../views/GroupView.vue")>;
    }[];
}[];
declare const AdminPermissionsRoutes: {
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    component: () => Promise<typeof import("../views/PermissionsView.vue")>;
    children: {
        path: string;
        name: string;
        meta: {
            guest: {
                redirect: {
                    name: string;
                };
            };
        };
        component: () => Promise<typeof import("../views/PermissionView.vue")>;
    }[];
}[];
declare const AdminRolesRoutes: {
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    component: () => Promise<typeof import("../views/RolesView.vue")>;
    children: {
        path: string;
        name: string;
        meta: {
            guest: {
                redirect: {
                    name: string;
                };
            };
        };
        component: () => Promise<typeof import("../views/RoleView.vue")>;
    }[];
}[];
declare const AdminUsersRoutes: {
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    component: () => Promise<typeof import("../views/UsersView.vue")>;
    children: {
        path: string;
        name: string;
        meta: {
            guest: {
                redirect: {
                    name: string;
                };
            };
        };
        component: () => Promise<typeof import("../views/UserView.vue")>;
    }[];
}[];
declare const _default: {
    path: string;
    name: string;
    component: () => Promise<typeof import("../views/DashboardView.vue")>;
}[][];
export default _default;
export { AdminDashboardRoutes, AdminActivitiesRoutes, AdminGroupsRoutes, AdminPermissionsRoutes, AdminRolesRoutes, AdminUsersRoutes };
