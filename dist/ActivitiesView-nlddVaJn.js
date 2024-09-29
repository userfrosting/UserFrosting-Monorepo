import { resolveComponent as t, openBlock as s, createElementBlock as c, Fragment as m, createElementVNode as o, createVNode as n, withCtx as a, createTextVNode as l } from "vue";
import { _ as f } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const p = {};
function _(d, e) {
  const i = t("font-awesome-icon"), r = t("UFCardBox");
  return s(), c(m, null, [
    e[1] || (e[1] = o("h3", { class: "uk-margin-remove" }, "Activities", -1)),
    e[2] || (e[2] = o("p", { class: "uk-text-meta uk-margin-remove-top" }, "A listing of user activities.", -1)),
    n(r, null, {
      header: a(() => [
        n(i, { icon: "list-check" }),
        e[0] || (e[0] = l(" Activities "))
      ]),
      _: 1
    })
  ], 64);
}
const v = /* @__PURE__ */ f(p, [["render", _]]);
export {
  v as default
};
