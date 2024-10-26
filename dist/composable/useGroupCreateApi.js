import { ref as s } from "vue";
import { a as l, b as c } from "../types-Ht7brb6q.js";
function m() {
  const u = {
    slug: "",
    name: "",
    description: "",
    icon: "users"
  }, t = s({ ...u }), r = s(!1), a = s(null);
  async function o() {
    return r.value = !0, a.value = null, l.post("/api/groups", t.value).then((e) => ({
      success: e.data.success,
      message: e.data.message,
      group: e.data.group
    })).catch((e) => {
      throw a.value = {
        description: "An error as occurred",
        style: c.Danger,
        closeBtn: !0,
        ...e.response.data
      }, a.value;
    }).finally(() => {
      r.value = !1;
    });
  }
  function n() {
    t.value = { ...u }, r.value = !1, a.value = null;
  }
  return { sendForm: o, resetForm: n, formData: t, loadingState: r, formError: a };
}
export {
  m as useGroupCreateApi
};
