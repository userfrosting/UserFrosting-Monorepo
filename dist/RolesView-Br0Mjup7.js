import { resolveComponent as t, openBlock as m, createElementBlock as c, Fragment as f, createVNode as e, withCtx as o, createTextVNode as r, createElementVNode as g, toDisplayString as d } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function x(S, n) {
  const u = t("UFHeaderPage"), l = t("UFSprunjeHeader"), i = t("RouterLink"), a = t("UFSprunjeColumn"), p = t("UFSprunjeTable"), _ = t("UFCardBox");
  return m(), c(f, null, [
    e(u, {
      title: "Roles",
      caption: "A listing of the roles for your site.  Provides management tools for editing and deleting roles."
    }),
    e(_, null, {
      default: o(() => [
        e(p, { dataUrl: "/api/roles" }, {
          header: o(() => [
            e(l, { sort: "name" }, {
              default: o(() => n[0] || (n[0] = [
                r("Role")
              ])),
              _: 1
            }),
            e(l, { sort: "description" }, {
              default: o(() => n[1] || (n[1] = [
                r("Description")
              ])),
              _: 1
            }),
            e(l, null, {
              default: o(() => n[2] || (n[2] = [
                r("Actions")
              ])),
              _: 1
            })
          ]),
          body: o(({ item: s }) => [
            e(a, null, {
              default: o(() => [
                g("strong", null, [
                  e(i, {
                    to: {
                      name: "admin.role",
                      params: { slug: s.slug }
                    }
                  }, {
                    default: o(() => [
                      r(d(s.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(a, null, {
              default: o(() => [
                r(d(s.description), 1)
              ]),
              _: 2
            }, 1024),
            e(a)
          ]),
          _: 1
        })
      ]),
      _: 1
    })
  ], 64);
}
const R = /* @__PURE__ */ F(U, [["render", x]]);
export {
  R as default
};
