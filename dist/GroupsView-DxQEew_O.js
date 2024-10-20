import { resolveComponent as r, openBlock as c, createElementBlock as g, Fragment as k, createVNode as t, withCtx as n, createElementVNode as e, createTextVNode as u, toDisplayString as i } from "vue";
import { _ as U } from "./_plugin-vue_export-helper-CHgC5LLL.js";
const b = {}, F = { class: "uk-button uk-button-default" }, w = {
  class: "uk-button uk-button-default uk-button-small",
  type: "button"
};
function x(C, o) {
  const p = r("UFHeaderPage"), d = r("font-awesome-icon"), l = r("UFSprunjeHeader"), m = r("RouterLink"), s = r("UFSprunjeColumn"), _ = r("UFSprunjeTable"), f = r("UFCardBox");
  return c(), g(k, null, [
    t(p, {
      title: "Groups",
      caption: "A listing of the groups for your site.  Provides management tools for editing and deleting groups."
    }),
    t(f, null, {
      default: n(() => [
        t(_, {
          dataUrl: "/api/groups",
          searchColumn: "name"
        }, {
          actions: n(() => [
            e("button", F, [
              t(d, { icon: "Users" }),
              o[0] || (o[0] = u(" Create Group "))
            ])
          ]),
          header: n(() => [
            t(l, { sort: "name" }, {
              default: n(() => o[1] || (o[1] = [
                u("Groups")
              ])),
              _: 1
            }),
            t(l, { sort: "description" }, {
              default: n(() => o[2] || (o[2] = [
                u("Description")
              ])),
              _: 1
            }),
            t(l, null, {
              default: n(() => o[3] || (o[3] = [
                u("Actions")
              ])),
              _: 1
            })
          ]),
          body: n(({ item: a }) => [
            t(s, null, {
              default: n(() => [
                e("strong", null, [
                  t(m, {
                    to: {
                      name: "admin.group",
                      params: { slug: a.slug }
                    }
                  }, {
                    default: n(() => [
                      u(i(a.name), 1)
                    ]),
                    _: 2
                  }, 1032, ["to"])
                ])
              ]),
              _: 2
            }, 1024),
            t(s, null, {
              default: n(() => [
                u(i(a.description), 1)
              ]),
              _: 2
            }, 1024),
            t(s, null, {
              default: n(() => [
                e("button", w, [
                  o[4] || (o[4] = u(" Actions ")),
                  t(d, {
                    icon: "caret-down",
                    "fixed-width": ""
                  })
                ]),
                o[5] || (o[5] = e("div", { "uk-dropdown": "" }, [
                  e("ul", { class: "uk-nav uk-dropdown-nav" }, [
                    e("li", null, [
                      e("a", { href: "#" }, "Edit Group")
                    ]),
                    e("li", null, [
                      e("a", { href: "#" }, "Delete Group")
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
const G = /* @__PURE__ */ U(b, [["render", x]]);
export {
  G as default
};
