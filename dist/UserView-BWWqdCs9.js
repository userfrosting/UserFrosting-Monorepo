import { defineComponent as F, resolveComponent as r, openBlock as d, createBlock as k, withCtx as n, createElementVNode as t, toDisplayString as i, createElementBlock as U, createCommentVNode as w, renderSlot as j, createVNode as o, createTextVNode as s, unref as m, Fragment as S, renderList as B } from "vue";
import { useRoute as $ } from "vue-router";
import { useUserAdminApi as x } from "./composable/user.js";
import { a as C } from "./types-Daou0lcF.js";
import { h as y } from "./moment-h96o7c8I.js";
const A = { class: "uk-text-center uk-margin" }, D = ["src"], L = { class: "uk-text-center uk-margin-remove" }, T = {
  key: 0,
  class: "uk-margin-remove uk-text-meta",
  "data-test": "meta"
}, H = { class: "uk-description-list" }, R = { class: "uk-text-meta" }, Y = {
  key: 0,
  class: "uk-text-meta"
}, M = {
  key: 1,
  class: "uk-text-meta"
}, P = { class: "uk-text-meta" }, N = { class: "uk-text-meta" }, V = { class: "uk-text-meta" }, E = /* @__PURE__ */ F({
  __name: "UserInfo",
  props: {
    user: {}
  },
  setup(g) {
    return (u, e) => {
      const l = r("font-awesome-icon"), a = r("UFLabel"), _ = r("UFCardBox");
      return d(), k(_, null, {
        default: n(() => [
          t("div", A, [
            t("img", {
              src: u.user.avatar,
              alt: "avatar",
              class: "uk-border-circle"
            }, null, 8, D),
            t("h3", L, i(u.user.full_name), 1),
            u.user.user_name ? (d(), U("p", T, " (" + i(u.user.user_name) + ") ", 1)) : w("", !0),
            j(u.$slots, "default", { dataTest: "slot" })
          ]),
          e[9] || (e[9] = t("hr", null, null, -1)),
          t("dl", H, [
            t("dt", null, [
              o(l, { icon: "envelope" }),
              e[0] || (e[0] = s(" Email"))
            ]),
            t("dd", R, i(u.user.email), 1),
            t("dt", null, [
              o(l, { icon: "users" }),
              e[1] || (e[1] = s(" Group"))
            ]),
            u.user.group ? (d(), U("dd", Y, i(u.user.group.name), 1)) : (d(), U("dd", M, e[2] || (e[2] = [
              t("i", null, "None", -1)
            ]))),
            t("dt", null, [
              o(l, { icon: "language" }),
              e[3] || (e[3] = s(" Locale"))
            ]),
            t("dd", P, i(u.user.locale_name), 1),
            t("dt", null, [
              o(l, { icon: "user-shield" }),
              e[4] || (e[4] = s(" Status"))
            ]),
            t("dd", N, [
              u.user.flag_enabled == !1 ? (d(), k(a, {
                key: 0,
                severity: m(C).Danger
              }, {
                default: n(() => e[5] || (e[5] = [
                  s(" Disabled ")
                ])),
                _: 1
              }, 8, ["severity"])) : u.user.flag_verified == !1 ? (d(), k(a, {
                key: 1,
                severity: m(C).Warning
              }, {
                default: n(() => e[6] || (e[6] = [
                  s(" Unactivated ")
                ])),
                _: 1
              }, 8, ["severity"])) : (d(), k(a, {
                key: 2,
                severity: m(C).Success
              }, {
                default: n(() => e[7] || (e[7] = [
                  s("Active")
                ])),
                _: 1
              }, 8, ["severity"]))
            ]),
            t("dt", null, [
              o(l, { icon: "calendar" }),
              e[8] || (e[8] = s(" Created on"))
            ]),
            t("dd", V, i(m(y)(u.user.created_at).format("MMMM Do, YYYY")), 1)
          ]),
          e[10] || (e[10] = t("hr", null, null, -1)),
          e[11] || (e[11] = t("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit User ", -1)),
          e[12] || (e[12] = t("button", { class: "uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Change User Password ", -1)),
          e[13] || (e[13] = t("button", { class: "uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Disable User ", -1)),
          e[14] || (e[14] = t("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete User ", -1)),
          j(u.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), G = /* @__PURE__ */ F({
  __name: "UserActivities",
  props: {
    user_name: {}
  },
  setup(g) {
    return (u, e) => {
      const l = r("UFSprunjeHeader"), a = r("UFSprunjeColumn"), _ = r("UFSprunjeTable"), f = r("UFCardBox");
      return d(), k(f, { title: "Activities" }, {
        default: n(() => [
          o(_, {
            dataUrl: "/api/users/u/" + u.user_name + "/activities",
            defaultSorts: { occurred_at: "desc" }
          }, {
            header: n(() => [
              o(l, { sort: "occurred_at" }, {
                default: n(() => e[0] || (e[0] = [
                  s("Activity Time")
                ])),
                _: 1
              }),
              o(l, { sort: "description" }, {
                default: n(() => e[1] || (e[1] = [
                  s("Description")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: p }) => [
              o(a, null, {
                default: n(() => [
                  t("div", null, i(m(y)(p.occurred_at).format("dddd")), 1),
                  t("div", null, i(m(y)(p.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              o(a, null, {
                default: n(() => [
                  t("div", null, i(p.ip_address), 1),
                  t("div", null, [
                    t("i", null, i(p.description), 1)
                  ])
                ]),
                _: 2
              }, 1024)
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), I = { class: "uk-button uk-button-default" }, W = { class: "uk-button uk-button-danger uk-button-small" }, q = /* @__PURE__ */ F({
  __name: "UserRoles",
  props: {
    slug: {}
  },
  setup(g) {
    return (u, e) => {
      const l = r("font-awesome-icon"), a = r("UFSprunjeHeader"), _ = r("RouterLink"), f = r("UFSprunjeColumn"), p = r("UFSprunjeTable"), b = r("UFCardBox");
      return d(), k(b, { title: "Roles" }, {
        default: n(() => [
          o(p, {
            dataUrl: "/api/users/u/" + u.slug + "/roles",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: n(() => [
              t("button", I, [
                o(l, { icon: "address-card" }),
                e[0] || (e[0] = s(" Add role "))
              ])
            ]),
            header: n(() => [
              o(a, { sort: "name" }, {
                default: n(() => e[1] || (e[1] = [
                  s("Role")
                ])),
                _: 1
              }),
              o(a, { sort: "description" }, {
                default: n(() => e[2] || (e[2] = [
                  s("Description")
                ])),
                _: 1
              }),
              o(a, { sort: "description" }, {
                default: n(() => e[3] || (e[3] = [
                  s("Actions")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: c }) => [
              o(f, null, {
                default: n(() => [
                  t("strong", null, [
                    o(_, {
                      to: {
                        name: "admin.role",
                        params: { slug: c.slug }
                      }
                    }, {
                      default: n(() => [
                        s(i(c.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              o(f, null, {
                default: n(() => [
                  s(i(c.description), 1)
                ]),
                _: 2
              }, 1024),
              o(f, null, {
                default: n(() => [
                  t("button", W, [
                    o(l, { icon: "trash" })
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
}), z = /* @__PURE__ */ F({
  __name: "UserPermissions",
  props: {
    user_name: {}
  },
  setup(g) {
    return (u, e) => {
      const l = r("UFSprunjeHeader"), a = r("RouterLink"), _ = r("UFSprunjeColumn"), f = r("UFLabel"), p = r("UFSprunjeTable"), b = r("UFCardBox");
      return d(), k(b, { title: "Permissions" }, {
        default: n(() => [
          o(p, {
            dataUrl: "/api/users/u/" + u.user_name + "/permissions",
            searchColumn: "name"
          }, {
            header: n(() => [
              o(l, { sort: "name" }, {
                default: n(() => e[0] || (e[0] = [
                  s("Permission")
                ])),
                _: 1
              }),
              o(l, { sort: "properties" }, {
                default: n(() => e[1] || (e[1] = [
                  s("Description")
                ])),
                _: 1
              }),
              o(l, null, {
                default: n(() => e[2] || (e[2] = [
                  s("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: c }) => [
              o(_, null, {
                default: n(() => [
                  t("strong", null, [
                    o(a, {
                      to: {
                        name: "admin.permission",
                        params: { id: c.id }
                      }
                    }, {
                      default: n(() => [
                        s(i(c.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              o(_, null, {
                default: n(() => [
                  s(i(c.description), 1)
                ]),
                _: 2
              }, 1024),
              o(_, null, {
                default: n(() => [
                  (d(!0), U(S, null, B(c.roles_via, (v) => (d(), k(a, {
                    key: v.id,
                    to: { name: "admin.role", params: { slug: v.slug } }
                  }, {
                    default: n(() => [
                      o(f, null, {
                        default: n(() => [
                          s(i(v.name), 1)
                        ]),
                        _: 2
                      }, 1024)
                    ]),
                    _: 2
                  }, 1032, ["to"]))), 128))
                ]),
                _: 2
              }, 1024)
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), J = { "uk-grid": "" }, K = { class: "uk-width-1-3" }, O = { class: "uk-width-2-3" }, Q = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, ne = /* @__PURE__ */ F({
  __name: "UserView",
  setup(g) {
    const u = $(), { user: e, error: l } = x(u);
    return (a, _) => {
      const f = r("UFHeaderPage"), p = r("UFAlert"), b = r("UFCardBox");
      return d(), U(S, null, [
        o(f, {
          title: "User details",
          caption: "User information page"
        }),
        m(l) ? (d(), k(b, { key: 0 }, {
          default: n(() => [
            o(p, { alert: m(l) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (d(), U(S, { key: 1 }, [
          t("div", J, [
            t("div", K, [
              o(E, { user: m(e) }, null, 8, ["user"])
            ]),
            t("div", O, [
              o(q, {
                slug: m(e).user_name
              }, null, 8, ["slug"])
            ])
          ]),
          t("div", Q, [
            t("div", null, [
              o(z, {
                user_name: m(e).user_name
              }, null, 8, ["user_name"])
            ]),
            t("div", null, [
              o(G, {
                user_name: a.$route.params.user_name.toString()
              }, null, 8, ["user_name"])
            ])
          ])
        ], 64))
      ], 64);
    };
  }
});
export {
  ne as default
};
