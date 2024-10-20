import { ref as F, watch as x, defineComponent as b, resolveComponent as s, openBlock as c, createBlock as g, withCtx as e, createElementVNode as t, createVNode as n, toDisplayString as d, createTextVNode as a, createElementBlock as C, Fragment as v, unref as U } from "vue";
import { useRoute as w } from "vue-router";
import { a as R } from "./axios-CXDYiOMX.js";
import { a as S } from "./types-Daou0lcF.js";
import "./moment-h96o7c8I.js";
function h(p) {
  const u = F(!1), o = F(), l = F({
    id: 0,
    slug: "",
    name: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    users_count: 0
  });
  async function r() {
    u.value = !0, o.value = null, await R.get("/api/roles/r/" + p.params.slug).then((_) => {
      l.value = _.data;
    }).catch((_) => {
      o.value = {
        description: "An error as occurred",
        style: S.Danger,
        ..._.response.data
      };
    }).finally(() => {
      u.value = !1;
    });
  }
  return x(
    () => p.params.slug,
    () => {
      r();
    },
    { immediate: !0 }
  ), { role: l, error: o, loading: u };
}
const j = { class: "uk-text-center" }, $ = { class: "uk-text-center uk-margin-remove" }, B = { class: "uk-text-meta" }, y = { class: "uk-description-list" }, A = { class: "uk-badge" }, H = /* @__PURE__ */ b({
  __name: "RoleInfo",
  props: {
    role: {}
  },
  setup(p) {
    return (u, o) => {
      const l = s("font-awesome-icon"), r = s("UFCardBox");
      return c(), g(r, null, {
        default: e(() => [
          t("div", j, [
            n(l, {
              icon: "address-card",
              class: "fa-5x"
            })
          ]),
          t("h3", $, d(u.role.name), 1),
          t("p", B, d(u.role.description), 1),
          o[1] || (o[1] = t("hr", null, null, -1)),
          t("dl", y, [
            t("dt", null, [
              n(l, { icon: "users" }),
              o[0] || (o[0] = a(" Users"))
            ]),
            t("dd", null, [
              t("span", A, d(u.role.users_count), 1)
            ])
          ]),
          o[2] || (o[2] = t("hr", null, null, -1)),
          o[3] || (o[3] = t("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit Role ", -1)),
          o[4] || (o[4] = t("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete Role ", -1))
        ]),
        _: 1
      });
    };
  }
}), P = { class: "uk-button uk-button-default" }, T = { class: "uk-text-meta" }, L = { class: "uk-button uk-button-danger uk-button-small" }, V = /* @__PURE__ */ b({
  __name: "RoleUsers",
  props: {
    slug: {}
  },
  setup(p) {
    return (u, o) => {
      const l = s("font-awesome-icon"), r = s("UFSprunjeHeader"), _ = s("RouterLink"), m = s("UFSprunjeColumn"), f = s("UFSprunjeTable"), k = s("UFCardBox");
      return c(), g(k, { title: "Role Users" }, {
        default: e(() => [
          n(f, {
            dataUrl: "/api/roles/r/" + u.slug + "/users",
            searchColumn: "name"
          }, {
            actions: e(() => [
              t("button", P, [
                n(l, { icon: "user-plus" }),
                o[0] || (o[0] = a(" Add user "))
              ])
            ]),
            header: e(() => [
              n(r, { sort: "name" }, {
                default: e(() => o[1] || (o[1] = [
                  a("User")
                ])),
                _: 1
              }),
              n(r, null, {
                default: e(() => o[2] || (o[2] = [
                  a("Actions")
                ])),
                _: 1
              })
            ]),
            body: e(({ item: i }) => [
              n(m, null, {
                default: e(() => [
                  t("strong", null, [
                    n(_, {
                      to: {
                        name: "admin.user",
                        params: { user_name: i.user_name }
                      }
                    }, {
                      default: e(() => [
                        a(d(i.full_name) + " (" + d(i.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  t("div", T, d(i.email), 1)
                ]),
                _: 2
              }, 1024),
              n(m, null, {
                default: e(() => [
                  t("button", L, [
                    n(l, { icon: "trash" })
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
}), D = { class: "uk-button uk-button-default" }, E = { class: "uk-button uk-button-danger uk-button-small" }, N = /* @__PURE__ */ b({
  __name: "RolePermissions",
  props: {
    role: {}
  },
  setup(p) {
    return (u, o) => {
      const l = s("font-awesome-icon"), r = s("UFSprunjeHeader"), _ = s("RouterLink"), m = s("UFSprunjeColumn"), f = s("UFSprunjeTable"), k = s("UFCardBox");
      return c(), g(k, { title: "Permissions" }, {
        default: e(() => [
          n(f, {
            dataUrl: "/api/roles/r/" + u.role + "/permissions",
            searchColumn: "name"
          }, {
            actions: e(() => [
              t("button", D, [
                n(l, { icon: "key" }),
                o[0] || (o[0] = a(" Add permission "))
              ])
            ]),
            header: e(() => [
              n(r, { sort: "name" }, {
                default: e(() => o[1] || (o[1] = [
                  a("Permission")
                ])),
                _: 1
              }),
              n(r, { sort: "properties" }, {
                default: e(() => o[2] || (o[2] = [
                  a("Slug/Condition")
                ])),
                _: 1
              }),
              n(r, null, {
                default: e(() => o[3] || (o[3] = [
                  a("Actions")
                ])),
                _: 1
              })
            ]),
            body: e(({ item: i }) => [
              n(m, null, {
                default: e(() => [
                  t("strong", null, [
                    n(_, {
                      to: {
                        name: "admin.permission",
                        params: { id: i.id }
                      }
                    }, {
                      default: e(() => [
                        a(d(i.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              n(m, null, {
                default: e(() => [
                  t("div", null, [
                    t("code", null, d(i.slug), 1)
                  ]),
                  t("div", null, [
                    o[4] || (o[4] = a(" ↳ ")),
                    t("code", null, d(i.conditions), 1)
                  ]),
                  t("div", null, [
                    t("i", null, d(i.description), 1)
                  ])
                ]),
                _: 2
              }, 1024),
              n(m, null, {
                default: e(() => [
                  t("button", E, [
                    n(l, { icon: "trash" })
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
}), I = { "uk-grid": "" }, q = { class: "uk-width-1-3" }, z = { class: "uk-width-2-3" }, G = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, W = /* @__PURE__ */ b({
  __name: "RoleView",
  setup(p) {
    const u = w(), { role: o, error: l } = h(u);
    return (r, _) => {
      const m = s("UFHeaderPage"), f = s("UFAlert"), k = s("UFCardBox");
      return c(), C(v, null, [
        n(m, {
          title: "Role details",
          caption: "Role information page"
        }),
        U(l) ? (c(), g(k, { key: 0 }, {
          default: e(() => [
            n(f, { alert: U(l) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (c(), C(v, { key: 1 }, [
          t("div", I, [
            t("div", q, [
              n(H, { role: U(o) }, null, 8, ["role"])
            ]),
            t("div", z, [
              n(V, {
                slug: U(o).slug
              }, null, 8, ["slug"])
            ])
          ]),
          t("div", G, [
            t("div", null, [
              n(N, {
                role: U(o).slug
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
