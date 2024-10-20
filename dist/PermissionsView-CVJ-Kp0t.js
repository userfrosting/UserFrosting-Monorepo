import { resolveComponent as o, openBlock as _, createElementBlock as c, Fragment as f, createVNode as e, withCtx as n, createTextVNode as r, createElementVNode as F, toDisplayString as l } from "vue";
import { _ as U } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const g = {};
function C(S, t) {
  const m = o("UFHeaderPage"), i = o("UFSprunjeHeader"), d = o("RouterLink"), a = o("UFSprunjeColumn"), p = o("UFSprunjeTable"), u = o("UFCardBox");
  return _(), c(f, null, [
    e(m, {
      title: "Permissions",
      caption: "A listing of the permissions for your site.  Provides management tools for editing and deleting permissions."
    }),
    e(u, null, {
      default: n(() => [
        e(p, {
          dataUrl: "/api/permissions",
          searchColumn: "name"
        }, {
          header: n(() => [
            e(i, { sort: "name" }, {
              default: n(() => t[0] || (t[0] = [
                r("Permission")
              ])),
              _: 1
            }),
            e(i, { sort: "properties" }, {
              default: n(() => t[1] || (t[1] = [
                r("Slug/Condition")
              ])),
              _: 1
            })
          ]),
          body: n(({ item: s }) => [
            e(a, null, {
              default: n(() => [
                F("strong", null, [
                  e(d, {
                    to: {
                      name: "admin.permission",
                      params: { id: s.id }
                    }
                  }, {
                    default: n(() => [
                      r(l(s.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(a, null, {
              default: n(() => [
                r(l(s.description), 1)
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
const P = /* @__PURE__ */ U(g, [["render", C]]);
export {
  P as default
};
