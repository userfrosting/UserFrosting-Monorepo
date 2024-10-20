import { ref as C, watch as B, defineComponent as v, resolveComponent as u, openBlock as d, createBlock as c, withCtx as n, createElementVNode as t, toDisplayString as i, createElementBlock as b, createCommentVNode as $, renderSlot as w, createVNode as s, createTextVNode as r, unref as _, Fragment as S, renderList as A } from "vue";
import { useRoute as x } from "vue-router";
import { a as D } from "./axios-CXDYiOMX.js";
import { a as F } from "./types-Daou0lcF.js";
import { h as j } from "./moment-h96o7c8I.js";
function L(U) {
  const o = C(!1), e = C(), l = C({
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
  async function a() {
    o.value = !0, e.value = null, await D.get("/api/users/u/" + U.params.user_name).then((m) => {
      l.value = m.data;
    }).catch((m) => {
      e.value = {
        description: "An error as occurred",
        style: F.Danger,
        ...m.response.data
      };
    }).finally(() => {
      o.value = !1;
    });
  }
  return B(
    () => U.params.user_name,
    () => {
      a();
    },
    { immediate: !0 }
  ), { user: l, error: e, loading: o };
}
const T = { class: "uk-text-center uk-margin" }, H = ["src"], R = { class: "uk-text-center uk-margin-remove" }, Y = {
  key: 0,
  class: "uk-margin-remove uk-text-meta",
  "data-test": "meta"
}, M = { class: "uk-description-list" }, P = { class: "uk-text-meta" }, N = {
  key: 0,
  class: "uk-text-meta"
}, V = {
  key: 1,
  class: "uk-text-meta"
}, E = { class: "uk-text-meta" }, h = { class: "uk-text-meta" }, G = { class: "uk-text-meta" }, I = /* @__PURE__ */ v({
  __name: "UserInfo",
  props: {
    user: {}
  },
  setup(U) {
    return (o, e) => {
      const l = u("font-awesome-icon"), a = u("UFLabel"), m = u("UFCardBox");
      return d(), c(m, null, {
        default: n(() => [
          t("div", T, [
            t("img", {
              src: o.user.avatar,
              alt: "avatar",
              class: "uk-border-circle"
            }, null, 8, H),
            t("h3", R, i(o.user.full_name), 1),
            o.user.user_name ? (d(), b("p", Y, " (" + i(o.user.user_name) + ") ", 1)) : $("", !0),
            w(o.$slots, "default", { dataTest: "slot" })
          ]),
          e[9] || (e[9] = t("hr", null, null, -1)),
          t("dl", M, [
            t("dt", null, [
              s(l, { icon: "envelope" }),
              e[0] || (e[0] = r(" Email"))
            ]),
            t("dd", P, i(o.user.email), 1),
            t("dt", null, [
              s(l, { icon: "users" }),
              e[1] || (e[1] = r(" Group"))
            ]),
            o.user.group ? (d(), b("dd", N, i(o.user.group.name), 1)) : (d(), b("dd", V, e[2] || (e[2] = [
              t("i", null, "None", -1)
            ]))),
            t("dt", null, [
              s(l, { icon: "language" }),
              e[3] || (e[3] = r(" Locale"))
            ]),
            t("dd", E, i(o.user.locale_name), 1),
            t("dt", null, [
              s(l, { icon: "user-shield" }),
              e[4] || (e[4] = r(" Status"))
            ]),
            t("dd", h, [
              o.user.flag_enabled == !1 ? (d(), c(a, {
                key: 0,
                severity: _(F).Danger
              }, {
                default: n(() => e[5] || (e[5] = [
                  r(" Disabled ")
                ])),
                _: 1
              }, 8, ["severity"])) : o.user.flag_verified == !1 ? (d(), c(a, {
                key: 1,
                severity: _(F).Warning
              }, {
                default: n(() => e[6] || (e[6] = [
                  r(" Unactivated ")
                ])),
                _: 1
              }, 8, ["severity"])) : (d(), c(a, {
                key: 2,
                severity: _(F).Success
              }, {
                default: n(() => e[7] || (e[7] = [
                  r("Active")
                ])),
                _: 1
              }, 8, ["severity"]))
            ]),
            t("dt", null, [
              s(l, { icon: "calendar" }),
              e[8] || (e[8] = r(" Created on"))
            ]),
            t("dd", G, i(_(j)(o.user.created_at).format("MMMM Do, YYYY")), 1)
          ]),
          e[10] || (e[10] = t("hr", null, null, -1)),
          e[11] || (e[11] = t("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit User ", -1)),
          e[12] || (e[12] = t("button", { class: "uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Change User Password ", -1)),
          e[13] || (e[13] = t("button", { class: "uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Disable User ", -1)),
          e[14] || (e[14] = t("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete User ", -1)),
          w(o.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), W = /* @__PURE__ */ v({
  __name: "UserActivities",
  props: {
    user_name: {}
  },
  setup(U) {
    return (o, e) => {
      const l = u("UFSprunjeHeader"), a = u("UFSprunjeColumn"), m = u("UFSprunjeTable"), f = u("UFCardBox");
      return d(), c(f, { title: "Activities" }, {
        default: n(() => [
          s(m, {
            dataUrl: "/api/users/u/" + o.user_name + "/activities",
            defaultSorts: { occurred_at: "desc" }
          }, {
            header: n(() => [
              s(l, { sort: "occurred_at" }, {
                default: n(() => e[0] || (e[0] = [
                  r("Activity Time")
                ])),
                _: 1
              }),
              s(l, { sort: "description" }, {
                default: n(() => e[1] || (e[1] = [
                  r("Description")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: p }) => [
              s(a, null, {
                default: n(() => [
                  t("div", null, i(_(j)(p.occurred_at).format("dddd")), 1),
                  t("div", null, i(_(j)(p.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              s(a, null, {
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
}), q = { class: "uk-button uk-button-default" }, z = { class: "uk-button uk-button-danger uk-button-small" }, J = /* @__PURE__ */ v({
  __name: "UserRoles",
  props: {
    slug: {}
  },
  setup(U) {
    return (o, e) => {
      const l = u("font-awesome-icon"), a = u("UFSprunjeHeader"), m = u("RouterLink"), f = u("UFSprunjeColumn"), p = u("UFSprunjeTable"), g = u("UFCardBox");
      return d(), c(g, { title: "Roles" }, {
        default: n(() => [
          s(p, {
            dataUrl: "/api/users/u/" + o.slug + "/roles",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: n(() => [
              t("button", q, [
                s(l, { icon: "address-card" }),
                e[0] || (e[0] = r(" Add role "))
              ])
            ]),
            header: n(() => [
              s(a, { sort: "name" }, {
                default: n(() => e[1] || (e[1] = [
                  r("Role")
                ])),
                _: 1
              }),
              s(a, { sort: "description" }, {
                default: n(() => e[2] || (e[2] = [
                  r("Description")
                ])),
                _: 1
              }),
              s(a, { sort: "description" }, {
                default: n(() => e[3] || (e[3] = [
                  r("Actions")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: k }) => [
              s(f, null, {
                default: n(() => [
                  t("strong", null, [
                    s(m, {
                      to: {
                        name: "admin.role",
                        params: { slug: k.slug }
                      }
                    }, {
                      default: n(() => [
                        r(i(k.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              s(f, null, {
                default: n(() => [
                  r(i(k.description), 1)
                ]),
                _: 2
              }, 1024),
              s(f, null, {
                default: n(() => [
                  t("button", z, [
                    s(l, { icon: "trash" })
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
}), K = /* @__PURE__ */ v({
  __name: "UserPermissions",
  props: {
    user_name: {}
  },
  setup(U) {
    return (o, e) => {
      const l = u("UFSprunjeHeader"), a = u("RouterLink"), m = u("UFSprunjeColumn"), f = u("UFLabel"), p = u("UFSprunjeTable"), g = u("UFCardBox");
      return d(), c(g, { title: "Permissions" }, {
        default: n(() => [
          s(p, {
            dataUrl: "/api/users/u/" + o.user_name + "/permissions",
            searchColumn: "name"
          }, {
            header: n(() => [
              s(l, { sort: "name" }, {
                default: n(() => e[0] || (e[0] = [
                  r("Permission")
                ])),
                _: 1
              }),
              s(l, { sort: "properties" }, {
                default: n(() => e[1] || (e[1] = [
                  r("Description")
                ])),
                _: 1
              }),
              s(l, null, {
                default: n(() => e[2] || (e[2] = [
                  r("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: n(({ item: k }) => [
              s(m, null, {
                default: n(() => [
                  t("strong", null, [
                    s(a, {
                      to: {
                        name: "admin.permission",
                        params: { id: k.id }
                      }
                    }, {
                      default: n(() => [
                        r(i(k.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              s(m, null, {
                default: n(() => [
                  r(i(k.description), 1)
                ]),
                _: 2
              }, 1024),
              s(m, null, {
                default: n(() => [
                  (d(!0), b(S, null, A(k.roles_via, (y) => (d(), c(a, {
                    key: y.id,
                    to: { name: "admin.role", params: { slug: y.slug } }
                  }, {
                    default: n(() => [
                      s(f, null, {
                        default: n(() => [
                          r(i(y.name), 1)
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
}, re = /* @__PURE__ */ v({
  __name: "UserView",
  setup(U) {
    const o = x(), { user: e, error: l } = L(o);
    return (a, m) => {
      const f = u("UFHeaderPage"), p = u("UFAlert"), g = u("UFCardBox");
      return d(), b(S, null, [
        s(f, {
          title: "User details",
          caption: "User information page"
        }),
        _(l) ? (d(), c(g, { key: 0 }, {
          default: n(() => [
            s(p, { alert: _(l) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (d(), b(S, { key: 1 }, [
          t("div", O, [
            t("div", Q, [
              s(I, { user: _(e) }, null, 8, ["user"])
            ]),
            t("div", X, [
              s(J, {
                slug: _(e).user_name
              }, null, 8, ["slug"])
            ])
          ]),
          t("div", Z, [
            t("div", null, [
              s(K, {
                user_name: _(e).user_name
              }, null, 8, ["user_name"])
            ]),
            t("div", null, [
              s(W, {
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
  re as default
};
