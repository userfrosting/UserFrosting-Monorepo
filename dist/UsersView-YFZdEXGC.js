import { resolveComponent as t, openBlock as i, createElementBlock as l, Fragment as c, createVNode as o, withCtx as n, createTextVNode as m, createElementVNode as d } from "vue";
import { _ as u } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const _ = {};
function f(p, e) {
  const r = t("UFHeaderPage"), s = t("font-awesome-icon"), a = t("UFCardBox");
  return i(), l(c, null, [
    o(r, {
      title: "Users",
      caption: `A listing of the users for your site. Provides management tools including the ability to
        edit user details, manually activate users, enable/disable users, and more.`
    }),
    o(a, null, {
      header: n(() => [
        o(s, { icon: "user" }),
        e[0] || (e[0] = m(" Users "))
      ]),
      footer: n(() => e[1] || (e[1] = [
        d("a", {
          href: "#",
          class: "uk-button uk-button-primary"
        }, "Create User", -1)
      ])),
      _: 1
    })
  ], 64);
}
const g = /* @__PURE__ */ u(_, [["render", f]]);
export {
  g as default
};
