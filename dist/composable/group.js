import { ref as r, watch as u } from "vue";
import { a as i } from "../axios-CXDYiOMX.js";
import { a as l } from "../types-Daou0lcF.js";
function m(o) {
  const a = r(!1), e = r(), s = r({
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
  async function n() {
    a.value = !0, e.value = null, await i.get("/api/groups/g/" + o.params.slug).then((t) => {
      s.value = t.data;
    }).catch((t) => {
      e.value = {
        description: "An error as occurred",
        style: l.Danger,
        closeBtn: !0,
        ...t.response.data
      };
    }).finally(() => {
      a.value = !1;
    });
  }
  return u(
    () => o.params.slug,
    () => {
      n();
    },
    { immediate: !0 }
  ), { group: s, error: e, loading: a };
}
export {
  m as useGroupApi
};
