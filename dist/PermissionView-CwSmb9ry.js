import { defineComponent as C, resolveComponent as t, openBlock as a, createBlock as _, withCtx as o, createElementVNode as e, createVNode as s, toDisplayString as i, renderSlot as S, createTextVNode as m, createElementBlock as g, Fragment as x, renderList as v, unref as k } from "vue";
import { useRoute as w } from "vue-router";
import { usePermissionApi as B } from "./composable/permission.js";
const P = { class: "uk-text-center" }, $ = { class: "uk-text-center uk-margin-remove" }, y = { class: "uk-text-meta" }, j = { class: "uk-description-list" }, b = { style: { "text-wrap": "wrap" } }, H = /* @__PURE__ */ C({
  __name: "PermissionInfo",
  props: {
    permission: {}
  },
  setup(h) {
    return (r, n) => {
      const l = t("font-awesome-icon"), u = t("UFCardBox");
      return a(), _(u, null, {
        default: o(() => [
          e("div", P, [
            s(l, {
              icon: "key",
              class: "fa-5x"
            })
          ]),
          e("h3", $, i(r.permission.name), 1),
          e("p", y, i(r.permission.description), 1),
          n[2] || (n[2] = e("hr", null, null, -1)),
          e("dl", j, [
            n[0] || (n[0] = e("dt", null, "Slug", -1)),
            e("dd", null, [
              e("pre", null, [
                e("code", null, i(r.permission.slug), 1)
              ])
            ]),
            n[1] || (n[1] = e("dt", null, "Conditions", -1)),
            e("dd", null, [
              e("pre", b, [
                e("code", null, i(r.permission.conditions), 1)
              ])
            ])
          ]),
          S(r.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), L = { class: "uk-text-meta" }, T = /* @__PURE__ */ C({
  __name: "PermissionUsers",
  props: {
    id: {}
  },
  setup(h) {
    return (r, n) => {
      const l = t("UFSprunjeHeader"), u = t("RouterLink"), p = t("UFSprunjeColumn"), c = t("UFLabel"), f = t("UFSprunjeTable"), U = t("UFCardBox");
      return a(), _(U, { title: "Users with this permission" }, {
        default: o(() => [
          s(f, {
            dataUrl: "/api/permissions/p/" + r.id + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            header: o(() => [
              s(l, { sort: "name" }, {
                default: o(() => n[0] || (n[0] = [
                  m("User")
                ])),
                _: 1
              }),
              s(l, null, {
                default: o(() => n[1] || (n[1] = [
                  m("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: o(({ item: d }) => [
              s(p, null, {
                default: o(() => [
                  e("strong", null, [
                    s(u, {
                      to: {
                        name: "admin.user",
                        params: { user_name: d.user_name }
                      }
                    }, {
                      default: o(() => [
                        m(i(d.full_name) + " (" + i(d.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  e("div", L, i(d.email), 1)
                ]),
                _: 2
              }, 1024),
              s(p, null, {
                default: o(() => [
                  (a(!0), g(x, null, v(d.roles_via, (F) => (a(), _(u, {
                    key: F.id,
                    to: { name: "admin.role", params: { slug: F.slug } }
                  }, {
                    default: o(() => [
                      s(c, null, {
                        default: o(() => [
                          m(i(F.name), 1)
                        ]),
                        _: 2
                      }, 1024)
                    ]),
                    _: 2
                  }, 1032, ["to"]))), 128))
                ]),
                _: 2
              }, 1024)
            ]),
            _: 1
          }, 8, ["dataUrl"])
        ]),
        _: 1
      });
    };
  }
}), V = {
  key: 1,
  "uk-grid": ""
}, A = { class: "uk-width-1-3" }, N = { class: "uk-width-2-3" }, I = /* @__PURE__ */ C({
  __name: "PermissionView",
  setup(h) {
    const r = w(), { permission: n, error: l } = B(r);
    return (u, p) => {
      const c = t("UFHeaderPage"), f = t("UFAlert"), U = t("UFCardBox");
      return a(), g(x, null, [
        s(c, {
          title: "Permission details",
          caption: "Permission information page"
        }),
        k(l) ? (a(), _(U, { key: 0 }, {
          default: o(() => [
            s(f, { alert: k(l) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (a(), g("div", V, [
          e("div", A, [
            s(H, { permission: k(n) }, null, 8, ["permission"])
          ]),
          e("div", N, [
            s(T, {
              id: u.$route.params.id.toString()
            }, null, 8, ["id"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  I as default
};
