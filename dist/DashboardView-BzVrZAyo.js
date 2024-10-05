import { defineComponent as ee, resolveComponent as H, openBlock as D, createElementBlock as v, Fragment as te, createVNode as N, createBlock as qe, withCtx as J, createTextVNode as ft, createElementVNode as m, renderList as Ie, toDisplayString as C, unref as L } from "vue";
import { defineStore as dt } from "pinia";
import { h as pt } from "./moment-h96o7c8I.js";
function He(e, t) {
  return function() {
    return e.apply(t, arguments);
  };
}
const { toString: ht } = Object.prototype, { getPrototypeOf: we } = Object, ne = /* @__PURE__ */ ((e) => (t) => {
  const n = ht.call(t);
  return e[n] || (e[n] = n.slice(8, -1).toLowerCase());
})(/* @__PURE__ */ Object.create(null)), P = (e) => (e = e.toLowerCase(), (t) => ne(t) === e), re = (e) => (t) => typeof t === e, { isArray: M } = Array, $ = re("undefined");
function mt(e) {
  return e !== null && !$(e) && e.constructor !== null && !$(e.constructor) && x(e.constructor.isBuffer) && e.constructor.isBuffer(e);
}
const ve = P("ArrayBuffer");
function yt(e) {
  let t;
  return typeof ArrayBuffer < "u" && ArrayBuffer.isView ? t = ArrayBuffer.isView(e) : t = e && e.buffer && ve(e.buffer), t;
}
const bt = re("string"), x = re("function"), Me = re("number"), se = (e) => e !== null && typeof e == "object", wt = (e) => e === !0 || e === !1, X = (e) => {
  if (ne(e) !== "object")
    return !1;
  const t = we(e);
  return (t === null || t === Object.prototype || Object.getPrototypeOf(t) === null) && !(Symbol.toStringTag in e) && !(Symbol.iterator in e);
}, gt = P("Date"), Et = P("File"), St = P("Blob"), Rt = P("FileList"), Ot = (e) => se(e) && x(e.pipe), Tt = (e) => {
  let t;
  return e && (typeof FormData == "function" && e instanceof FormData || x(e.append) && ((t = ne(e)) === "formdata" || // detect form-data instance
  t === "object" && x(e.toString) && e.toString() === "[object FormData]"));
}, At = P("URLSearchParams"), [_t, xt, Ct, Pt] = ["ReadableStream", "Request", "Response", "Headers"].map(P), Nt = (e) => e.trim ? e.trim() : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
function W(e, t, { allOwnKeys: n = !1 } = {}) {
  if (e === null || typeof e > "u")
    return;
  let r, s;
  if (typeof e != "object" && (e = [e]), M(e))
    for (r = 0, s = e.length; r < s; r++)
      t.call(null, e[r], r, e);
  else {
    const o = n ? Object.getOwnPropertyNames(e) : Object.keys(e), i = o.length;
    let c;
    for (r = 0; r < i; r++)
      c = o[r], t.call(null, e[c], c, e);
  }
}
function ze(e, t) {
  t = t.toLowerCase();
  const n = Object.keys(e);
  let r = n.length, s;
  for (; r-- > 0; )
    if (s = n[r], t === s.toLowerCase())
      return s;
  return null;
}
const j = typeof globalThis < "u" ? globalThis : typeof self < "u" ? self : typeof window < "u" ? window : global, Ve = (e) => !$(e) && e !== j;
function fe() {
  const { caseless: e } = Ve(this) && this || {}, t = {}, n = (r, s) => {
    const o = e && ze(t, s) || s;
    X(t[o]) && X(r) ? t[o] = fe(t[o], r) : X(r) ? t[o] = fe({}, r) : M(r) ? t[o] = r.slice() : t[o] = r;
  };
  for (let r = 0, s = arguments.length; r < s; r++)
    arguments[r] && W(arguments[r], n);
  return t;
}
const kt = (e, t, n, { allOwnKeys: r } = {}) => (W(t, (s, o) => {
  n && x(s) ? e[o] = He(s, n) : e[o] = s;
}, { allOwnKeys: r }), e), Ft = (e) => (e.charCodeAt(0) === 65279 && (e = e.slice(1)), e), Bt = (e, t, n, r) => {
  e.prototype = Object.create(t.prototype, r), e.prototype.constructor = e, Object.defineProperty(e, "super", {
    value: t.prototype
  }), n && Object.assign(e.prototype, n);
}, Dt = (e, t, n, r) => {
  let s, o, i;
  const c = {};
  if (t = t || {}, e == null) return t;
  do {
    for (s = Object.getOwnPropertyNames(e), o = s.length; o-- > 0; )
      i = s[o], (!r || r(i, e, t)) && !c[i] && (t[i] = e[i], c[i] = !0);
    e = n !== !1 && we(e);
  } while (e && (!n || n(e, t)) && e !== Object.prototype);
  return t;
}, Ut = (e, t, n) => {
  e = String(e), (n === void 0 || n > e.length) && (n = e.length), n -= t.length;
  const r = e.indexOf(t, n);
  return r !== -1 && r === n;
}, Lt = (e) => {
  if (!e) return null;
  if (M(e)) return e;
  let t = e.length;
  if (!Me(t)) return null;
  const n = new Array(t);
  for (; t-- > 0; )
    n[t] = e[t];
  return n;
}, jt = /* @__PURE__ */ ((e) => (t) => e && t instanceof e)(typeof Uint8Array < "u" && we(Uint8Array)), qt = (e, t) => {
  const r = (e && e[Symbol.iterator]).call(e);
  let s;
  for (; (s = r.next()) && !s.done; ) {
    const o = s.value;
    t.call(e, o[0], o[1]);
  }
}, It = (e, t) => {
  let n;
  const r = [];
  for (; (n = e.exec(t)) !== null; )
    r.push(n);
  return r;
}, Ht = P("HTMLFormElement"), vt = (e) => e.toLowerCase().replace(
  /[-_\s]([a-z\d])(\w*)/g,
  function(n, r, s) {
    return r.toUpperCase() + s;
  }
), Te = (({ hasOwnProperty: e }) => (t, n) => e.call(t, n))(Object.prototype), Mt = P("RegExp"), Je = (e, t) => {
  const n = Object.getOwnPropertyDescriptors(e), r = {};
  W(n, (s, o) => {
    let i;
    (i = t(s, o, e)) !== !1 && (r[o] = i || s);
  }), Object.defineProperties(e, r);
}, zt = (e) => {
  Je(e, (t, n) => {
    if (x(e) && ["arguments", "caller", "callee"].indexOf(n) !== -1)
      return !1;
    const r = e[n];
    if (x(r)) {
      if (t.enumerable = !1, "writable" in t) {
        t.writable = !1;
        return;
      }
      t.set || (t.set = () => {
        throw Error("Can not rewrite read-only method '" + n + "'");
      });
    }
  });
}, Vt = (e, t) => {
  const n = {}, r = (s) => {
    s.forEach((o) => {
      n[o] = !0;
    });
  };
  return M(e) ? r(e) : r(String(e).split(t)), n;
}, Jt = () => {
}, $t = (e, t) => e != null && Number.isFinite(e = +e) ? e : t, ae = "abcdefghijklmnopqrstuvwxyz", Ae = "0123456789", $e = {
  DIGIT: Ae,
  ALPHA: ae,
  ALPHA_DIGIT: ae + ae.toUpperCase() + Ae
}, Wt = (e = 16, t = $e.ALPHA_DIGIT) => {
  let n = "";
  const { length: r } = t;
  for (; e--; )
    n += t[Math.random() * r | 0];
  return n;
};
function Kt(e) {
  return !!(e && x(e.append) && e[Symbol.toStringTag] === "FormData" && e[Symbol.iterator]);
}
const Gt = (e) => {
  const t = new Array(10), n = (r, s) => {
    if (se(r)) {
      if (t.indexOf(r) >= 0)
        return;
      if (!("toJSON" in r)) {
        t[s] = r;
        const o = M(r) ? [] : {};
        return W(r, (i, c) => {
          const f = n(i, s + 1);
          !$(f) && (o[c] = f);
        }), t[s] = void 0, o;
      }
    }
    return r;
  };
  return n(e, 0);
}, Xt = P("AsyncFunction"), Qt = (e) => e && (se(e) || x(e)) && x(e.then) && x(e.catch), We = ((e, t) => e ? setImmediate : t ? ((n, r) => (j.addEventListener("message", ({ source: s, data: o }) => {
  s === j && o === n && r.length && r.shift()();
}, !1), (s) => {
  r.push(s), j.postMessage(n, "*");
}))(`axios@${Math.random()}`, []) : (n) => setTimeout(n))(
  typeof setImmediate == "function",
  x(j.postMessage)
), Zt = typeof queueMicrotask < "u" ? queueMicrotask.bind(j) : typeof process < "u" && process.nextTick || We, a = {
  isArray: M,
  isArrayBuffer: ve,
  isBuffer: mt,
  isFormData: Tt,
  isArrayBufferView: yt,
  isString: bt,
  isNumber: Me,
  isBoolean: wt,
  isObject: se,
  isPlainObject: X,
  isReadableStream: _t,
  isRequest: xt,
  isResponse: Ct,
  isHeaders: Pt,
  isUndefined: $,
  isDate: gt,
  isFile: Et,
  isBlob: St,
  isRegExp: Mt,
  isFunction: x,
  isStream: Ot,
  isURLSearchParams: At,
  isTypedArray: jt,
  isFileList: Rt,
  forEach: W,
  merge: fe,
  extend: kt,
  trim: Nt,
  stripBOM: Ft,
  inherits: Bt,
  toFlatObject: Dt,
  kindOf: ne,
  kindOfTest: P,
  endsWith: Ut,
  toArray: Lt,
  forEachEntry: qt,
  matchAll: It,
  isHTMLForm: Ht,
  hasOwnProperty: Te,
  hasOwnProp: Te,
  // an alias to avoid ESLint no-prototype-builtins detection
  reduceDescriptors: Je,
  freezeMethods: zt,
  toObjectSet: Vt,
  toCamelCase: vt,
  noop: Jt,
  toFiniteNumber: $t,
  findKey: ze,
  global: j,
  isContextDefined: Ve,
  ALPHABET: $e,
  generateString: Wt,
  isSpecCompliantForm: Kt,
  toJSONObject: Gt,
  isAsyncFn: Xt,
  isThenable: Qt,
  setImmediate: We,
  asap: Zt
};
function y(e, t, n, r, s) {
  Error.call(this), Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : this.stack = new Error().stack, this.message = e, this.name = "AxiosError", t && (this.code = t), n && (this.config = n), r && (this.request = r), s && (this.response = s, this.status = s.status ? s.status : null);
}
a.inherits(y, Error, {
  toJSON: function() {
    return {
      // Standard
      message: this.message,
      name: this.name,
      // Microsoft
      description: this.description,
      number: this.number,
      // Mozilla
      fileName: this.fileName,
      lineNumber: this.lineNumber,
      columnNumber: this.columnNumber,
      stack: this.stack,
      // Axios
      config: a.toJSONObject(this.config),
      code: this.code,
      status: this.status
    };
  }
});
const Ke = y.prototype, Ge = {};
[
  "ERR_BAD_OPTION_VALUE",
  "ERR_BAD_OPTION",
  "ECONNABORTED",
  "ETIMEDOUT",
  "ERR_NETWORK",
  "ERR_FR_TOO_MANY_REDIRECTS",
  "ERR_DEPRECATED",
  "ERR_BAD_RESPONSE",
  "ERR_BAD_REQUEST",
  "ERR_CANCELED",
  "ERR_NOT_SUPPORT",
  "ERR_INVALID_URL"
  // eslint-disable-next-line func-names
].forEach((e) => {
  Ge[e] = { value: e };
});
Object.defineProperties(y, Ge);
Object.defineProperty(Ke, "isAxiosError", { value: !0 });
y.from = (e, t, n, r, s, o) => {
  const i = Object.create(Ke);
  return a.toFlatObject(e, i, function(f) {
    return f !== Error.prototype;
  }, (c) => c !== "isAxiosError"), y.call(i, e.message, t, n, r, s), i.cause = e, i.name = e.name, o && Object.assign(i, o), i;
};
const Yt = null;
function de(e) {
  return a.isPlainObject(e) || a.isArray(e);
}
function Xe(e) {
  return a.endsWith(e, "[]") ? e.slice(0, -2) : e;
}
function _e(e, t, n) {
  return e ? e.concat(t).map(function(s, o) {
    return s = Xe(s), !n && o ? "[" + s + "]" : s;
  }).join(n ? "." : "") : t;
}
function en(e) {
  return a.isArray(e) && !e.some(de);
}
const tn = a.toFlatObject(a, {}, null, function(t) {
  return /^is[A-Z]/.test(t);
});
function oe(e, t, n) {
  if (!a.isObject(e))
    throw new TypeError("target must be an object");
  t = t || new FormData(), n = a.toFlatObject(n, {
    metaTokens: !0,
    dots: !1,
    indexes: !1
  }, !1, function(b, h) {
    return !a.isUndefined(h[b]);
  });
  const r = n.metaTokens, s = n.visitor || u, o = n.dots, i = n.indexes, f = (n.Blob || typeof Blob < "u" && Blob) && a.isSpecCompliantForm(t);
  if (!a.isFunction(s))
    throw new TypeError("visitor must be a function");
  function l(p) {
    if (p === null) return "";
    if (a.isDate(p))
      return p.toISOString();
    if (!f && a.isBlob(p))
      throw new y("Blob is not supported. Use a Buffer instead.");
    return a.isArrayBuffer(p) || a.isTypedArray(p) ? f && typeof Blob == "function" ? new Blob([p]) : Buffer.from(p) : p;
  }
  function u(p, b, h) {
    let g = p;
    if (p && !h && typeof p == "object") {
      if (a.endsWith(b, "{}"))
        b = r ? b : b.slice(0, -2), p = JSON.stringify(p);
      else if (a.isArray(p) && en(p) || (a.isFileList(p) || a.endsWith(b, "[]")) && (g = a.toArray(p)))
        return b = Xe(b), g.forEach(function(O, k) {
          !(a.isUndefined(O) || O === null) && t.append(
            // eslint-disable-next-line no-nested-ternary
            i === !0 ? _e([b], k, o) : i === null ? b : b + "[]",
            l(O)
          );
        }), !1;
    }
    return de(p) ? !0 : (t.append(_e(h, b, o), l(p)), !1);
  }
  const d = [], w = Object.assign(tn, {
    defaultVisitor: u,
    convertValue: l,
    isVisitable: de
  });
  function S(p, b) {
    if (!a.isUndefined(p)) {
      if (d.indexOf(p) !== -1)
        throw Error("Circular reference detected in " + b.join("."));
      d.push(p), a.forEach(p, function(g, R) {
        (!(a.isUndefined(g) || g === null) && s.call(
          t,
          g,
          a.isString(R) ? R.trim() : R,
          b,
          w
        )) === !0 && S(g, b ? b.concat(R) : [R]);
      }), d.pop();
    }
  }
  if (!a.isObject(e))
    throw new TypeError("data must be an object");
  return S(e), t;
}
function xe(e) {
  const t = {
    "!": "%21",
    "'": "%27",
    "(": "%28",
    ")": "%29",
    "~": "%7E",
    "%20": "+",
    "%00": "\0"
  };
  return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g, function(r) {
    return t[r];
  });
}
function ge(e, t) {
  this._pairs = [], e && oe(e, this, t);
}
const Qe = ge.prototype;
Qe.append = function(t, n) {
  this._pairs.push([t, n]);
};
Qe.toString = function(t) {
  const n = t ? function(r) {
    return t.call(this, r, xe);
  } : xe;
  return this._pairs.map(function(s) {
    return n(s[0]) + "=" + n(s[1]);
  }, "").join("&");
};
function nn(e) {
  return encodeURIComponent(e).replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]");
}
function Ze(e, t, n) {
  if (!t)
    return e;
  const r = n && n.encode || nn, s = n && n.serialize;
  let o;
  if (s ? o = s(t, n) : o = a.isURLSearchParams(t) ? t.toString() : new ge(t, n).toString(r), o) {
    const i = e.indexOf("#");
    i !== -1 && (e = e.slice(0, i)), e += (e.indexOf("?") === -1 ? "?" : "&") + o;
  }
  return e;
}
class Ce {
  constructor() {
    this.handlers = [];
  }
  /**
   * Add a new interceptor to the stack
   *
   * @param {Function} fulfilled The function to handle `then` for a `Promise`
   * @param {Function} rejected The function to handle `reject` for a `Promise`
   *
   * @return {Number} An ID used to remove interceptor later
   */
  use(t, n, r) {
    return this.handlers.push({
      fulfilled: t,
      rejected: n,
      synchronous: r ? r.synchronous : !1,
      runWhen: r ? r.runWhen : null
    }), this.handlers.length - 1;
  }
  /**
   * Remove an interceptor from the stack
   *
   * @param {Number} id The ID that was returned by `use`
   *
   * @returns {Boolean} `true` if the interceptor was removed, `false` otherwise
   */
  eject(t) {
    this.handlers[t] && (this.handlers[t] = null);
  }
  /**
   * Clear all interceptors from the stack
   *
   * @returns {void}
   */
  clear() {
    this.handlers && (this.handlers = []);
  }
  /**
   * Iterate over all the registered interceptors
   *
   * This method is particularly useful for skipping over any
   * interceptors that may have become `null` calling `eject`.
   *
   * @param {Function} fn The function to call for each interceptor
   *
   * @returns {void}
   */
  forEach(t) {
    a.forEach(this.handlers, function(r) {
      r !== null && t(r);
    });
  }
}
const Ye = {
  silentJSONParsing: !0,
  forcedJSONParsing: !0,
  clarifyTimeoutError: !1
}, rn = typeof URLSearchParams < "u" ? URLSearchParams : ge, sn = typeof FormData < "u" ? FormData : null, on = typeof Blob < "u" ? Blob : null, an = {
  isBrowser: !0,
  classes: {
    URLSearchParams: rn,
    FormData: sn,
    Blob: on
  },
  protocols: ["http", "https", "file", "blob", "url", "data"]
}, Ee = typeof window < "u" && typeof document < "u", pe = typeof navigator == "object" && navigator || void 0, cn = Ee && (!pe || ["ReactNative", "NativeScript", "NS"].indexOf(pe.product) < 0), ln = typeof WorkerGlobalScope < "u" && // eslint-disable-next-line no-undef
self instanceof WorkerGlobalScope && typeof self.importScripts == "function", un = Ee && window.location.href || "http://localhost", fn = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  hasBrowserEnv: Ee,
  hasStandardBrowserEnv: cn,
  hasStandardBrowserWebWorkerEnv: ln,
  navigator: pe,
  origin: un
}, Symbol.toStringTag, { value: "Module" })), A = {
  ...fn,
  ...an
};
function dn(e, t) {
  return oe(e, new A.classes.URLSearchParams(), Object.assign({
    visitor: function(n, r, s, o) {
      return A.isNode && a.isBuffer(n) ? (this.append(r, n.toString("base64")), !1) : o.defaultVisitor.apply(this, arguments);
    }
  }, t));
}
function pn(e) {
  return a.matchAll(/\w+|\[(\w*)]/g, e).map((t) => t[0] === "[]" ? "" : t[1] || t[0]);
}
function hn(e) {
  const t = {}, n = Object.keys(e);
  let r;
  const s = n.length;
  let o;
  for (r = 0; r < s; r++)
    o = n[r], t[o] = e[o];
  return t;
}
function et(e) {
  function t(n, r, s, o) {
    let i = n[o++];
    if (i === "__proto__") return !0;
    const c = Number.isFinite(+i), f = o >= n.length;
    return i = !i && a.isArray(s) ? s.length : i, f ? (a.hasOwnProp(s, i) ? s[i] = [s[i], r] : s[i] = r, !c) : ((!s[i] || !a.isObject(s[i])) && (s[i] = []), t(n, r, s[i], o) && a.isArray(s[i]) && (s[i] = hn(s[i])), !c);
  }
  if (a.isFormData(e) && a.isFunction(e.entries)) {
    const n = {};
    return a.forEachEntry(e, (r, s) => {
      t(pn(r), s, n, 0);
    }), n;
  }
  return null;
}
function mn(e, t, n) {
  if (a.isString(e))
    try {
      return (t || JSON.parse)(e), a.trim(e);
    } catch (r) {
      if (r.name !== "SyntaxError")
        throw r;
    }
  return (0, JSON.stringify)(e);
}
const K = {
  transitional: Ye,
  adapter: ["xhr", "http", "fetch"],
  transformRequest: [function(t, n) {
    const r = n.getContentType() || "", s = r.indexOf("application/json") > -1, o = a.isObject(t);
    if (o && a.isHTMLForm(t) && (t = new FormData(t)), a.isFormData(t))
      return s ? JSON.stringify(et(t)) : t;
    if (a.isArrayBuffer(t) || a.isBuffer(t) || a.isStream(t) || a.isFile(t) || a.isBlob(t) || a.isReadableStream(t))
      return t;
    if (a.isArrayBufferView(t))
      return t.buffer;
    if (a.isURLSearchParams(t))
      return n.setContentType("application/x-www-form-urlencoded;charset=utf-8", !1), t.toString();
    let c;
    if (o) {
      if (r.indexOf("application/x-www-form-urlencoded") > -1)
        return dn(t, this.formSerializer).toString();
      if ((c = a.isFileList(t)) || r.indexOf("multipart/form-data") > -1) {
        const f = this.env && this.env.FormData;
        return oe(
          c ? { "files[]": t } : t,
          f && new f(),
          this.formSerializer
        );
      }
    }
    return o || s ? (n.setContentType("application/json", !1), mn(t)) : t;
  }],
  transformResponse: [function(t) {
    const n = this.transitional || K.transitional, r = n && n.forcedJSONParsing, s = this.responseType === "json";
    if (a.isResponse(t) || a.isReadableStream(t))
      return t;
    if (t && a.isString(t) && (r && !this.responseType || s)) {
      const i = !(n && n.silentJSONParsing) && s;
      try {
        return JSON.parse(t);
      } catch (c) {
        if (i)
          throw c.name === "SyntaxError" ? y.from(c, y.ERR_BAD_RESPONSE, this, null, this.response) : c;
      }
    }
    return t;
  }],
  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,
  xsrfCookieName: "XSRF-TOKEN",
  xsrfHeaderName: "X-XSRF-TOKEN",
  maxContentLength: -1,
  maxBodyLength: -1,
  env: {
    FormData: A.classes.FormData,
    Blob: A.classes.Blob
  },
  validateStatus: function(t) {
    return t >= 200 && t < 300;
  },
  headers: {
    common: {
      Accept: "application/json, text/plain, */*",
      "Content-Type": void 0
    }
  }
};
a.forEach(["delete", "get", "head", "post", "put", "patch"], (e) => {
  K.headers[e] = {};
});
const yn = a.toObjectSet([
  "age",
  "authorization",
  "content-length",
  "content-type",
  "etag",
  "expires",
  "from",
  "host",
  "if-modified-since",
  "if-unmodified-since",
  "last-modified",
  "location",
  "max-forwards",
  "proxy-authorization",
  "referer",
  "retry-after",
  "user-agent"
]), bn = (e) => {
  const t = {};
  let n, r, s;
  return e && e.split(`
`).forEach(function(i) {
    s = i.indexOf(":"), n = i.substring(0, s).trim().toLowerCase(), r = i.substring(s + 1).trim(), !(!n || t[n] && yn[n]) && (n === "set-cookie" ? t[n] ? t[n].push(r) : t[n] = [r] : t[n] = t[n] ? t[n] + ", " + r : r);
  }), t;
}, Pe = Symbol("internals");
function V(e) {
  return e && String(e).trim().toLowerCase();
}
function Q(e) {
  return e === !1 || e == null ? e : a.isArray(e) ? e.map(Q) : String(e);
}
function wn(e) {
  const t = /* @__PURE__ */ Object.create(null), n = /([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;
  let r;
  for (; r = n.exec(e); )
    t[r[1]] = r[2];
  return t;
}
const gn = (e) => /^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());
function ce(e, t, n, r, s) {
  if (a.isFunction(r))
    return r.call(this, t, n);
  if (s && (t = n), !!a.isString(t)) {
    if (a.isString(r))
      return t.indexOf(r) !== -1;
    if (a.isRegExp(r))
      return r.test(t);
  }
}
function En(e) {
  return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g, (t, n, r) => n.toUpperCase() + r);
}
function Sn(e, t) {
  const n = a.toCamelCase(" " + t);
  ["get", "set", "has"].forEach((r) => {
    Object.defineProperty(e, r + n, {
      value: function(s, o, i) {
        return this[r].call(this, t, s, o, i);
      },
      configurable: !0
    });
  });
}
class _ {
  constructor(t) {
    t && this.set(t);
  }
  set(t, n, r) {
    const s = this;
    function o(c, f, l) {
      const u = V(f);
      if (!u)
        throw new Error("header name must be a non-empty string");
      const d = a.findKey(s, u);
      (!d || s[d] === void 0 || l === !0 || l === void 0 && s[d] !== !1) && (s[d || f] = Q(c));
    }
    const i = (c, f) => a.forEach(c, (l, u) => o(l, u, f));
    if (a.isPlainObject(t) || t instanceof this.constructor)
      i(t, n);
    else if (a.isString(t) && (t = t.trim()) && !gn(t))
      i(bn(t), n);
    else if (a.isHeaders(t))
      for (const [c, f] of t.entries())
        o(f, c, r);
    else
      t != null && o(n, t, r);
    return this;
  }
  get(t, n) {
    if (t = V(t), t) {
      const r = a.findKey(this, t);
      if (r) {
        const s = this[r];
        if (!n)
          return s;
        if (n === !0)
          return wn(s);
        if (a.isFunction(n))
          return n.call(this, s, r);
        if (a.isRegExp(n))
          return n.exec(s);
        throw new TypeError("parser must be boolean|regexp|function");
      }
    }
  }
  has(t, n) {
    if (t = V(t), t) {
      const r = a.findKey(this, t);
      return !!(r && this[r] !== void 0 && (!n || ce(this, this[r], r, n)));
    }
    return !1;
  }
  delete(t, n) {
    const r = this;
    let s = !1;
    function o(i) {
      if (i = V(i), i) {
        const c = a.findKey(r, i);
        c && (!n || ce(r, r[c], c, n)) && (delete r[c], s = !0);
      }
    }
    return a.isArray(t) ? t.forEach(o) : o(t), s;
  }
  clear(t) {
    const n = Object.keys(this);
    let r = n.length, s = !1;
    for (; r--; ) {
      const o = n[r];
      (!t || ce(this, this[o], o, t, !0)) && (delete this[o], s = !0);
    }
    return s;
  }
  normalize(t) {
    const n = this, r = {};
    return a.forEach(this, (s, o) => {
      const i = a.findKey(r, o);
      if (i) {
        n[i] = Q(s), delete n[o];
        return;
      }
      const c = t ? En(o) : String(o).trim();
      c !== o && delete n[o], n[c] = Q(s), r[c] = !0;
    }), this;
  }
  concat(...t) {
    return this.constructor.concat(this, ...t);
  }
  toJSON(t) {
    const n = /* @__PURE__ */ Object.create(null);
    return a.forEach(this, (r, s) => {
      r != null && r !== !1 && (n[s] = t && a.isArray(r) ? r.join(", ") : r);
    }), n;
  }
  [Symbol.iterator]() {
    return Object.entries(this.toJSON())[Symbol.iterator]();
  }
  toString() {
    return Object.entries(this.toJSON()).map(([t, n]) => t + ": " + n).join(`
`);
  }
  get [Symbol.toStringTag]() {
    return "AxiosHeaders";
  }
  static from(t) {
    return t instanceof this ? t : new this(t);
  }
  static concat(t, ...n) {
    const r = new this(t);
    return n.forEach((s) => r.set(s)), r;
  }
  static accessor(t) {
    const r = (this[Pe] = this[Pe] = {
      accessors: {}
    }).accessors, s = this.prototype;
    function o(i) {
      const c = V(i);
      r[c] || (Sn(s, i), r[c] = !0);
    }
    return a.isArray(t) ? t.forEach(o) : o(t), this;
  }
}
_.accessor(["Content-Type", "Content-Length", "Accept", "Accept-Encoding", "User-Agent", "Authorization"]);
a.reduceDescriptors(_.prototype, ({ value: e }, t) => {
  let n = t[0].toUpperCase() + t.slice(1);
  return {
    get: () => e,
    set(r) {
      this[n] = r;
    }
  };
});
a.freezeMethods(_);
function le(e, t) {
  const n = this || K, r = t || n, s = _.from(r.headers);
  let o = r.data;
  return a.forEach(e, function(c) {
    o = c.call(n, o, s.normalize(), t ? t.status : void 0);
  }), s.normalize(), o;
}
function tt(e) {
  return !!(e && e.__CANCEL__);
}
function z(e, t, n) {
  y.call(this, e ?? "canceled", y.ERR_CANCELED, t, n), this.name = "CanceledError";
}
a.inherits(z, y, {
  __CANCEL__: !0
});
function nt(e, t, n) {
  const r = n.config.validateStatus;
  !n.status || !r || r(n.status) ? e(n) : t(new y(
    "Request failed with status code " + n.status,
    [y.ERR_BAD_REQUEST, y.ERR_BAD_RESPONSE][Math.floor(n.status / 100) - 4],
    n.config,
    n.request,
    n
  ));
}
function Rn(e) {
  const t = /^([-+\w]{1,25})(:?\/\/|:)/.exec(e);
  return t && t[1] || "";
}
function On(e, t) {
  e = e || 10;
  const n = new Array(e), r = new Array(e);
  let s = 0, o = 0, i;
  return t = t !== void 0 ? t : 1e3, function(f) {
    const l = Date.now(), u = r[o];
    i || (i = l), n[s] = f, r[s] = l;
    let d = o, w = 0;
    for (; d !== s; )
      w += n[d++], d = d % e;
    if (s = (s + 1) % e, s === o && (o = (o + 1) % e), l - i < t)
      return;
    const S = u && l - u;
    return S ? Math.round(w * 1e3 / S) : void 0;
  };
}
function Tn(e, t) {
  let n = 0, r = 1e3 / t, s, o;
  const i = (l, u = Date.now()) => {
    n = u, s = null, o && (clearTimeout(o), o = null), e.apply(null, l);
  };
  return [(...l) => {
    const u = Date.now(), d = u - n;
    d >= r ? i(l, u) : (s = l, o || (o = setTimeout(() => {
      o = null, i(s);
    }, r - d)));
  }, () => s && i(s)];
}
const Z = (e, t, n = 3) => {
  let r = 0;
  const s = On(50, 250);
  return Tn((o) => {
    const i = o.loaded, c = o.lengthComputable ? o.total : void 0, f = i - r, l = s(f), u = i <= c;
    r = i;
    const d = {
      loaded: i,
      total: c,
      progress: c ? i / c : void 0,
      bytes: f,
      rate: l || void 0,
      estimated: l && c && u ? (c - i) / l : void 0,
      event: o,
      lengthComputable: c != null,
      [t ? "download" : "upload"]: !0
    };
    e(d);
  }, n);
}, Ne = (e, t) => {
  const n = e != null;
  return [(r) => t[0]({
    lengthComputable: n,
    total: e,
    loaded: r
  }), t[1]];
}, ke = (e) => (...t) => a.asap(() => e(...t)), An = A.hasStandardBrowserEnv ? (
  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  function() {
    const t = A.navigator && /(msie|trident)/i.test(A.navigator.userAgent), n = document.createElement("a");
    let r;
    function s(o) {
      let i = o;
      return t && (n.setAttribute("href", i), i = n.href), n.setAttribute("href", i), {
        href: n.href,
        protocol: n.protocol ? n.protocol.replace(/:$/, "") : "",
        host: n.host,
        search: n.search ? n.search.replace(/^\?/, "") : "",
        hash: n.hash ? n.hash.replace(/^#/, "") : "",
        hostname: n.hostname,
        port: n.port,
        pathname: n.pathname.charAt(0) === "/" ? n.pathname : "/" + n.pathname
      };
    }
    return r = s(window.location.href), function(i) {
      const c = a.isString(i) ? s(i) : i;
      return c.protocol === r.protocol && c.host === r.host;
    };
  }()
) : (
  // Non standard browser envs (web workers, react-native) lack needed support.
  /* @__PURE__ */ function() {
    return function() {
      return !0;
    };
  }()
), _n = A.hasStandardBrowserEnv ? (
  // Standard browser envs support document.cookie
  {
    write(e, t, n, r, s, o) {
      const i = [e + "=" + encodeURIComponent(t)];
      a.isNumber(n) && i.push("expires=" + new Date(n).toGMTString()), a.isString(r) && i.push("path=" + r), a.isString(s) && i.push("domain=" + s), o === !0 && i.push("secure"), document.cookie = i.join("; ");
    },
    read(e) {
      const t = document.cookie.match(new RegExp("(^|;\\s*)(" + e + ")=([^;]*)"));
      return t ? decodeURIComponent(t[3]) : null;
    },
    remove(e) {
      this.write(e, "", Date.now() - 864e5);
    }
  }
) : (
  // Non-standard browser env (web workers, react-native) lack needed support.
  {
    write() {
    },
    read() {
      return null;
    },
    remove() {
    }
  }
);
function xn(e) {
  return /^([a-z][a-z\d+\-.]*:)?\/\//i.test(e);
}
function Cn(e, t) {
  return t ? e.replace(/\/?\/$/, "") + "/" + t.replace(/^\/+/, "") : e;
}
function rt(e, t) {
  return e && !xn(t) ? Cn(e, t) : t;
}
const Fe = (e) => e instanceof _ ? { ...e } : e;
function I(e, t) {
  t = t || {};
  const n = {};
  function r(l, u, d) {
    return a.isPlainObject(l) && a.isPlainObject(u) ? a.merge.call({ caseless: d }, l, u) : a.isPlainObject(u) ? a.merge({}, u) : a.isArray(u) ? u.slice() : u;
  }
  function s(l, u, d) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(l))
        return r(void 0, l, d);
    } else return r(l, u, d);
  }
  function o(l, u) {
    if (!a.isUndefined(u))
      return r(void 0, u);
  }
  function i(l, u) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(l))
        return r(void 0, l);
    } else return r(void 0, u);
  }
  function c(l, u, d) {
    if (d in t)
      return r(l, u);
    if (d in e)
      return r(void 0, l);
  }
  const f = {
    url: o,
    method: o,
    data: o,
    baseURL: i,
    transformRequest: i,
    transformResponse: i,
    paramsSerializer: i,
    timeout: i,
    timeoutMessage: i,
    withCredentials: i,
    withXSRFToken: i,
    adapter: i,
    responseType: i,
    xsrfCookieName: i,
    xsrfHeaderName: i,
    onUploadProgress: i,
    onDownloadProgress: i,
    decompress: i,
    maxContentLength: i,
    maxBodyLength: i,
    beforeRedirect: i,
    transport: i,
    httpAgent: i,
    httpsAgent: i,
    cancelToken: i,
    socketPath: i,
    responseEncoding: i,
    validateStatus: c,
    headers: (l, u) => s(Fe(l), Fe(u), !0)
  };
  return a.forEach(Object.keys(Object.assign({}, e, t)), function(u) {
    const d = f[u] || s, w = d(e[u], t[u], u);
    a.isUndefined(w) && d !== c || (n[u] = w);
  }), n;
}
const st = (e) => {
  const t = I({}, e);
  let { data: n, withXSRFToken: r, xsrfHeaderName: s, xsrfCookieName: o, headers: i, auth: c } = t;
  t.headers = i = _.from(i), t.url = Ze(rt(t.baseURL, t.url), e.params, e.paramsSerializer), c && i.set(
    "Authorization",
    "Basic " + btoa((c.username || "") + ":" + (c.password ? unescape(encodeURIComponent(c.password)) : ""))
  );
  let f;
  if (a.isFormData(n)) {
    if (A.hasStandardBrowserEnv || A.hasStandardBrowserWebWorkerEnv)
      i.setContentType(void 0);
    else if ((f = i.getContentType()) !== !1) {
      const [l, ...u] = f ? f.split(";").map((d) => d.trim()).filter(Boolean) : [];
      i.setContentType([l || "multipart/form-data", ...u].join("; "));
    }
  }
  if (A.hasStandardBrowserEnv && (r && a.isFunction(r) && (r = r(t)), r || r !== !1 && An(t.url))) {
    const l = s && o && _n.read(o);
    l && i.set(s, l);
  }
  return t;
}, Pn = typeof XMLHttpRequest < "u", Nn = Pn && function(e) {
  return new Promise(function(n, r) {
    const s = st(e);
    let o = s.data;
    const i = _.from(s.headers).normalize();
    let { responseType: c, onUploadProgress: f, onDownloadProgress: l } = s, u, d, w, S, p;
    function b() {
      S && S(), p && p(), s.cancelToken && s.cancelToken.unsubscribe(u), s.signal && s.signal.removeEventListener("abort", u);
    }
    let h = new XMLHttpRequest();
    h.open(s.method.toUpperCase(), s.url, !0), h.timeout = s.timeout;
    function g() {
      if (!h)
        return;
      const O = _.from(
        "getAllResponseHeaders" in h && h.getAllResponseHeaders()
      ), T = {
        data: !c || c === "text" || c === "json" ? h.responseText : h.response,
        status: h.status,
        statusText: h.statusText,
        headers: O,
        config: e,
        request: h
      };
      nt(function(U) {
        n(U), b();
      }, function(U) {
        r(U), b();
      }, T), h = null;
    }
    "onloadend" in h ? h.onloadend = g : h.onreadystatechange = function() {
      !h || h.readyState !== 4 || h.status === 0 && !(h.responseURL && h.responseURL.indexOf("file:") === 0) || setTimeout(g);
    }, h.onabort = function() {
      h && (r(new y("Request aborted", y.ECONNABORTED, e, h)), h = null);
    }, h.onerror = function() {
      r(new y("Network Error", y.ERR_NETWORK, e, h)), h = null;
    }, h.ontimeout = function() {
      let k = s.timeout ? "timeout of " + s.timeout + "ms exceeded" : "timeout exceeded";
      const T = s.transitional || Ye;
      s.timeoutErrorMessage && (k = s.timeoutErrorMessage), r(new y(
        k,
        T.clarifyTimeoutError ? y.ETIMEDOUT : y.ECONNABORTED,
        e,
        h
      )), h = null;
    }, o === void 0 && i.setContentType(null), "setRequestHeader" in h && a.forEach(i.toJSON(), function(k, T) {
      h.setRequestHeader(T, k);
    }), a.isUndefined(s.withCredentials) || (h.withCredentials = !!s.withCredentials), c && c !== "json" && (h.responseType = s.responseType), l && ([w, p] = Z(l, !0), h.addEventListener("progress", w)), f && h.upload && ([d, S] = Z(f), h.upload.addEventListener("progress", d), h.upload.addEventListener("loadend", S)), (s.cancelToken || s.signal) && (u = (O) => {
      h && (r(!O || O.type ? new z(null, e, h) : O), h.abort(), h = null);
    }, s.cancelToken && s.cancelToken.subscribe(u), s.signal && (s.signal.aborted ? u() : s.signal.addEventListener("abort", u)));
    const R = Rn(s.url);
    if (R && A.protocols.indexOf(R) === -1) {
      r(new y("Unsupported protocol " + R + ":", y.ERR_BAD_REQUEST, e));
      return;
    }
    h.send(o || null);
  });
}, kn = (e, t) => {
  const { length: n } = e = e ? e.filter(Boolean) : [];
  if (t || n) {
    let r = new AbortController(), s;
    const o = function(l) {
      if (!s) {
        s = !0, c();
        const u = l instanceof Error ? l : this.reason;
        r.abort(u instanceof y ? u : new z(u instanceof Error ? u.message : u));
      }
    };
    let i = t && setTimeout(() => {
      i = null, o(new y(`timeout ${t} of ms exceeded`, y.ETIMEDOUT));
    }, t);
    const c = () => {
      e && (i && clearTimeout(i), i = null, e.forEach((l) => {
        l.unsubscribe ? l.unsubscribe(o) : l.removeEventListener("abort", o);
      }), e = null);
    };
    e.forEach((l) => l.addEventListener("abort", o));
    const { signal: f } = r;
    return f.unsubscribe = () => a.asap(c), f;
  }
}, Fn = function* (e, t) {
  let n = e.byteLength;
  if (n < t) {
    yield e;
    return;
  }
  let r = 0, s;
  for (; r < n; )
    s = r + t, yield e.slice(r, s), r = s;
}, Bn = async function* (e, t) {
  for await (const n of Dn(e))
    yield* Fn(n, t);
}, Dn = async function* (e) {
  if (e[Symbol.asyncIterator]) {
    yield* e;
    return;
  }
  const t = e.getReader();
  try {
    for (; ; ) {
      const { done: n, value: r } = await t.read();
      if (n)
        break;
      yield r;
    }
  } finally {
    await t.cancel();
  }
}, Be = (e, t, n, r) => {
  const s = Bn(e, t);
  let o = 0, i, c = (f) => {
    i || (i = !0, r && r(f));
  };
  return new ReadableStream({
    async pull(f) {
      try {
        const { done: l, value: u } = await s.next();
        if (l) {
          c(), f.close();
          return;
        }
        let d = u.byteLength;
        if (n) {
          let w = o += d;
          n(w);
        }
        f.enqueue(new Uint8Array(u));
      } catch (l) {
        throw c(l), l;
      }
    },
    cancel(f) {
      return c(f), s.return();
    }
  }, {
    highWaterMark: 2
  });
}, ie = typeof fetch == "function" && typeof Request == "function" && typeof Response == "function", ot = ie && typeof ReadableStream == "function", Un = ie && (typeof TextEncoder == "function" ? /* @__PURE__ */ ((e) => (t) => e.encode(t))(new TextEncoder()) : async (e) => new Uint8Array(await new Response(e).arrayBuffer())), it = (e, ...t) => {
  try {
    return !!e(...t);
  } catch {
    return !1;
  }
}, Ln = ot && it(() => {
  let e = !1;
  const t = new Request(A.origin, {
    body: new ReadableStream(),
    method: "POST",
    get duplex() {
      return e = !0, "half";
    }
  }).headers.has("Content-Type");
  return e && !t;
}), De = 64 * 1024, he = ot && it(() => a.isReadableStream(new Response("").body)), Y = {
  stream: he && ((e) => e.body)
};
ie && ((e) => {
  ["text", "arrayBuffer", "blob", "formData", "stream"].forEach((t) => {
    !Y[t] && (Y[t] = a.isFunction(e[t]) ? (n) => n[t]() : (n, r) => {
      throw new y(`Response type '${t}' is not supported`, y.ERR_NOT_SUPPORT, r);
    });
  });
})(new Response());
const jn = async (e) => {
  if (e == null)
    return 0;
  if (a.isBlob(e))
    return e.size;
  if (a.isSpecCompliantForm(e))
    return (await new Request(A.origin, {
      method: "POST",
      body: e
    }).arrayBuffer()).byteLength;
  if (a.isArrayBufferView(e) || a.isArrayBuffer(e))
    return e.byteLength;
  if (a.isURLSearchParams(e) && (e = e + ""), a.isString(e))
    return (await Un(e)).byteLength;
}, qn = async (e, t) => {
  const n = a.toFiniteNumber(e.getContentLength());
  return n ?? jn(t);
}, In = ie && (async (e) => {
  let {
    url: t,
    method: n,
    data: r,
    signal: s,
    cancelToken: o,
    timeout: i,
    onDownloadProgress: c,
    onUploadProgress: f,
    responseType: l,
    headers: u,
    withCredentials: d = "same-origin",
    fetchOptions: w
  } = st(e);
  l = l ? (l + "").toLowerCase() : "text";
  let S = kn([s, o && o.toAbortSignal()], i), p;
  const b = S && S.unsubscribe && (() => {
    S.unsubscribe();
  });
  let h;
  try {
    if (f && Ln && n !== "get" && n !== "head" && (h = await qn(u, r)) !== 0) {
      let T = new Request(t, {
        method: "POST",
        body: r,
        duplex: "half"
      }), F;
      if (a.isFormData(r) && (F = T.headers.get("content-type")) && u.setContentType(F), T.body) {
        const [U, G] = Ne(
          h,
          Z(ke(f))
        );
        r = Be(T.body, De, U, G);
      }
    }
    a.isString(d) || (d = d ? "include" : "omit");
    const g = "credentials" in Request.prototype;
    p = new Request(t, {
      ...w,
      signal: S,
      method: n.toUpperCase(),
      headers: u.normalize().toJSON(),
      body: r,
      duplex: "half",
      credentials: g ? d : void 0
    });
    let R = await fetch(p);
    const O = he && (l === "stream" || l === "response");
    if (he && (c || O && b)) {
      const T = {};
      ["status", "statusText", "headers"].forEach((Oe) => {
        T[Oe] = R[Oe];
      });
      const F = a.toFiniteNumber(R.headers.get("content-length")), [U, G] = c && Ne(
        F,
        Z(ke(c), !0)
      ) || [];
      R = new Response(
        Be(R.body, De, U, () => {
          G && G(), b && b();
        }),
        T
      );
    }
    l = l || "text";
    let k = await Y[a.findKey(Y, l) || "text"](R, e);
    return !O && b && b(), await new Promise((T, F) => {
      nt(T, F, {
        data: k,
        headers: _.from(R.headers),
        status: R.status,
        statusText: R.statusText,
        config: e,
        request: p
      });
    });
  } catch (g) {
    throw b && b(), g && g.name === "TypeError" && /fetch/i.test(g.message) ? Object.assign(
      new y("Network Error", y.ERR_NETWORK, e, p),
      {
        cause: g.cause || g
      }
    ) : y.from(g, g && g.code, e, p);
  }
}), me = {
  http: Yt,
  xhr: Nn,
  fetch: In
};
a.forEach(me, (e, t) => {
  if (e) {
    try {
      Object.defineProperty(e, "name", { value: t });
    } catch {
    }
    Object.defineProperty(e, "adapterName", { value: t });
  }
});
const Ue = (e) => `- ${e}`, Hn = (e) => a.isFunction(e) || e === null || e === !1, at = {
  getAdapter: (e) => {
    e = a.isArray(e) ? e : [e];
    const { length: t } = e;
    let n, r;
    const s = {};
    for (let o = 0; o < t; o++) {
      n = e[o];
      let i;
      if (r = n, !Hn(n) && (r = me[(i = String(n)).toLowerCase()], r === void 0))
        throw new y(`Unknown adapter '${i}'`);
      if (r)
        break;
      s[i || "#" + o] = r;
    }
    if (!r) {
      const o = Object.entries(s).map(
        ([c, f]) => `adapter ${c} ` + (f === !1 ? "is not supported by the environment" : "is not available in the build")
      );
      let i = t ? o.length > 1 ? `since :
` + o.map(Ue).join(`
`) : " " + Ue(o[0]) : "as no adapter specified";
      throw new y(
        "There is no suitable adapter to dispatch the request " + i,
        "ERR_NOT_SUPPORT"
      );
    }
    return r;
  },
  adapters: me
};
function ue(e) {
  if (e.cancelToken && e.cancelToken.throwIfRequested(), e.signal && e.signal.aborted)
    throw new z(null, e);
}
function Le(e) {
  return ue(e), e.headers = _.from(e.headers), e.data = le.call(
    e,
    e.transformRequest
  ), ["post", "put", "patch"].indexOf(e.method) !== -1 && e.headers.setContentType("application/x-www-form-urlencoded", !1), at.getAdapter(e.adapter || K.adapter)(e).then(function(r) {
    return ue(e), r.data = le.call(
      e,
      e.transformResponse,
      r
    ), r.headers = _.from(r.headers), r;
  }, function(r) {
    return tt(r) || (ue(e), r && r.response && (r.response.data = le.call(
      e,
      e.transformResponse,
      r.response
    ), r.response.headers = _.from(r.response.headers))), Promise.reject(r);
  });
}
const ct = "1.7.7", Se = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach((e, t) => {
  Se[e] = function(r) {
    return typeof r === e || "a" + (t < 1 ? "n " : " ") + e;
  };
});
const je = {};
Se.transitional = function(t, n, r) {
  function s(o, i) {
    return "[Axios v" + ct + "] Transitional option '" + o + "'" + i + (r ? ". " + r : "");
  }
  return (o, i, c) => {
    if (t === !1)
      throw new y(
        s(i, " has been removed" + (n ? " in " + n : "")),
        y.ERR_DEPRECATED
      );
    return n && !je[i] && (je[i] = !0, console.warn(
      s(
        i,
        " has been deprecated since v" + n + " and will be removed in the near future"
      )
    )), t ? t(o, i, c) : !0;
  };
};
function vn(e, t, n) {
  if (typeof e != "object")
    throw new y("options must be an object", y.ERR_BAD_OPTION_VALUE);
  const r = Object.keys(e);
  let s = r.length;
  for (; s-- > 0; ) {
    const o = r[s], i = t[o];
    if (i) {
      const c = e[o], f = c === void 0 || i(c, o, e);
      if (f !== !0)
        throw new y("option " + o + " must be " + f, y.ERR_BAD_OPTION_VALUE);
      continue;
    }
    if (n !== !0)
      throw new y("Unknown option " + o, y.ERR_BAD_OPTION);
  }
}
const ye = {
  assertOptions: vn,
  validators: Se
}, B = ye.validators;
class q {
  constructor(t) {
    this.defaults = t, this.interceptors = {
      request: new Ce(),
      response: new Ce()
    };
  }
  /**
   * Dispatch a request
   *
   * @param {String|Object} configOrUrl The config specific for this request (merged with this.defaults)
   * @param {?Object} config
   *
   * @returns {Promise} The Promise to be fulfilled
   */
  async request(t, n) {
    try {
      return await this._request(t, n);
    } catch (r) {
      if (r instanceof Error) {
        let s;
        Error.captureStackTrace ? Error.captureStackTrace(s = {}) : s = new Error();
        const o = s.stack ? s.stack.replace(/^.+\n/, "") : "";
        try {
          r.stack ? o && !String(r.stack).endsWith(o.replace(/^.+\n.+\n/, "")) && (r.stack += `
` + o) : r.stack = o;
        } catch {
        }
      }
      throw r;
    }
  }
  _request(t, n) {
    typeof t == "string" ? (n = n || {}, n.url = t) : n = t || {}, n = I(this.defaults, n);
    const { transitional: r, paramsSerializer: s, headers: o } = n;
    r !== void 0 && ye.assertOptions(r, {
      silentJSONParsing: B.transitional(B.boolean),
      forcedJSONParsing: B.transitional(B.boolean),
      clarifyTimeoutError: B.transitional(B.boolean)
    }, !1), s != null && (a.isFunction(s) ? n.paramsSerializer = {
      serialize: s
    } : ye.assertOptions(s, {
      encode: B.function,
      serialize: B.function
    }, !0)), n.method = (n.method || this.defaults.method || "get").toLowerCase();
    let i = o && a.merge(
      o.common,
      o[n.method]
    );
    o && a.forEach(
      ["delete", "get", "head", "post", "put", "patch", "common"],
      (p) => {
        delete o[p];
      }
    ), n.headers = _.concat(i, o);
    const c = [];
    let f = !0;
    this.interceptors.request.forEach(function(b) {
      typeof b.runWhen == "function" && b.runWhen(n) === !1 || (f = f && b.synchronous, c.unshift(b.fulfilled, b.rejected));
    });
    const l = [];
    this.interceptors.response.forEach(function(b) {
      l.push(b.fulfilled, b.rejected);
    });
    let u, d = 0, w;
    if (!f) {
      const p = [Le.bind(this), void 0];
      for (p.unshift.apply(p, c), p.push.apply(p, l), w = p.length, u = Promise.resolve(n); d < w; )
        u = u.then(p[d++], p[d++]);
      return u;
    }
    w = c.length;
    let S = n;
    for (d = 0; d < w; ) {
      const p = c[d++], b = c[d++];
      try {
        S = p(S);
      } catch (h) {
        b.call(this, h);
        break;
      }
    }
    try {
      u = Le.call(this, S);
    } catch (p) {
      return Promise.reject(p);
    }
    for (d = 0, w = l.length; d < w; )
      u = u.then(l[d++], l[d++]);
    return u;
  }
  getUri(t) {
    t = I(this.defaults, t);
    const n = rt(t.baseURL, t.url);
    return Ze(n, t.params, t.paramsSerializer);
  }
}
a.forEach(["delete", "get", "head", "options"], function(t) {
  q.prototype[t] = function(n, r) {
    return this.request(I(r || {}, {
      method: t,
      url: n,
      data: (r || {}).data
    }));
  };
});
a.forEach(["post", "put", "patch"], function(t) {
  function n(r) {
    return function(o, i, c) {
      return this.request(I(c || {}, {
        method: t,
        headers: r ? {
          "Content-Type": "multipart/form-data"
        } : {},
        url: o,
        data: i
      }));
    };
  }
  q.prototype[t] = n(), q.prototype[t + "Form"] = n(!0);
});
class Re {
  constructor(t) {
    if (typeof t != "function")
      throw new TypeError("executor must be a function.");
    let n;
    this.promise = new Promise(function(o) {
      n = o;
    });
    const r = this;
    this.promise.then((s) => {
      if (!r._listeners) return;
      let o = r._listeners.length;
      for (; o-- > 0; )
        r._listeners[o](s);
      r._listeners = null;
    }), this.promise.then = (s) => {
      let o;
      const i = new Promise((c) => {
        r.subscribe(c), o = c;
      }).then(s);
      return i.cancel = function() {
        r.unsubscribe(o);
      }, i;
    }, t(function(o, i, c) {
      r.reason || (r.reason = new z(o, i, c), n(r.reason));
    });
  }
  /**
   * Throws a `CanceledError` if cancellation has been requested.
   */
  throwIfRequested() {
    if (this.reason)
      throw this.reason;
  }
  /**
   * Subscribe to the cancel signal
   */
  subscribe(t) {
    if (this.reason) {
      t(this.reason);
      return;
    }
    this._listeners ? this._listeners.push(t) : this._listeners = [t];
  }
  /**
   * Unsubscribe from the cancel signal
   */
  unsubscribe(t) {
    if (!this._listeners)
      return;
    const n = this._listeners.indexOf(t);
    n !== -1 && this._listeners.splice(n, 1);
  }
  toAbortSignal() {
    const t = new AbortController(), n = (r) => {
      t.abort(r);
    };
    return this.subscribe(n), t.signal.unsubscribe = () => this.unsubscribe(n), t.signal;
  }
  /**
   * Returns an object that contains a new `CancelToken` and a function that, when called,
   * cancels the `CancelToken`.
   */
  static source() {
    let t;
    return {
      token: new Re(function(s) {
        t = s;
      }),
      cancel: t
    };
  }
}
function Mn(e) {
  return function(n) {
    return e.apply(null, n);
  };
}
function zn(e) {
  return a.isObject(e) && e.isAxiosError === !0;
}
const be = {
  Continue: 100,
  SwitchingProtocols: 101,
  Processing: 102,
  EarlyHints: 103,
  Ok: 200,
  Created: 201,
  Accepted: 202,
  NonAuthoritativeInformation: 203,
  NoContent: 204,
  ResetContent: 205,
  PartialContent: 206,
  MultiStatus: 207,
  AlreadyReported: 208,
  ImUsed: 226,
  MultipleChoices: 300,
  MovedPermanently: 301,
  Found: 302,
  SeeOther: 303,
  NotModified: 304,
  UseProxy: 305,
  Unused: 306,
  TemporaryRedirect: 307,
  PermanentRedirect: 308,
  BadRequest: 400,
  Unauthorized: 401,
  PaymentRequired: 402,
  Forbidden: 403,
  NotFound: 404,
  MethodNotAllowed: 405,
  NotAcceptable: 406,
  ProxyAuthenticationRequired: 407,
  RequestTimeout: 408,
  Conflict: 409,
  Gone: 410,
  LengthRequired: 411,
  PreconditionFailed: 412,
  PayloadTooLarge: 413,
  UriTooLong: 414,
  UnsupportedMediaType: 415,
  RangeNotSatisfiable: 416,
  ExpectationFailed: 417,
  ImATeapot: 418,
  MisdirectedRequest: 421,
  UnprocessableEntity: 422,
  Locked: 423,
  FailedDependency: 424,
  TooEarly: 425,
  UpgradeRequired: 426,
  PreconditionRequired: 428,
  TooManyRequests: 429,
  RequestHeaderFieldsTooLarge: 431,
  UnavailableForLegalReasons: 451,
  InternalServerError: 500,
  NotImplemented: 501,
  BadGateway: 502,
  ServiceUnavailable: 503,
  GatewayTimeout: 504,
  HttpVersionNotSupported: 505,
  VariantAlsoNegotiates: 506,
  InsufficientStorage: 507,
  LoopDetected: 508,
  NotExtended: 510,
  NetworkAuthenticationRequired: 511
};
Object.entries(be).forEach(([e, t]) => {
  be[t] = e;
});
function lt(e) {
  const t = new q(e), n = He(q.prototype.request, t);
  return a.extend(n, q.prototype, t, { allOwnKeys: !0 }), a.extend(n, t, null, { allOwnKeys: !0 }), n.create = function(s) {
    return lt(I(e, s));
  }, n;
}
const E = lt(K);
E.Axios = q;
E.CanceledError = z;
E.CancelToken = Re;
E.isCancel = tt;
E.VERSION = ct;
E.toFormData = oe;
E.AxiosError = y;
E.Cancel = E.CanceledError;
E.all = function(t) {
  return Promise.all(t);
};
E.spread = Mn;
E.isAxiosError = zn;
E.mergeConfig = I;
E.AxiosHeaders = _;
E.formToJSON = (e) => et(a.isHTMLForm(e) ? new FormData(e) : e);
E.getAdapter = at.getAdapter;
E.HttpStatusCode = be;
E.default = E;
var ut = /* @__PURE__ */ ((e) => (e.Primary = "Primary", e.Success = "Success", e.Warning = "Warning", e.Danger = "Danger", e))(ut || {});
const Vn = {
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
}, Jn = dt("dashboardApi", {
  state: () => ({
    data: Vn
  }),
  actions: {
    async load() {
      return E.get("/api/dashboard").then((e) => (this.data = e.data, this.data)).catch((e) => {
        throw {
          description: "An error as occurred",
          style: ut.Danger,
          closeBtn: !0,
          ...e.response.data
        };
      });
    }
  }
}), $n = /* @__PURE__ */ ee({
  __name: "DashboardStats",
  props: {
    users: {},
    roles: {},
    groups: {}
  },
  setup(e) {
    return (t, n) => {
      const r = H("UFInfoBox");
      return D(), v(te, null, [
        N(r, {
          value: t.users,
          label: "Users",
          faIcon: "user",
          to: { name: "admin.users" }
        }, null, 8, ["value"]),
        N(r, {
          value: t.roles,
          label: "Roles",
          faIcon: "address-card",
          to: { name: "admin.roles" }
        }, null, 8, ["value"]),
        N(r, {
          value: t.groups,
          label: "Groups",
          faIcon: "users",
          to: { name: "admin.groups" }
        }, null, 8, ["value"])
      ], 64);
    };
  }
}), Wn = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, Kn = ["src"], Gn = { class: "uk-margin-remove" }, Xn = { class: "uk-margin-remove uk-text-meta" }, Qn = /* @__PURE__ */ ee({
  __name: "DashboardRecentUsers",
  props: {
    users: {}
  },
  setup(e) {
    return (t, n) => {
      const r = H("RouterLink"), s = H("UFCardBox");
      return D(), qe(s, { title: "Latest Users" }, {
        footer: J(() => [
          N(r, {
            to: { name: "admin.users" },
            class: "uk-text-center"
          }, {
            default: J(() => n[0] || (n[0] = [
              ft("View All Users")
            ])),
            _: 1
          })
        ]),
        default: J(() => [
          m("div", Wn, [
            (D(!0), v(te, null, Ie(t.users, (o) => (D(), v("div", {
              key: o.id,
              class: "uk-text-center"
            }, [
              N(r, {
                to: { name: "admin.user", params: { user_name: o.user_name } },
                class: "uk-text-decoration-none uk-link-text"
              }, {
                default: J(() => [
                  m("img", {
                    src: o.avatar,
                    alt: "User Image",
                    class: "uk-border-circle"
                  }, null, 8, Kn),
                  m("p", Gn, C(o.full_name), 1),
                  m("p", Xn, C(L(pt)(o.created_at).fromNow()), 1)
                ]),
                _: 2
              }, 1032, ["to"])
            ]))), 128))
          ])
        ]),
        _: 1
      });
    };
  }
}), Zn = { class: "uk-description-list" }, Yn = { class: "uk-list uk-list-disc uk-list-collapse" }, er = /* @__PURE__ */ ee({
  __name: "DashboardSystemInfo",
  props: {
    info: {},
    sprinkles: {}
  },
  setup(e) {
    return (t, n) => {
      const r = H("UFCardBox");
      return D(), qe(r, { title: "System Information" }, {
        default: J(() => [
          m("dl", Zn, [
            n[0] || (n[0] = m("dt", null, "Framework version", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.frameworkVersion), 1)
              ])
            ]),
            n[1] || (n[1] = m("dt", null, "PHP version", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.phpVersion), 1)
              ])
            ]),
            n[2] || (n[2] = m("dt", null, "Webserver software", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.server), 1)
              ])
            ]),
            n[3] || (n[3] = m("dt", null, "Database connection", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.database.connection), 1)
              ])
            ]),
            n[4] || (n[4] = m("dt", null, "Database version", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.database.type) + " " + C(t.info.database.version), 1)
              ])
            ]),
            n[5] || (n[5] = m("dt", null, "Database name", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.database.name), 1)
              ])
            ]),
            n[6] || (n[6] = m("dt", null, "Project directory", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, C(t.info.projectPath), 1)
              ])
            ]),
            n[7] || (n[7] = m("dt", null, "Loaded sprinkles", -1)),
            m("dd", null, [
              m("ul", Yn, [
                (D(!0), v(te, null, Ie(t.sprinkles, (s) => (D(), v("li", { key: s }, C(s), 1))), 128))
              ])
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), tr = {
  class: "uk-child-width-expand",
  "uk-grid": ""
}, nr = {
  class: "uk-child-width-1-2",
  "uk-grid": ""
}, rr = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, ar = /* @__PURE__ */ ee({
  __name: "DashboardView",
  setup(e) {
    const t = Jn();
    return t.load(), (n, r) => {
      const s = H("UFHeaderPage"), o = H("UFCardBox");
      return D(), v(te, null, [
        N(s, { title: "Dashboard" }),
        m("div", tr, [
          N($n, {
            users: L(t).data.counter.users,
            roles: L(t).data.counter.roles,
            groups: L(t).data.counter.groups
          }, null, 8, ["users", "roles", "groups"])
        ]),
        m("div", nr, [
          m("div", null, [
            m("div", rr, [
              m("div", null, [
                N(Qn, {
                  users: L(t).data.users
                }, null, 8, ["users"])
              ]),
              m("div", null, [
                N(er, {
                  info: L(t).data.info,
                  sprinkles: L(t).data.sprinkles
                }, null, 8, ["info", "sprinkles"])
              ])
            ])
          ]),
          m("div", null, [
            N(o, { title: "Activities" })
          ])
        ])
      ], 64);
    };
  }
});
export {
  ar as default
};
