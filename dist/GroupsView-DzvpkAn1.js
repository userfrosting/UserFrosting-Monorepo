import { resolveComponent as t, openBlock as m, createElementBlock as c, Fragment as f, createVNode as e, withCtx as n, createTextVNode as r, createElementVNode as g, toDisplayString as s } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function x(S, o) {
  const p = t("UFHeaderPage"), l = t("UFSprunjeHeader"), d = t("RouterLink"), u = t("UFSprunjeColumn"), i = t("UFSprunjeTable"), _ = t("UFCardBox");
  return m(), c(f, null, [
    e(p, {
      title: "Groups",
      caption: "A listing of the groups for your site.  Provides management tools for editing and deleting groups."
    }),
    e(_, null, {
      default: n(() => [
        e(i, { dataUrl: "/api/groups" }, {
          header: n(() => [
            e(l, null, {
              default: n(() => o[0] || (o[0] = [
                r("Groups")
              ])),
              _: 1
            }),
            e(l, null, {
              default: n(() => o[1] || (o[1] = [
                r("Description")
              ])),
              _: 1
            }),
            e(l, null, {
              default: n(() => o[2] || (o[2] = [
                r("Actions")
              ])),
              _: 1
            })
          ]),
          body: n(({ item: a }) => [
            e(u, null, {
              default: n(() => [
                g("strong", null, [
                  e(d, {
                    to: {
                      name: "admin.group",
                      params: { slug: a.slug }
                    }
                  }, {
                    default: n(() => [
                      r(s(a.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(u, null, {
              default: n(() => [
                r(s(a.description), 1)
              ]),
              _: 2
            }, 1024),
            e(u)
          ]),
          _: 1
        })
      ]),
      _: 1
    })
  ], 64);
}
const k = /* @__PURE__ */ F(U, [["render", x]]);
export {
  k as default
};
