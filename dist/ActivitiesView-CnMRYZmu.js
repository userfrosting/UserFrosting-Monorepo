import { ref as h, resolveComponent as a, openBlock as r, createElementBlock as s, Fragment as d, createVNode as i, withCtx as c, createElementVNode as e, renderList as k, toDisplayString as n, unref as m, createTextVNode as g } from "vue";
import { a as x, h as _ } from "./moment-BwEV_F1Z.js";
const B = { class: "uk-table uk-table-striped" }, F = { class: "uk-text-meta" }, A = {
  __name: "ActivitiesView",
  setup(U) {
    const o = h({});
    return x.get("/api/activities?size=10&page=0&sorts%5Boccurred_at%5D=desc").then((l) => {
      o.value = l.data;
    }).catch((l) => {
      console.error(l);
    }), (l, u) => {
      const p = a("UFHeaderPage"), v = a("RouterLink"), f = a("UFCardBox");
      return r(), s(d, null, [
        i(p, {
          title: "Activities",
          caption: "A listing of user activities."
        }),
        i(f, null, {
          default: c(() => [
            e("table", B, [
              u[0] || (u[0] = e("thead", null, [
                e("tr", null, [
                  e("th", null, "Activity Time"),
                  e("th", null, "User"),
                  e("th", null, "Description")
                ])
              ], -1)),
              e("tbody", null, [
                (r(!0), s(d, null, k(o.value.rows, (t) => (r(), s("tr", {
                  key: t.id
                }, [
                  e("td", null, [
                    e("div", null, n(m(_)(t.occurred_at).format("dddd")), 1),
                    e("div", null, n(m(_)(t.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                  ]),
                  e("td", null, [
                    e("strong", null, [
                      i(v, {
                        to: {
                          name: "admin.user",
                          params: { user_name: t.user.user_name }
                        }
                      }, {
                        default: c(() => [
                          g(n(t.user.full_name) + " (" + n(t.user.user_name) + ") ", 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ]),
                    e("div", F, n(t.user.email), 1)
                  ]),
                  e("td", null, [
                    e("div", null, n(t.ip_address), 1),
                    e("div", null, [
                      e("i", null, n(t.description), 1)
                    ])
                  ])
                ]))), 128))
              ])
            ])
          ]),
          _: 1
        })
      ], 64);
    };
  }
};
export {
  A as default
};
