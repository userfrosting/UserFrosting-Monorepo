import { resolveComponent as a, openBlock as U, createElementBlock as F, Fragment as v, createVNode as e, withCtx as t, createTextVNode as r, createElementVNode as s, toDisplayString as l, unref as i } from "vue";
import { h as _ } from "./moment-h96o7c8I.js";
const y = { class: "uk-text-meta" }, j = {
  __name: "UsersView",
  setup(g) {
    return (S, n) => {
      const m = a("UFHeaderPage"), u = a("UFSprunjeHeader"), p = a("RouterLink"), d = a("UFSprunjeColumn"), c = a("UFSprunjeTable"), f = a("UFCardBox");
      return U(), F(v, null, [
        e(m, {
          title: "Users",
          caption: `A listing of the users for your site. Provides management tools including the ability to
        edit user details, manually activate users, enable/disable users, and more.`
        }),
        e(f, null, {
          default: t(() => [
            e(c, { dataUrl: "/api/users" }, {
              header: t(() => [
                e(u, null, {
                  default: t(() => n[0] || (n[0] = [
                    r("User")
                  ])),
                  _: 1
                }),
                e(u, null, {
                  default: t(() => n[1] || (n[1] = [
                    r("Last Activity")
                  ])),
                  _: 1
                }),
                e(u, null, {
                  default: t(() => n[2] || (n[2] = [
                    r("Status")
                  ])),
                  _: 1
                }),
                e(u, null, {
                  default: t(() => n[3] || (n[3] = [
                    r("Actions")
                  ])),
                  _: 1
                })
              ]),
              body: t(({ item: o }) => [
                e(d, null, {
                  default: t(() => [
                    s("strong", null, [
                      e(p, {
                        to: {
                          name: "admin.user",
                          params: { user_name: o.user_name }
                        }
                      }, {
                        default: t(() => [
                          r(l(o.full_name) + " (" + l(o.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    s("div", y, l(o.email), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: t(() => [
                    s("div", null, l(i(_)(o.last_activity.occurred_at).format("dddd")), 1),
                    s("div", null, l(i(_)(o.last_activity.occurred_at).format("MMM Do, YYYY h:mm a")), 1),
                    s("i", null, l(o.last_activity.description), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d),
                e(d)
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
  j as default
};
