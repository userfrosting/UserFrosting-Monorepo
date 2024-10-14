import { resolveComponent as r, openBlock as _, createElementBlock as g, Fragment as b, createVNode as n, withCtx as t, createTextVNode as o, createElementVNode as s, toDisplayString as l, unref as u, createBlock as p } from "vue";
import { a as f } from "./types-Daou0lcF.js";
import { h as c } from "./moment-h96o7c8I.js";
const k = { class: "uk-text-meta" }, L = {
  __name: "UsersView",
  setup(S) {
    return (x, e) => {
      const v = r("UFHeaderPage"), i = r("UFSprunjeHeader"), y = r("RouterLink"), d = r("UFSprunjeColumn"), m = r("UFLabel"), U = r("UFSprunjeTable"), F = r("UFCardBox");
      return _(), g(b, null, [
        n(v, {
          title: "Users",
          caption: `A listing of the users for your site. Provides management tools including the ability to
        edit user details, manually activate users, enable/disable users, and more.`
        }),
        n(F, null, {
          default: t(() => [
            n(U, {
              dataUrl: "/api/users",
              searchColumn: "name"
            }, {
              header: t(() => [
                n(i, { sort: "name" }, {
                  default: t(() => e[0] || (e[0] = [
                    o("User")
                  ])),
                  _: 1
                }),
                n(i, { sort: "last_activity" }, {
                  default: t(() => e[1] || (e[1] = [
                    o("Last Activity")
                  ])),
                  _: 1
                }),
                n(i, { sort: "status" }, {
                  default: t(() => e[2] || (e[2] = [
                    o("Status")
                  ])),
                  _: 1
                }),
                n(i, null, {
                  default: t(() => e[3] || (e[3] = [
                    o("Actions")
                  ])),
                  _: 1
                })
              ]),
              body: t(({ item: a }) => [
                n(d, null, {
                  default: t(() => [
                    s("strong", null, [
                      n(y, {
                        to: {
                          name: "admin.user",
                          params: { user_name: a.user_name }
                        }
                      }, {
                        default: t(() => [
                          o(l(a.full_name) + " (" + l(a.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    s("div", k, l(a.email), 1)
                  ]),
                  _: 2
                }, 1024),
                n(d, null, {
                  default: t(() => [
                    s("div", null, l(u(c)(a.last_activity.occurred_at).format("dddd")), 1),
                    s("div", null, l(u(c)(a.last_activity.occurred_at).format("MMM Do, YYYY h:mm a")), 1),
                    s("i", null, l(a.last_activity.description), 1)
                  ]),
                  _: 2
                }, 1024),
                n(d, null, {
                  default: t(() => [
                    a.flag_enabled === 0 ? (_(), p(m, {
                      key: 0,
                      severity: u(f).Danger
                    }, {
                      default: t(() => e[4] || (e[4] = [
                        o("Disabled")
                      ])),
                      _: 1
                    }, 8, ["severity"])) : a.flag_verified === 0 ? (_(), p(m, {
                      key: 1,
                      severity: u(f).Warning
                    }, {
                      default: t(() => e[5] || (e[5] = [
                        o("Unactivated")
                      ])),
                      _: 1
                    }, 8, ["severity"])) : (_(), p(m, {
                      key: 2,
                      severity: u(f).Success
                    }, {
                      default: t(() => e[6] || (e[6] = [
                        o("Active")
                      ])),
                      _: 1
                    }, 8, ["severity"]))
                  ]),
                  _: 2
                }, 1024),
                n(d)
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
