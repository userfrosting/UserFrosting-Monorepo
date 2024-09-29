import { ref as f, resolveComponent as i, openBlock as u, createElementBlock as r, Fragment as v, createElementVNode as e, createVNode as s, renderList as c, withCtx as m, toDisplayString as t, createTextVNode as b } from "vue";
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
    return g.get("/api/dashboard").then((d) => {
      n.value = d.data;
    }).catch((d) => {
      console.error(d);
    }), (d, l) => {
      const a = i("UFInfoBox"), k = i("RouterLink"), p = i("UFCardBox");
      return u(), r(v, null, [
        l[13] || (l[13] = e("h3", null, "Dashboard", -1)),
        e("div", x, [
          e("div", null, [
            s(a, {
              value: n.value.counter.users,
              label: "Users",
              faIcon: "user",
              to: { name: "admin.users" }
            }, null, 8, ["value"])
          ]),
          e("div", null, [
            s(a, {
              value: n.value.counter.roles,
              label: "Roles",
              faIcon: "address-card",
              to: { name: "admin.roles" }
            }, null, 8, ["value"])
          ]),
          e("div", null, [
            s(a, {
              value: n.value.counter.groups,
              label: "Groups",
              faIcon: "users",
              to: { name: "admin.groups" }
            }, null, 8, ["value"])
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
                  (u(!0), r(v, null, c(n.value.users, (o) => (u(), r("div", {
                    key: o.id,
                    class: "uk-text-center"
                  }, [
                    s(k, {
                      to: { name: "admin.user", params: { user_name: o.user_name } },
                      class: "uk-text-decoration-none uk-link-text"
                    }, {
                      default: m(() => [
                        e("img", {
                          src: o.avatar,
                          alt: "User Image",
                          class: "uk-border-circle"
                        }, null, 8, F),
                        e("p", I, t(o.full_name), 1),
                        e("p", B, t(o.registered), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]))), 128))
                ])
              ]),
              e("div", D, [
                s(k, {
                  to: { name: "admin.users" },
                  class: "uk-button uk-button-text"
                }, {
                  default: m(() => l[0] || (l[0] = [
                    b("View All Users")
                  ])),
                  _: 1
                })
              ])
            ]),
            l[12] || (l[12] = e("br", null, null, -1)),
            s(p, { title: "System Information" }, {
              default: m(() => [
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
                      (u(!0), r(v, null, c(n.value.sprinkles, (o) => (u(), r("li", {
                        key: o.name
                      }, t(o), 1))), 128))
                    ])
                  ])
                ])
              ]),
              _: 1
            })
          ]),
          e("div", null, [
            s(p, { title: "Activities" })
          ])
        ])
      ], 64);
    };
  }
};
export {
  C as default
};
