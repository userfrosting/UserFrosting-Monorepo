import { ref as k, watch as y, defineComponent as v, resolveComponent as l, openBlock as _, createBlock as f, withCtx as s, createElementVNode as t, createCommentVNode as x, toDisplayString as u, createVNode as o, createTextVNode as p, unref as c, createElementBlock as F, Fragment as C } from "vue";
import { useRoute as w } from "vue-router";
import { a as B } from "./axios-CXDYiOMX.js";
import { a as S } from "./types-Daou0lcF.js";
import { h } from "./moment-h96o7c8I.js";
function A(m) {
  const n = k(!1), e = k(), r = k({
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
  async function d() {
    n.value = !0, e.value = null, await B.get("/api/groups/g/" + m.params.slug).then((a) => {
      r.value = a.data;
    }).catch((a) => {
      e.value = {
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
      d();
    },
    { immediate: !0 }
  ), { group: r, error: e, loading: n };
}
const G = { class: "uk-text-center" }, j = { class: "uk-text-center uk-margin-remove" }, $ = { class: "uk-text-meta" }, V = { class: "uk-description-list" }, b = { class: "uk-badge" }, H = /* @__PURE__ */ v({
  __name: "GroupInfo",
  props: {
    group: {}
  },
  setup(m) {
    return (n, e) => {
      const r = l("font-awesome-icon"), d = l("UFCardBox");
      return _(), f(d, null, {
        default: s(() => [
          t("div", G, [
            n.group.icon ? (_(), f(r, {
              key: 0,
              icon: n.group.icon,
              class: "fa-5x"
            }, null, 8, ["icon"])) : x("", !0)
          ]),
          t("h3", j, u(n.group.name), 1),
          t("p", $, u(n.group.description), 1),
          e[1] || (e[1] = t("hr", null, null, -1)),
          t("dl", V, [
            t("dt", null, [
              o(r, { icon: "users" }),
              e[0] || (e[0] = p(" Users"))
            ]),
            t("dd", null, [
              t("span", b, u(n.group.users_count), 1)
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), N = { class: "uk-text-meta" }, Y = /* @__PURE__ */ v({
  __name: "GroupUsers",
  props: {
    slug: {}
  },
  setup(m) {
    return (n, e) => {
      const r = l("UFSprunjeHeader"), d = l("RouterLink"), a = l("UFSprunjeColumn"), g = l("UFSprunjeTable"), U = l("UFCardBox");
      return _(), f(U, { title: "Group Users" }, {
        default: s(() => [
          o(g, {
            dataUrl: "/api/groups/g/" + n.slug + "/users"
          }, {
            header: s(() => [
              o(r, { sort: "name" }, {
                default: s(() => e[0] || (e[0] = [
                  p("User")
                ])),
                _: 1
              }),
              o(r, { sort: "last_activity" }, {
                default: s(() => e[1] || (e[1] = [
                  p("Last Activity")
                ])),
                _: 1
              }),
              o(r, { sort: "status" }, {
                default: s(() => e[2] || (e[2] = [
                  p("Status")
                ])),
                _: 1
              }),
              o(r, null, {
                default: s(() => e[3] || (e[3] = [
                  p("Actions")
                ])),
                _: 1
              })
            ]),
            body: s(({ item: i }) => [
              o(a, null, {
                default: s(() => [
                  t("strong", null, [
                    o(d, {
                      to: {
                        name: "admin.user",
                        params: { user_name: i.user_name }
                      }
                    }, {
                      default: s(() => [
                        p(u(i.full_name) + " (" + u(i.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  t("div", N, u(i.email), 1)
                ]),
                _: 2
              }, 1024),
              o(a, null, {
                default: s(() => [
                  t("div", null, u(c(h)(i.last_activity.occurred_at).format("dddd")), 1),
                  t("div", null, u(c(h)(i.last_activity.occurred_at).format("MMM Do, YYYY h:mm a")), 1),
                  t("i", null, u(i.last_activity.description), 1)
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
}), D = {
  key: 1,
  "uk-grid": ""
}, L = { class: "uk-width-1-3" }, M = { class: "uk-width-2-3" }, q = /* @__PURE__ */ v({
  __name: "GroupView",
  setup(m) {
    const n = w(), { group: e, error: r } = A(n);
    return (d, a) => {
      const g = l("UFHeaderPage"), U = l("UFAlert");
      return _(), F(C, null, [
        o(g, {
          title: "Group details",
          caption: "Group information page"
        }),
        c(r) ? (_(), f(U, {
          key: 0,
          alert: c(r)
        }, null, 8, ["alert"])) : (_(), F("div", D, [
          t("div", L, [
            o(H, { group: c(e) }, null, 8, ["group"])
          ]),
          t("div", M, [
            o(Y, {
              slug: c(e).slug
            }, null, 8, ["slug"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  q as default
};
