import { defineComponent as k, resolveComponent as u, openBlock as i, createElementBlock as _, Fragment as v, createVNode as o, createBlock as g, withCtx as t, createTextVNode as f, createElementVNode as e, renderList as h, toDisplayString as r, unref as d } from "vue";
import { defineStore as D } from "pinia";
import { a as w, b as x } from "./types-BgMW-dbA.js";
import { h as b } from "./moment-h96o7c8I.js";
const y = {
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
}, B = D("dashboardApi", {
  state: () => ({
    data: y
  }),
  actions: {
    async load() {
      return w.get("/api/dashboard").then((p) => (this.data = p.data, this.data)).catch((p) => {
        throw {
          description: "An error as occurred",
          style: x.Danger,
          closeBtn: !0,
          ...p.response.data
        };
      });
    }
  }
}), S = /* @__PURE__ */ k({
  __name: "DashboardStats",
  props: {
    users: {},
    roles: {},
    groups: {}
  },
  setup(p) {
    return (s, n) => {
      const l = u("UFInfoBox");
      return i(), _(v, null, [
        o(l, {
          value: s.users,
          label: "Users",
          faIcon: "user",
          to: { name: "admin.users" }
        }, null, 8, ["value"]),
        o(l, {
          value: s.roles,
          label: "Roles",
          faIcon: "address-card",
          to: { name: "admin.roles" }
        }, null, 8, ["value"]),
        o(l, {
          value: s.groups,
          label: "Groups",
          faIcon: "users",
          to: { name: "admin.groups" }
        }, null, 8, ["value"])
      ], 64);
    };
  }
}), C = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, $ = ["src"], j = { class: "uk-margin-remove" }, V = { class: "uk-margin-remove uk-text-meta" }, A = /* @__PURE__ */ k({
  __name: "DashboardRecentUsers",
  props: {
    users: {}
  },
  setup(p) {
    return (s, n) => {
      const l = u("RouterLink"), a = u("UFCardBox");
      return i(), g(a, { title: "Latest Users" }, {
        footer: t(() => [
          o(l, {
            to: { name: "admin.users" },
            class: "uk-text-center"
          }, {
            default: t(() => n[0] || (n[0] = [
              f("View All Users")
            ])),
            _: 1
          })
        ]),
        default: t(() => [
          e("div", C, [
            (i(!0), _(v, null, h(s.users, (m) => (i(), _("div", {
              key: m.id,
              class: "uk-text-center"
            }, [
              o(l, {
                to: { name: "admin.user", params: { user_name: m.user_name } },
                class: "uk-text-decoration-none uk-link-text"
              }, {
                default: t(() => [
                  e("img", {
                    src: m.avatar,
                    alt: "User Image",
                    class: "uk-border-circle"
                  }, null, 8, $),
                  e("p", j, r(m.full_name), 1),
                  e("p", V, r(d(b)(m.created_at).fromNow()), 1)
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
}), I = { class: "uk-description-list" }, L = { class: "uk-list uk-list-disc uk-list-collapse" }, P = /* @__PURE__ */ k({
  __name: "DashboardSystemInfo",
  props: {
    info: {},
    sprinkles: {}
  },
  setup(p) {
    return (s, n) => {
      const l = u("UFCardBox");
      return i(), g(l, { title: "System Information" }, {
        default: t(() => [
          e("dl", I, [
            n[0] || (n[0] = e("dt", null, "Framework version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.frameworkVersion), 1)
              ])
            ]),
            n[1] || (n[1] = e("dt", null, "PHP version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.phpVersion), 1)
              ])
            ]),
            n[2] || (n[2] = e("dt", null, "Webserver software", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.server), 1)
              ])
            ]),
            n[3] || (n[3] = e("dt", null, "Database connection", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.database.connection), 1)
              ])
            ]),
            n[4] || (n[4] = e("dt", null, "Database version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.database.type) + " " + r(s.info.database.version), 1)
              ])
            ]),
            n[5] || (n[5] = e("dt", null, "Database name", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.database.name), 1)
              ])
            ]),
            n[6] || (n[6] = e("dt", null, "Project directory", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, r(s.info.projectPath), 1)
              ])
            ]),
            n[7] || (n[7] = e("dt", null, "Loaded sprinkles", -1)),
            e("dd", null, [
              e("ul", L, [
                (i(!0), _(v, null, h(s.sprinkles, (a) => (i(), _("li", { key: a }, r(a), 1))), 128))
              ])
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), R = { class: "uk-text-meta" }, H = /* @__PURE__ */ k({
  __name: "DashboardActivities",
  setup(p) {
    return (s, n) => {
      const l = u("UFSprunjeHeader"), a = u("UFSprunjeColumn"), m = u("RouterLink"), U = u("UFSprunjeTable"), F = u("UFCardBox");
      return i(), g(F, { title: "Latest Activities" }, {
        default: t(() => [
          o(U, {
            dataUrl: "/api/activities",
            defaultSorts: { occurred_at: "desc" },
            hidePagination: ""
          }, {
            header: t(() => [
              o(l, null, {
                default: t(() => n[0] || (n[0] = [
                  f("Activity Time")
                ])),
                _: 1
              }),
              o(l, null, {
                default: t(() => n[1] || (n[1] = [
                  f("User")
                ])),
                _: 1
              }),
              o(l, null, {
                default: t(() => n[2] || (n[2] = [
                  f("Description")
                ])),
                _: 1
              })
            ]),
            body: t(({ item: c }) => [
              o(a, null, {
                default: t(() => [
                  e("div", null, r(d(b)(c.occurred_at).format("dddd")), 1),
                  e("div", null, r(d(b)(c.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              o(a, null, {
                default: t(() => [
                  e("strong", null, [
                    o(m, {
                      to: {
                        name: "admin.user",
                        params: { user_name: c.user.user_name }
                      }
                    }, {
                      default: t(() => [
                        f(r(c.user.full_name) + " (" + r(c.user.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  e("div", R, r(c.user.email), 1)
                ]),
                _: 2
              }, 1024),
              o(a, null, {
                default: t(() => [
                  e("div", null, r(c.ip_address), 1),
                  e("div", null, [
                    e("i", null, r(c.description), 1)
                  ])
                ]),
                _: 2
              }, 1024)
            ]),
            _: 1
          })
        ]),
        _: 1
      });
    };
  }
}), N = {
  class: "uk-child-width-expand",
  "uk-grid": ""
}, T = {
  class: "uk-child-width-1-2",
  "uk-grid": ""
}, Y = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, q = /* @__PURE__ */ k({
  __name: "DashboardView",
  setup(p) {
    const s = B();
    return s.load(), (n, l) => {
      const a = u("UFHeaderPage");
      return i(), _(v, null, [
        o(a, { title: "Dashboard" }),
        e("div", N, [
          o(S, {
            users: d(s).data.counter.users,
            roles: d(s).data.counter.roles,
            groups: d(s).data.counter.groups
          }, null, 8, ["users", "roles", "groups"])
        ]),
        e("div", T, [
          e("div", null, [
            e("div", Y, [
              e("div", null, [
                o(A, {
                  users: d(s).data.users
                }, null, 8, ["users"])
              ]),
              e("div", null, [
                o(P, {
                  info: d(s).data.info,
                  sprinkles: d(s).data.sprinkles
                }, null, 8, ["info", "sprinkles"])
              ])
            ])
          ]),
          e("div", null, [
            o(H)
          ])
        ])
      ], 64);
    };
  }
});
export {
  q as default
};
