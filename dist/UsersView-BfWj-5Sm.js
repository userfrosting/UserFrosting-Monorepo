import { resolveComponent as a, openBlock as f, createElementBlock as g, Fragment as F, createVNode as o, withCtx as n, createElementVNode as t, createTextVNode as l, toDisplayString as r, unref as u, createBlock as m } from "vue";
import { a as p } from "./types-Daou0lcF.js";
import { h as c } from "./moment-h96o7c8I.js";
const w = { class: "uk-button uk-button-default" }, C = { class: "uk-text-meta" }, S = {
  class: "uk-button uk-button-default uk-button-small",
  type: "button"
}, L = {
  __name: "UsersView",
  setup(x) {
    return (j, e) => {
      const U = a("UFHeaderPage"), v = a("font-awesome-icon"), i = a("UFSprunjeHeader"), y = a("RouterLink"), d = a("UFSprunjeColumn"), _ = a("UFLabel"), b = a("UFSprunjeTable"), k = a("UFCardBox");
      return f(), g(F, null, [
        o(U, {
          title: "Users",
          caption: `A listing of the users for your site. Provides management tools including the ability to
        edit user details, manually activate users, enable/disable users, and more.`
        }),
        o(k, null, {
          default: n(() => [
            o(b, {
              dataUrl: "/api/users",
              searchColumn: "name"
            }, {
              actions: n(() => [
                t("button", w, [
                  o(v, { icon: "user-plus" }),
                  e[0] || (e[0] = l(" Create user "))
                ])
              ]),
              header: n(() => [
                o(i, { sort: "name" }, {
                  default: n(() => e[1] || (e[1] = [
                    l("User")
                  ])),
                  _: 1
                }),
                o(i, { sort: "last_activity" }, {
                  default: n(() => e[2] || (e[2] = [
                    l("Last Activity")
                  ])),
                  _: 1
                }),
                o(i, { sort: "status" }, {
                  default: n(() => e[3] || (e[3] = [
                    l("Status")
                  ])),
                  _: 1
                }),
                o(i, null, {
                  default: n(() => e[4] || (e[4] = [
                    l("Actions")
                  ])),
                  _: 1
                })
              ]),
              body: n(({ item: s }) => [
                o(d, null, {
                  default: n(() => [
                    t("strong", null, [
                      o(y, {
                        to: {
                          name: "admin.user",
                          params: { user_name: s.user_name }
                        }
                      }, {
                        default: n(() => [
                          l(r(s.full_name) + " (" + r(s.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    t("div", C, r(s.email), 1)
                  ]),
                  _: 2
                }, 1024),
                o(d, null, {
                  default: n(() => [
                    t("div", null, r(u(c)(s.last_activity.occurred_at).format("dddd")), 1),
                    t("div", null, r(u(c)(s.last_activity.occurred_at).format("MMM Do, YYYY h:mm a")), 1),
                    t("i", null, r(s.last_activity.description), 1)
                  ]),
                  _: 2
                }, 1024),
                o(d, null, {
                  default: n(() => [
                    s.flag_enabled == !1 ? (f(), m(_, {
                      key: 0,
                      severity: u(p).Danger
                    }, {
                      default: n(() => e[5] || (e[5] = [
                        l(" Disabled ")
                      ])),
                      _: 1
                    }, 8, ["severity"])) : s.flag_verified == !1 ? (f(), m(_, {
                      key: 1,
                      severity: u(p).Warning
                    }, {
                      default: n(() => e[6] || (e[6] = [
                        l(" Unactivated ")
                      ])),
                      _: 1
                    }, 8, ["severity"])) : (f(), m(_, {
                      key: 2,
                      severity: u(p).Success
                    }, {
                      default: n(() => e[7] || (e[7] = [
                        l("Active")
                      ])),
                      _: 1
                    }, 8, ["severity"]))
                  ]),
                  _: 2
                }, 1024),
                o(d, null, {
                  default: n(() => [
                    t("button", S, [
                      e[8] || (e[8] = l(" Actions ")),
                      o(v, {
                        icon: "caret-down",
                        "fixed-width": ""
                      })
                    ]),
                    e[9] || (e[9] = t("div", { "uk-dropdown": "" }, [
                      t("ul", { class: "uk-nav uk-dropdown-nav" }, [
                        t("li", null, [
                          t("a", { href: "#" }, "Edit User")
                        ]),
                        t("li", null, [
                          t("a", { href: "#" }, "Change User Password")
                        ]),
                        t("li", null, [
                          t("a", { href: "#" }, "Disable User")
                        ]),
                        t("li", null, [
                          t("a", { href: "#" }, "Delete User")
                        ])
                      ])
                    ], -1))
                  ]),
                  _: 1
                })
              ]),
              _: 1
            })
          ]),
          _: 1
        })
      ], 64);
    };
  }
};
export {
  L as default
};
