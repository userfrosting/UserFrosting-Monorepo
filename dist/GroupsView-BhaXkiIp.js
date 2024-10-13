import { resolveComponent as t, openBlock as _, createElementBlock as c, Fragment as f, createVNode as e, withCtx as o, createTextVNode as r, createElementVNode as g, toDisplayString as s } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function x(C, n) {
  const p = t("UFHeaderPage"), a = t("UFSprunjeHeader"), d = t("RouterLink"), l = t("UFSprunjeColumn"), i = t("UFSprunjeTable"), m = t("UFCardBox");
  return _(), c(f, null, [
    e(p, {
      title: "Groups",
      caption: "A listing of the groups for your site.  Provides management tools for editing and deleting groups."
    }),
    e(m, null, {
      default: o(() => [
        e(i, {
          dataUrl: "/api/groups",
          searchColumn: "name"
        }, {
          header: o(() => [
            e(a, { sort: "name" }, {
              default: o(() => n[0] || (n[0] = [
                r("Groups")
              ])),
              _: 1
            }),
            e(a, { sort: "description" }, {
              default: o(() => n[1] || (n[1] = [
                r("Description")
              ])),
              _: 1
            }),
            e(a, null, {
              default: o(() => n[2] || (n[2] = [
                r("Actions")
              ])),
              _: 1
            })
          ]),
          body: o(({ item: u }) => [
            e(l, null, {
              default: o(() => [
                g("strong", null, [
                  e(d, {
                    to: {
                      name: "admin.group",
                      params: { slug: u.slug }
                    }
                  }, {
                    default: o(() => [
                      r(s(u.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(l, null, {
              default: o(() => [
                r(s(u.description), 1)
              ]),
              _: 2
            }, 1024),
            e(l)
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
