import { resolveComponent as o, openBlock as n, createElementBlock as s, Fragment as r, createVNode as a } from "vue";
import { _ as t } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const c = {};
function m(i, l) {
  const e = o("UFSideBarItem");
  return n(), s(r, null, [
    a(e, {
      to: { name: "admin.dashboard" },
      faIcon: "gauge-high",
      label: "Dashboard"
    }),
    a(e, {
      to: { name: "admin.users" },
      faIcon: "user",
      label: "Users"
    }),
    a(e, {
      to: { name: "admin.activities" },
      faIcon: "list-check",
      label: "Activities"
    }),
    a(e, {
      to: { name: "admin.roles" },
      faIcon: "address-card",
      label: "Roles"
    }),
    a(e, {
      to: { name: "admin.permissions" },
      faIcon: "key",
      label: "Permissions"
    }),
    a(e, {
      to: { name: "admin.groups" },
      faIcon: "users",
      label: "Groups"
    })
  ], 64);
}
const _ = /* @__PURE__ */ t(c, [["render", m]]);
export {
  _ as SidebarMenuItems
};
