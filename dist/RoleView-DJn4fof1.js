import { ref as F, watch as S, defineComponent as b, resolveComponent as s, openBlock as c, createBlock as g, withCtx as n, createElementVNode as t, createVNode as e, toDisplayString as i, createTextVNode as a, renderSlot as w, createElementBlock as C, Fragment as v, unref as U } from "vue";
import { useRoute as R } from "vue-router";
import { a as x } from "./axios-CXDYiOMX.js";
import { a as $ } from "./types-Daou0lcF.js";
function h(p) {
  const l = F(!1), o = F(), r = F({
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
    l.value = !0, o.value = null, await x.get("/api/roles/r/" + p.params.slug).then((_) => {
      r.value = _.data;
    }).catch((_) => {
      o.value = {
        description: "An error as occurred",
        style: $.Danger,
        ..._.response.data
      };
    }).finally(() => {
      l.value = !1;
    });
  }
  return S(
    () => p.params.slug,
    () => {
      u();
    },
    { immediate: !0 }
  ), { role: r, error: o, loading: l };
}
const j = { class: "uk-text-center" }, B = { class: "uk-text-center uk-margin-remove" }, y = { class: "uk-text-meta" }, A = { class: "uk-description-list" }, H = { class: "uk-badge" }, T = /* @__PURE__ */ b({
  __name: "RoleInfo",
  props: {
    role: {}
  },
  setup(p) {
    return (l, o) => {
      const r = s("font-awesome-icon"), u = s("UFCardBox");
      return c(), g(u, null, {
        default: n(() => [
          t("div", j, [
            e(r, {
              icon: "address-card",
              class: "fa-5x"
            })
          ]),
          t("h3", B, i(l.role.name), 1),
          t("p", y, i(l.role.description), 1),
          o[1] || (o[1] = t("hr", null, null, -1)),
          t("dl", A, [
            t("dt", null, [
              e(r, { icon: "users" }),
              o[0] || (o[0] = a(" Users"))
            ]),
            t("dd", null, [
              t("span", H, i(l.role.users_count), 1)
            ])
          ]),
          o[2] || (o[2] = t("hr", null, null, -1)),
          o[3] || (o[3] = t("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit Role ", -1)),
          o[4] || (o[4] = t("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete Role ", -1)),
          w(l.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), P = { class: "uk-button uk-button-default" }, L = { class: "uk-text-meta" }, V = { class: "uk-button uk-button-danger uk-button-small" }, D = /* @__PURE__ */ b({
  __name: "RoleUsers",
  props: {
    slug: {}
  },
  setup(p) {
    return (l, o) => {
      const r = s("font-awesome-icon"), u = s("UFSprunjeHeader"), _ = s("RouterLink"), m = s("UFSprunjeColumn"), f = s("UFSprunjeTable"), k = s("UFCardBox");
      return c(), g(k, { title: "Role Users" }, {
        default: n(() => [
          e(f, {
            dataUrl: "/api/roles/r/" + l.slug + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: n(() => [
              t("button", P, [
                e(r, { icon: "user-plus" }),
                o[0] || (o[0] = a(" Add user "))
              ])
            ]),
            header: n(() => [
              e(u, { sort: "name" }, {
                default: n(() => o[1] || (o[1] = [
                  a("User")
                ])),
                _: 1
              }),
              e(u, null, {
                default: n(() => o[2] || (o[2] = [
                  a("Actions")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: d }) => [
              e(m, null, {
                default: n(() => [
                  t("strong", null, [
                    e(_, {
                      to: {
                        name: "admin.user",
                        params: { user_name: d.user_name }
                      }
                    }, {
                      default: n(() => [
                        a(i(d.full_name) + " (" + i(d.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  t("div", L, i(d.email), 1)
                ]),
                _: 2
              }, 1024),
              e(m, null, {
                default: n(() => [
                  t("button", V, [
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
    return (l, o) => {
      const r = s("font-awesome-icon"), u = s("UFSprunjeHeader"), _ = s("RouterLink"), m = s("UFSprunjeColumn"), f = s("UFSprunjeTable"), k = s("UFCardBox");
      return c(), g(k, { title: "Permissions" }, {
        default: n(() => [
          e(f, {
            dataUrl: "/api/roles/r/" + l.role + "/permissions",
            searchColumn: "name"
          }, {
            actions: n(() => [
              t("button", E, [
                e(r, { icon: "key" }),
                o[0] || (o[0] = a(" Add permission "))
              ])
            ]),
            header: n(() => [
              e(u, { sort: "name" }, {
                default: n(() => o[1] || (o[1] = [
                  a("Permission")
                ])),
                _: 1
              }),
              e(u, { sort: "properties" }, {
                default: n(() => o[2] || (o[2] = [
                  a("Slug/Condition")
                ])),
                _: 1
              }),
              e(u, null, {
                default: n(() => o[3] || (o[3] = [
                  a("Actions")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: d }) => [
              e(m, null, {
                default: n(() => [
                  t("strong", null, [
                    e(_, {
                      to: {
                        name: "admin.permission",
                        params: { id: d.id }
                      }
                    }, {
                      default: n(() => [
                        a(i(d.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              e(m, null, {
                default: n(() => [
                  t("div", null, [
                    t("code", null, i(d.slug), 1)
                  ]),
                  t("div", null, [
                    o[4] || (o[4] = a(" ↳ ")),
                    t("code", null, i(d.conditions), 1)
                  ]),
                  t("div", null, [
                    t("i", null, i(d.description), 1)
                  ])
                ]),
                _: 2
              }, 1024),
              e(m, null, {
                default: n(() => [
                  t("button", N, [
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
    const l = R(), { role: o, error: r } = h(l);
    return (u, _) => {
      const m = s("UFHeaderPage"), f = s("UFAlert"), k = s("UFCardBox");
      return c(), C(v, null, [
        e(m, {
          title: "Role details",
          caption: "Role information page"
        }),
        U(r) ? (c(), g(k, { key: 0 }, {
          default: n(() => [
            e(f, { alert: U(r) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (c(), C(v, { key: 1 }, [
          t("div", q, [
            t("div", z, [
              e(T, { role: U(o) }, null, 8, ["role"])
            ]),
            t("div", G, [
              e(D, {
                slug: U(o).slug
              }, null, 8, ["slug"])
            ])
          ]),
          t("div", J, [
            t("div", null, [
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
