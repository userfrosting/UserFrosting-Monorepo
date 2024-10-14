import { resolveComponent as o, openBlock as d, createElementBlock as g, Fragment as S, createVNode as n, withCtx as t, createTextVNode as r, createElementVNode as s, toDisplayString as l, unref as f, createBlock as p } from "vue";
import { h as v } from "./moment-h96o7c8I.js";
const b = { class: "uk-text-meta" }, B = {
  __name: "UsersView",
  setup(k) {
    return (_, e) => {
      const y = o("UFHeaderPage"), u = o("UFSprunjeHeader"), c = o("RouterLink"), i = o("UFSprunjeColumn"), m = o("UFLabel"), U = o("UFSprunjeTable"), F = o("UFCardBox");
      return d(), g(S, null, [
        n(y, {
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
                n(u, { sort: "name" }, {
                  default: t(() => e[0] || (e[0] = [
                    r("User")
                  ])),
                  _: 1
                }),
                n(u, { sort: "last_activity" }, {
                  default: t(() => e[1] || (e[1] = [
                    r("Last Activity")
                  ])),
                  _: 1
                }),
                n(u, { sort: "status" }, {
                  default: t(() => e[2] || (e[2] = [
                    r("Status")
                  ])),
                  _: 1
                }),
                n(u, null, {
                  default: t(() => e[3] || (e[3] = [
                    r("Actions")
                  ])),
                  _: 1
                })
              ]),
              body: t(({ item: a }) => [
                n(i, null, {
                  default: t(() => [
                    s("strong", null, [
                      n(c, {
                        to: {
                          name: "admin.user",
                          params: { user_name: a.user_name }
                        }
                      }, {
                        default: t(() => [
                          r(l(a.full_name) + " (" + l(a.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    s("div", b, l(a.email), 1)
                  ]),
                  _: 2
                }, 1024),
                n(i, null, {
                  default: t(() => [
                    s("div", null, l(f(v)(a.last_activity.occurred_at).format("dddd")), 1),
                    s("div", null, l(f(v)(a.last_activity.occurred_at).format("MMM Do, YYYY h:mm a")), 1),
                    s("i", null, l(a.last_activity.description), 1)
                  ]),
                  _: 2
                }, 1024),
                n(i, null, {
                  default: t(() => [
                    a.flag_enabled === 0 ? (d(), p(m, {
                      key: 0,
                      severity: _.Severity.Danger
                    }, {
                      default: t(() => e[4] || (e[4] = [
                        r("Disabled")
                      ])),
                      _: 1
                    }, 8, ["severity"])) : a.flag_verified === 0 ? (d(), p(m, {
                      key: 1,
                      severity: _.Severity.Warning
                    }, {
                      default: t(() => e[5] || (e[5] = [
                        r("Unactivated")
                      ])),
                      _: 1
                    }, 8, ["severity"])) : (d(), p(m, {
                      key: 2,
                      severity: _.Severity.Success
                    }, {
                      default: t(() => e[6] || (e[6] = [
                        r("Active")
                      ])),
                      _: 1
                    }, 8, ["severity"]))
                  ]),
                  _: 2
                }, 1024),
                n(i)
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
  B as default
};
