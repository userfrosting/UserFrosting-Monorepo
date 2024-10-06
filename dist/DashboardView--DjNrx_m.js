import { defineComponent as K, resolveComponent as F, openBlock as B, createElementBlock as M, Fragment as ne, createVNode as T, createBlock as Ee, withCtx as A, createTextVNode as J, createElementVNode as m, renderList as He, toDisplayString as O, unref as D } from "vue";
import { defineStore as pt } from "pinia";
import { h as de } from "./moment-h96o7c8I.js";
function Me(e, t) {
  return function() {
    return e.apply(t, arguments);
  };
}
const { toString: ht } = Object.prototype, { getPrototypeOf: Se } = Object, re = /* @__PURE__ */ ((e) => (t) => {
  const n = ht.call(t);
  return e[n] || (e[n] = n.slice(8, -1).toLowerCase());
})(/* @__PURE__ */ Object.create(null)), N = (e) => (e = e.toLowerCase(), (t) => re(t) === e), se = (e) => (t) => typeof t === e, { isArray: z } = Array, W = se("undefined");
function mt(e) {
  return e !== null && !W(e) && e.constructor !== null && !W(e.constructor) && k(e.constructor.isBuffer) && e.constructor.isBuffer(e);
}
const ze = N("ArrayBuffer");
function yt(e) {
  let t;
  return typeof ArrayBuffer < "u" && ArrayBuffer.isView ? t = ArrayBuffer.isView(e) : t = e && e.buffer && ze(e.buffer), t;
}
const bt = se("string"), k = se("function"), Ve = se("number"), oe = (e) => e !== null && typeof e == "object", wt = (e) => e === !0 || e === !1, Q = (e) => {
  if (re(e) !== "object")
    return !1;
  const t = Se(e);
  return (t === null || t === Object.prototype || Object.getPrototypeOf(t) === null) && !(Symbol.toStringTag in e) && !(Symbol.iterator in e);
}, gt = N("Date"), Et = N("File"), St = N("Blob"), Rt = N("FileList"), _t = (e) => oe(e) && k(e.pipe), Ot = (e) => {
  let t;
  return e && (typeof FormData == "function" && e instanceof FormData || k(e.append) && ((t = re(e)) === "formdata" || // detect form-data instance
  t === "object" && k(e.toString) && e.toString() === "[object FormData]"));
}, Tt = N("URLSearchParams"), [At, xt, Ct, Pt] = ["ReadableStream", "Request", "Response", "Headers"].map(N), kt = (e) => e.trim ? e.trim() : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
function G(e, t, { allOwnKeys: n = !1 } = {}) {
  if (e === null || typeof e > "u")
    return;
  let r, s;
  if (typeof e != "object" && (e = [e]), z(e))
    for (r = 0, s = e.length; r < s; r++)
      t.call(null, e[r], r, e);
  else {
    const o = n ? Object.getOwnPropertyNames(e) : Object.keys(e), i = o.length;
    let l;
    for (r = 0; r < i; r++)
      l = o[r], t.call(null, e[l], l, e);
  }
}
function $e(e, t) {
  t = t.toLowerCase();
  const n = Object.keys(e);
  let r = n.length, s;
  for (; r-- > 0; )
    if (s = n[r], t === s.toLowerCase())
      return s;
  return null;
}
const I = typeof globalThis < "u" ? globalThis : typeof self < "u" ? self : typeof window < "u" ? window : global, Je = (e) => !W(e) && e !== I;
function pe() {
  const { caseless: e } = Je(this) && this || {}, t = {}, n = (r, s) => {
    const o = e && $e(t, s) || s;
    Q(t[o]) && Q(r) ? t[o] = pe(t[o], r) : Q(r) ? t[o] = pe({}, r) : z(r) ? t[o] = r.slice() : t[o] = r;
  };
  for (let r = 0, s = arguments.length; r < s; r++)
    arguments[r] && G(arguments[r], n);
  return t;
}
const Nt = (e, t, n, { allOwnKeys: r } = {}) => (G(t, (s, o) => {
  n && k(s) ? e[o] = Me(s, n) : e[o] = s;
}, { allOwnKeys: r }), e), Ft = (e) => (e.charCodeAt(0) === 65279 && (e = e.slice(1)), e), Ut = (e, t, n, r) => {
  e.prototype = Object.create(t.prototype, r), e.prototype.constructor = e, Object.defineProperty(e, "super", {
    value: t.prototype
  }), n && Object.assign(e.prototype, n);
}, Dt = (e, t, n, r) => {
  let s, o, i;
  const l = {};
  if (t = t || {}, e == null) return t;
  do {
    for (s = Object.getOwnPropertyNames(e), o = s.length; o-- > 0; )
      i = s[o], (!r || r(i, e, t)) && !l[i] && (t[i] = e[i], l[i] = !0);
    e = n !== !1 && Se(e);
  } while (e && (!n || n(e, t)) && e !== Object.prototype);
  return t;
}, Bt = (e, t, n) => {
  e = String(e), (n === void 0 || n > e.length) && (n = e.length), n -= t.length;
  const r = e.indexOf(t, n);
  return r !== -1 && r === n;
}, Lt = (e) => {
  if (!e) return null;
  if (z(e)) return e;
  let t = e.length;
  if (!Ve(t)) return null;
  const n = new Array(t);
  for (; t-- > 0; )
    n[t] = e[t];
  return n;
}, jt = /* @__PURE__ */ ((e) => (t) => e && t instanceof e)(typeof Uint8Array < "u" && Se(Uint8Array)), qt = (e, t) => {
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
}, vt = N("HTMLFormElement"), Ht = (e) => e.toLowerCase().replace(
  /[-_\s]([a-z\d])(\w*)/g,
  function(n, r, s) {
    return r.toUpperCase() + s;
  }
), xe = (({ hasOwnProperty: e }) => (t, n) => e.call(t, n))(Object.prototype), Mt = N("RegExp"), We = (e, t) => {
  const n = Object.getOwnPropertyDescriptors(e), r = {};
  G(n, (s, o) => {
    let i;
    (i = t(s, o, e)) !== !1 && (r[o] = i || s);
  }), Object.defineProperties(e, r);
}, zt = (e) => {
  We(e, (t, n) => {
    if (k(e) && ["arguments", "caller", "callee"].indexOf(n) !== -1)
      return !1;
    const r = e[n];
    if (k(r)) {
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
  return z(e) ? r(e) : r(String(e).split(t)), n;
}, $t = () => {
}, Jt = (e, t) => e != null && Number.isFinite(e = +e) ? e : t, le = "abcdefghijklmnopqrstuvwxyz", Ce = "0123456789", Ke = {
  DIGIT: Ce,
  ALPHA: le,
  ALPHA_DIGIT: le + le.toUpperCase() + Ce
}, Wt = (e = 16, t = Ke.ALPHA_DIGIT) => {
  let n = "";
  const { length: r } = t;
  for (; e--; )
    n += t[Math.random() * r | 0];
  return n;
};
function Kt(e) {
  return !!(e && k(e.append) && e[Symbol.toStringTag] === "FormData" && e[Symbol.iterator]);
}
const Gt = (e) => {
  const t = new Array(10), n = (r, s) => {
    if (oe(r)) {
      if (t.indexOf(r) >= 0)
        return;
      if (!("toJSON" in r)) {
        t[s] = r;
        const o = z(r) ? [] : {};
        return G(r, (i, l) => {
          const f = n(i, s + 1);
          !W(f) && (o[l] = f);
        }), t[s] = void 0, o;
      }
    }
    return r;
  };
  return n(e, 0);
}, Xt = N("AsyncFunction"), Yt = (e) => e && (oe(e) || k(e)) && k(e.then) && k(e.catch), Ge = ((e, t) => e ? setImmediate : t ? ((n, r) => (I.addEventListener("message", ({ source: s, data: o }) => {
  s === I && o === n && r.length && r.shift()();
}, !1), (s) => {
  r.push(s), I.postMessage(n, "*");
}))(`axios@${Math.random()}`, []) : (n) => setTimeout(n))(
  typeof setImmediate == "function",
  k(I.postMessage)
), Qt = typeof queueMicrotask < "u" ? queueMicrotask.bind(I) : typeof process < "u" && process.nextTick || Ge, a = {
  isArray: z,
  isArrayBuffer: ze,
  isBuffer: mt,
  isFormData: Ot,
  isArrayBufferView: yt,
  isString: bt,
  isNumber: Ve,
  isBoolean: wt,
  isObject: oe,
  isPlainObject: Q,
  isReadableStream: At,
  isRequest: xt,
  isResponse: Ct,
  isHeaders: Pt,
  isUndefined: W,
  isDate: gt,
  isFile: Et,
  isBlob: St,
  isRegExp: Mt,
  isFunction: k,
  isStream: _t,
  isURLSearchParams: Tt,
  isTypedArray: jt,
  isFileList: Rt,
  forEach: G,
  merge: pe,
  extend: Nt,
  trim: kt,
  stripBOM: Ft,
  inherits: Ut,
  toFlatObject: Dt,
  kindOf: re,
  kindOfTest: N,
  endsWith: Bt,
  toArray: Lt,
  forEachEntry: qt,
  matchAll: It,
  isHTMLForm: vt,
  hasOwnProperty: xe,
  hasOwnProp: xe,
  // an alias to avoid ESLint no-prototype-builtins detection
  reduceDescriptors: We,
  freezeMethods: zt,
  toObjectSet: Vt,
  toCamelCase: Ht,
  noop: $t,
  toFiniteNumber: Jt,
  findKey: $e,
  global: I,
  isContextDefined: Je,
  ALPHABET: Ke,
  generateString: Wt,
  isSpecCompliantForm: Kt,
  toJSONObject: Gt,
  isAsyncFn: Xt,
  isThenable: Yt,
  setImmediate: Ge,
  asap: Qt
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
const Xe = y.prototype, Ye = {};
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
  Ye[e] = { value: e };
});
Object.defineProperties(y, Ye);
Object.defineProperty(Xe, "isAxiosError", { value: !0 });
y.from = (e, t, n, r, s, o) => {
  const i = Object.create(Xe);
  return a.toFlatObject(e, i, function(f) {
    return f !== Error.prototype;
  }, (l) => l !== "isAxiosError"), y.call(i, e.message, t, n, r, s), i.cause = e, i.name = e.name, o && Object.assign(i, o), i;
};
const Zt = null;
function he(e) {
  return a.isPlainObject(e) || a.isArray(e);
}
function Qe(e) {
  return a.endsWith(e, "[]") ? e.slice(0, -2) : e;
}
function Pe(e, t, n) {
  return e ? e.concat(t).map(function(s, o) {
    return s = Qe(s), !n && o ? "[" + s + "]" : s;
  }).join(n ? "." : "") : t;
}
function en(e) {
  return a.isArray(e) && !e.some(he);
}
const tn = a.toFlatObject(a, {}, null, function(t) {
  return /^is[A-Z]/.test(t);
});
function ie(e, t, n) {
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
  function c(p) {
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
        return b = Qe(b), g.forEach(function(_, U) {
          !(a.isUndefined(_) || _ === null) && t.append(
            // eslint-disable-next-line no-nested-ternary
            i === !0 ? Pe([b], U, o) : i === null ? b : b + "[]",
            c(_)
          );
        }), !1;
    }
    return he(p) ? !0 : (t.append(Pe(h, b, o), c(p)), !1);
  }
  const d = [], w = Object.assign(tn, {
    defaultVisitor: u,
    convertValue: c,
    isVisitable: he
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
function ke(e) {
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
function Re(e, t) {
  this._pairs = [], e && ie(e, this, t);
}
const Ze = Re.prototype;
Ze.append = function(t, n) {
  this._pairs.push([t, n]);
};
Ze.toString = function(t) {
  const n = t ? function(r) {
    return t.call(this, r, ke);
  } : ke;
  return this._pairs.map(function(s) {
    return n(s[0]) + "=" + n(s[1]);
  }, "").join("&");
};
function nn(e) {
  return encodeURIComponent(e).replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]");
}
function et(e, t, n) {
  if (!t)
    return e;
  const r = n && n.encode || nn, s = n && n.serialize;
  let o;
  if (s ? o = s(t, n) : o = a.isURLSearchParams(t) ? t.toString() : new Re(t, n).toString(r), o) {
    const i = e.indexOf("#");
    i !== -1 && (e = e.slice(0, i)), e += (e.indexOf("?") === -1 ? "?" : "&") + o;
  }
  return e;
}
class Ne {
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
const tt = {
  silentJSONParsing: !0,
  forcedJSONParsing: !0,
  clarifyTimeoutError: !1
}, rn = typeof URLSearchParams < "u" ? URLSearchParams : Re, sn = typeof FormData < "u" ? FormData : null, on = typeof Blob < "u" ? Blob : null, an = {
  isBrowser: !0,
  classes: {
    URLSearchParams: rn,
    FormData: sn,
    Blob: on
  },
  protocols: ["http", "https", "file", "blob", "url", "data"]
}, _e = typeof window < "u" && typeof document < "u", me = typeof navigator == "object" && navigator || void 0, ln = _e && (!me || ["ReactNative", "NativeScript", "NS"].indexOf(me.product) < 0), cn = typeof WorkerGlobalScope < "u" && // eslint-disable-next-line no-undef
self instanceof WorkerGlobalScope && typeof self.importScripts == "function", un = _e && window.location.href || "http://localhost", fn = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  hasBrowserEnv: _e,
  hasStandardBrowserEnv: ln,
  hasStandardBrowserWebWorkerEnv: cn,
  navigator: me,
  origin: un
}, Symbol.toStringTag, { value: "Module" })), C = {
  ...fn,
  ...an
};
function dn(e, t) {
  return ie(e, new C.classes.URLSearchParams(), Object.assign({
    visitor: function(n, r, s, o) {
      return C.isNode && a.isBuffer(n) ? (this.append(r, n.toString("base64")), !1) : o.defaultVisitor.apply(this, arguments);
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
function nt(e) {
  function t(n, r, s, o) {
    let i = n[o++];
    if (i === "__proto__") return !0;
    const l = Number.isFinite(+i), f = o >= n.length;
    return i = !i && a.isArray(s) ? s.length : i, f ? (a.hasOwnProp(s, i) ? s[i] = [s[i], r] : s[i] = r, !l) : ((!s[i] || !a.isObject(s[i])) && (s[i] = []), t(n, r, s[i], o) && a.isArray(s[i]) && (s[i] = hn(s[i])), !l);
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
const X = {
  transitional: tt,
  adapter: ["xhr", "http", "fetch"],
  transformRequest: [function(t, n) {
    const r = n.getContentType() || "", s = r.indexOf("application/json") > -1, o = a.isObject(t);
    if (o && a.isHTMLForm(t) && (t = new FormData(t)), a.isFormData(t))
      return s ? JSON.stringify(nt(t)) : t;
    if (a.isArrayBuffer(t) || a.isBuffer(t) || a.isStream(t) || a.isFile(t) || a.isBlob(t) || a.isReadableStream(t))
      return t;
    if (a.isArrayBufferView(t))
      return t.buffer;
    if (a.isURLSearchParams(t))
      return n.setContentType("application/x-www-form-urlencoded;charset=utf-8", !1), t.toString();
    let l;
    if (o) {
      if (r.indexOf("application/x-www-form-urlencoded") > -1)
        return dn(t, this.formSerializer).toString();
      if ((l = a.isFileList(t)) || r.indexOf("multipart/form-data") > -1) {
        const f = this.env && this.env.FormData;
        return ie(
          l ? { "files[]": t } : t,
          f && new f(),
          this.formSerializer
        );
      }
    }
    return o || s ? (n.setContentType("application/json", !1), mn(t)) : t;
  }],
  transformResponse: [function(t) {
    const n = this.transitional || X.transitional, r = n && n.forcedJSONParsing, s = this.responseType === "json";
    if (a.isResponse(t) || a.isReadableStream(t))
      return t;
    if (t && a.isString(t) && (r && !this.responseType || s)) {
      const i = !(n && n.silentJSONParsing) && s;
      try {
        return JSON.parse(t);
      } catch (l) {
        if (i)
          throw l.name === "SyntaxError" ? y.from(l, y.ERR_BAD_RESPONSE, this, null, this.response) : l;
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
    FormData: C.classes.FormData,
    Blob: C.classes.Blob
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
  X.headers[e] = {};
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
}, Fe = Symbol("internals");
function $(e) {
  return e && String(e).trim().toLowerCase();
}
function Z(e) {
  return e === !1 || e == null ? e : a.isArray(e) ? e.map(Z) : String(e);
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
class P {
  constructor(t) {
    t && this.set(t);
  }
  set(t, n, r) {
    const s = this;
    function o(l, f, c) {
      const u = $(f);
      if (!u)
        throw new Error("header name must be a non-empty string");
      const d = a.findKey(s, u);
      (!d || s[d] === void 0 || c === !0 || c === void 0 && s[d] !== !1) && (s[d || f] = Z(l));
    }
    const i = (l, f) => a.forEach(l, (c, u) => o(c, u, f));
    if (a.isPlainObject(t) || t instanceof this.constructor)
      i(t, n);
    else if (a.isString(t) && (t = t.trim()) && !gn(t))
      i(bn(t), n);
    else if (a.isHeaders(t))
      for (const [l, f] of t.entries())
        o(f, l, r);
    else
      t != null && o(n, t, r);
    return this;
  }
  get(t, n) {
    if (t = $(t), t) {
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
    if (t = $(t), t) {
      const r = a.findKey(this, t);
      return !!(r && this[r] !== void 0 && (!n || ce(this, this[r], r, n)));
    }
    return !1;
  }
  delete(t, n) {
    const r = this;
    let s = !1;
    function o(i) {
      if (i = $(i), i) {
        const l = a.findKey(r, i);
        l && (!n || ce(r, r[l], l, n)) && (delete r[l], s = !0);
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
        n[i] = Z(s), delete n[o];
        return;
      }
      const l = t ? En(o) : String(o).trim();
      l !== o && delete n[o], n[l] = Z(s), r[l] = !0;
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
    const r = (this[Fe] = this[Fe] = {
      accessors: {}
    }).accessors, s = this.prototype;
    function o(i) {
      const l = $(i);
      r[l] || (Sn(s, i), r[l] = !0);
    }
    return a.isArray(t) ? t.forEach(o) : o(t), this;
  }
}
P.accessor(["Content-Type", "Content-Length", "Accept", "Accept-Encoding", "User-Agent", "Authorization"]);
a.reduceDescriptors(P.prototype, ({ value: e }, t) => {
  let n = t[0].toUpperCase() + t.slice(1);
  return {
    get: () => e,
    set(r) {
      this[n] = r;
    }
  };
});
a.freezeMethods(P);
function ue(e, t) {
  const n = this || X, r = t || n, s = P.from(r.headers);
  let o = r.data;
  return a.forEach(e, function(l) {
    o = l.call(n, o, s.normalize(), t ? t.status : void 0);
  }), s.normalize(), o;
}
function rt(e) {
  return !!(e && e.__CANCEL__);
}
function V(e, t, n) {
  y.call(this, e ?? "canceled", y.ERR_CANCELED, t, n), this.name = "CanceledError";
}
a.inherits(V, y, {
  __CANCEL__: !0
});
function st(e, t, n) {
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
function _n(e, t) {
  e = e || 10;
  const n = new Array(e), r = new Array(e);
  let s = 0, o = 0, i;
  return t = t !== void 0 ? t : 1e3, function(f) {
    const c = Date.now(), u = r[o];
    i || (i = c), n[s] = f, r[s] = c;
    let d = o, w = 0;
    for (; d !== s; )
      w += n[d++], d = d % e;
    if (s = (s + 1) % e, s === o && (o = (o + 1) % e), c - i < t)
      return;
    const S = u && c - u;
    return S ? Math.round(w * 1e3 / S) : void 0;
  };
}
function On(e, t) {
  let n = 0, r = 1e3 / t, s, o;
  const i = (c, u = Date.now()) => {
    n = u, s = null, o && (clearTimeout(o), o = null), e.apply(null, c);
  };
  return [(...c) => {
    const u = Date.now(), d = u - n;
    d >= r ? i(c, u) : (s = c, o || (o = setTimeout(() => {
      o = null, i(s);
    }, r - d)));
  }, () => s && i(s)];
}
const ee = (e, t, n = 3) => {
  let r = 0;
  const s = _n(50, 250);
  return On((o) => {
    const i = o.loaded, l = o.lengthComputable ? o.total : void 0, f = i - r, c = s(f), u = i <= l;
    r = i;
    const d = {
      loaded: i,
      total: l,
      progress: l ? i / l : void 0,
      bytes: f,
      rate: c || void 0,
      estimated: c && l && u ? (l - i) / c : void 0,
      event: o,
      lengthComputable: l != null,
      [t ? "download" : "upload"]: !0
    };
    e(d);
  }, n);
}, Ue = (e, t) => {
  const n = e != null;
  return [(r) => t[0]({
    lengthComputable: n,
    total: e,
    loaded: r
  }), t[1]];
}, De = (e) => (...t) => a.asap(() => e(...t)), Tn = C.hasStandardBrowserEnv ? (
  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  function() {
    const t = C.navigator && /(msie|trident)/i.test(C.navigator.userAgent), n = document.createElement("a");
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
      const l = a.isString(i) ? s(i) : i;
      return l.protocol === r.protocol && l.host === r.host;
    };
  }()
) : (
  // Non standard browser envs (web workers, react-native) lack needed support.
  /* @__PURE__ */ function() {
    return function() {
      return !0;
    };
  }()
), An = C.hasStandardBrowserEnv ? (
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
function ot(e, t) {
  return e && !xn(t) ? Cn(e, t) : t;
}
const Be = (e) => e instanceof P ? { ...e } : e;
function H(e, t) {
  t = t || {};
  const n = {};
  function r(c, u, d) {
    return a.isPlainObject(c) && a.isPlainObject(u) ? a.merge.call({ caseless: d }, c, u) : a.isPlainObject(u) ? a.merge({}, u) : a.isArray(u) ? u.slice() : u;
  }
  function s(c, u, d) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(c))
        return r(void 0, c, d);
    } else return r(c, u, d);
  }
  function o(c, u) {
    if (!a.isUndefined(u))
      return r(void 0, u);
  }
  function i(c, u) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(c))
        return r(void 0, c);
    } else return r(void 0, u);
  }
  function l(c, u, d) {
    if (d in t)
      return r(c, u);
    if (d in e)
      return r(void 0, c);
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
    validateStatus: l,
    headers: (c, u) => s(Be(c), Be(u), !0)
  };
  return a.forEach(Object.keys(Object.assign({}, e, t)), function(u) {
    const d = f[u] || s, w = d(e[u], t[u], u);
    a.isUndefined(w) && d !== l || (n[u] = w);
  }), n;
}
const it = (e) => {
  const t = H({}, e);
  let { data: n, withXSRFToken: r, xsrfHeaderName: s, xsrfCookieName: o, headers: i, auth: l } = t;
  t.headers = i = P.from(i), t.url = et(ot(t.baseURL, t.url), e.params, e.paramsSerializer), l && i.set(
    "Authorization",
    "Basic " + btoa((l.username || "") + ":" + (l.password ? unescape(encodeURIComponent(l.password)) : ""))
  );
  let f;
  if (a.isFormData(n)) {
    if (C.hasStandardBrowserEnv || C.hasStandardBrowserWebWorkerEnv)
      i.setContentType(void 0);
    else if ((f = i.getContentType()) !== !1) {
      const [c, ...u] = f ? f.split(";").map((d) => d.trim()).filter(Boolean) : [];
      i.setContentType([c || "multipart/form-data", ...u].join("; "));
    }
  }
  if (C.hasStandardBrowserEnv && (r && a.isFunction(r) && (r = r(t)), r || r !== !1 && Tn(t.url))) {
    const c = s && o && An.read(o);
    c && i.set(s, c);
  }
  return t;
}, Pn = typeof XMLHttpRequest < "u", kn = Pn && function(e) {
  return new Promise(function(n, r) {
    const s = it(e);
    let o = s.data;
    const i = P.from(s.headers).normalize();
    let { responseType: l, onUploadProgress: f, onDownloadProgress: c } = s, u, d, w, S, p;
    function b() {
      S && S(), p && p(), s.cancelToken && s.cancelToken.unsubscribe(u), s.signal && s.signal.removeEventListener("abort", u);
    }
    let h = new XMLHttpRequest();
    h.open(s.method.toUpperCase(), s.url, !0), h.timeout = s.timeout;
    function g() {
      if (!h)
        return;
      const _ = P.from(
        "getAllResponseHeaders" in h && h.getAllResponseHeaders()
      ), x = {
        data: !l || l === "text" || l === "json" ? h.responseText : h.response,
        status: h.status,
        statusText: h.statusText,
        headers: _,
        config: e,
        request: h
      };
      st(function(q) {
        n(q), b();
      }, function(q) {
        r(q), b();
      }, x), h = null;
    }
    "onloadend" in h ? h.onloadend = g : h.onreadystatechange = function() {
      !h || h.readyState !== 4 || h.status === 0 && !(h.responseURL && h.responseURL.indexOf("file:") === 0) || setTimeout(g);
    }, h.onabort = function() {
      h && (r(new y("Request aborted", y.ECONNABORTED, e, h)), h = null);
    }, h.onerror = function() {
      r(new y("Network Error", y.ERR_NETWORK, e, h)), h = null;
    }, h.ontimeout = function() {
      let U = s.timeout ? "timeout of " + s.timeout + "ms exceeded" : "timeout exceeded";
      const x = s.transitional || tt;
      s.timeoutErrorMessage && (U = s.timeoutErrorMessage), r(new y(
        U,
        x.clarifyTimeoutError ? y.ETIMEDOUT : y.ECONNABORTED,
        e,
        h
      )), h = null;
    }, o === void 0 && i.setContentType(null), "setRequestHeader" in h && a.forEach(i.toJSON(), function(U, x) {
      h.setRequestHeader(x, U);
    }), a.isUndefined(s.withCredentials) || (h.withCredentials = !!s.withCredentials), l && l !== "json" && (h.responseType = s.responseType), c && ([w, p] = ee(c, !0), h.addEventListener("progress", w)), f && h.upload && ([d, S] = ee(f), h.upload.addEventListener("progress", d), h.upload.addEventListener("loadend", S)), (s.cancelToken || s.signal) && (u = (_) => {
      h && (r(!_ || _.type ? new V(null, e, h) : _), h.abort(), h = null);
    }, s.cancelToken && s.cancelToken.subscribe(u), s.signal && (s.signal.aborted ? u() : s.signal.addEventListener("abort", u)));
    const R = Rn(s.url);
    if (R && C.protocols.indexOf(R) === -1) {
      r(new y("Unsupported protocol " + R + ":", y.ERR_BAD_REQUEST, e));
      return;
    }
    h.send(o || null);
  });
}, Nn = (e, t) => {
  const { length: n } = e = e ? e.filter(Boolean) : [];
  if (t || n) {
    let r = new AbortController(), s;
    const o = function(c) {
      if (!s) {
        s = !0, l();
        const u = c instanceof Error ? c : this.reason;
        r.abort(u instanceof y ? u : new V(u instanceof Error ? u.message : u));
      }
    };
    let i = t && setTimeout(() => {
      i = null, o(new y(`timeout ${t} of ms exceeded`, y.ETIMEDOUT));
    }, t);
    const l = () => {
      e && (i && clearTimeout(i), i = null, e.forEach((c) => {
        c.unsubscribe ? c.unsubscribe(o) : c.removeEventListener("abort", o);
      }), e = null);
    };
    e.forEach((c) => c.addEventListener("abort", o));
    const { signal: f } = r;
    return f.unsubscribe = () => a.asap(l), f;
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
}, Un = async function* (e, t) {
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
}, Le = (e, t, n, r) => {
  const s = Un(e, t);
  let o = 0, i, l = (f) => {
    i || (i = !0, r && r(f));
  };
  return new ReadableStream({
    async pull(f) {
      try {
        const { done: c, value: u } = await s.next();
        if (c) {
          l(), f.close();
          return;
        }
        let d = u.byteLength;
        if (n) {
          let w = o += d;
          n(w);
        }
        f.enqueue(new Uint8Array(u));
      } catch (c) {
        throw l(c), c;
      }
    },
    cancel(f) {
      return l(f), s.return();
    }
  }, {
    highWaterMark: 2
  });
}, ae = typeof fetch == "function" && typeof Request == "function" && typeof Response == "function", at = ae && typeof ReadableStream == "function", Bn = ae && (typeof TextEncoder == "function" ? /* @__PURE__ */ ((e) => (t) => e.encode(t))(new TextEncoder()) : async (e) => new Uint8Array(await new Response(e).arrayBuffer())), lt = (e, ...t) => {
  try {
    return !!e(...t);
  } catch {
    return !1;
  }
}, Ln = at && lt(() => {
  let e = !1;
  const t = new Request(C.origin, {
    body: new ReadableStream(),
    method: "POST",
    get duplex() {
      return e = !0, "half";
    }
  }).headers.has("Content-Type");
  return e && !t;
}), je = 64 * 1024, ye = at && lt(() => a.isReadableStream(new Response("").body)), te = {
  stream: ye && ((e) => e.body)
};
ae && ((e) => {
  ["text", "arrayBuffer", "blob", "formData", "stream"].forEach((t) => {
    !te[t] && (te[t] = a.isFunction(e[t]) ? (n) => n[t]() : (n, r) => {
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
    return (await new Request(C.origin, {
      method: "POST",
      body: e
    }).arrayBuffer()).byteLength;
  if (a.isArrayBufferView(e) || a.isArrayBuffer(e))
    return e.byteLength;
  if (a.isURLSearchParams(e) && (e = e + ""), a.isString(e))
    return (await Bn(e)).byteLength;
}, qn = async (e, t) => {
  const n = a.toFiniteNumber(e.getContentLength());
  return n ?? jn(t);
}, In = ae && (async (e) => {
  let {
    url: t,
    method: n,
    data: r,
    signal: s,
    cancelToken: o,
    timeout: i,
    onDownloadProgress: l,
    onUploadProgress: f,
    responseType: c,
    headers: u,
    withCredentials: d = "same-origin",
    fetchOptions: w
  } = it(e);
  c = c ? (c + "").toLowerCase() : "text";
  let S = Nn([s, o && o.toAbortSignal()], i), p;
  const b = S && S.unsubscribe && (() => {
    S.unsubscribe();
  });
  let h;
  try {
    if (f && Ln && n !== "get" && n !== "head" && (h = await qn(u, r)) !== 0) {
      let x = new Request(t, {
        method: "POST",
        body: r,
        duplex: "half"
      }), L;
      if (a.isFormData(r) && (L = x.headers.get("content-type")) && u.setContentType(L), x.body) {
        const [q, Y] = Ue(
          h,
          ee(De(f))
        );
        r = Le(x.body, je, q, Y);
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
    const _ = ye && (c === "stream" || c === "response");
    if (ye && (l || _ && b)) {
      const x = {};
      ["status", "statusText", "headers"].forEach((Ae) => {
        x[Ae] = R[Ae];
      });
      const L = a.toFiniteNumber(R.headers.get("content-length")), [q, Y] = l && Ue(
        L,
        ee(De(l), !0)
      ) || [];
      R = new Response(
        Le(R.body, je, q, () => {
          Y && Y(), b && b();
        }),
        x
      );
    }
    c = c || "text";
    let U = await te[a.findKey(te, c) || "text"](R, e);
    return !_ && b && b(), await new Promise((x, L) => {
      st(x, L, {
        data: U,
        headers: P.from(R.headers),
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
}), be = {
  http: Zt,
  xhr: kn,
  fetch: In
};
a.forEach(be, (e, t) => {
  if (e) {
    try {
      Object.defineProperty(e, "name", { value: t });
    } catch {
    }
    Object.defineProperty(e, "adapterName", { value: t });
  }
});
const qe = (e) => `- ${e}`, vn = (e) => a.isFunction(e) || e === null || e === !1, ct = {
  getAdapter: (e) => {
    e = a.isArray(e) ? e : [e];
    const { length: t } = e;
    let n, r;
    const s = {};
    for (let o = 0; o < t; o++) {
      n = e[o];
      let i;
      if (r = n, !vn(n) && (r = be[(i = String(n)).toLowerCase()], r === void 0))
        throw new y(`Unknown adapter '${i}'`);
      if (r)
        break;
      s[i || "#" + o] = r;
    }
    if (!r) {
      const o = Object.entries(s).map(
        ([l, f]) => `adapter ${l} ` + (f === !1 ? "is not supported by the environment" : "is not available in the build")
      );
      let i = t ? o.length > 1 ? `since :
` + o.map(qe).join(`
`) : " " + qe(o[0]) : "as no adapter specified";
      throw new y(
        "There is no suitable adapter to dispatch the request " + i,
        "ERR_NOT_SUPPORT"
      );
    }
    return r;
  },
  adapters: be
};
function fe(e) {
  if (e.cancelToken && e.cancelToken.throwIfRequested(), e.signal && e.signal.aborted)
    throw new V(null, e);
}
function Ie(e) {
  return fe(e), e.headers = P.from(e.headers), e.data = ue.call(
    e,
    e.transformRequest
  ), ["post", "put", "patch"].indexOf(e.method) !== -1 && e.headers.setContentType("application/x-www-form-urlencoded", !1), ct.getAdapter(e.adapter || X.adapter)(e).then(function(r) {
    return fe(e), r.data = ue.call(
      e,
      e.transformResponse,
      r
    ), r.headers = P.from(r.headers), r;
  }, function(r) {
    return rt(r) || (fe(e), r && r.response && (r.response.data = ue.call(
      e,
      e.transformResponse,
      r.response
    ), r.response.headers = P.from(r.response.headers))), Promise.reject(r);
  });
}
const ut = "1.7.7", Oe = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach((e, t) => {
  Oe[e] = function(r) {
    return typeof r === e || "a" + (t < 1 ? "n " : " ") + e;
  };
});
const ve = {};
Oe.transitional = function(t, n, r) {
  function s(o, i) {
    return "[Axios v" + ut + "] Transitional option '" + o + "'" + i + (r ? ". " + r : "");
  }
  return (o, i, l) => {
    if (t === !1)
      throw new y(
        s(i, " has been removed" + (n ? " in " + n : "")),
        y.ERR_DEPRECATED
      );
    return n && !ve[i] && (ve[i] = !0, console.warn(
      s(
        i,
        " has been deprecated since v" + n + " and will be removed in the near future"
      )
    )), t ? t(o, i, l) : !0;
  };
};
function Hn(e, t, n) {
  if (typeof e != "object")
    throw new y("options must be an object", y.ERR_BAD_OPTION_VALUE);
  const r = Object.keys(e);
  let s = r.length;
  for (; s-- > 0; ) {
    const o = r[s], i = t[o];
    if (i) {
      const l = e[o], f = l === void 0 || i(l, o, e);
      if (f !== !0)
        throw new y("option " + o + " must be " + f, y.ERR_BAD_OPTION_VALUE);
      continue;
    }
    if (n !== !0)
      throw new y("Unknown option " + o, y.ERR_BAD_OPTION);
  }
}
const we = {
  assertOptions: Hn,
  validators: Oe
}, j = we.validators;
class v {
  constructor(t) {
    this.defaults = t, this.interceptors = {
      request: new Ne(),
      response: new Ne()
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
    typeof t == "string" ? (n = n || {}, n.url = t) : n = t || {}, n = H(this.defaults, n);
    const { transitional: r, paramsSerializer: s, headers: o } = n;
    r !== void 0 && we.assertOptions(r, {
      silentJSONParsing: j.transitional(j.boolean),
      forcedJSONParsing: j.transitional(j.boolean),
      clarifyTimeoutError: j.transitional(j.boolean)
    }, !1), s != null && (a.isFunction(s) ? n.paramsSerializer = {
      serialize: s
    } : we.assertOptions(s, {
      encode: j.function,
      serialize: j.function
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
    ), n.headers = P.concat(i, o);
    const l = [];
    let f = !0;
    this.interceptors.request.forEach(function(b) {
      typeof b.runWhen == "function" && b.runWhen(n) === !1 || (f = f && b.synchronous, l.unshift(b.fulfilled, b.rejected));
    });
    const c = [];
    this.interceptors.response.forEach(function(b) {
      c.push(b.fulfilled, b.rejected);
    });
    let u, d = 0, w;
    if (!f) {
      const p = [Ie.bind(this), void 0];
      for (p.unshift.apply(p, l), p.push.apply(p, c), w = p.length, u = Promise.resolve(n); d < w; )
        u = u.then(p[d++], p[d++]);
      return u;
    }
    w = l.length;
    let S = n;
    for (d = 0; d < w; ) {
      const p = l[d++], b = l[d++];
      try {
        S = p(S);
      } catch (h) {
        b.call(this, h);
        break;
      }
    }
    try {
      u = Ie.call(this, S);
    } catch (p) {
      return Promise.reject(p);
    }
    for (d = 0, w = c.length; d < w; )
      u = u.then(c[d++], c[d++]);
    return u;
  }
  getUri(t) {
    t = H(this.defaults, t);
    const n = ot(t.baseURL, t.url);
    return et(n, t.params, t.paramsSerializer);
  }
}
a.forEach(["delete", "get", "head", "options"], function(t) {
  v.prototype[t] = function(n, r) {
    return this.request(H(r || {}, {
      method: t,
      url: n,
      data: (r || {}).data
    }));
  };
});
a.forEach(["post", "put", "patch"], function(t) {
  function n(r) {
    return function(o, i, l) {
      return this.request(H(l || {}, {
        method: t,
        headers: r ? {
          "Content-Type": "multipart/form-data"
        } : {},
        url: o,
        data: i
      }));
    };
  }
  v.prototype[t] = n(), v.prototype[t + "Form"] = n(!0);
});
class Te {
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
      const i = new Promise((l) => {
        r.subscribe(l), o = l;
      }).then(s);
      return i.cancel = function() {
        r.unsubscribe(o);
      }, i;
    }, t(function(o, i, l) {
      r.reason || (r.reason = new V(o, i, l), n(r.reason));
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
      token: new Te(function(s) {
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
const ge = {
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
Object.entries(ge).forEach(([e, t]) => {
  ge[t] = e;
});
function ft(e) {
  const t = new v(e), n = Me(v.prototype.request, t);
  return a.extend(n, v.prototype, t, { allOwnKeys: !0 }), a.extend(n, t, null, { allOwnKeys: !0 }), n.create = function(s) {
    return ft(H(e, s));
  }, n;
}
const E = ft(X);
E.Axios = v;
E.CanceledError = V;
E.CancelToken = Te;
E.isCancel = rt;
E.VERSION = ut;
E.toFormData = ie;
E.AxiosError = y;
E.Cancel = E.CanceledError;
E.all = function(t) {
  return Promise.all(t);
};
E.spread = Mn;
E.isAxiosError = zn;
E.mergeConfig = H;
E.AxiosHeaders = P;
E.formToJSON = (e) => nt(a.isHTMLForm(e) ? new FormData(e) : e);
E.getAdapter = ct.getAdapter;
E.HttpStatusCode = ge;
E.default = E;
var dt = /* @__PURE__ */ ((e) => (e.Primary = "Primary", e.Success = "Success", e.Warning = "Warning", e.Danger = "Danger", e))(dt || {});
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
}, $n = pt("dashboardApi", {
  state: () => ({
    data: Vn
  }),
  actions: {
    async load() {
      return E.get("/api/dashboard").then((e) => (this.data = e.data, this.data)).catch((e) => {
        throw {
          description: "An error as occurred",
          style: dt.Danger,
          closeBtn: !0,
          ...e.response.data
        };
      });
    }
  }
}), Jn = /* @__PURE__ */ K({
  __name: "DashboardStats",
  props: {
    users: {},
    roles: {},
    groups: {}
  },
  setup(e) {
    return (t, n) => {
      const r = F("UFInfoBox");
      return B(), M(ne, null, [
        T(r, {
          value: t.users,
          label: "Users",
          faIcon: "user",
          to: { name: "admin.users" }
        }, null, 8, ["value"]),
        T(r, {
          value: t.roles,
          label: "Roles",
          faIcon: "address-card",
          to: { name: "admin.roles" }
        }, null, 8, ["value"]),
        T(r, {
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
}, Kn = ["src"], Gn = { class: "uk-margin-remove" }, Xn = { class: "uk-margin-remove uk-text-meta" }, Yn = /* @__PURE__ */ K({
  __name: "DashboardRecentUsers",
  props: {
    users: {}
  },
  setup(e) {
    return (t, n) => {
      const r = F("RouterLink"), s = F("UFCardBox");
      return B(), Ee(s, { title: "Latest Users" }, {
        footer: A(() => [
          T(r, {
            to: { name: "admin.users" },
            class: "uk-text-center"
          }, {
            default: A(() => n[0] || (n[0] = [
              J("View All Users")
            ])),
            _: 1
          })
        ]),
        default: A(() => [
          m("div", Wn, [
            (B(!0), M(ne, null, He(t.users, (o) => (B(), M("div", {
              key: o.id,
              class: "uk-text-center"
            }, [
              T(r, {
                to: { name: "admin.user", params: { user_name: o.user_name } },
                class: "uk-text-decoration-none uk-link-text"
              }, {
                default: A(() => [
                  m("img", {
                    src: o.avatar,
                    alt: "User Image",
                    class: "uk-border-circle"
                  }, null, 8, Kn),
                  m("p", Gn, O(o.full_name), 1),
                  m("p", Xn, O(D(de)(o.created_at).fromNow()), 1)
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
}), Qn = { class: "uk-description-list" }, Zn = { class: "uk-list uk-list-disc uk-list-collapse" }, er = /* @__PURE__ */ K({
  __name: "DashboardSystemInfo",
  props: {
    info: {},
    sprinkles: {}
  },
  setup(e) {
    return (t, n) => {
      const r = F("UFCardBox");
      return B(), Ee(r, { title: "System Information" }, {
        default: A(() => [
          m("dl", Qn, [
            n[0] || (n[0] = m("dt", null, "Framework version", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.frameworkVersion), 1)
              ])
            ]),
            n[1] || (n[1] = m("dt", null, "PHP version", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.phpVersion), 1)
              ])
            ]),
            n[2] || (n[2] = m("dt", null, "Webserver software", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.server), 1)
              ])
            ]),
            n[3] || (n[3] = m("dt", null, "Database connection", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.database.connection), 1)
              ])
            ]),
            n[4] || (n[4] = m("dt", null, "Database version", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.database.type) + " " + O(t.info.database.version), 1)
              ])
            ]),
            n[5] || (n[5] = m("dt", null, "Database name", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.database.name), 1)
              ])
            ]),
            n[6] || (n[6] = m("dt", null, "Project directory", -1)),
            m("dd", null, [
              m("pre", null, [
                m("code", null, O(t.info.projectPath), 1)
              ])
            ]),
            n[7] || (n[7] = m("dt", null, "Loaded sprinkles", -1)),
            m("dd", null, [
              m("ul", Zn, [
                (B(!0), M(ne, null, He(t.sprinkles, (s) => (B(), M("li", { key: s }, O(s), 1))), 128))
              ])
            ])
          ])
        ]),
        _: 1
      });
    };
  }
}), tr = { class: "uk-text-meta" }, nr = /* @__PURE__ */ K({
  __name: "DashboardActivities",
  setup(e) {
    return (t, n) => {
      const r = F("UFSprunjeHeader"), s = F("UFSprunjeColumn"), o = F("RouterLink"), i = F("UFSprunjeTable"), l = F("UFCardBox");
      return B(), Ee(l, { title: "Latest Activities" }, {
        default: A(() => [
          T(i, {
            dataUrl: "/api/activities",
            defaultSorts: { occurred_at: "desc" },
            hidePagination: ""
          }, {
            header: A(() => [
              T(r, null, {
                default: A(() => n[0] || (n[0] = [
                  J("Activity Time")
                ])),
                _: 1
              }),
              T(r, null, {
                default: A(() => n[1] || (n[1] = [
                  J("User")
                ])),
                _: 1
              }),
              T(r, null, {
                default: A(() => n[2] || (n[2] = [
                  J("Description")
                ])),
                _: 1
              })
            ]),
            body: A(({ item: f }) => [
              T(s, null, {
                default: A(() => [
                  m("div", null, O(D(de)(f.occurred_at).format("dddd")), 1),
                  m("div", null, O(D(de)(f.occurred_at).format("MMM Do, YYYY h:mm a")), 1)
                ]),
                _: 2
              }, 1024),
              T(s, null, {
                default: A(() => [
                  m("strong", null, [
                    T(o, {
                      to: {
                        name: "admin.user",
                        params: { user_name: f.user.user_name }
                      }
                    }, {
                      default: A(() => [
                        J(O(f.user.full_name) + " (" + O(f.user.user_name) + ") ", 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]),
                  m("div", tr, O(f.user.email), 1)
                ]),
                _: 2
              }, 1024),
              T(s, null, {
                default: A(() => [
                  m("div", null, O(f.ip_address), 1),
                  m("div", null, [
                    m("i", null, O(f.description), 1)
                  ])
                ]),
                _: 2
              }, 1024)
            ]),
            _: 1
          })
        ]),
        _: 1
      });
    };
  }
}), rr = {
  class: "uk-child-width-expand",
  "uk-grid": ""
}, sr = {
  class: "uk-child-width-1-2",
  "uk-grid": ""
}, or = {
  class: "uk-child-width-1-1",
  "uk-grid": ""
}, cr = /* @__PURE__ */ K({
  __name: "DashboardView",
  setup(e) {
    const t = $n();
    return t.load(), (n, r) => {
      const s = F("UFHeaderPage");
      return B(), M(ne, null, [
        T(s, { title: "Dashboard" }),
        m("div", rr, [
          T(Jn, {
            users: D(t).data.counter.users,
            roles: D(t).data.counter.roles,
            groups: D(t).data.counter.groups
          }, null, 8, ["users", "roles", "groups"])
        ]),
        m("div", sr, [
          m("div", null, [
            m("div", or, [
              m("div", null, [
                T(Yn, {
                  users: D(t).data.users
                }, null, 8, ["users"])
              ]),
              m("div", null, [
                T(er, {
                  info: D(t).data.info,
                  sprinkles: D(t).data.sprinkles
                }, null, 8, ["info", "sprinkles"])
              ])
            ])
          ]),
          m("div", null, [
            T(nr)
          ])
        ])
      ], 64);
    };
  }
});
export {
  cr as default
};
