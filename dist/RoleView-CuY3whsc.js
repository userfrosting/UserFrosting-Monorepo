import { defineComponent as U, resolveComponent as s, openBlock as m, createBlock as b, withCtx as e, createElementVNode as n, createVNode as t, toDisplayString as _, createTextVNode as r, renderSlot as R, createElementBlock as g, Fragment as C, unref as f } from "vue";
import { useRoute as S } from "vue-router";
import { useRoleApi as $ } from "./composable/role.js";
const w = { class: "uk-text-center" }, x = { class: "uk-text-center uk-margin-remove" }, j = { class: "uk-text-meta" }, h = { class: "uk-description-list" }, B = { class: "uk-badge" }, v = /* @__PURE__ */ U({
  __name: "RoleInfo",
  props: {
    role: {}
  },
  setup(F) {
    return (u, o) => {
      const l = s("font-awesome-icon"), a = s("UFCardBox");
      return m(), b(a, null, {
        default: e(() => [
          n("div", w, [
            t(l, {
              icon: "address-card",
              class: "fa-5x"
            })
          ]),
          n("h3", x, _(u.role.name), 1),
          n("p", j, _(u.role.description), 1),
          o[1] || (o[1] = n("hr", null, null, -1)),
          n("dl", h, [
            n("dt", null, [
              t(l, { icon: "users" }),
              o[0] || (o[0] = r(" Users"))
            ]),
            n("dd", null, [
              n("span", B, _(u.role.users_count), 1)
            ])
          ]),
          o[2] || (o[2] = n("hr", null, null, -1)),
          o[3] || (o[3] = n("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit Role ", -1)),
          o[4] || (o[4] = n("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete Role ", -1)),
          R(u.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), y = { class: "uk-button uk-button-default" }, A = { class: "uk-text-meta" }, H = { class: "uk-button uk-button-danger uk-button-small" }, T = /* @__PURE__ */ U({
  __name: "RoleUsers",
  props: {
    slug: {}
  },
  setup(F) {
    return (u, o) => {
      const l = s("font-awesome-icon"), a = s("UFSprunjeHeader"), k = s("RouterLink"), d = s("UFSprunjeColumn"), p = s("UFSprunjeTable"), c = s("UFCardBox");
      return m(), b(c, { title: "Role Users" }, {
        default: e(() => [
          t(p, {
            dataUrl: "/api/roles/r/" + u.slug + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: e(() => [
              n("button", y, [
                t(l, { icon: "user-plus" }),
                o[0] || (o[0] = r(" Add user "))
              ])
            ]),
            header: e(() => [
              t(a, { sort: "name" }, {
                default: e(() => o[1] || (o[1] = [
                  r("User")
                ])),
                _: 1
              }),
              t(a, null, {
                default: e(() => o[2] || (o[2] = [
                  r("Actions")
                ])),
                _: 1
              })
            ]),
            body: e(({ item: i }) => [
              t(d, null, {
                default: e(() => [
                  n("strong", null, [
                    t(k, {
                      to: {
                        name: "admin.user",
                        params: { user_name: i.user_name }
                      }
                    }, {
                      default: e(() => [
                        r(_(i.full_name) + " (" + _(i.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  n("div", A, _(i.email), 1)
                ]),
                _: 2
              }, 1024),
              t(d, null, {
                default: e(() => [
                  n("button", H, [
                    t(l, { icon: "trash" })
                  ])
                ]),
                _: 1
              })
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), P = { class: "uk-button uk-button-default" }, L = { class: "uk-button uk-button-danger uk-button-small" }, V = /* @__PURE__ */ U({
  __name: "RolePermissions",
  props: {
    role: {}
  },
  setup(F) {
    return (u, o) => {
      const l = s("font-awesome-icon"), a = s("UFSprunjeHeader"), k = s("RouterLink"), d = s("UFSprunjeColumn"), p = s("UFSprunjeTable"), c = s("UFCardBox");
      return m(), b(c, { title: "Permissions" }, {
        default: e(() => [
          t(p, {
            dataUrl: "/api/roles/r/" + u.role + "/permissions",
            searchColumn: "name"
          }, {
            actions: e(() => [
              n("button", P, [
                t(l, { icon: "key" }),
                o[0] || (o[0] = r(" Add permission "))
              ])
            ]),
            header: e(() => [
              t(a, { sort: "name" }, {
                default: e(() => o[1] || (o[1] = [
                  r("Permission")
                ])),
                _: 1
              }),
              t(a, { sort: "properties" }, {
                default: e(() => o[2] || (o[2] = [
                  r("Description")
                ])),
                _: 1
              }),
              t(a, null, {
                default: e(() => o[3] || (o[3] = [
                  r("Actions")
                ])),
                _: 1
              })
            ]),
            body: e(({ item: i }) => [
              t(d, null, {
                default: e(() => [
                  n("strong", null, [
                    t(k, {
                      to: {
                        name: "admin.permission",
                        params: { id: i.id }
                      }
                    }, {
                      default: e(() => [
                        r(_(i.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              t(d, null, {
                default: e(() => [
                  r(_(i.description), 1)
                ]),
                _: 2
              }, 1024),
              t(d, null, {
                default: e(() => [
                  n("button", L, [
                    t(l, { icon: "trash" })
                  ])
                ]),
                _: 1
              })
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), D = { "uk-grid": "" }, E = { class: "uk-width-1-3" }, N = { class: "uk-width-2-3" }, I = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, J = /* @__PURE__ */ U({
  __name: "RoleView",
  setup(F) {
    const u = S(), { role: o, error: l } = $(u);
    return (a, k) => {
      const d = s("UFHeaderPage"), p = s("UFAlert"), c = s("UFCardBox");
      return m(), g(C, null, [
        t(d, {
          title: "Role details",
          caption: "Role information page"
        }),
        f(l) ? (m(), b(c, { key: 0 }, {
          default: e(() => [
            t(p, { alert: f(l) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (m(), g(C, { key: 1 }, [
          n("div", D, [
            n("div", E, [
              t(v, { role: f(o) }, null, 8, ["role"])
            ]),
            n("div", N, [
              t(T, {
                slug: f(o).slug
              }, null, 8, ["slug"])
            ])
          ]),
          n("div", I, [
            n("div", null, [
              t(V, {
                role: a.$route.params.slug.toString()
              }, null, 8, ["role"])
            ])
          ])
        ], 64))
      ], 64);
    };
  }
});
export {
  J as default
};
