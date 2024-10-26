const n = [
  {
    path: "dashboard",
    name: "admin.dashboard",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./DashboardView-D_3JBZn7.js")
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
    component: () => import("./ActivitiesView-zMin4Yo-.js")
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
        component: () => import("./GroupsView-B1HxEK-_.js")
      },
      {
        path: "g/:slug",
        name: "admin.group",
        component: () => import("./GroupView-BwwF9LFo.js")
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
        component: () => import("./PermissionsView-CXWyUe3L.js")
      },
      {
        path: "p/:id",
        // permissions/p/{id}
        name: "admin.permission",
        component: () => import("./PermissionView-B_Cpnimc.js")
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
        component: () => import("./RolesView-BsMEKOXm.js")
      },
      {
        path: "r/:slug",
        // roles/r/{slug}
        name: "admin.role",
        component: () => import("./RoleView-CMpv_-_v.js")
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
        component: () => import("./UsersView-BnC0XV1m.js")
      },
      {
        path: "u/:user_name",
        // users/u/{user_name}
        name: "admin.user",
        component: () => import("./UserView-hTK3dcXV.js")
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
