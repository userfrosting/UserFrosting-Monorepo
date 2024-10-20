import { ref as k, watch as w, defineComponent as C, resolveComponent as r, openBlock as d, createBlock as c, withCtx as t, createElementVNode as n, createVNode as o, toDisplayString as i, renderSlot as y, createTextVNode as _, createElementBlock as v, Fragment as x, renderList as S, unref as h } from "vue";
import { useRoute as B } from "vue-router";
import { a as P } from "./axios-CXDYiOMX.js";
import { a as $ } from "./types-Daou0lcF.js";
function j(m) {
  const s = k(!1), e = k(), a = k({
    id: 0,
    slug: "",
    name: "",
    conditions: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null
  });
  async function l() {
    s.value = !0, e.value = null, await P.get("/api/permissions/p/" + m.params.slug).then((u) => {
      a.value = u.data;
    }).catch((u) => {
      e.value = {
        description: "An error as occurred",
        style: $.Danger,
        ...u.response.data
      };
    }).finally(() => {
      s.value = !1;
    });
  }
  return w(
    () => m.params.slug,
    () => {
      l();
    },
    { immediate: !0 }
  ), { permission: a, error: e, loading: s };
}
const b = { class: "uk-text-center" }, A = { class: "uk-text-center uk-margin-remove" }, H = { class: "uk-text-meta" }, L = { class: "uk-description-list" }, T = { style: { "text-wrap": "wrap" } }, V = /* @__PURE__ */ C({
  __name: "PermissionInfo",
  props: {
    permission: {}
  },
  setup(m) {
    return (s, e) => {
      const a = r("font-awesome-icon"), l = r("UFCardBox");
      return d(), c(l, null, {
        default: t(() => [
          n("div", b, [
            o(a, {
              icon: "key",
              class: "fa-5x"
            })
          ]),
          n("h3", A, i(s.permission.name), 1),
          n("p", H, i(s.permission.description), 1),
          e[2] || (e[2] = n("hr", null, null, -1)),
          n("dl", L, [
            e[0] || (e[0] = n("dt", null, "Slug", -1)),
            n("dd", null, [
              n("pre", null, [
                n("code", null, i(s.permission.slug), 1)
              ])
            ]),
            e[1] || (e[1] = n("dt", null, "Conditions", -1)),
            n("dd", null, [
              n("pre", T, [
                n("code", null, i(s.permission.conditions), 1)
              ])
            ])
          ]),
          y(s.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), N = { class: "uk-text-meta" }, R = /* @__PURE__ */ C({
  __name: "PermissionUsers",
  props: {
    slug: {}
  },
  setup(m) {
    return (s, e) => {
      const a = r("UFSprunjeHeader"), l = r("RouterLink"), u = r("UFSprunjeColumn"), f = r("UFLabel"), g = r("UFSprunjeTable"), U = r("UFCardBox");
      return d(), c(U, { title: "Users with this permission" }, {
        default: t(() => [
          o(g, {
            dataUrl: "/api/permissions/p/" + s.slug + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            header: t(() => [
              o(a, { sort: "name" }, {
                default: t(() => e[0] || (e[0] = [
                  _("User")
                ])),
                _: 1
              }),
              o(a, null, {
                default: t(() => e[1] || (e[1] = [
                  _("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: t(({ item: p }) => [
              o(u, null, {
                default: t(() => [
                  n("strong", null, [
                    o(l, {
                      to: {
                        name: "admin.user",
                        params: { user_name: p.user_name }
                      }
                    }, {
                      default: t(() => [
                        _(i(p.full_name) + " (" + i(p.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  n("div", N, i(p.email), 1)
                ]),
                _: 2
              }, 1024),
              o(u, null, {
                default: t(() => [
                  (d(!0), v(x, null, S(p.roles_via, (F) => (d(), c(l, {
                    key: F.id,
                    to: { name: "admin.role", params: { slug: F.slug } }
                  }, {
                    default: t(() => [
                      o(f, null, {
                        default: t(() => [
                          _(i(F.name), 1)
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
}), D = {
  key: 1,
  "uk-grid": ""
}, E = { class: "uk-width-1-3" }, I = { class: "uk-width-2-3" }, K = /* @__PURE__ */ C({
  __name: "PermissionView",
  setup(m) {
    const s = B(), { permission: e, error: a } = j(s);
    return (l, u) => {
      const f = r("UFHeaderPage"), g = r("UFAlert"), U = r("UFCardBox");
      return d(), v(x, null, [
        o(f, {
          title: "Permission details",
          caption: "Permission information page"
        }),
        h(a) ? (d(), c(U, { key: 0 }, {
          default: t(() => [
            o(g, { alert: h(a) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (d(), v("div", D, [
          n("div", E, [
            o(V, { permission: h(e) }, null, 8, ["permission"])
          ]),
          n("div", I, [
            o(R, {
              slug: l.$route.params.slug.toString()
            }, null, 8, ["slug"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  K as default
};
