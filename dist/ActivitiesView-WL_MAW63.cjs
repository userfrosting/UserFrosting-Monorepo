"use strict";Object.defineProperty(exports,Symbol.toStringTag,{value:"Module"});const e=require("vue"),l=require("./moment-Cv2I3nb0.cjs"),s={class:"uk-table uk-table-striped"},d={class:"uk-text-meta"},u={__name:"ActivitiesView",setup(m){const o=e.ref({});return l.axios.get("/api/activities?size=10&page=0&sorts%5Boccurred_at%5D=desc").then(n=>{o.value=n.data}).catch(n=>{console.error(n)}),(n,r)=>{const a=e.resolveComponent("UFHeaderPage"),i=e.resolveComponent("RouterLink"),c=e.resolveComponent("UFCardBox");return e.openBlock(),e.createElementBlock(e.Fragment,null,[e.createVNode(a,{title:"Activities",caption:"A listing of user activities."}),e.createVNode(c,null,{default:e.withCtx(()=>[e.createElementVNode("table",s,[r[0]||(r[0]=e.createElementVNode("thead",null,[e.createElementVNode("tr",null,[e.createElementVNode("th",null,"Activity Time"),e.createElementVNode("th",null,"User"),e.createElementVNode("th",null,"Description")])],-1)),e.createElementVNode("tbody",null,[(e.openBlock(!0),e.createElementBlock(e.Fragment,null,e.renderList(o.value.rows,t=>(e.openBlock(),e.createElementBlock("tr",{key:t.id},[e.createElementVNode("td",null,[e.createElementVNode("div",null,e.toDisplayString(e.unref(l.hooks)(t.occurred_at).format("dddd")),1),e.createElementVNode("div",null,e.toDisplayString(e.unref(l.hooks)(t.occurred_at).format("MMM Do, YYYY h:mm a")),1)]),e.createElementVNode("td",null,[e.createElementVNode("strong",null,[e.createVNode(i,{to:{name:"admin.user",params:{user_name:t.user.user_name}}},{default:e.withCtx(()=>[e.createTextVNode(e.toDisplayString(t.user.full_name)+" ("+e.toDisplayString(t.user.user_name)+") ",1)]),_:2},1032,["to"])]),e.createElementVNode("div",d,e.toDisplayString(t.user.email),1)]),e.createElementVNode("td",null,[e.createElementVNode("div",null,e.toDisplayString(t.ip_address),1),e.createElementVNode("div",null,[e.createElementVNode("i",null,e.toDisplayString(t.description),1)])])]))),128))])])]),_:1})],64)}}};exports.default=u;
