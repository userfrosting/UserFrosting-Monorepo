import { defineComponent as f, resolveComponent as p, openBlock as l, createElementBlock as c, Fragment as k, createVNode as t, createBlock as _, withCtx as m, createTextVNode as b, createElementVNode as e, renderList as v, toDisplayString as o, unref as d } from "vue";
import { defineStore as h } from "pinia";
import { a as U, h as D } from "./moment-BwEV_F1Z.js";
var g = /* @__PURE__ */ ((r) => (r.Primary = "Primary", r.Success = "Success", r.Warning = "Warning", r.Danger = "Danger", r))(g || {});
const w = {
  counter: {
    users: 0,
    roles: 0,
    groups: 0
  },
  info: {
    frameworkVersion: "",
    phpVersion: "",
    database: {
      connection: "",
      name: "",
      type: "",
      version: ""
    },
    server: "",
    projectPath: ""
  },
  sprinkles: {},
  users: []
}, y = h("dashboardApi", {
  state: () => ({
    data: w
  }),
  actions: {
    async load() {
      return U.get("/api/dashboard").then((r) => (this.data = r.data, this.data)).catch((r) => {
        throw {
          description: "An error as occurred",
          style: g.Danger,
          closeBtn: !0,
          ...r.response.data
        };
      });
    }
  }
}), B = /* @__PURE__ */ f({
  __name: "DashboardStats",
  props: {
    users: {},
    roles: {},
    groups: {}
  },
  setup(r) {
    return (s, n) => {
      const a = p("UFInfoBox");
      return l(), c(k, null, [
        t(a, {
          value: s.users,
          label: "Users",
          faIcon: "user",
          to: { name: "admin.users" }
        }, null, 8, ["value"]),
        t(a, {
          value: s.roles,
          label: "Roles",
          faIcon: "address-card",
          to: { name: "admin.roles" }
        }, null, 8, ["value"]),
        t(a, {
          value: s.groups,
          label: "Groups",
          faIcon: "users",
          to: { name: "admin.groups" }
        }, null, 8, ["value"])
      ], 64);
    };
  }
}), F = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, x = ["src"], C = { class: "uk-margin-remove" }, P = { class: "uk-margin-remove uk-text-meta" }, V = /* @__PURE__ */ f({
  __name: "DashboardRecentUsers",
  props: {
    users: {}
  },
  setup(r) {
    return (s, n) => {
      const a = p("RouterLink"), i = p("UFCardBox");
      return l(), _(i, { title: "Latest Users" }, {
        footer: m(() => [
          t(a, {
            to: { name: "admin.users" },
            class: "uk-text-center"
          }, {
            default: m(() => n[0] || (n[0] = [
              b("View All Users")
            ])),
            _: 1
          })
        ]),
        default: m(() => [
          e("div", F, [
            (l(!0), c(k, null, v(s.users, (u) => (l(), c("div", {
              key: u.id,
              class: "uk-text-center"
            }, [
              t(a, {
                to: { name: "admin.user", params: { user_name: u.user_name } },
                class: "uk-text-decoration-none uk-link-text"
              }, {
                default: m(() => [
                  e("img", {
                    src: u.avatar,
                    alt: "User Image",
                    class: "uk-border-circle"
                  }, null, 8, x),
                  e("p", C, o(u.full_name), 1),
                  e("p", P, o(d(D)(u.created_at).fromNow()), 1)
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
}), I = { class: "uk-description-list" }, $ = { class: "uk-list uk-list-disc uk-list-collapse" }, S = /* @__PURE__ */ f({
  __name: "DashboardSystemInfo",
  props: {
    info: {},
    sprinkles: {}
  },
  setup(r) {
    return (s, n) => {
      const a = p("UFCardBox");
      return l(), _(a, { title: "System Information" }, {
        default: m(() => [
          e("dl", I, [
            n[0] || (n[0] = e("dt", null, "Framework version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.frameworkVersion), 1)
              ])
            ]),
            n[1] || (n[1] = e("dt", null, "PHP version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.phpVersion), 1)
              ])
            ]),
            n[2] || (n[2] = e("dt", null, "Webserver software", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.server), 1)
              ])
            ]),
            n[3] || (n[3] = e("dt", null, "Database connection", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.database.connection), 1)
              ])
            ]),
            n[4] || (n[4] = e("dt", null, "Database version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.database.type) + " " + o(s.info.database.version), 1)
              ])
            ]),
            n[5] || (n[5] = e("dt", null, "Database name", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.database.name), 1)
              ])
            ]),
            n[6] || (n[6] = e("dt", null, "Project directory", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, o(s.info.projectPath), 1)
              ])
            ]),
            n[7] || (n[7] = e("dt", null, "Loaded sprinkles", -1)),
            e("dd", null, [
              e("ul", $, [
                (l(!0), c(k, null, v(s.sprinkles, (i) => (l(), c("li", { key: i }, o(i), 1))), 128))
              ])
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), A = {
  class: "uk-child-width-expand",
  "uk-grid": ""
}, L = {
  class: "uk-child-width-1-2",
  "uk-grid": ""
}, N = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, W = /* @__PURE__ */ f({
  __name: "DashboardView",
  setup(r) {
    const s = y();
    return s.load(), (n, a) => {
      const i = p("UFHeaderPage"), u = p("UFCardBox");
      return l(), c(k, null, [
        t(i, { title: "Dashboard" }),
        e("div", A, [
          t(B, {
            users: d(s).data.counter.users,
            roles: d(s).data.counter.roles,
            groups: d(s).data.counter.groups
          }, null, 8, ["users", "roles", "groups"])
        ]),
        e("div", L, [
          e("div", null, [
            e("div", N, [
              e("div", null, [
                t(V, {
                  users: d(s).data.users
                }, null, 8, ["users"])
              ]),
              e("div", null, [
                t(S, {
                  info: d(s).data.info,
                  sprinkles: d(s).data.sprinkles
                }, null, 8, ["info", "sprinkles"])
              ])
            ])
          ]),
          e("div", null, [
            t(u, { title: "Activities" })
          ])
        ])
      ], 64);
    };
  }
});
export {
  W as default
};
