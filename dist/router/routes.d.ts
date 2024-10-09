declare const AdminDashboardRoutes: {
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
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
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    children: {
        path: string;
        name: string;
        component: () => Promise<typeof import("../views/GroupsView.vue")>;
    }[];
}[];
declare const AdminPermissionsRoutes: {
    path: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    children: {
        path: string;
        name: string;
        component: () => Promise<typeof import("../views/PermissionsView.vue")>;
    }[];
}[];
declare const AdminRolesRoutes: {
    path: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    children: {
        path: string;
        name: string;
        component: () => Promise<typeof import("../views/RolesView.vue")>;
    }[];
}[];
declare const AdminUsersRoutes: {
    path: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    children: {
        path: string;
        name: string;
        component: () => Promise<typeof import("../views/UsersView.vue")>;
    }[];
}[];
declare const AdminRoutes: ({
    path: string;
    name: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    component: () => Promise<typeof import("../views/DashboardView.vue")>;
} | {
    path: string;
    meta: {
        auth: {
            redirect: {
                name: string;
            };
        };
    };
    children: {
        path: string;
        name: string;
        component: () => Promise<typeof import("../views/GroupsView.vue")>;
    }[];
})[];
export default AdminRoutes;
export { AdminDashboardRoutes, AdminActivitiesRoutes, AdminGroupsRoutes, AdminPermissionsRoutes, AdminRolesRoutes, AdminUsersRoutes };
