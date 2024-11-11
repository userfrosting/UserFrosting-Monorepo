import { ref as t } from "vue";
import { a as o, b as n } from "../types-Ht7brb6q.js";
function l() {
  const e = t(!1), r = t(null);
  async function s(u) {
    return e.value = !0, r.value = null, o.post("/api/groups", u).then((a) => ({
      success: a.data.success,
      message: a.data.message,
      group: a.data.group
    })).catch((a) => {
      throw r.value = {
        description: "An error as occurred",
        style: n.Danger,
        closeBtn: !0,
        ...a.response.data
      }, r.value;
    }).finally(() => {
      e.value = !1;
    });
  }
  return { submitGroupEdit: s, apiLoading: e, apiError: r };
}
export {
  l as useGroupCreateApi
};
