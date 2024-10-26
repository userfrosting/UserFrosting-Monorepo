import { defineStore as e } from "pinia";
import { a, b as o } from "../types-Ht7brb6q.js";
const s = {
  counter: {
    users: 0,
    roles: 0,
    groups: 0
  },
  info: {
    frameworkVersion: "",
    phpVersion: "",
    database: {
      connection: "",
      name: "",
      type: "",
      version: ""
    },
    server: "",
    projectPath: ""
  },
  sprinkles: {},
  users: []
}, d = e("dashboardApi", {
  state: () => ({
    data: s
  }),
  actions: {
    async load() {
      return a.get("/api/dashboard").then((r) => (this.data = r.data, this.data)).catch((r) => {
        throw {
          description: "An error as occurred",
          style: o.Danger,
          closeBtn: !0,
          ...r.response.data
        };
      });
    }
  }
});
export {
  d as useDashboardApi
};
