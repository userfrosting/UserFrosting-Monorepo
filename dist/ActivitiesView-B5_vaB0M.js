import { resolveComponent as u, openBlock as U, createElementBlock as v, Fragment as F, createVNode as e, withCtx as n, createTextVNode as a, createElementVNode as o, toDisplayString as r, unref as i } from "vue";
import { h as _ } from "./moment-h96o7c8I.js";
const x = { class: "uk-text-meta" }, C = {
  __name: "ActivitiesView",
  setup(S) {
    return (g, l) => {
      const p = u("UFHeaderPage"), s = u("UFSprunjeHeader"), d = u("UFSprunjeColumn"), c = u("RouterLink"), m = u("UFSprunjeTable"), f = u("UFCardBox");
      return U(), v(F, null, [
        e(p, {
          title: "Activities",
          caption: "A listing of user activities."
        }),
        e(f, null, {
          default: n(() => [
            e(m, { dataUrl: "/api/activities" }, {
              header: n(() => [
                e(s, null, {
                  default: n(() => l[0] || (l[0] = [
                    a("Activity Time")
                  ])),
                  _: 1
                }),
                e(s, null, {
                  default: n(() => l[1] || (l[1] = [
                    a("User")
                  ])),
                  _: 1
                }),
                e(s, null, {
                  default: n(() => l[2] || (l[2] = [
                    a("Description")
                  ])),
                  _: 1
                })
              ]),
              body: n(({ item: t }) => [
                e(d, null, {
                  default: n(() => [
                    o("div", null, r(i(_)(t.occurred_at).format("dddd")), 1),
                    o("div", null, r(i(_)(t.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: n(() => [
                    o("strong", null, [
                      e(c, {
                        to: {
                          name: "admin.user",
                          params: { user_name: t.user.user_name }
                        }
                      }, {
                        default: n(() => [
                          a(r(t.user.full_name) + " (" + r(t.user.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    o("div", x, r(t.user.email), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: n(() => [
                    o("div", null, r(t.ip_address), 1),
                    o("div", null, [
                      o("i", null, r(t.description), 1)
                    ])
                  ]),
                  _: 2
                }, 1024)
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
  C as default
};
