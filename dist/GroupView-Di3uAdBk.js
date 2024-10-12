import { ref as v, watch as y, defineComponent as U, resolveComponent as l, openBlock as p, createBlock as g, withCtx as r, createElementVNode as e, createCommentVNode as x, toDisplayString as u, createVNode as o, createTextVNode as d, unref as _, createElementBlock as h, Fragment as C } from "vue";
import { useRoute as w } from "vue-router";
import { a as B, b as S } from "./types-BgMW-dbA.js";
import { h as F } from "./moment-h96o7c8I.js";
function A(m) {
  const n = v(!1), t = v(), s = v({
    id: 0,
    name: "",
    slug: "",
    description: "",
    icon: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    users_count: 0
  });
  async function c() {
    n.value = !0, t.value = null, await B.get("/api/groups/g/" + m.params.slug).then((a) => {
      s.value = a.data;
    }).catch((a) => {
      t.value = {
        description: "An error as occurred",
        style: S.Danger,
        closeBtn: !0,
        ...a.response.data
      };
    }).finally(() => {
      n.value = !1;
    });
  }
  return y(
    () => m.params.slug,
    () => {
      c();
    },
    { immediate: !0 }
  ), { group: s, error: t, loading: n };
}
const G = { class: "uk-text-center" }, j = { class: "uk-text-center uk-margin-remove" }, $ = { class: "uk-text-meta" }, b = { "uk-grid": "" }, V = { class: "uk-width-auto@m" }, H = { class: "uk-width-expand@m uk-text-right" }, N = { class: "uk-badge" }, Y = /* @__PURE__ */ U({
  __name: "GroupInfo",
  props: {
    group: {}
  },
  setup(m) {
    return (n, t) => {
      const s = l("font-awesome-icon"), c = l("UFCardBox");
      return p(), g(c, null, {
        default: r(() => [
          e("div", G, [
            n.group.icon ? (p(), g(s, {
              key: 0,
              icon: n.group.icon,
              class: "fa-5x"
            }, null, 8, ["icon"])) : x("", !0)
          ]),
          e("h3", j, u(n.group.name), 1),
          e("p", $, u(n.group.description), 1),
          e("div", b, [
            e("div", V, [
              e("strong", null, [
                o(s, { icon: "users" }),
                t[0] || (t[0] = d(" Users"))
              ])
            ]),
            e("div", H, [
              e("span", N, u(n.group.users_count), 1)
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), D = { class: "uk-text-meta" }, L = /* @__PURE__ */ U({
  __name: "GroupUsers",
  props: {
    slug: {}
  },
  setup(m) {
    return (n, t) => {
      const s = l("UFSprunjeHeader"), c = l("RouterLink"), a = l("UFSprunjeColumn"), f = l("UFSprunjeTable"), k = l("UFCardBox");
      return p(), g(k, { title: "Group Users" }, {
        default: r(() => [
          o(f, {
            dataUrl: "/api/groups/g/" + n.slug + "/users"
          }, {
            header: r(() => [
              o(s, { sort: "name" }, {
                default: r(() => t[0] || (t[0] = [
                  d("User")
                ])),
                _: 1
              }),
              o(s, { sort: "last_activity" }, {
                default: r(() => t[1] || (t[1] = [
                  d("Last Activity")
                ])),
                _: 1
              }),
              o(s, { sort: "status" }, {
                default: r(() => t[2] || (t[2] = [
                  d("Status")
                ])),
                _: 1
              }),
              o(s, null, {
                default: r(() => t[3] || (t[3] = [
                  d("Actions")
                ])),
                _: 1
              })
            ]),
            body: r(({ item: i }) => [
              o(a, null, {
                default: r(() => [
                  e("strong", null, [
                    o(c, {
                      to: {
                        name: "admin.user",
                        params: { user_name: i.user_name }
                      }
                    }, {
                      default: r(() => [
                        d(u(i.full_name) + " (" + u(i.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  e("div", D, u(i.email), 1)
                ]),
                _: 2
              }, 1024),
              o(a, null, {
                default: r(() => [
                  e("div", null, u(_(F)(i.last_activity.occurred_at).format("dddd")), 1),
                  e("div", null, u(_(F)(i.last_activity.occurred_at).format("MMM Do, YYYY h:mm a")), 1),
                  e("i", null, u(i.last_activity.description), 1)
                ]),
                _: 2
              }, 1024),
              o(a),
              o(a)
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), M = {
  key: 1,
  "uk-grid": ""
}, R = { class: "uk-width-1-3" }, T = { class: "uk-width-2-3" }, z = /* @__PURE__ */ U({
  __name: "GroupView",
  setup(m) {
    const n = w(), { group: t, error: s } = A(n);
    return (c, a) => {
      const f = l("UFHeaderPage"), k = l("UFAlertContainer");
      return p(), h(C, null, [
        o(f, {
          title: "Group details",
          caption: "Group information page"
        }),
        _(s) ? (p(), g(k, {
          key: 0,
          alert: _(s)
        }, null, 8, ["alert"])) : (p(), h("div", M, [
          e("div", R, [
            o(Y, { group: _(t) }, null, 8, ["group"])
          ]),
          e("div", T, [
            o(L, {
              slug: _(t).slug
            }, null, 8, ["slug"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  z as default
};
