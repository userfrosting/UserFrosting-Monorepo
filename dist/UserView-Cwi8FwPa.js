import { ref as y, watch as B, defineComponent as F, resolveComponent as a, openBlock as d, createBlock as f, withCtx as t, createElementVNode as s, toDisplayString as i, createElementBlock as g, createCommentVNode as $, renderSlot as w, createVNode as n, createTextVNode as r, unref as _, Fragment as C, renderList as A } from "vue";
import { useRoute as x } from "vue-router";
import { a as L } from "./axios-CXDYiOMX.js";
import { a as b } from "./types-Daou0lcF.js";
import { h as j } from "./moment-h96o7c8I.js";
function T(k) {
  const o = y(!1), e = y(), l = y({
    id: 0,
    user_name: "",
    first_name: "",
    last_name: "",
    full_name: "",
    email: "",
    avatar: "",
    flag_enabled: !1,
    flag_verified: !1,
    group_id: null,
    locale: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    locale_name: "",
    group: null
  });
  async function u() {
    o.value = !0, e.value = null, await L.get("/api/users/u/" + k.params.user_name).then((m) => {
      l.value = m.data;
    }).catch((m) => {
      e.value = {
        description: "An error as occurred",
        style: b.Danger,
        ...m.response.data
      };
    }).finally(() => {
      o.value = !1;
    });
  }
  return B(
    () => k.params.user_name,
    () => {
      u();
    },
    { immediate: !0 }
  ), { user: l, error: e, loading: o };
}
const D = { class: "uk-text-center uk-margin" }, H = ["src"], R = { class: "uk-text-center uk-margin-remove" }, Y = {
  key: 0,
  class: "uk-margin-remove uk-text-meta",
  "data-test": "meta"
}, M = { class: "uk-description-list" }, N = { class: "uk-text-meta" }, P = {
  key: 0,
  class: "uk-text-meta"
}, V = {
  key: 1,
  class: "uk-text-meta"
}, E = { class: "uk-text-meta" }, h = { class: "uk-text-meta" }, G = { class: "uk-text-meta" }, I = /* @__PURE__ */ F({
  __name: "UserInfo",
  props: {
    user: {}
  },
  setup(k) {
    return (o, e) => {
      const l = a("font-awesome-icon"), u = a("UFLabel"), m = a("UFCardBox");
      return d(), f(m, null, {
        default: t(() => [
          s("div", D, [
            s("img", {
              src: o.user.avatar,
              alt: "avatar",
              class: "uk-border-circle"
            }, null, 8, H),
            s("h3", R, i(o.user.full_name), 1),
            o.user.user_name ? (d(), g("p", Y, " (" + i(o.user.user_name) + ") ", 1)) : $("", !0),
            w(o.$slots, "default", { dataTest: "slot" })
          ]),
          e[9] || (e[9] = s("hr", null, null, -1)),
          s("dl", M, [
            s("dt", null, [
              n(l, { icon: "envelope" }),
              e[0] || (e[0] = r(" Email"))
            ]),
            s("dd", N, i(o.user.email), 1),
            s("dt", null, [
              n(l, { icon: "users" }),
              e[1] || (e[1] = r(" Group"))
            ]),
            o.user.group ? (d(), g("dd", P, i(o.user.group.name), 1)) : (d(), g("dd", V, e[2] || (e[2] = [
              s("i", null, "None", -1)
            ]))),
            s("dt", null, [
              n(l, { icon: "language" }),
              e[3] || (e[3] = r(" Locale"))
            ]),
            s("dd", E, i(o.user.locale_name), 1),
            s("dt", null, [
              n(l, { icon: "user-shield" }),
              e[4] || (e[4] = r(" Status"))
            ]),
            s("dd", h, [
              o.user.flag_enabled == !1 ? (d(), f(u, {
                key: 0,
                severity: _(b).Danger
              }, {
                default: t(() => e[5] || (e[5] = [
                  r(" Disabled ")
                ])),
                _: 1
              }, 8, ["severity"])) : o.user.flag_verified == !1 ? (d(), f(u, {
                key: 1,
                severity: _(b).Warning
              }, {
                default: t(() => e[6] || (e[6] = [
                  r(" Unactivated ")
                ])),
                _: 1
              }, 8, ["severity"])) : (d(), f(u, {
                key: 2,
                severity: _(b).Success
              }, {
                default: t(() => e[7] || (e[7] = [
                  r("Active")
                ])),
                _: 1
              }, 8, ["severity"]))
            ]),
            s("dt", null, [
              n(l, { icon: "calendar" }),
              e[8] || (e[8] = r(" Created on"))
            ]),
            s("dd", G, i(_(j)(o.user.created_at).format("MMMM Do, YYYY")), 1)
          ]),
          e[10] || (e[10] = s("hr", null, null, -1)),
          e[11] || (e[11] = s("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit User ", -1)),
          e[12] || (e[12] = s("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete User ", -1)),
          w(o.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), W = /* @__PURE__ */ F({
  __name: "UserActivities",
  props: {
    user_name: {}
  },
  setup(k) {
    return (o, e) => {
      const l = a("UFSprunjeHeader"), u = a("UFSprunjeColumn"), m = a("UFSprunjeTable"), c = a("UFCardBox");
      return d(), f(c, { title: "Activities" }, {
        default: t(() => [
          n(m, {
            dataUrl: "/api/users/u/" + o.user_name + "/activities",
            defaultSorts: { occurred_at: "desc" }
          }, {
            header: t(() => [
              n(l, { sort: "occurred_at" }, {
                default: t(() => e[0] || (e[0] = [
                  r("Activity Time")
                ])),
                _: 1
              }),
              n(l, { sort: "description" }, {
                default: t(() => e[1] || (e[1] = [
                  r("Description")
                ])),
                _: 1
              })
            ]),
            body: t(({ item: p }) => [
              n(u, null, {
                default: t(() => [
                  s("div", null, i(_(j)(p.occurred_at).format("dddd")), 1),
                  s("div", null, i(_(j)(p.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              n(u, null, {
                default: t(() => [
                  s("div", null, i(p.ip_address), 1),
                  s("div", null, [
                    s("i", null, i(p.description), 1)
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
}), q = { class: "uk-button uk-button-default" }, z = { class: "uk-button uk-button-danger uk-button-small" }, J = /* @__PURE__ */ F({
  __name: "UserRoles",
  props: {
    slug: {}
  },
  setup(k) {
    return (o, e) => {
      const l = a("font-awesome-icon"), u = a("UFSprunjeHeader"), m = a("RouterLink"), c = a("UFSprunjeColumn"), p = a("UFSprunjeTable"), v = a("UFCardBox");
      return d(), f(v, { title: "Roles" }, {
        default: t(() => [
          n(p, {
            dataUrl: "/api/users/u/" + o.slug + "/roles",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: t(() => [
              s("button", q, [
                n(l, { icon: "address-card" }),
                e[0] || (e[0] = r(" Add role "))
              ])
            ]),
            header: t(() => [
              n(u, { sort: "name" }, {
                default: t(() => e[1] || (e[1] = [
                  r("Role")
                ])),
                _: 1
              }),
              n(u, { sort: "description" }, {
                default: t(() => e[2] || (e[2] = [
                  r("Description")
                ])),
                _: 1
              }),
              n(u, { sort: "description" }, {
                default: t(() => e[3] || (e[3] = [
                  r("Actions")
                ])),
                _: 1
              })
            ]),
            body: t(({ item: U }) => [
              n(c, null, {
                default: t(() => [
                  s("strong", null, [
                    n(m, {
                      to: {
                        name: "admin.role",
                        params: { slug: U.slug }
                      }
                    }, {
                      default: t(() => [
                        r(i(U.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              n(c, null, {
                default: t(() => [
                  r(i(U.description), 1)
                ]),
                _: 2
              }, 1024),
              n(c, null, {
                default: t(() => [
                  s("button", z, [
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
}), K = /* @__PURE__ */ F({
  __name: "UserPermissions",
  props: {
    user_name: {}
  },
  setup(k) {
    return (o, e) => {
      const l = a("UFSprunjeHeader"), u = a("RouterLink"), m = a("UFSprunjeColumn"), c = a("UFLabel"), p = a("UFSprunjeTable"), v = a("UFCardBox");
      return d(), f(v, { title: "Permissions" }, {
        default: t(() => [
          n(p, {
            dataUrl: "/api/users/u/" + o.user_name + "/permissions",
            searchColumn: "name"
          }, {
            header: t(() => [
              n(l, { sort: "name" }, {
                default: t(() => e[0] || (e[0] = [
                  r("Permission")
                ])),
                _: 1
              }),
              n(l, { sort: "properties" }, {
                default: t(() => e[1] || (e[1] = [
                  r("Slug/Condition")
                ])),
                _: 1
              }),
              n(l, null, {
                default: t(() => e[2] || (e[2] = [
                  r("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: t(({ item: U }) => [
              n(m, null, {
                default: t(() => [
                  s("strong", null, [
                    n(u, {
                      to: {
                        name: "admin.permission",
                        params: { id: U.id }
                      }
                    }, {
                      default: t(() => [
                        r(i(U.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              n(m, null, {
                default: t(() => [
                  r(i(U.description), 1)
                ]),
                _: 2
              }, 1024),
              n(m, null, {
                default: t(() => [
                  (d(!0), g(C, null, A(U.roles_via, (S) => (d(), f(u, {
                    key: S.id,
                    to: { name: "admin.role", params: { slug: S.slug } }
                  }, {
                    default: t(() => [
                      n(c, null, {
                        default: t(() => [
                          r(i(S.name), 1)
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
}), O = { "uk-grid": "" }, Q = { class: "uk-width-1-3" }, X = { class: "uk-width-2-3" }, Z = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, re = /* @__PURE__ */ F({
  __name: "UserView",
  setup(k) {
    const o = x(), { user: e, error: l } = T(o);
    return (u, m) => {
      const c = a("UFHeaderPage"), p = a("UFAlert"), v = a("UFCardBox");
      return d(), g(C, null, [
        n(c, {
          title: "User details",
          caption: "User information page"
        }),
        _(l) ? (d(), f(v, { key: 0 }, {
          default: t(() => [
            n(p, { alert: _(l) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (d(), g(C, { key: 1 }, [
          s("div", O, [
            s("div", Q, [
              n(I, { user: _(e) }, null, 8, ["user"])
            ]),
            s("div", X, [
              n(J, {
                slug: _(e).user_name
              }, null, 8, ["slug"])
            ])
          ]),
          s("div", Z, [
            s("div", null, [
              n(K, {
                user_name: _(e).user_name
              }, null, 8, ["user_name"])
            ]),
            s("div", null, [
              n(W, {
                user_name: u.$route.params.user_name.toString()
              }, null, 8, ["user_name"])
            ])
          ])
        ], 64))
      ], 64);
    };
  }
});
export {
  re as default
};
