import { resolveComponent as l, openBlock as c, createElementBlock as k, Fragment as b, createVNode as e, withCtx as t, createElementVNode as n, createTextVNode as r, toDisplayString as i } from "vue";
import { _ as g } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const F = {}, U = { class: "uk-button uk-button-default" }, w = {
  class: "uk-button uk-button-default uk-button-small",
  type: "button"
};
function x(C, o) {
  const p = l("UFHeaderPage"), d = l("font-awesome-icon"), s = l("UFSprunjeHeader"), m = l("RouterLink"), u = l("UFSprunjeColumn"), _ = l("UFSprunjeTable"), f = l("UFCardBox");
  return c(), k(b, null, [
    e(p, {
      title: "Roles",
      caption: "A listing of the roles for your site.  Provides management tools for editing and deleting roles."
    }),
    e(f, null, {
      default: t(() => [
        e(_, {
          dataUrl: "/api/roles",
          searchColumn: "name"
        }, {
          actions: t(() => [
            n("button", U, [
              e(d, { icon: "address-card" }),
              o[0] || (o[0] = r(" Create Role "))
            ])
          ]),
          header: t(() => [
            e(s, { sort: "name" }, {
              default: t(() => o[1] || (o[1] = [
                r("Role")
              ])),
              _: 1
            }),
            e(s, { sort: "description" }, {
              default: t(() => o[2] || (o[2] = [
                r("Description")
              ])),
              _: 1
            }),
            e(s, null, {
              default: t(() => o[3] || (o[3] = [
                r("Actions")
              ])),
              _: 1
            })
          ]),
          body: t(({ item: a }) => [
            e(u, null, {
              default: t(() => [
                n("strong", null, [
                  e(m, {
                    to: {
                      name: "admin.role",
                      params: { slug: a.slug }
                    }
                  }, {
                    default: t(() => [
                      r(i(a.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            e(u, null, {
              default: t(() => [
                r(i(a.description), 1)
              ]),
              _: 2
            }, 1024),
            e(u, null, {
              default: t(() => [
                n("button", w, [
                  o[4] || (o[4] = r(" Actions ")),
                  e(d, {
                    icon: "caret-down",
                    "fixed-width": ""
                  })
                ]),
                o[5] || (o[5] = n("div", { "uk-dropdown": "" }, [
                  n("ul", { class: "uk-nav uk-dropdown-nav" }, [
                    n("li", null, [
                      n("a", { href: "#" }, "Edit Role")
                    ]),
                    n("li", null, [
                      n("a", { href: "#" }, "Delete Role")
                    ])
                  ])
                ], -1))
              ]),
              _: 1
            })
          ]),
          _: 1
        })
      ]),
      _: 1
    })
  ], 64);
}
const j = /* @__PURE__ */ g(F, [["render", x]]);
export {
  j as default
};
