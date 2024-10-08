import { resolveComponent as t, openBlock as m, createElementBlock as c, Fragment as f, createVNode as e, withCtx as o, createTextVNode as r, createElementVNode as g, toDisplayString as s } from "vue";
import { _ as F } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const U = {};
function x(S, n) {
  const p = t("UFHeaderPage"), l = t("UFSprunjeHeader"), d = t("RouterLink"), a = t("UFSprunjeColumn"), i = t("UFSprunjeTable"), _ = t("UFCardBox");
  return m(), c(f, null, [
    e(p, {
      title: "Groups",
      caption: "A listing of the groups for your site.  Provides management tools for editing and deleting groups."
    }),
    e(_, null, {
      default: o(() => [
        e(i, { dataUrl: "/api/groups" }, {
          header: o(() => [
            e(l, { sort: "name" }, {
              default: o(() => n[0] || (n[0] = [
                r("Groups")
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
          body: o(({ item: u }) => [
            e(a, null, {
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
            e(a, null, {
              default: o(() => [
                r(s(u.description), 1)
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
const k = /* @__PURE__ */ F(U, [["render", x]]);
export {
  k as default
};
