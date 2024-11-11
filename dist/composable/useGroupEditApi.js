import { ref as t } from "vue";
import { a as n, b as i } from "../types-Ht7brb6q.js";
function p() {
  const e = t(!1), r = t(null);
  async function u(s, o) {
    return e.value = !0, r.value = null, n.put("/api/groups/g/" + s, o).then((a) => ({
      success: a.data.success,
      message: a.data.message,
      group: a.data.group
    })).catch((a) => {
      throw r.value = {
        description: "An error as occurred",
        style: i.Danger,
        closeBtn: !0,
        ...a.response.data
      }, r.value;
    }).finally(() => {
      e.value = !1;
    });
  }
  return { submitGroupEdit: u, apiLoading: e, apiError: r };
}
export {
  p as useGroupEditApi
};
