import { ref as f, resolveComponent as m, openBlock as a, createElementBlock as d, Fragment as k, createElementVNode as e, createVNode as o, withCtx as u, renderList as p, toDisplayString as t, createTextVNode as b } from "vue";
import { a as g } from "./axios-CXDYiOMX.js";
const x = {
  class: "uk-grid uk-child-width-1-3",
  "uk-grid": ""
}, _ = {
  class: "uk-grid uk-child-width-1-2",
  "uk-grid": ""
}, w = { class: "uk-card uk-card-default uk-card-small" }, y = { class: "uk-card-body" }, U = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, F = ["src"], I = { class: "uk-margin-remove" }, B = { class: "uk-margin-remove uk-text-meta" }, D = { class: "uk-card-footer uk-text-center" }, R = { class: "uk-description-list" }, V = { class: "uk-list uk-list-disc uk-list-collapse" }, C = {
  __name: "DashboardView",
  setup(E) {
    const n = f({
      counter: {
        users: 0,
        roles: 0,
        groups: 0
      },
      info: {
        version: {
          framework: "",
          php: ""
        },
        database: {
          connection: "",
          name: "",
          type: "",
          version: ""
        },
        environment: {},
        path: {
          project: ""
        }
      },
      sprinkles: {},
      users: []
    });
    return g.get("/api/dashboard").then((i) => {
      n.value = i.data;
    }).catch((i) => {
      console.error(i);
    }), (i, l) => {
      const v = m("UFInfoBox"), r = m("RouterLink"), c = m("UFCardBox");
      return a(), d(k, null, [
        l[13] || (l[13] = e("h3", null, "Dashboard", -1)),
        e("div", x, [
          e("div", null, [
            o(r, {
              to: { name: "admin.users" },
              class: "uk-text-decoration-none"
            }, {
              default: u(() => [
                o(v, {
                  value: n.value.counter.users,
                  label: "Users",
                  faIcon: "user"
                }, null, 8, ["value"])
              ]),
              _: 1
            })
          ]),
          e("div", null, [
            o(r, {
              to: { name: "admin.roles" },
              class: "uk-text-decoration-none"
            }, {
              default: u(() => [
                o(v, {
                  value: n.value.counter.roles,
                  label: "Roles",
                  faIcon: "address-card"
                }, null, 8, ["value"])
              ]),
              _: 1
            })
          ]),
          e("div", null, [
            o(r, {
              to: { name: "admin.groups" },
              class: "uk-text-decoration-none"
            }, {
              default: u(() => [
                o(v, {
                  value: n.value.counter.groups,
                  label: "Groups",
                  faIcon: "users"
                }, null, 8, ["value"])
              ]),
              _: 1
            })
          ])
        ]),
        e("div", _, [
          e("div", null, [
            e("div", w, [
              l[1] || (l[1] = e("div", { class: "uk-card-header" }, [
                e("div", { class: "uk-grid uk-grid-small" }, [
                  e("div", { class: "uk-width-auto" }, [
                    e("h4", { "data-test": "title" }, "Latest Users")
                  ])
                ])
              ], -1)),
              e("div", y, [
                e("div", U, [
                  (a(!0), d(k, null, p(n.value.users, (s) => (a(), d("div", {
                    key: s.id,
                    class: "uk-text-center"
                  }, [
                    o(r, {
                      to: { name: "admin.user", params: { user_name: s.user_name } },
                      class: "uk-text-decoration-none uk-link-text"
                    }, {
                      default: u(() => [
                        e("img", {
                          src: s.avatar,
                          alt: "User Image",
                          class: "uk-border-circle"
                        }, null, 8, F),
                        e("p", I, t(s.full_name), 1),
                        e("p", B, t(s.registered), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]))), 128))
                ])
              ]),
              e("div", D, [
                o(r, {
                  to: { name: "admin.users" },
                  class: "uk-button uk-button-text"
                }, {
                  default: u(() => l[0] || (l[0] = [
                    b("View All Users")
                  ])),
                  _: 1
                })
              ])
            ]),
            l[12] || (l[12] = e("br", null, null, -1)),
            o(c, { title: "System Information" }, {
              default: u(() => [
                e("dl", R, [
                  l[2] || (l[2] = e("dt", null, "Frameword version", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.version.framework), 1)
                    ])
                  ]),
                  l[3] || (l[3] = e("dt", null, "PHP version", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.version.php), 1)
                    ])
                  ]),
                  l[4] || (l[4] = e("dt", null, "Webserver software", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.environment.SERVER_SOFTWARE), 1)
                    ])
                  ]),
                  l[5] || (l[5] = e("dt", null, "Database connection", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.database.connection), 1)
                    ])
                  ]),
                  l[6] || (l[6] = e("dt", null, "Database version", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.database.type) + " " + t(n.value.info.database.version), 1)
                    ])
                  ]),
                  l[7] || (l[7] = e("dt", null, "Database name", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.database.name), 1)
                    ])
                  ]),
                  l[8] || (l[8] = e("dt", null, "Project directory", -1)),
                  e("dd", null, [
                    e("pre", null, [
                      e("code", null, t(n.value.info.path.project), 1)
                    ])
                  ]),
                  l[9] || (l[9] = e("dt", null, "Site root url", -1)),
                  l[10] || (l[10] = e("dd", null, [
                    e("pre", null, [
                      e("code")
                    ])
                  ], -1)),
                  l[11] || (l[11] = e("dt", null, "Loaded sprinkles", -1)),
                  e("dd", null, [
                    e("ul", V, [
                      (a(!0), d(k, null, p(n.value.sprinkles, (s) => (a(), d("li", {
                        key: s.name
                      }, t(s), 1))), 128))
                    ])
                  ])
                ])
              ]),
              _: 1
            })
          ]),
          e("div", null, [
            o(c, { title: "Activities" })
          ])
        ])
      ], 64);
    };
  }
};
export {
  C as default
};
