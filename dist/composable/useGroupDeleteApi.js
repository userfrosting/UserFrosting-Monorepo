import { ref as t } from "vue";
import { a as o, b as l } from "../types-Ht7brb6q.js";
function i() {
  const r = t(!1), e = t(null);
  async function s(u) {
    return r.value = !0, e.value = null, o.delete("/api/groups/g/" + u).then((a) => ({
      success: a.data.success,
      message: a.data.message
    })).catch((a) => {
      throw e.value = {
        description: "An error as occurred",
        style: l.Danger,
        closeBtn: !0,
        ...a.response.data
      }, e.value;
    }).finally(() => {
      r.value = !1;
    });
  }
  return { loadingState: r, apiError: e, deleteGroup: s };
}
export {
  i as useGroupDeleteApi
};
