import { resolveComponent as u, openBlock as U, createElementBlock as v, Fragment as F, createVNode as e, withCtx as t, createTextVNode as a, createElementVNode as o, toDisplayString as r, unref as i } from "vue";
import { h as _ } from "./moment-h96o7c8I.js";
const S = { class: "uk-text-meta" }, C = {
  __name: "ActivitiesView",
  setup(x) {
    return (g, l) => {
      const c = u("UFHeaderPage"), s = u("UFSprunjeHeader"), d = u("UFSprunjeColumn"), p = u("RouterLink"), m = u("UFSprunjeTable"), f = u("UFCardBox");
      return U(), v(F, null, [
        e(c, {
          title: "Activities",
          caption: "A listing of user activities."
        }),
        e(f, null, {
          default: t(() => [
            e(m, {
              dataUrl: "/api/activities",
              defaultSorts: { occurred_at: "desc" }
            }, {
              header: t(() => [
                e(s, null, {
                  default: t(() => l[0] || (l[0] = [
                    a("Activity Time")
                  ])),
                  _: 1
                }),
                e(s, null, {
                  default: t(() => l[1] || (l[1] = [
                    a("User")
                  ])),
                  _: 1
                }),
                e(s, null, {
                  default: t(() => l[2] || (l[2] = [
                    a("Description")
                  ])),
                  _: 1
                })
              ]),
              body: t(({ item: n }) => [
                e(d, null, {
                  default: t(() => [
                    o("div", null, r(i(_)(n.occurred_at).format("dddd")), 1),
                    o("div", null, r(i(_)(n.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: t(() => [
                    o("strong", null, [
                      e(p, {
                        to: {
                          name: "admin.user",
                          params: { user_name: n.user.user_name }
                        }
                      }, {
                        default: t(() => [
                          a(r(n.user.full_name) + " (" + r(n.user.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    o("div", S, r(n.user.email), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: t(() => [
                    o("div", null, r(n.ip_address), 1),
                    o("div", null, [
                      o("i", null, r(n.description), 1)
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
