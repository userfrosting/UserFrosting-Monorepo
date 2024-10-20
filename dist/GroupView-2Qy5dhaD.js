import { ref as k, watch as v, defineComponent as U, resolveComponent as r, openBlock as i, createBlock as g, withCtx as u, createElementVNode as o, createCommentVNode as w, toDisplayString as p, createVNode as n, createTextVNode as c, renderSlot as C, createElementBlock as F, Fragment as $, unref as b } from "vue";
import { useRoute as y } from "vue-router";
import { a as G } from "./axios-CXDYiOMX.js";
import { a as S } from "./types-Daou0lcF.js";
function x(d) {
  const e = k(!1), t = k(), s = k({
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
  async function a() {
    e.value = !0, t.value = null, await G.get("/api/groups/g/" + d.params.slug).then((l) => {
      s.value = l.data;
    }).catch((l) => {
      t.value = {
        description: "An error as occurred",
        style: S.Danger,
        closeBtn: !0,
        ...l.response.data
      };
    }).finally(() => {
      e.value = !1;
    });
  }
  return v(
    () => d.params.slug,
    () => {
      a();
    },
    { immediate: !0 }
  ), { group: s, error: t, loading: e };
}
const B = { class: "uk-text-center" }, A = { class: "uk-text-center uk-margin-remove" }, j = { class: "uk-text-meta" }, V = { class: "uk-description-list" }, H = { class: "uk-badge" }, N = /* @__PURE__ */ U({
  __name: "GroupInfo",
  props: {
    group: {}
  },
  setup(d) {
    return (e, t) => {
      const s = r("font-awesome-icon"), a = r("UFCardBox");
      return i(), g(a, null, {
        default: u(() => [
          o("div", B, [
            e.group.icon ? (i(), g(s, {
              key: 0,
              icon: e.group.icon,
              class: "fa-5x"
            }, null, 8, ["icon"])) : w("", !0)
          ]),
          o("h3", A, p(e.group.name), 1),
          o("p", j, p(e.group.description), 1),
          t[1] || (t[1] = o("hr", null, null, -1)),
          o("dl", V, [
            o("dt", null, [
              n(s, { icon: "users" }),
              t[0] || (t[0] = c(" Users"))
            ]),
            o("dd", null, [
              o("span", H, p(e.group.users_count), 1)
            ])
          ]),
          t[2] || (t[2] = o("hr", null, null, -1)),
          t[3] || (t[3] = o("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit Group ", -1)),
          t[4] || (t[4] = o("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete Group ", -1)),
          C(e.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), T = { class: "uk-button uk-button-default" }, D = { class: "uk-text-meta" }, E = { class: "uk-button uk-button-danger uk-button-small" }, R = /* @__PURE__ */ U({
  __name: "GroupUsers",
  props: {
    slug: {}
  },
  setup(d) {
    return (e, t) => {
      const s = r("font-awesome-icon"), a = r("UFSprunjeHeader"), l = r("RouterLink"), m = r("UFSprunjeColumn"), f = r("UFSprunjeTable"), h = r("UFCardBox");
      return i(), g(h, { title: "Group Users" }, {
        default: u(() => [
          n(f, {
            dataUrl: "/api/groups/g/" + e.slug + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: u(() => [
              o("button", T, [
                n(s, { icon: "user-plus" }),
                t[0] || (t[0] = c(" Add user "))
              ])
            ]),
            header: u(() => [
              n(a, { sort: "name" }, {
                default: u(() => t[1] || (t[1] = [
                  c("User")
                ])),
                _: 1
              }),
              n(a, null, {
                default: u(() => t[2] || (t[2] = [
                  c("Actions")
                ])),
                _: 1
              })
            ]),
            body: u(({ item: _ }) => [
              n(m, null, {
                default: u(() => [
                  o("strong", null, [
                    n(l, {
                      to: {
                        name: "admin.user",
                        params: { user_name: _.user_name }
                      }
                    }, {
                      default: u(() => [
                        c(p(_.full_name) + " (" + p(_.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  o("div", D, p(_.email), 1)
                ]),
                _: 2
              }, 1024),
              n(m, null, {
                default: u(() => [
                  o("button", E, [
                    n(s, { icon: "trash" })
                  ])
                ]),
                _: 1
              })
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), L = {
  key: 1,
  "uk-grid": ""
}, P = { class: "uk-width-1-3" }, I = { class: "uk-width-2-3" }, M = /* @__PURE__ */ U({
  __name: "GroupView",
  setup(d) {
    const e = y(), { group: t, error: s } = x(e);
    return (a, l) => {
      const m = r("UFHeaderPage"), f = r("UFAlert");
      return i(), F($, null, [
        n(m, {
          title: "Group details",
          caption: "Group information page"
        }),
        b(s) ? (i(), g(f, {
          key: 0,
          alert: b(s)
        }, null, 8, ["alert"])) : (i(), F("div", L, [
          o("div", P, [
            n(N, { group: b(t) }, null, 8, ["group"])
          ]),
          o("div", I, [
            n(R, {
              slug: a.$route.params.slug.toString()
            }, null, 8, ["slug"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  M as default
};
