const n = [
  {
    path: "dashboard",
    name: "admin.dashboard",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./DashboardView--DjNrx_m.js")
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
    component: () => import("./ActivitiesView-DgDr8nR8.js")
  }
], e = [
  {
    path: "groups",
    name: "admin.groups",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./GroupsView-DzvpkAn1.js"),
    children: [
      {
        path: "g/:slug",
        // groups/g/{slug}
        name: "admin.group",
        component: () => import("./GroupView-Br2XanZz.js")
      }
    ]
  }
], o = [
  {
    path: "permissions",
    name: "admin.permissions",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./PermissionsView-DTXYw4jD.js"),
    children: [
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
    name: "admin.roles",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./RolesView-BMYhrvg7.js"),
    children: [
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
    name: "admin.users",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./UsersView-CMB-o-lB.js"),
    children: [
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
