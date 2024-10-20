import { ref as F, watch as w, defineComponent as b, resolveComponent as s, openBlock as c, createBlock as g, withCtx as n, createElementVNode as o, createVNode as e, toDisplayString as m, createTextVNode as a, renderSlot as R, createElementBlock as C, Fragment as h, unref as U } from "vue";
import { useRoute as S } from "vue-router";
import { a as v } from "./axios-CXDYiOMX.js";
import { a as x } from "./types-Daou0lcF.js";
function $(p) {
  const l = F(!1), t = F(), r = F({
    id: 0,
    slug: "",
    name: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    users_count: 0
  });
  async function u() {
    l.value = !0, t.value = null, await v.get("/api/roles/r/" + p.params.slug).then((i) => {
      r.value = i.data;
    }).catch((i) => {
      t.value = {
        description: "An error as occurred",
        style: x.Danger,
        ...i.response.data
      };
    }).finally(() => {
      l.value = !1;
    });
  }
  return w(
    () => p.params.slug,
    () => {
      u();
    },
    { immediate: !0 }
  ), { role: r, error: t, loading: l };
}
const j = { class: "uk-text-center" }, B = { class: "uk-text-center uk-margin-remove" }, y = { class: "uk-text-meta" }, A = { class: "uk-description-list" }, H = { class: "uk-badge" }, T = /* @__PURE__ */ b({
  __name: "RoleInfo",
  props: {
    role: {}
  },
  setup(p) {
    return (l, t) => {
      const r = s("font-awesome-icon"), u = s("UFCardBox");
      return c(), g(u, null, {
        default: n(() => [
          o("div", j, [
            e(r, {
              icon: "address-card",
              class: "fa-5x"
            })
          ]),
          o("h3", B, m(l.role.name), 1),
          o("p", y, m(l.role.description), 1),
          t[1] || (t[1] = o("hr", null, null, -1)),
          o("dl", A, [
            o("dt", null, [
              e(r, { icon: "users" }),
              t[0] || (t[0] = a(" Users"))
            ]),
            o("dd", null, [
              o("span", H, m(l.role.users_count), 1)
            ])
          ]),
          t[2] || (t[2] = o("hr", null, null, -1)),
          t[3] || (t[3] = o("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit Role ", -1)),
          t[4] || (t[4] = o("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete Role ", -1)),
          R(l.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), P = { class: "uk-button uk-button-default" }, D = { class: "uk-text-meta" }, L = { class: "uk-button uk-button-danger uk-button-small" }, V = /* @__PURE__ */ b({
  __name: "RoleUsers",
  props: {
    slug: {}
  },
  setup(p) {
    return (l, t) => {
      const r = s("font-awesome-icon"), u = s("UFSprunjeHeader"), i = s("RouterLink"), d = s("UFSprunjeColumn"), f = s("UFSprunjeTable"), k = s("UFCardBox");
      return c(), g(k, { title: "Role Users" }, {
        default: n(() => [
          e(f, {
            dataUrl: "/api/roles/r/" + l.slug + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: n(() => [
              o("button", P, [
                e(r, { icon: "user-plus" }),
                t[0] || (t[0] = a(" Add user "))
              ])
            ]),
            header: n(() => [
              e(u, { sort: "name" }, {
                default: n(() => t[1] || (t[1] = [
                  a("User")
                ])),
                _: 1
              }),
              e(u, null, {
                default: n(() => t[2] || (t[2] = [
                  a("Actions")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: _ }) => [
              e(d, null, {
                default: n(() => [
                  o("strong", null, [
                    e(i, {
                      to: {
                        name: "admin.user",
                        params: { user_name: _.user_name }
                      }
                    }, {
                      default: n(() => [
                        a(m(_.full_name) + " (" + m(_.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  o("div", D, m(_.email), 1)
                ]),
                _: 2
              }, 1024),
              e(d, null, {
                default: n(() => [
                  o("button", L, [
                    e(r, { icon: "trash" })
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
}), E = { class: "uk-button uk-button-default" }, N = { class: "uk-button uk-button-danger uk-button-small" }, I = /* @__PURE__ */ b({
  __name: "RolePermissions",
  props: {
    role: {}
  },
  setup(p) {
    return (l, t) => {
      const r = s("font-awesome-icon"), u = s("UFSprunjeHeader"), i = s("RouterLink"), d = s("UFSprunjeColumn"), f = s("UFSprunjeTable"), k = s("UFCardBox");
      return c(), g(k, { title: "Permissions" }, {
        default: n(() => [
          e(f, {
            dataUrl: "/api/roles/r/" + l.role + "/permissions",
            searchColumn: "name"
          }, {
            actions: n(() => [
              o("button", E, [
                e(r, { icon: "key" }),
                t[0] || (t[0] = a(" Add permission "))
              ])
            ]),
            header: n(() => [
              e(u, { sort: "name" }, {
                default: n(() => t[1] || (t[1] = [
                  a("Permission")
                ])),
                _: 1
              }),
              e(u, { sort: "properties" }, {
                default: n(() => t[2] || (t[2] = [
                  a("Description")
                ])),
                _: 1
              }),
              e(u, null, {
                default: n(() => t[3] || (t[3] = [
                  a("Actions")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: _ }) => [
              e(d, null, {
                default: n(() => [
                  o("strong", null, [
                    e(i, {
                      to: {
                        name: "admin.permission",
                        params: { id: _.id }
                      }
                    }, {
                      default: n(() => [
                        a(m(_.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              e(d, null, {
                default: n(() => [
                  a(m(_.description), 1)
                ]),
                _: 2
              }, 1024),
              e(d, null, {
                default: n(() => [
                  o("button", N, [
                    e(r, { icon: "trash" })
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
}), q = { "uk-grid": "" }, z = { class: "uk-width-1-3" }, G = { class: "uk-width-2-3" }, J = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, W = /* @__PURE__ */ b({
  __name: "RoleView",
  setup(p) {
    const l = S(), { role: t, error: r } = $(l);
    return (u, i) => {
      const d = s("UFHeaderPage"), f = s("UFAlert"), k = s("UFCardBox");
      return c(), C(h, null, [
        e(d, {
          title: "Role details",
          caption: "Role information page"
        }),
        U(r) ? (c(), g(k, { key: 0 }, {
          default: n(() => [
            e(f, { alert: U(r) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (c(), C(h, { key: 1 }, [
          o("div", q, [
            o("div", z, [
              e(T, { role: U(t) }, null, 8, ["role"])
            ]),
            o("div", G, [
              e(V, {
                slug: U(t).slug
              }, null, 8, ["slug"])
            ])
          ]),
          o("div", J, [
            o("div", null, [
              e(I, {
                role: u.$route.params.slug.toString()
              }, null, 8, ["role"])
            ])
          ])
        ], 64))
      ], 64);
    };
  }
});
export {
  W as default
};
