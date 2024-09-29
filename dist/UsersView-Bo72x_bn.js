import { resolveComponent as o, openBlock as i, createElementBlock as m, Fragment as l, createElementVNode as t, createVNode as r, withCtx as n, createTextVNode as u } from "vue";
import { _ as d } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const f = {};
function c(p, e) {
  const s = o("font-awesome-icon"), a = o("UFCardBox");
  return i(), m(l, null, [
    e[2] || (e[2] = t("h3", { class: "uk-margin-remove" }, "Users", -1)),
    e[3] || (e[3] = t("p", { class: "uk-text-meta uk-margin-remove-top" }, " A listing of the users for your site. Provides management tools including the ability to edit user details, manually activate users, enable/disable users, and more. ", -1)),
    r(a, null, {
      header: n(() => [
        r(s, { icon: "user" }),
        e[0] || (e[0] = u(" Users "))
      ]),
      footer: n(() => e[1] || (e[1] = [
        t("a", {
          href: "#",
          class: "uk-button uk-button-primary"
        }, "Create User", -1)
      ])),
      _: 1
    })
  ], 64);
}
const k = /* @__PURE__ */ d(f, [["render", c]]);
export {
  k as default
};
