import { defineComponent as g, resolveComponent as u, openBlock as a, createBlock as _, withCtx as s, createElementVNode as o, createCommentVNode as C, toDisplayString as p, createVNode as e, createTextVNode as i, renderSlot as h, createElementBlock as U, Fragment as w, unref as k } from "vue";
import { useRoute as $ } from "vue-router";
import { useGroupApi as G } from "./composable/group.js";
const S = { class: "uk-text-center" }, v = { class: "uk-text-center uk-margin-remove" }, x = { class: "uk-text-meta" }, B = { class: "uk-description-list" }, j = { class: "uk-badge" }, y = /* @__PURE__ */ g({
  __name: "GroupInfo",
  props: {
    group: {}
  },
  setup(f) {
    return (n, t) => {
      const r = u("font-awesome-icon"), l = u("UFCardBox");
      return a(), _(l, null, {
        default: s(() => [
          o("div", S, [
            n.group.icon ? (a(), _(r, {
              key: 0,
              icon: n.group.icon,
              class: "fa-5x"
            }, null, 8, ["icon"])) : C("", !0)
          ]),
          o("h3", v, p(n.group.name), 1),
          o("p", x, p(n.group.description), 1),
          t[1] || (t[1] = o("hr", null, null, -1)),
          o("dl", B, [
            o("dt", null, [
              e(r, { icon: "users" }),
              t[0] || (t[0] = i(" Users"))
            ]),
            o("dd", null, [
              o("span", j, p(n.group.users_count), 1)
            ])
          ]),
          t[2] || (t[2] = o("hr", null, null, -1)),
          t[3] || (t[3] = o("button", { class: "uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Edit Group ", -1)),
          t[4] || (t[4] = o("button", { class: "uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small" }, " Delete Group ", -1)),
          h(n.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), A = { class: "uk-button uk-button-default" }, V = { class: "uk-text-meta" }, H = { class: "uk-button uk-button-danger uk-button-small" }, N = /* @__PURE__ */ g({
  __name: "GroupUsers",
  props: {
    slug: {}
  },
  setup(f) {
    return (n, t) => {
      const r = u("font-awesome-icon"), l = u("UFSprunjeHeader"), b = u("RouterLink"), d = u("UFSprunjeColumn"), c = u("UFSprunjeTable"), F = u("UFCardBox");
      return a(), _(F, { title: "Group Users" }, {
        default: s(() => [
          e(c, {
            dataUrl: "/api/groups/g/" + n.slug + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            actions: s(() => [
              o("button", A, [
                e(r, { icon: "user-plus" }),
                t[0] || (t[0] = i(" Add user "))
              ])
            ]),
            header: s(() => [
              e(l, { sort: "name" }, {
                default: s(() => t[1] || (t[1] = [
                  i("User")
                ])),
                _: 1
              }),
              e(l, null, {
                default: s(() => t[2] || (t[2] = [
                  i("Actions")
                ])),
                _: 1
              })
            ]),
            body: s(({ item: m }) => [
              e(d, null, {
                default: s(() => [
                  o("strong", null, [
                    e(b, {
                      to: {
                        name: "admin.user",
                        params: { user_name: m.user_name }
                      }
                    }, {
                      default: s(() => [
                        i(p(m.full_name) + " (" + p(m.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  o("div", V, p(m.email), 1)
                ]),
                _: 2
              }, 1024),
              e(d, null, {
                default: s(() => [
                  o("button", H, [
                    e(r, { icon: "trash" })
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
}), T = {
  key: 1,
  "uk-grid": ""
}, E = { class: "uk-width-1-3" }, R = { class: "uk-width-2-3" }, I = /* @__PURE__ */ g({
  __name: "GroupView",
  setup(f) {
    const n = $(), { group: t, error: r } = G(n);
    return (l, b) => {
      const d = u("UFHeaderPage"), c = u("UFAlert");
      return a(), U(w, null, [
        e(d, {
          title: "Group details",
          caption: "Group information page"
        }),
        k(r) ? (a(), _(c, {
          key: 0,
          alert: k(r)
        }, null, 8, ["alert"])) : (a(), U("div", T, [
          o("div", E, [
            e(y, { group: k(t) }, null, 8, ["group"])
          ]),
          o("div", R, [
            e(N, {
              slug: l.$route.params.slug.toString()
            }, null, 8, ["slug"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  I as default
};
