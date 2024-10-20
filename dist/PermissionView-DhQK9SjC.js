import { ref as g, watch as w, defineComponent as C, resolveComponent as r, openBlock as d, createBlock as c, withCtx as o, createElementVNode as n, createVNode as s, toDisplayString as l, renderSlot as y, createTextVNode as _, createElementBlock as v, Fragment as x, renderList as S, unref as h } from "vue";
import { useRoute as B } from "vue-router";
import { a as P } from "./axios-CXDYiOMX.js";
import { a as $ } from "./types-Daou0lcF.js";
function j(m) {
  const t = g(!1), e = g(), a = g({
    id: 0,
    slug: "",
    name: "",
    conditions: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null
  });
  async function i() {
    t.value = !0, e.value = null, await P.get("/api/permissions/p/" + m.params.id).then((u) => {
      a.value = u.data;
    }).catch((u) => {
      e.value = {
        description: "An error as occurred",
        style: $.Danger,
        ...u.response.data
      };
    }).finally(() => {
      t.value = !1;
    });
  }
  return w(
    () => m.params.id,
    () => {
      i();
    },
    { immediate: !0 }
  ), { permission: a, error: e, loading: t };
}
const b = { class: "uk-text-center" }, A = { class: "uk-text-center uk-margin-remove" }, H = { class: "uk-text-meta" }, L = { class: "uk-description-list" }, T = { style: { "text-wrap": "wrap" } }, V = /* @__PURE__ */ C({
  __name: "PermissionInfo",
  props: {
    permission: {}
  },
  setup(m) {
    return (t, e) => {
      const a = r("font-awesome-icon"), i = r("UFCardBox");
      return d(), c(i, null, {
        default: o(() => [
          n("div", b, [
            s(a, {
              icon: "key",
              class: "fa-5x"
            })
          ]),
          n("h3", A, l(t.permission.name), 1),
          n("p", H, l(t.permission.description), 1),
          e[2] || (e[2] = n("hr", null, null, -1)),
          n("dl", L, [
            e[0] || (e[0] = n("dt", null, "Slug", -1)),
            n("dd", null, [
              n("pre", null, [
                n("code", null, l(t.permission.slug), 1)
              ])
            ]),
            e[1] || (e[1] = n("dt", null, "Conditions", -1)),
            n("dd", null, [
              n("pre", T, [
                n("code", null, l(t.permission.conditions), 1)
              ])
            ])
          ]),
          y(t.$slots, "default", { dataTest: "slot" })
        ]),
        _: 3
      });
    };
  }
}), N = { class: "uk-text-meta" }, R = /* @__PURE__ */ C({
  __name: "PermissionUsers",
  props: {
    id: {}
  },
  setup(m) {
    return (t, e) => {
      const a = r("UFSprunjeHeader"), i = r("RouterLink"), u = r("UFSprunjeColumn"), f = r("UFLabel"), U = r("UFSprunjeTable"), F = r("UFCardBox");
      return d(), c(F, { title: "Users with this permission" }, {
        default: o(() => [
          s(U, {
            dataUrl: "/api/permissions/p/" + t.id + "/users",
            searchColumn: "name",
            hideFilters: ""
          }, {
            header: o(() => [
              s(a, { sort: "name" }, {
                default: o(() => e[0] || (e[0] = [
                  _("User")
                ])),
                _: 1
              }),
              s(a, null, {
                default: o(() => e[1] || (e[1] = [
                  _("Has permission via roles")
                ])),
                _: 1
              })
            ]),
            body: o(({ item: p }) => [
              s(u, null, {
                default: o(() => [
                  n("strong", null, [
                    s(i, {
                      to: {
                        name: "admin.user",
                        params: { user_name: p.user_name }
                      }
                    }, {
                      default: o(() => [
                        _(l(p.full_name) + " (" + l(p.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  n("div", N, l(p.email), 1)
                ]),
                _: 2
              }, 1024),
              s(u, null, {
                default: o(() => [
                  (d(!0), v(x, null, S(p.roles_via, (k) => (d(), c(i, {
                    key: k.id,
                    to: { name: "admin.role", params: { slug: k.slug } }
                  }, {
                    default: o(() => [
                      s(f, null, {
                        default: o(() => [
                          _(l(k.name), 1)
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
    const t = B(), { permission: e, error: a } = j(t);
    return (i, u) => {
      const f = r("UFHeaderPage"), U = r("UFAlert"), F = r("UFCardBox");
      return d(), v(x, null, [
        s(f, {
          title: "Permission details",
          caption: "Permission information page"
        }),
        h(a) ? (d(), c(F, { key: 0 }, {
          default: o(() => [
            s(U, { alert: h(a) }, null, 8, ["alert"])
          ]),
          _: 1
        })) : (d(), v("div", D, [
          n("div", E, [
            s(V, { permission: h(e) }, null, 8, ["permission"])
          ]),
          n("div", I, [
            s(R, {
              id: i.$route.params.id.toString()
            }, null, 8, ["id"])
          ])
        ]))
      ], 64);
    };
  }
});
export {
  K as default
};
