import { ref as l, watch as u } from "vue";
import { a as i } from "../axios-CXDYiOMX.js";
import { a as o } from "../types-Daou0lcF.js";
function d(t) {
  const a = l(!1), e = l(), n = l({
    id: 0,
    user_name: "",
    first_name: "",
    last_name: "",
    full_name: "",
    email: "",
    avatar: "",
    flag_enabled: !1,
    flag_verified: !1,
    group_id: null,
    locale: "",
    created_at: "",
    updated_at: "",
    deleted_at: null,
    locale_name: "",
    group: null
  });
  async function s() {
    a.value = !0, e.value = null, await i.get("/api/users/u/" + t.params.user_name).then((r) => {
      n.value = r.data;
    }).catch((r) => {
      e.value = {
        description: "An error as occurred",
        style: o.Danger,
        ...r.response.data
      };
    }).finally(() => {
      a.value = !1;
    });
  }
  return u(
    () => t.params.user_name,
    () => {
      s();
    },
    { immediate: !0 }
  ), { user: n, error: e, loading: a };
}
export {
  d as useUserAdminApi
};
