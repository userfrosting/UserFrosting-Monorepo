import { resolveComponent as a, openBlock as U, createElementBlock as v, Fragment as F, createVNode as e, withCtx as t, createTextVNode as l, createElementVNode as n, toDisplayString as o, unref as i } from "vue";
import { h as _ } from "./moment-h96o7c8I.js";
const S = { class: "uk-text-meta" }, k = {
  __name: "ActivitiesView",
  setup(x) {
    return (C, u) => {
      const c = a("UFHeaderPage"), s = a("UFSprunjeHeader"), d = a("UFSprunjeColumn"), p = a("RouterLink"), m = a("UFSprunjeTable"), f = a("UFCardBox");
      return U(), v(F, null, [
        e(c, {
          title: "Activities",
          caption: "A listing of user activities."
        }),
        e(f, null, {
          default: t(() => [
            e(m, {
              dataUrl: "/api/activities",
              searchColumn: "user",
              defaultSorts: { occurred_at: "desc" }
            }, {
              header: t(() => [
                e(s, { sort: "occurred_at" }, {
                  default: t(() => u[0] || (u[0] = [
                    l("Activity Time")
                  ])),
                  _: 1
                }),
                e(s, { sort: "user" }, {
                  default: t(() => u[1] || (u[1] = [
                    l("User")
                  ])),
                  _: 1
                }),
                e(s, { sort: "description" }, {
                  default: t(() => u[2] || (u[2] = [
                    l("Description")
                  ])),
                  _: 1
                })
              ]),
              body: t(({ item: r }) => [
                e(d, null, {
                  default: t(() => [
                    n("div", null, o(i(_)(r.occurred_at).format("dddd")), 1),
                    n("div", null, o(i(_)(r.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: t(() => [
                    n("strong", null, [
                      e(p, {
                        to: {
                          name: "admin.user",
                          params: { user_name: r.user.user_name }
                        }
                      }, {
                        default: t(() => [
                          l(o(r.user.full_name) + " (" + o(r.user.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    n("div", S, o(r.user.email), 1)
                  ]),
                  _: 2
                }, 1024),
                e(d, null, {
                  default: t(() => [
                    n("div", null, o(r.ip_address), 1),
                    n("div", null, [
                      n("i", null, o(r.description), 1)
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
  k as default
};
