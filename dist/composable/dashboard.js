import { defineStore as e } from "pinia";
import { a } from "../axios-CXDYiOMX.js";
import { a as o } from "../types-Daou0lcF.js";
const t = {
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
}, p = e("dashboardApi", {
  state: () => ({
    data: t
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
  p as useDashboardApi
};
