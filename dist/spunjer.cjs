"use strict";Object.defineProperty(exports,Symbol.toStringTag,{value:"Module"});const e=require("vue"),g=require("./axios-tuVKNgv9.cjs"),h=n=>{const o=e.ref(10),u=e.ref(0),l=e.ref("[occurred_at]=desc"),t=e.ref({}),r=e.ref(!1);async function s(){r.value=!0,g.axios.get(e.toValue(n)+"?size="+o.value+"&page="+u.value+"&sorts%5Boccurred_at%5D=desc").then(c=>{t.value=c.data,r.value=!1}).catch(c=>{console.error(c)})}const d=e.computed(()=>Math.ceil(t.value.count_filtered/o.value)-1),a=e.computed(()=>t.value.count),i=e.computed(()=>u.value*o.value+1),v=e.computed(()=>Math.min((u.value+1)*o.value,a.value)),f=e.computed(()=>t.value.count_filtered),p=e.computed(()=>t.value.rows);function m(){console.log("Not yet implemented")}return e.watchEffect(()=>{s()}),{dataUrl:n,size:o,page:u,sorts:l,data:t,fetch:s,loading:r,downloadCsv:m,totalPages:d,countFiltered:f,count:a,rows:p,first:i,last:v}};exports.useSprunjer=h;
