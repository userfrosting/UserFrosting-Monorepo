import { resolveComponent as t, openBlock as m, createElementBlock as c, Fragment as f, createVNode as e, withCtx as n, createTextVNode as l, createElementVNode as g, toDisplayString as u } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function x(S, o) {
  const d = t("UFHeaderPage"), r = t("UFSprunjeHeader"), i = t("RouterLink"), a = t("UFSprunjeColumn"), p = t("UFSprunjeTable"), _ = t("UFCardBox");
  return m(), c(f, null, [
    e(d, {
      title: "Roles",
      caption: "A listing of the roles for your site.  Provides management tools for editing and deleting roles."
    }),
    e(_, null, {
      default: n(() => [
        e(p, { dataUrl: "/api/roles" }, {
          header: n(() => [
            e(r, null, {
              default: n(() => o[0] || (o[0] = [
                l("Role")
              ])),
              _: 1
            }),
            e(r, null, {
              default: n(() => o[1] || (o[1] = [
                l("Description")
              ])),
              _: 1
            }),
            e(r, null, {
              default: n(() => o[2] || (o[2] = [
                l("Actions")
              ])),
              _: 1
            })
          ]),
          body: n(({ item: s }) => [
            e(a, null, {
              default: n(() => [
                g("strong", null, [
                  e(i, {
                    to: {
                      name: "admin.role",
                      params: { slug: s.slug }
                    }
                  }, {
                    default: n(() => [
                      l(u(s.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(a, null, {
              default: n(() => [
                l(u(s.description), 1)
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
