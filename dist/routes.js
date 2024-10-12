const n = [
  {
    path: "dashboard",
    name: "admin.dashboard",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./DashboardView-DvU4PBgd.js")
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
    component: () => import("./ActivitiesView-BPs4raaf.js")
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
        component: () => import("./GroupsView-Bm9TF1U3.js")
      },
      {
        path: "g/:slug",
        name: "admin.group",
        component: () => import("./GroupView-Di3uAdBk.js")
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
        component: () => import("./PermissionsView-C-572ZCS.js")
      },
      {
        path: "p/:id",
        // permissions/p/{id}
        name: "admin.permission",
        component: () => import("./PermissionView-CrT77lW9.js")
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
        component: () => import("./RolesView-Br0Mjup7.js")
      },
      {
        path: "r/:slug",
        // roles/r/{slug}
        name: "admin.role",
        component: () => import("./RoleView-DdLudICm.js")
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
        component: () => import("./UsersView-BudQS2wW.js")
      },
      {
        path: "u/:user_name",
        // users/u/{user_name}
        name: "admin.user",
        component: () => import("./UserView-jTy8GhIn.js")
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
