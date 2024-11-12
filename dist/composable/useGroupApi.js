import { ref as r, watch as u } from "vue";
import { a as l, b as i } from "../types-Ht7brb6q.js";
function d(s) {
  const a = r(!1), e = r(), n = r({
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
  async function o() {
    a.value = !0, e.value = null, await l.get("/api/groups/g/" + s.params.slug).then((t) => {
      n.value = t.data;
    }).catch((t) => {
      e.value = {
        description: "An error as occurred",
        style: i.Danger,
        closeBtn: !0,
        ...t.response.data
      };
    }).finally(() => {
      a.value = !1;
    });
  }
  return u(
    () => s.params.slug,
    () => {
      o();
    },
    { immediate: !0 }
  ), { group: n, error: e, loading: a, fetchApi: o };
}
export {
  d as useGroupApi
};
