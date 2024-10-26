import { ref as r, watch as o } from "vue";
import { a as u, b as i } from "../types-Ht7brb6q.js";
function p(s) {
  const a = r(!1), e = r(), l = r({
    id: 0,
    slug: "",
    name: "",
    description: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    users_count: 0
  });
  async function n() {
    a.value = !0, e.value = null, await u.get("/api/roles/r/" + s.params.slug).then((t) => {
      l.value = t.data;
    }).catch((t) => {
      e.value = {
        description: "An error as occurred",
        style: i.Danger,
        ...t.response.data
      };
    }).finally(() => {
      a.value = !1;
    });
  }
  return o(
    () => s.params.slug,
    () => {
      n();
    },
    { immediate: !0 }
  ), { role: l, error: e, loading: a };
}
export {
  p as useRoleApi
};
