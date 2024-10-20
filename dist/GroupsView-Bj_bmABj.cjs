"use strict";Object.defineProperty(exports,Symbol.toStringTag,{value:"Module"});const e=require("vue"),i=require("./_plugin-vue_export-helper-BHFhmbuH.cjs"),c={},p={class:"uk-button uk-button-default"},m={class:"uk-button uk-button-default uk-button-small",type:"button"};function V(_,t){const a=e.resolveComponent("UFHeaderPage"),l=e.resolveComponent("font-awesome-icon"),o=e.resolveComponent("UFSprunjeHeader"),u=e.resolveComponent("RouterLink"),n=e.resolveComponent("UFSprunjeColumn"),d=e.resolveComponent("UFSprunjeTable"),s=e.resolveComponent("UFCardBox");return e.openBlock(),e.createElementBlock(e.Fragment,null,[e.createVNode(a,{title:"Groups",caption:"A listing of the groups for your site.  Provides management tools for editing and deleting groups."}),e.createVNode(s,null,{default:e.withCtx(()=>[e.createVNode(d,{dataUrl:"/api/groups",searchColumn:"name"},{actions:e.withCtx(()=>[e.createElementVNode("button",p,[e.createVNode(l,{icon:"Users"}),t[0]||(t[0]=e.createTextVNode(" Create Group "))])]),header:e.withCtx(()=>[e.createVNode(o,{sort:"name"},{default:e.withCtx(()=>t[1]||(t[1]=[e.createTextVNode("Groups")])),_:1}),e.createVNode(o,{sort:"description"},{default:e.withCtx(()=>t[2]||(t[2]=[e.createTextVNode("Description")])),_:1}),e.createVNode(o,null,{default:e.withCtx(()=>t[3]||(t[3]=[e.createTextVNode("Actions")])),_:1})]),body:e.withCtx(({item:r})=>[e.createVNode(n,null,{default:e.withCtx(()=>[e.createElementVNode("strong",null,[e.createVNode(u,{to:{name:"admin.group",params:{slug:r.slug}}},{default:e.withCtx(()=>[e.createTextVNode(e.toDisplayString(r.name),1)]),_:2},1032,["to"])])]),_:2},1024),e.createVNode(n,null,{default:e.withCtx(()=>[e.createTextVNode(e.toDisplayString(r.description),1)]),_:2},1024),e.createVNode(n,null,{default:e.withCtx(()=>[e.createElementVNode("button",m,[t[4]||(t[4]=e.createTextVNode(" Actions ")),e.createVNode(l,{icon:"caret-down","fixed-width":""})]),t[5]||(t[5]=e.createElementVNode("div",{"uk-dropdown":""},[e.createElementVNode("ul",{class:"uk-nav uk-dropdown-nav"},[e.createElementVNode("li",null,[e.createElementVNode("a",{href:"#"},"Edit Group")]),e.createElementVNode("li",null,[e.createElementVNode("a",{href:"#"},"Delete Group")])])],-1))]),_:1})]),_:1})]),_:1})],64)}const N=i._export_sfc(c,[["render",V]]);exports.default=N;
