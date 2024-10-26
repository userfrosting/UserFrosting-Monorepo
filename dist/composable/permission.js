import { ref as i, watch as o } from "vue";
import { a as l, b as c } from "../types-Ht7brb6q.js";
function u(r) {
  const a = i(!1), e = i(), s = i({
    id: 0,
    slug: "",
    name: "",
    conditions: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null
  });
  async function n() {
    a.value = !0, e.value = null, await l.get("/api/permissions/p/" + r.params.id).then((t) => {
      s.value = t.data;
    }).catch((t) => {
      e.value = {
        description: "An error as occurred",
        style: c.Danger,
        ...t.response.data
      };
    }).finally(() => {
      a.value = !1;
    });
  }
  return o(
    () => r.params.id,
    () => {
      n();
    },
    { immediate: !0 }
  ), { permission: s, error: e, loading: a };
}
export {
  u as usePermissionApi
};
