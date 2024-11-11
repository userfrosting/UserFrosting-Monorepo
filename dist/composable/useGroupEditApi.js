import { ref as e } from "vue";
import { a as n, b as l } from "../types-Ht7brb6q.js";
function p() {
  const t = e(!1), r = e(null);
  async function u(s, o) {
    return t.value = !0, r.value = null, n.put("/api/groups/g/" + s, o).then((a) => ({
      success: a.data.success,
      message: a.data.message,
      group: a.data.group
    })).catch((a) => {
      throw r.value = {
        description: "An error as occurred",
        style: l.Danger,
        closeBtn: !0,
        ...a.response.data
      }, r.value;
    }).finally(() => {
      t.value = !1;
    });
  }
  return { submitGroupEdit: u, loadingState: t, apiError: r };
}
export {
  p as useGroupEditApi
};
