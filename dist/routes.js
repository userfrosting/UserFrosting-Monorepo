const n = [
  {
    path: "dashboard",
    name: "admin.dashboard",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./DashboardView-Cgrx0SLr.js")
  }
], t = [
  {
    path: "activities",
    name: "admin.activities",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./ActivitiesView-BJRJlLSZ.js")
  }
], e = [
  {
    path: "groups",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    children: [
      {
        path: "",
        name: "admin.groups",
        component: () => import("./GroupsView-BhaXkiIp.js")
      },
      {
        path: "g/:slug",
        name: "admin.group",
        component: () => import("./GroupView-2Qy5dhaD.js")
      }
    ]
  }
], o = [
  {
    path: "permissions",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    children: [
      {
        path: "",
        name: "admin.permissions",
        component: () => import("./PermissionsView-CVJ-Kp0t.js")
      },
      {
        path: "p/:id",
        // permissions/p/{id}
        name: "admin.permission",
        component: () => import("./PermissionView-DhQK9SjC.js")
      }
    ]
  }
], a = [
  {
    path: "roles",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    children: [
      {
        path: "",
        name: "admin.roles",
        component: () => import("./RolesView-Dh16ocgC.js")
      },
      {
        path: "r/:slug",
        // roles/r/{slug}
        name: "admin.role",
        component: () => import("./RoleView-DJn4fof1.js")
      }
    ]
  }
], m = [
  {
    path: "users",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    children: [
      {
        path: "",
        name: "admin.users",
        component: () => import("./UsersView-MO0dK8Sx.js")
      },
      {
        path: "u/:user_name",
        // users/u/{user_name}
        name: "admin.user",
        component: () => import("./UserView-Cwi8FwPa.js")
      }
    ]
  }
], i = [
  ...n,
  ...t,
  ...e,
  ...o,
  ...a,
  ...m
];
export {
  t as AdminActivitiesRoutes,
  n as AdminDashboardRoutes,
  e as AdminGroupsRoutes,
  o as AdminPermissionsRoutes,
  a as AdminRolesRoutes,
  m as AdminUsersRoutes,
  i as default
};
