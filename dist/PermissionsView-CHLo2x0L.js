import { resolveComponent as r, openBlock as c, createElementBlock as f, Fragment as g, createVNode as e, withCtx as n, createTextVNode as s, createElementVNode as o, toDisplayString as i } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function C(S, t) {
  const u = r("UFHeaderPage"), a = r("UFSprunjeHeader"), m = r("RouterLink"), d = r("UFSprunjeColumn"), p = r("UFSprunjeTable"), _ = r("UFCardBox");
  return c(), f(g, null, [
    e(u, {
      title: "Permissions",
      caption: "A listing of the permissions for your site.  Provides management tools for editing and deleting permissions."
    }),
    e(_, null, {
      default: n(() => [
        e(p, {
          dataUrl: "/api/permissions",
          searchColumn: "name"
        }, {
          header: n(() => [
            e(a, { sort: "name" }, {
              default: n(() => t[0] || (t[0] = [
                s("Permission")
              ])),
              _: 1
            }),
            e(a, { sort: "properties" }, {
              default: n(() => t[1] || (t[1] = [
                s("Slug/Condition")
              ])),
              _: 1
            })
          ]),
          body: n(({ item: l }) => [
            e(d, null, {
              default: n(() => [
                o("strong", null, [
                  e(m, {
                    to: {
                      name: "admin.permission",
                      params: { id: l.id }
                    }
                  }, {
                    default: n(() => [
                      s(i(l.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(d, null, {
              default: n(() => [
                o("div", null, [
                  o("code", null, i(l.slug), 1)
                ]),
                o("div", null, [
                  t[2] || (t[2] = s(" ↳ ")),
                  o("code", null, i(l.conditions), 1)
                ]),
                o("div", null, [
                  o("i", null, i(l.description), 1)
                ])
              ]),
              _: 2
            }, 1024)
          ]),
          _: 1
        })
      ]),
      _: 1
    })
  ], 64);
}
const P = /* @__PURE__ */ F(U, [["render", C]]);
export {
  P as default
};
