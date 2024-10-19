import { ref as C, watch as j, defineComponent as k, resolveComponent as a, openBlock as _, createBlock as f, withCtx as s, createElementVNode as n, toDisplayString as u, createElementBlock as g, createCommentVNode as b, renderSlot as x, createVNode as t, createTextVNode as l, unref as m, Fragment as y } from "vue";
import { useRoute as B } from "vue-router";
import { a as A } from "./axios-CXDYiOMX.js";
import { a as F } from "./types-Daou0lcF.js";
import { h as S } from "./moment-h96o7c8I.js";
function w(U) {
  const o = C(!1), e = C(), r = C({
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
  async function i() {
    o.value = !0, e.value = null, await A.get("/api/users/u/" + U.params.user_name).then((d) => {
      r.value = d.data;
    }).catch((d) => {
      e.value = {
        description: "An error as occurred",
        style: F.Danger,
        ...d.response.data
      };
    }).finally(() => {
      o.value = !1;
    });
  }
  return j(
    () => U.params.user_name,
    () => {
      i();
    },
    { immediate: !0 }
  ), { user: r, error: e, loading: o };
}
const H = { class: "uk-text-center uk-margin" }, T = ["src"], $ = { class: "uk-text-center uk-margin-remove" }, D = {
  key: 0,
  class: "uk-margin-remove uk-text-meta",
  "data-test": "meta"
}, R = { class: "uk-description-list" }, Y = { class: "uk-text-meta" }, L = {
  key: 0,
  class: "uk-text-meta"
}, M = {
  key: 1,
  class: "uk-text-meta"
}, N = { class: "uk-text-meta" }, P = { class: "uk-text-meta" }, V = { class: "uk-text-meta" }, E = /* @__PURE__ */ k({
  __name: "UserInfo",
  props: {
    user: {}
  },
  setup(U) {
    return (o, e) => {
      const r = a("font-awesome-icon"), i = a("UFLabel"), d = a("UFCardBox");
      return _(), f(d, null, {
        default: s(() => [
          n("div", H, [
            n("img", {
              src: o.user.avatar,
              alt: "avatar",
              class: "uk-border-circle"
            }, null, 8, T),
            n("h3", $, u(o.user.full_name), 1),
            o.user.user_name ? (_(), g("p", D, " (" + u(o.user.user_name) + ") ", 1)) : b("", !0),
            x(o.$slots, "default", { dataTest: "slot" })
          ]),
          e[9] || (e[9] = n("hr", null, null, -1)),
          n("dl", R, [
            n("dt", null, [
              t(r, { icon: "envelope" }),
              e[0] || (e[0] = l(" Email"))
            ]),
            n("dd", Y, u(o.user.email), 1),
            n("dt", null, [
              t(r, { icon: "users" }),
              e[1] || (e[1] = l(" Group"))
            ]),
            o.user.group ? (_(), g("dd", L, u(o.user.group.name), 1)) : (_(), g("dd", M, e[2] || (e[2] = [
              n("i", null, "None", -1)
            ]))),
            n("dt", null, [
              t(r, { icon: "language" }),
              e[3] || (e[3] = l(" Locale"))
            ]),
            n("dd", N, u(o.user.locale_name), 1),
            n("dt", null, [
              t(r, { icon: "user-shield" }),
              e[4] || (e[4] = l(" Status"))
            ]),
            n("dd", P, [
              o.user.flag_enabled == !1 ? (_(), f(i, {
                key: 0,
                severity: m(F).Danger
              }, {
                default: s(() => e[5] || (e[5] = [
                  l(" Disabled ")
                ])),
                _: 1
              }, 8, ["severity"])) : o.user.flag_verified == !1 ? (_(), f(i, {
                key: 1,
                severity: m(F).Warning
              }, {
                default: s(() => e[6] || (e[6] = [
                  l(" Unactivated ")
                ])),
                _: 1
              }, 8, ["severity"])) : (_(), f(i, {
                key: 2,
                severity: m(F).Success
              }, {
                default: s(() => e[7] || (e[7] = [
                  l("Active")
                ])),
                _: 1
              }, 8, ["severity"]))
            ]),
            n("dt", null, [
              t(r, { icon: "calendar" }),
              e[8] || (e[8] = l(" Created on"))
            ]),
            n("dd", V, u(m(S)(o.user.created_at).format("MMMM Do, YYYY")), 1)
          ])
        ]),
        _: 3
      });
    };
  }
}), h = /* @__PURE__ */ k({
  __name: "UserActivities",
  props: {
    user_name: {}
  },
  setup(U) {
    return (o, e) => {
      const r = a("UFSprunjeHeader"), i = a("UFSprunjeColumn"), d = a("UFSprunjeTable"), v = a("UFCardBox");
      return _(), f(v, { title: "Activities" }, {
        default: s(() => [
          t(d, {
            dataUrl: "/api/users/u/" + o.user_name + "/activities",
            defaultSorts: { occurred_at: "desc" }
          }, {
            header: s(() => [
              t(r, { sort: "occurred_at" }, {
                default: s(() => e[0] || (e[0] = [
                  l("Activity Time")
                ])),
                _: 1
              }),
              t(r, { sort: "description" }, {
                default: s(() => e[1] || (e[1] = [
                  l("Description")
                ])),
                _: 1
              })
            ]),
            body: s(({ item: c }) => [
              t(i, null, {
                default: s(() => [
                  n("div", null, u(m(S)(c.occurred_at).format("dddd")), 1),
                  n("div", null, u(m(S)(c.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              t(i, null, {
                default: s(() => [
                  n("div", null, u(c.ip_address), 1),
                  n("div", null, [
                    n("i", null, u(c.description), 1)
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
}), G = /* @__PURE__ */ k({
  __name: "UserRoles",
  props: {
    slug: {}
  },
  setup(U) {
    return (o, e) => {
      const r = a("UFSprunjeHeader"), i = a("RouterLink"), d = a("UFSprunjeColumn"), v = a("UFSprunjeTable"), c = a("UFCardBox");
      return _(), f(c, { title: "Roles" }, {
        default: s(() => [
          t(v, {
            dataUrl: "/api/users/u/" + o.slug + "/roles",
            searchColumn: "name"
          }, {
            header: s(() => [
              t(r, { sort: "name" }, {
                default: s(() => e[0] || (e[0] = [
                  l("Role")
                ])),
                _: 1
              }),
              t(r, { sort: "description" }, {
                default: s(() => e[1] || (e[1] = [
                  l("Description")
                ])),
                _: 1
              }),
              t(r, { sort: "description" }, {
                default: s(() => e[2] || (e[2] = [
                  l("Actions")
                ])),
                _: 1
              })
            ]),
            body: s(({ item: p }) => [
              t(d, null, {
                default: s(() => [
                  n("strong", null, [
                    t(i, {
                      to: {
                        name: "admin.role",
                        params: { slug: p.slug }
                      }
                    }, {
                      default: s(() => [
                        l(u(p.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              t(d, null, {
                default: s(() => [
                  l(u(p.description), 1)
                ]),
                _: 2
              }, 1024),
              t(d)
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), I = /* @__PURE__ */ k({
  __name: "UserPermissions",
  props: {
    user_name: {}
  },
  setup(U) {
    return (o, e) => {
      const r = a("UFSprunjeHeader"), i = a("RouterLink"), d = a("UFSprunjeColumn"), v = a("UFSprunjeTable"), c = a("UFCardBox");
      return _(), f(c, { title: "Permissions" }, {
        default: s(() => [
          t(v, {
            dataUrl: "/api/users/u/" + o.user_name + "/permissions",
            searchColumn: "name"
          }, {
            header: s(() => [
              t(r, { sort: "name" }, {
                default: s(() => e[0] || (e[0] = [
                  l("Permission")
                ])),
                _: 1
              }),
              t(r, { sort: "properties" }, {
                default: s(() => e[1] || (e[1] = [
                  l("Slug/Condition")
                ])),
                _: 1
              }),
              t(r, null, {
                default: s(() => e[2] || (e[2] = [
                  l("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: s(({ item: p }) => [
              t(d, null, {
                default: s(() => [
                  n("strong", null, [
                    t(i, {
                      to: {
                        name: "admin.permission",
                        params: { id: p.id }
                      }
                    }, {
                      default: s(() => [
                        l(u(p.name), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ])
                ]),
                _: 2
              }, 1024),
              t(d, null, {
                default: s(() => [
                  n("div", null, [
                    n("code", null, u(p.slug), 1)
                  ]),
                  n("div", null, [
                    e[3] || (e[3] = l(" ↳ ")),
                    n("code", null, u(p.conditions), 1)
                  ]),
                  n("div", null, [
                    n("i", null, u(p.description), 1)
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
}), W = { "uk-grid": "" }, q = { class: "uk-width-1-3" }, z = { class: "uk-width-2-3" }, J = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, ee = /* @__PURE__ */ k({
  __name: "UserView",
  setup(U) {
    const o = B(), { user: e, error: r } = w(o);
    return (i, d) => {
      const v = a("UFHeaderPage"), c = a("UFAlert"), p = a("UFCardBox");
      return _(), g(y, null, [
        t(v, {
          title: "User details",
          caption: "User information page"
        }),
        m(r) ? (_(), f(p, { key: 0 }, {
          default: s(() => [
            t(c, { alert: m(r) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (_(), g(y, { key: 1 }, [
          n("div", W, [
            n("div", q, [
              t(E, { user: m(e) }, null, 8, ["user"])
            ]),
            n("div", z, [
              t(G, {
                slug: m(e).user_name
              }, null, 8, ["slug"])
            ])
          ]),
          n("div", J, [
            n("div", null, [
              t(I, {
                user_name: m(e).user_name
              }, null, 8, ["user_name"])
            ]),
            n("div", null, [
              t(h, {
                user_name: m(e).user_name
              }, null, 8, ["user_name"])
            ])
          ])
        ], 64))
      ], 64);
    };
  }
});
export {
  ee as default
};
