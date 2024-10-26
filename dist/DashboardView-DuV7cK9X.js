import { defineComponent as f, resolveComponent as a, openBlock as i, createElementBlock as _, Fragment as v, createVNode as o, createBlock as U, withCtx as r, createTextVNode as c, createElementVNode as e, renderList as g, toDisplayString as l, unref as d } from "vue";
import { useDashboardApi as D } from "./composable/dashboard.js";
import { h as b } from "./moment-h96o7c8I.js";
const x = /* @__PURE__ */ f({
  __name: "DashboardStats",
  props: {
    users: {},
    roles: {},
    groups: {}
  },
  setup(k) {
    return (s, n) => {
      const t = a("UFInfoBox");
      return i(), _(v, null, [
        o(t, {
          value: s.users,
          label: "Users",
          faIcon: "user",
          to: { name: "admin.users" }
        }, null, 8, ["value"]),
        o(t, {
          value: s.roles,
          label: "Roles",
          faIcon: "address-card",
          to: { name: "admin.roles" }
        }, null, 8, ["value"]),
        o(t, {
          value: s.groups,
          label: "Groups",
          faIcon: "users",
          to: { name: "admin.groups" }
        }, null, 8, ["value"])
      ], 64);
    };
  }
}), B = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, C = ["src"], S = { class: "uk-margin-remove" }, w = { class: "uk-margin-remove uk-text-meta" }, $ = /* @__PURE__ */ f({
  __name: "DashboardRecentUsers",
  props: {
    users: {}
  },
  setup(k) {
    return (s, n) => {
      const t = a("RouterLink"), u = a("UFCardBox");
      return i(), U(u, { title: "Latest Users" }, {
        footer: r(() => [
          o(t, {
            to: { name: "admin.users" },
            class: "uk-text-center"
          }, {
            default: r(() => n[0] || (n[0] = [
              c("View All Users")
            ])),
            _: 1
          })
        ]),
        default: r(() => [
          e("div", B, [
            (i(!0), _(v, null, g(s.users, (m) => (i(), _("div", {
              key: m.id,
              class: "uk-text-center"
            }, [
              o(t, {
                to: { name: "admin.user", params: { user_name: m.user_name } },
                class: "uk-text-decoration-none uk-link-text"
              }, {
                default: r(() => [
                  e("img", {
                    src: m.avatar,
                    alt: "User Image",
                    class: "uk-border-circle"
                  }, null, 8, C),
                  e("p", S, l(m.full_name), 1),
                  e("p", w, l(d(b)(m.created_at).fromNow()), 1)
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
}), y = { class: "uk-description-list" }, j = { class: "uk-list uk-list-disc uk-list-collapse" }, I = /* @__PURE__ */ f({
  __name: "DashboardSystemInfo",
  props: {
    info: {},
    sprinkles: {}
  },
  setup(k) {
    return (s, n) => {
      const t = a("UFCardBox");
      return i(), U(t, { title: "System Information" }, {
        default: r(() => [
          e("dl", y, [
            n[0] || (n[0] = e("dt", null, "Framework version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.frameworkVersion), 1)
              ])
            ]),
            n[1] || (n[1] = e("dt", null, "PHP version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.phpVersion), 1)
              ])
            ]),
            n[2] || (n[2] = e("dt", null, "Webserver software", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.server), 1)
              ])
            ]),
            n[3] || (n[3] = e("dt", null, "Database connection", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.database.connection), 1)
              ])
            ]),
            n[4] || (n[4] = e("dt", null, "Database version", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.database.type) + " " + l(s.info.database.version), 1)
              ])
            ]),
            n[5] || (n[5] = e("dt", null, "Database name", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.database.name), 1)
              ])
            ]),
            n[6] || (n[6] = e("dt", null, "Project directory", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, l(s.info.projectPath), 1)
              ])
            ]),
            n[7] || (n[7] = e("dt", null, "Loaded sprinkles", -1)),
            e("dd", null, [
              e("ul", j, [
                (i(!0), _(v, null, g(s.sprinkles, (u) => (i(), _("li", { key: u }, l(u), 1))), 128))
              ])
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), L = { class: "uk-text-meta" }, P = /* @__PURE__ */ f({
  __name: "DashboardActivities",
  setup(k) {
    return (s, n) => {
      const t = a("UFSprunjeHeader"), u = a("UFSprunjeColumn"), m = a("RouterLink"), F = a("UFSprunjeTable"), h = a("UFCardBox");
      return i(), U(h, { title: "Latest Activities" }, {
        default: r(() => [
          o(F, {
            dataUrl: "/api/activities",
            defaultSorts: { occurred_at: "desc" },
            hidePagination: "",
            hideFilters: ""
          }, {
            header: r(() => [
              o(t, null, {
                default: r(() => n[0] || (n[0] = [
                  c("Activity Time")
                ])),
                _: 1
              }),
              o(t, null, {
                default: r(() => n[1] || (n[1] = [
                  c("User")
                ])),
                _: 1
              }),
              o(t, null, {
                default: r(() => n[2] || (n[2] = [
                  c("Description")
                ])),
                _: 1
              })
            ]),
            body: r(({ item: p }) => [
              o(u, null, {
                default: r(() => [
                  e("div", null, l(d(b)(p.occurred_at).format("dddd")), 1),
                  e("div", null, l(d(b)(p.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              o(u, null, {
                default: r(() => [
                  e("strong", null, [
                    o(m, {
                      to: {
                        name: "admin.user",
                        params: { user_name: p.user.user_name }
                      }
                    }, {
                      default: r(() => [
                        c(l(p.user.full_name) + " (" + l(p.user.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  e("div", L, l(p.user.email), 1)
                ]),
                _: 2
              }, 1024),
              o(u, null, {
                default: r(() => [
                  e("div", null, l(p.ip_address), 1),
                  e("div", null, [
                    e("i", null, l(p.description), 1)
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
}), V = {
  class: "uk-child-width-expand",
  "uk-grid": ""
}, R = {
  class: "uk-child-width-1-2",
  "uk-grid": ""
}, A = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, Y = /* @__PURE__ */ f({
  __name: "DashboardView",
  setup(k) {
    const s = D();
    return s.load(), (n, t) => {
      const u = a("UFHeaderPage");
      return i(), _(v, null, [
        o(u, { title: "Dashboard" }),
        e("div", V, [
          o(x, {
            users: d(s).data.counter.users,
            roles: d(s).data.counter.roles,
            groups: d(s).data.counter.groups
          }, null, 8, ["users", "roles", "groups"])
        ]),
        e("div", R, [
          e("div", null, [
            e("div", A, [
              e("div", null, [
                o($, {
                  users: d(s).data.users
                }, null, 8, ["users"])
              ]),
              e("div", null, [
                o(I, {
                  info: d(s).data.info,
                  sprinkles: d(s).data.sprinkles
                }, null, 8, ["info", "sprinkles"])
              ])
            ])
          ]),
          e("div", null, [
            o(P)
          ])
        ])
      ], 64);
    };
  }
});
export {
  Y as default
};
