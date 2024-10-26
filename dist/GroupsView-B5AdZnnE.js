import { defineComponent as x, ref as F, reactive as S, resolveComponent as a, openBlock as v, createElementBlock as y, withModifiers as j, createElementVNode as t, createBlock as D, createCommentVNode as V, createVNode as o, withDirectives as g, unref as i, vModelText as b, inject as $, Fragment as G, createTextVNode as m, withCtx as l, toDisplayString as U } from "vue";
import { a as h } from "./axios-CXDYiOMX.js";
import { a as A } from "./types-Daou0lcF.js";
function C() {
  return {
    slug: "",
    name: "",
    description: "",
    icon: "users"
  };
}
async function B(_) {
  return h.post("/api/groups", _).then((d) => d.data.message).catch((d) => {
    throw {
      description: "An error as occurred",
      style: A.Danger,
      closeBtn: !0,
      ...d.response.data
    };
  });
}
const N = { class: "uk-fieldset uk-form-stacked" }, H = { class: "uk-margin" }, M = { class: "uk-inline uk-width-1-1" }, P = { class: "uk-margin" }, T = { class: "uk-inline uk-width-1-1" }, E = { class: "uk-margin" }, I = { class: "uk-inline uk-width-1-1" }, L = { class: "uk-margin" }, R = {
  class: "uk-text-right",
  "uk-margin": ""
}, q = /* @__PURE__ */ x({
  __name: "GroupCreateForm",
  emits: ["cancel", "saved"],
  setup(_, { emit: d }) {
    const n = d, f = F(!1), s = F();
    let r = S(C());
    async function k() {
      f.value = !0, s.value = null, await B(r).then((c) => {
        n("saved"), r = C();
      }).catch((c) => {
        s.value = c;
      }).finally(() => {
        f.value = !1;
      });
    }
    return (c, e) => {
      const w = a("UFAlert"), p = a("font-awesome-icon");
      return v(), y("form", {
        onSubmit: e[5] || (e[5] = j((u) => k(), ["prevent"]))
      }, [
        t("fieldset", N, [
          s.value ? (v(), D(w, {
            key: 0,
            "data-test": "error",
            alert: s.value
          }, null, 8, ["alert"])) : V("", !0),
          t("div", H, [
            e[6] || (e[6] = t("label", {
              class: "uk-form-label",
              for: "form-stacked-text"
            }, "Group name", -1)),
            t("div", M, [
              o(p, {
                class: "fa-form-icon",
                icon: "pen-to-square",
                "fixed-width": ""
              }),
              g(t("input", {
                class: "uk-input",
                type: "text",
                placeholder: "Please enter a name for the group",
                "aria-label": "Group Name",
                "data-test": "name",
                "onUpdate:modelValue": e[0] || (e[0] = (u) => i(r).name = u)
              }, null, 512), [
                [b, i(r).name]
              ])
            ])
          ]),
          t("div", P, [
            e[7] || (e[7] = t("label", {
              class: "uk-form-label",
              for: "form-stacked-text"
            }, "Slug", -1)),
            t("div", T, [
              o(p, {
                class: "fa-form-icon",
                icon: "tag",
                "fixed-width": ""
              }),
              g(t("input", {
                class: "uk-input",
                type: "text",
                placeholder: "Group Slug",
                "aria-label": "Group Slug",
                "data-test": "slug",
                "onUpdate:modelValue": e[1] || (e[1] = (u) => i(r).slug = u)
              }, null, 512), [
                [b, i(r).slug]
              ])
            ])
          ]),
          t("div", E, [
            e[8] || (e[8] = t("label", {
              class: "uk-form-label",
              for: "form-stacked-text"
            }, "Group Icon", -1)),
            t("div", I, [
              o(p, {
                class: "fa-form-icon",
                icon: i(r).icon,
                "fixed-width": ""
              }, null, 8, ["icon"]),
              g(t("input", {
                class: "uk-input",
                type: "text",
                placeholder: "Icon for group members",
                "aria-label": "Group Icon",
                "data-test": "icon",
                "onUpdate:modelValue": e[2] || (e[2] = (u) => i(r).icon = u)
              }, null, 512), [
                [b, i(r).icon]
              ])
            ])
          ]),
          t("div", L, [
            e[9] || (e[9] = t("label", {
              class: "uk-form-label",
              for: "form-stacked-text"
            }, "Description", -1)),
            g(t("textarea", {
              class: "uk-textarea",
              placeholder: "Group Description",
              "aria-label": "Description",
              "data-test": "description",
              rows: "6",
              "onUpdate:modelValue": e[3] || (e[3] = (u) => i(r).description = u)
            }, null, 512), [
              [b, i(r).description]
            ])
          ]),
          t("div", R, [
            t("button", {
              class: "uk-button uk-button-default",
              type: "button",
              onClick: e[4] || (e[4] = (u) => c.$emit("cancel"))
            }, "Cancel"),
            e[10] || (e[10] = t("button", {
              class: "uk-button uk-button-primary",
              type: "submit"
            }, "Save", -1))
          ])
        ])
      ], 32);
    };
  }
}), z = {
  class: "uk-button uk-button-default",
  type: "button",
  "uk-toggle": "target: #group-create-form"
}, J = {
  id: "group-create-form",
  "uk-modal": ""
}, K = { class: "uk-modal-dialog uk-modal-body" }, O = /* @__PURE__ */ x({
  __name: "GroupCreateModal",
  setup(_) {
    const d = $("sprunjer"), n = () => {
      d.fetch();
    };
    return (f, s) => {
      const r = a("font-awesome-icon");
      return v(), y(G, null, [
        t("button", z, [
          o(r, {
            icon: "plus",
            "fixed-width": ""
          }),
          s[0] || (s[0] = m(" Create Group "))
        ]),
        t("div", J, [
          t("div", K, [
            s[1] || (s[1] = t("button", {
              class: "uk-modal-close-default",
              type: "button",
              "uk-close": ""
            }, null, -1)),
            s[2] || (s[2] = t("h3", { class: "uk-modal-title" }, "Create Group", -1)),
            o(q, {
              onCancel: n,
              onSaved: n
            })
          ])
        ])
      ], 64);
    };
  }
}), Q = {
  class: "uk-button uk-button-default uk-button-small",
  type: "button"
}, Z = /* @__PURE__ */ x({
  __name: "GroupsView",
  setup(_) {
    return (d, n) => {
      const f = a("UFHeaderPage"), s = a("UFSprunjeHeader"), r = a("RouterLink"), k = a("UFSprunjeColumn"), c = a("font-awesome-icon"), e = a("UFSprunjeTable"), w = a("UFCardBox");
      return v(), y(G, null, [
        o(f, {
          title: "Groups",
          caption: "A listing of the groups for your site. Provides management tools for editing and deleting groups."
        }),
        o(w, null, {
          default: l(() => [
            o(e, {
              dataUrl: "/api/groups",
              searchColumn: "name"
            }, {
              actions: l(() => [
                o(O)
              ]),
              header: l(() => [
                o(s, { sort: "name" }, {
                  default: l(() => n[0] || (n[0] = [
                    m("Groups")
                  ])),
                  _: 1
                }),
                o(s, { sort: "description" }, {
                  default: l(() => n[1] || (n[1] = [
                    m("Description")
                  ])),
                  _: 1
                }),
                o(s, null, {
                  default: l(() => n[2] || (n[2] = [
                    m("Actions")
                  ])),
                  _: 1
                })
              ]),
              body: l(({ item: p }) => [
                o(k, null, {
                  default: l(() => [
                    t("strong", null, [
                      o(r, {
                        to: {
                          name: "admin.group",
                          params: { slug: p.slug }
                        }
                      }, {
                        default: l(() => [
                          m(U(p.name), 1)
                        ]),
                        _: 2
                      }, 1032, ["to"])
                    ])
                  ]),
                  _: 2
                }, 1024),
                o(k, null, {
                  default: l(() => [
                    m(U(p.description), 1)
                  ]),
                  _: 2
                }, 1024),
                o(k, null, {
                  default: l(() => [
                    t("button", Q, [
                      n[3] || (n[3] = m(" Actions ")),
                      o(c, {
                        icon: "caret-down",
                        "fixed-width": ""
                      })
                    ]),
                    n[4] || (n[4] = t("div", { "uk-dropdown": "" }, [
                      t("ul", { class: "uk-nav uk-dropdown-nav" }, [
                        t("li", null, [
                          t("a", { href: "#" }, "Edit Group")
                        ]),
                        t("li", null, [
                          t("a", { href: "#" }, "Delete Group")
                        ])
                      ])
                    ], -1))
                  ]),
                  _: 1
                })
              ]),
              _: 1
            })
          ]),
          _: 1
        })
      ], 64);
    };
  }
});
export {
  Z as default
};
