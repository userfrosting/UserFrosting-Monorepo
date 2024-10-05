import { resolveComponent as l, openBlock as c, createElementBlock as f, Fragment as g, createVNode as n, withCtx as e, createTextVNode as i, createElementVNode as o, toDisplayString as s } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function S(x, t) {
  const a = l("UFHeaderPage"), d = l("UFSprunjeHeader"), p = l("RouterLink"), u = l("UFSprunjeColumn"), m = l("UFSprunjeTable"), _ = l("UFCardBox");
  return c(), f(g, null, [
    n(a, {
      title: "Permissions",
      caption: "A listing of the permissions for your site.  Provides management tools for editing and deleting permissions."
    }),
    n(_, null, {
      default: e(() => [
        n(m, { dataUrl: "/api/permissions" }, {
          header: e(() => [
            n(d, null, {
              default: e(() => t[0] || (t[0] = [
                i("Permission")
              ])),
              _: 1
            }),
            n(d, null, {
              default: e(() => t[1] || (t[1] = [
                i("Slug/Condition")
              ])),
              _: 1
            })
          ]),
          body: e(({ item: r }) => [
            n(u, null, {
              default: e(() => [
                o("strong", null, [
                  n(p, {
                    to: {
                      name: "admin.permission",
                      params: { id: r.id }
                    }
                  }, {
                    default: e(() => [
                      i(s(r.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            n(u, null, {
              default: e(() => [
                o("div", null, [
                  o("code", null, s(r.slug), 1)
                ]),
                o("div", null, [
                  t[2] || (t[2] = i(" ↳ ")),
                  o("code", null, s(r.conditions), 1)
                ]),
                o("div", null, [
                  o("i", null, s(r.description), 1)
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
const P = /* @__PURE__ */ F(U, [["render", S]]);
export {
  P as default
};
