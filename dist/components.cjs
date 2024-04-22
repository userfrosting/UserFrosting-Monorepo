"use strict";Object.defineProperties(exports,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}});const e=require("vue"),E=require("./types.cjs"),l=require("vue-router"),y={key:1},p=e.defineComponent({__name:"AlertContainer",props:{title:{default:""},description:{default:""},style:{default:E.AlertStyle.Primary},closeBtn:{type:Boolean,default:!1}},setup(a){return(t,n)=>(e.openBlock(),e.createElementBlock("div",{class:e.normalizeClass(t.style),"uk-alert":""},[t.closeBtn?(e.openBlock(),e.createElementBlock("a",{key:0,class:"uk-alert-close","uk-close":"",onClick:n[0]||(n[0]=o=>t.$emit("close"))})):e.createCommentVNode("",!0),t.title?(e.openBlock(),e.createElementBlock("h3",y,e.toDisplayString(t.title),1)):e.createCommentVNode("",!0),e.createElementVNode("p",null,[e.renderSlot(t.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(t.description),1)])])],2))}}),g=["href"],d=e.defineComponent({__name:"AppLink",props:{to:{default:""},label:{default:""}},setup(a){const t=a,n=e.computed(()=>typeof t.to=="string"&&t.to.startsWith("http"));return(o,r)=>n.value?(e.openBlock(),e.createElementBlock("a",{key:0,href:o.to,target:"_blank"},[e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])],8,g)):(e.openBlock(),e.createBlock(e.unref(l.RouterLink),{key:1,to:o.to},{default:e.withCtx(()=>[e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])]),_:3},8,["to"]))}}),u=(a,t)=>{const n=a.__vccOpts||a;for(const[o,r]of t)n[o]=r;return n},S={},w={class:"uf-main uk-section uk-section-default"},D={class:"uk-container"};function L(a,t){return e.openBlock(),e.createElementBlock("div",w,[e.createElementVNode("div",D,[e.renderSlot(a.$slots,"default")])])}const m=u(S,[["render",L]]),T={"uk-sticky":"sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky"},I={class:"uk-navbar-container"},P={class:"uk-container uk-container-expand"},A={class:"uk-navbar","uk-navbar":""},R={class:"uk-navbar-left"},U={class:"uk-navbar-right"},z={class:"uk-navbar-nav"},k=e.defineComponent({__name:"NavBar",props:{to:{default:""},title:{default:""}},setup(a){return(t,n)=>(e.openBlock(),e.createElementBlock("header",null,[e.createElementVNode("div",T,[e.createElementVNode("div",I,[e.createElementVNode("div",P,[e.createElementVNode("nav",A,[e.createElementVNode("div",R,[e.createVNode(d,{to:t.to,class:"uk-navbar-item uk-logo"},{default:e.withCtx(()=>[e.renderSlot(t.$slots,"title",{},()=>[e.createTextVNode(e.toDisplayString(t.title),1)])]),_:3},8,["to"])]),e.createElementVNode("div",U,[e.createElementVNode("ul",z,[e.renderSlot(t.$slots,"default")])])])])])])]))}}),M=e.createElementVNode("span",{"uk-navbar-parent-icon":""},null,-1),W={class:"uk-navbar-dropdown","uk-dropdown":"offset: 0"},q={class:"uk-nav uk-navbar-dropdown-nav"},f=e.defineComponent({__name:"NavBarDropdown",props:{label:{default:""}},setup(a){return(t,n)=>(e.openBlock(),e.createElementBlock("li",null,[e.createElementVNode("a",null,[e.renderSlot(t.$slots,"label",{},()=>[e.createTextVNode(e.toDisplayString(t.label),1)]),e.createTextVNode(),M]),e.createElementVNode("div",W,[e.createElementVNode("ul",q,[e.renderSlot(t.$slots,"default")])])]))}}),O={},j={class:"uk-nav-divider"};function F(a,t){return e.openBlock(),e.createElementBlock("li",j)}const _=u(O,[["render",F]]),G={key:0},H=["href"],J=["href","onClick"],B=e.defineComponent({__name:"NavBarItem",props:{to:{default:""},label:{default:""}},setup(a){const t=a,n=e.computed(()=>typeof t.to=="string"&&t.to.startsWith("http"));return(o,r)=>n.value?(e.openBlock(),e.createElementBlock("li",G,[e.createElementVNode("a",{href:o.to,target:"_blank"},[e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])],8,H)])):(e.openBlock(),e.createBlock(e.unref(l.RouterLink),e.mergeProps({key:1},o.$props,{custom:""}),{default:e.withCtx(({isActive:s,href:c,navigate:i})=>[e.createElementVNode("li",{class:e.normalizeClass({"uk-active":s})},[e.createElementVNode("a",e.mergeProps(o.$attrs,{href:c,onClick:i}),[e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])],16,J)],2)]),_:3},16))}}),K={class:"uf-nav-user"},Q=["src"],X={class:"uk-navbar-dropdown","uk-dropdown":"offset: 0"},Y={class:"uk-nav uk-navbar-dropdown-nav"},Z={class:"uk-card uk-card-body uk-text-center"},x=["src"],ee={key:1},te={key:2,class:"uk-text-meta"},h=e.defineComponent({__name:"NavBarUserCard",props:{username:{default:""},avatar:{default:""},meta:{default:""}},setup(a){return(t,n)=>(e.openBlock(),e.createElementBlock("li",K,[e.createElementVNode("a",null,[e.createTextVNode(e.toDisplayString(t.username)+" ",1),t.avatar?(e.openBlock(),e.createElementBlock("img",{key:0,src:t.avatar,alt:"avatar",class:"uk-border-circle"},null,8,Q)):e.createCommentVNode("",!0)]),e.createElementVNode("div",X,[e.createElementVNode("ul",Y,[e.createElementVNode("div",Z,[t.avatar?(e.openBlock(),e.createElementBlock("img",{key:0,src:t.avatar,alt:"avatar",class:"uk-border-circle","uk-height-match":""},null,8,x)):e.createCommentVNode("",!0),t.username?(e.openBlock(),e.createElementBlock("p",ee,e.toDisplayString(t.username),1)):e.createCommentVNode("",!0),t.meta?(e.openBlock(),e.createElementBlock("p",te,"("+e.toDisplayString(t.meta)+")",1)):e.createCommentVNode("",!0)]),e.renderSlot(t.$slots,"default")])])]))}}),oe={key:0},ne=["href"],ae={key:1},v=e.defineComponent({__name:"NavBarUserCardButton",props:{to:{default:""},label:{default:""}},setup(a){const t=a,n=e.computed(()=>typeof t.to=="string"&&t.to.startsWith("http"));return(o,r)=>n.value?(e.openBlock(),e.createElementBlock("li",oe,[e.createElementVNode("a",{class:"uk-button uk-button-default uk-button-small uk-text-center",href:o.to,target:"_blank"},[e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])],8,ne)])):(e.openBlock(),e.createElementBlock("li",ae,[e.createVNode(e.unref(l.RouterLink),{to:o.to,class:"uk-button uk-button-default uk-button-small uk-text-center"},{default:e.withCtx(()=>[e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])]),_:3},8,["to"])]))}}),re={},le={class:"uf-sidebar-left uk-light uk-visible@m"},se={class:"left-nav-wrap"},ce={class:"uk-nav uk-nav-default","data-uk-nav":""};function ie(a,t){return e.openBlock(),e.createElementBlock("aside",le,[e.createElementVNode("div",se,[e.createElementVNode("ul",ce,[e.renderSlot(a.$slots,"default")])])])}const N=u(re,[["render",ie]]),de=["data-uk-icon"],ue={key:2,"uk-nav-parent-icon":""},pe={class:"uk-nav-sub"},$=e.defineComponent({__name:"SideBarDropdown",props:{to:{default:""},label:{default:""},faIcon:{default:""},icon:{default:""},hideCaret:{type:Boolean,default:!1}},setup(a){return(t,n)=>{const o=e.resolveComponent("font-awesome-icon");return e.openBlock(),e.createBlock(e.unref(l.RouterLink),e.mergeProps(t.$props,{custom:""}),{default:e.withCtx(({isActive:r})=>[e.createElementVNode("li",{class:e.normalizeClass(["uk-parent",{"uk-open":r}])},[e.createElementVNode("a",e.normalizeProps(e.guardReactiveProps(t.$attrs)),[t.icon?(e.openBlock(),e.createElementBlock("span",{key:0,"data-uk-icon":t.icon,class:"uk-margin-small-right"},null,8,de)):e.createCommentVNode("",!0),t.faIcon?(e.openBlock(),e.createBlock(o,{key:1,class:"uk-margin-small-right",icon:t.faIcon},null,8,["icon"])):e.createCommentVNode("",!0),e.renderSlot(t.$slots,"label",{},()=>[e.createTextVNode(e.toDisplayString(t.label),1)]),t.hideCaret?e.createCommentVNode("",!0):(e.openBlock(),e.createElementBlock("span",ue))],16),e.createElementVNode("ul",pe,[e.renderSlot(t.$slots,"default")])],2)]),_:3},16)}}}),me={key:0},ke=["href"],fe=["data-uk-icon"],_e=["href","onClick"],Be=["data-uk-icon"],V=e.defineComponent({__name:"SideBarItem",props:{to:{default:""},label:{default:""},faIcon:{default:""},icon:{default:""}},setup(a){const t=a,n=e.computed(()=>typeof t.to=="string"&&t.to.startsWith("http"));return(o,r)=>{const s=e.resolveComponent("font-awesome-icon");return n.value?(e.openBlock(),e.createElementBlock("li",me,[e.createElementVNode("a",{href:o.to,target:"_blank"},[o.icon?(e.openBlock(),e.createElementBlock("span",{key:0,"data-uk-icon":o.icon,class:"uk-margin-small-right"},null,8,fe)):e.createCommentVNode("",!0),o.faIcon?(e.openBlock(),e.createBlock(s,{key:1,class:"uk-margin-small-right",icon:o.faIcon},null,8,["icon"])):e.createCommentVNode("",!0),e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])],8,ke)])):(e.openBlock(),e.createBlock(e.unref(l.RouterLink),e.mergeProps({key:1},o.$props,{custom:""}),{default:e.withCtx(({isExactActive:c,href:i,navigate:C})=>[e.createElementVNode("li",{class:e.normalizeClass({"uk-active":c})},[e.createElementVNode("a",e.mergeProps(o.$attrs,{href:i,onClick:C}),[o.icon?(e.openBlock(),e.createElementBlock("span",{key:0,"data-uk-icon":o.icon,class:"uk-margin-small-right"},null,8,Be)):e.createCommentVNode("",!0),o.faIcon?(e.openBlock(),e.createBlock(s,{key:1,class:"uk-margin-small-right",icon:o.faIcon},null,8,["icon"])):e.createCommentVNode("",!0),e.renderSlot(o.$slots,"default",{},()=>[e.createTextVNode(e.toDisplayString(o.label),1)])],16,_e)],2)]),_:3},16))}}}),he={class:"uk-nav-header"},b=e.defineComponent({__name:"SideBarLabel",props:{label:{}},setup(a){return(t,n)=>(e.openBlock(),e.createElementBlock("li",he,e.toDisplayString(t.label),1))}}),ve={install:(a,t)=>{const n=t&&t.prefix?t.prefix:"UF";a.component(n+"AlertContainer",p).component(n+"AppLink",d).component(n+"MainContent",m).component(n+"NavBar",k).component(n+"NavBarDropdown",f).component(n+"NavBarDropdownSeparator",_).component(n+"NavBarItem",B).component(n+"NavBarUserCard",h).component(n+"NavBarUserCardButton",v).component(n+"SideBar",N).component(n+"SideBarDropdown",$).component(n+"SideBarItem",V).component(n+"SideBarLabel",b)}};exports.AlertContainer=p;exports.AppLink=d;exports.MainContent=m;exports.NavBar=k;exports.NavBarDropdown=f;exports.NavBarDropdownSeparator=_;exports.NavBarItem=B;exports.NavBarUserCard=h;exports.NavBarUserCardButton=v;exports.SideBar=N;exports.SideBarDropdown=$;exports.SideBarItem=V;exports.SideBarLabel=b;exports.default=ve;
