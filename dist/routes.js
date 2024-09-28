const e = [
  {
    path: "dashboard",
    name: "admin.dashboard",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./DashboardView-BbtHCt79.js")
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
    component: () => import("./ActivitiesView-C0jTPO1P.js")
  }
], n = [
  {
    path: "groups",
    name: "admin.groups",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./GroupsView-BXI7Qici.js"),
    children: [
      {
        path: "g/:slug",
        // groups/g/{slug}
        name: "admin.group",
        meta: {
          guest: {
            redirect: { name: "home" }
          }
        },
        component: () => import("./GroupView-R6IL_kMD.js")
      }
    ]
  }
], m = [
  {
    path: "permissions",
    name: "admin.permissions",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./PermissionsView-D5yG-J19.js"),
    children: [
      {
        path: "p/:id",
        // permissions/p/{id}
        name: "admin.permission",
        meta: {
          guest: {
            redirect: { name: "home" }
          }
        },
        component: () => import("./PermissionView-Bo5S_ghn.js")
      }
    ]
  }
], o = [
  {
    path: "roles",
    name: "admin.roles",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./RolesView-TXQJEbIW.js"),
    children: [
      {
        path: "r/:slug",
        // roles/r/{slug}
        name: "admin.role",
        meta: {
          guest: {
            redirect: { name: "home" }
          }
        },
        component: () => import("./RoleView-HTwNAw_F.js")
      }
    ]
  }
], a = [
  {
    path: "users",
    name: "admin.users",
    meta: {
      auth: {
        redirect: { name: "account.login" }
      }
    },
    component: () => import("./UsersView-l_DRqlsU.js"),
    children: [
      {
        path: "u/:user_name",
        // users/u/{user_name}
        name: "admin.user",
        meta: {
          guest: {
            redirect: { name: "home" }
          }
        },
        component: () => import("./UserView-BX3m4dnh.js")
      }
    ]
  }
], i = [
  ...e,
  ...t,
  ...n,
  ...m,
  ...o,
  ...a
];
export {
  t as AdminActivitiesRoutes,
  e as AdminDashboardRoutes,
  n as AdminGroupsRoutes,
  m as AdminPermissionsRoutes,
  o as AdminRolesRoutes,
  a as AdminUsersRoutes,
  i as default
};
