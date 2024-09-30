import { defineComponent as U, resolveComponent as p, openBlock as u, createElementBlock as m, Fragment as h, createVNode as t, createBlock as D, withCtx as c, createTextVNode as F, createElementVNode as e, renderList as w, toDisplayString as l, unref as x, ref as C, withAsyncContext as I } from "vue";
import { a as P, h as V } from "./moment-BwEV_F1Z.js";
var B = /* @__PURE__ */ ((o) => (o.Primary = "Primary", o.Success = "Success", o.Warning = "Warning", o.Danger = "Danger", o))(B || {});
async function $() {
  return P.get("/api/dashboard").then((o) => o.data).catch((o) => {
    throw {
      description: "An error as occurred",
      style: B.Danger,
      closeBtn: !0,
      ...o.response.data
    };
  });
}
const S = /* @__PURE__ */ U({
  __name: "DashboardStats",
  props: {
    users: {},
    roles: {},
    groups: {}
  },
  setup(o) {
    return (s, n) => {
      const r = p("UFInfoBox");
      return u(), m(h, null, [
        t(r, {
          value: s.users,
          label: "Users",
          faIcon: "user",
          to: { name: "admin.users" }
        }, null, 8, ["value"]),
        t(r, {
          value: s.roles,
          label: "Roles",
          faIcon: "address-card",
          to: { name: "admin.roles" }
        }, null, 8, ["value"]),
        t(r, {
          value: s.groups,
          label: "Groups",
          faIcon: "users",
          to: { name: "admin.groups" }
        }, null, 8, ["value"])
      ], 64);
    };
  }
}), A = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, L = ["src"], N = { class: "uk-margin-remove" }, R = { class: "uk-margin-remove uk-text-meta" }, H = /* @__PURE__ */ U({
  __name: "DashboardRecentUsers",
  props: {
    users: {}
  },
  setup(o) {
    return (s, n) => {
      const r = p("RouterLink"), d = p("center"), i = p("UFCardBox");
      return u(), D(i, { title: "Latest Users" }, {
        footer: c(() => [
          t(d, null, {
            default: c(() => [
              t(r, { to: { name: "admin.users" } }, {
                default: c(() => n[0] || (n[0] = [
                  F(" View All Users ")
                ])),
                _: 1
              })
            ]),
            _: 1
          })
        ]),
        default: c(() => [
          e("div", A, [
            (u(!0), m(h, null, w(s.users, (a) => (u(), m("div", {
              key: a.id,
              class: "uk-text-center"
            }, [
              t(r, {
                to: { name: "admin.user", params: { user_name: a.user_name } },
                class: "uk-text-decoration-none uk-link-text"
              }, {
                default: c(() => [
                  e("img", {
                    src: a.avatar,
                    alt: "User Image",
                    class: "uk-border-circle"
                  }, null, 8, L),
                  e("p", N, l(a.full_name), 1),
                  e("p", R, l(x(V)(a.created_at).fromNow()), 1)
                ]),
                _: 2
              }, 1032, ["to"])
            ]))), 128))
          ])
        ]),
        _: 1
      });
    };
  }
}), W = { class: "uk-description-list" }, j = { class: "uk-list uk-list-disc uk-list-collapse" }, E = /* @__PURE__ */ U({
  __name: "DashboardSystemInfo",
  props: {
    info: {},
    sprinkles: {}
  },
  setup(o) {
    return (s, n) => {
      const r = p("UFCardBox");
      return u(), D(r, { title: "System Information" }, {
        default: c(() => {
          var d, i, a, b, _, f, k, v;
          return [
            e("dl", W, [
              n[0] || (n[0] = e("dt", null, "Framework version", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((d = s.info) == null ? void 0 : d.frameworkVersion), 1)
                ])
              ]),
              n[1] || (n[1] = e("dt", null, "PHP version", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((i = s.info) == null ? void 0 : i.phpVersion), 1)
                ])
              ]),
              n[2] || (n[2] = e("dt", null, "Webserver software", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((a = s.info) == null ? void 0 : a.server), 1)
                ])
              ]),
              n[3] || (n[3] = e("dt", null, "Database connection", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((b = s.info) == null ? void 0 : b.database.connection), 1)
                ])
              ]),
              n[4] || (n[4] = e("dt", null, "Database version", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((_ = s.info) == null ? void 0 : _.database.type) + " " + l((f = s.info) == null ? void 0 : f.database.version), 1)
                ])
              ]),
              n[5] || (n[5] = e("dt", null, "Database name", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((k = s.info) == null ? void 0 : k.database.name), 1)
                ])
              ]),
              n[6] || (n[6] = e("dt", null, "Project directory", -1)),
              e("dd", null, [
                e("pre", null, [
                  e("code", null, l((v = s.info) == null ? void 0 : v.projectPath), 1)
                ])
              ]),
              n[7] || (n[7] = e("dt", null, "Loaded sprinkles", -1)),
              e("dd", null, [
                e("ul", j, [
                  (u(!0), m(h, null, w(s.sprinkles, (g) => (u(), m("li", {
                    key: g.name
                  }, l(g), 1))), 128))
                ])
              ])
            ])
          ];
        }),
        _: 1
      });
    };
  }
}), G = {
  class: "uk-grid uk-child-width-expand",
  "uk-grid": ""
}, T = {
  class: "uk-grid uk-child-width-1-2",
  "uk-grid": ""
}, J = /* @__PURE__ */ U({
  __name: "DashboardView",
  async setup(o) {
    let s, n;
    const r = C();
    return [s, n] = I(() => $().then((d) => {
      r.value = d;
    })), await s, n(), (d, i) => {
      var _, f, k, v, g, y;
      const a = p("UFHeaderPage"), b = p("UFCardBox");
      return u(), m(h, null, [
        t(a, { title: "Dashboard" }),
        e("div", G, [
          t(S, {
            users: ((_ = r.value) == null ? void 0 : _.counter.users) ?? 0,
            roles: ((f = r.value) == null ? void 0 : f.counter.roles) ?? 0,
            groups: ((k = r.value) == null ? void 0 : k.counter.groups) ?? 0
          }, null, 8, ["users", "roles", "groups"])
        ]),
        e("div", T, [
          e("div", null, [
            t(H, {
              users: (v = r.value) == null ? void 0 : v.users
            }, null, 8, ["users"]),
            i[0] || (i[0] = e("br", null, null, -1)),
            t(E, {
              data: (g = r.value) == null ? void 0 : g.info,
              sprinkles: (y = r.value) == null ? void 0 : y.sprinkles
            }, null, 8, ["data", "sprinkles"])
          ]),
          e("div", null, [
            t(b, { title: "Activities" })
          ])
        ])
      ], 64);
    };
  }
});
export {
  J as default
};
