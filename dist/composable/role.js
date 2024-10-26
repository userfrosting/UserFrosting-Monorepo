import { ref as t, watch as n } from "vue";
import { a as i } from "../axios-CXDYiOMX.js";
import { a as u } from "../types-Daou0lcF.js";
function m(o) {
  const e = t(!1), a = t(), s = t({
    id: 0,
    slug: "",
    name: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    users_count: 0
  });
  async function l() {
    e.value = !0, a.value = null, await i.get("/api/roles/r/" + o.params.slug).then((r) => {
      s.value = r.data;
    }).catch((r) => {
      a.value = {
        description: "An error as occurred",
        style: u.Danger,
        ...r.response.data
      };
    }).finally(() => {
      e.value = !1;
    });
  }
  return n(
    () => o.params.slug,
    () => {
      l();
    },
    { immediate: !0 }
  ), { role: s, error: a, loading: e };
}
export {
  m as useRoleApi
};
