import { defineStore as Ge } from "pinia";
import { AlertStyle as v } from "./types.js";
function Ae(e, t) {
  return function() {
    return e.apply(t, arguments);
  };
}
const { toString: Xe } = Object.prototype, { getPrototypeOf: ie } = Object, J = /* @__PURE__ */ ((e) => (t) => {
  const n = Xe.call(t);
  return e[n] || (e[n] = n.slice(8, -1).toLowerCase());
})(/* @__PURE__ */ Object.create(null)), A = (e) => (e = e.toLowerCase(), (t) => J(t) === e), V = (e) => (t) => typeof t === e, { isArray: L } = Array, k = V("undefined");
function Qe(e) {
  return e !== null && !k(e) && e.constructor !== null && !k(e.constructor) && O(e.constructor.isBuffer) && e.constructor.isBuffer(e);
}
const xe = A("ArrayBuffer");
function Ze(e) {
  let t;
  return typeof ArrayBuffer < "u" && ArrayBuffer.isView ? t = ArrayBuffer.isView(e) : t = e && e.buffer && xe(e.buffer), t;
}
const Ye = V("string"), O = V("function"), Ce = V("number"), W = (e) => e !== null && typeof e == "object", et = (e) => e === !0 || e === !1, H = (e) => {
  if (J(e) !== "object")
    return !1;
  const t = ie(e);
  return (t === null || t === Object.prototype || Object.getPrototypeOf(t) === null) && !(Symbol.toStringTag in e) && !(Symbol.iterator in e);
}, tt = A("Date"), nt = A("File"), rt = A("Blob"), st = A("FileList"), ot = (e) => W(e) && O(e.pipe), it = (e) => {
  let t;
  return e && (typeof FormData == "function" && e instanceof FormData || O(e.append) && ((t = J(e)) === "formdata" || // detect form-data instance
  t === "object" && O(e.toString) && e.toString() === "[object FormData]"));
}, at = A("URLSearchParams"), [ct, ut, lt, ft] = ["ReadableStream", "Request", "Response", "Headers"].map(A), dt = (e) => e.trim ? e.trim() : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
function j(e, t, { allOwnKeys: n = !1 } = {}) {
  if (e === null || typeof e > "u")
    return;
  let r, s;
  if (typeof e != "object" && (e = [e]), L(e))
    for (r = 0, s = e.length; r < s; r++)
      t.call(null, e[r], r, e);
  else {
    const o = n ? Object.getOwnPropertyNames(e) : Object.keys(e), i = o.length;
    let c;
    for (r = 0; r < i; r++)
      c = o[r], t.call(null, e[c], c, e);
  }
}
function Ne(e, t) {
  t = t.toLowerCase();
  const n = Object.keys(e);
  let r = n.length, s;
  for (; r-- > 0; )
    if (s = n[r], t === s.toLowerCase())
      return s;
  return null;
}
const Pe = typeof globalThis < "u" ? globalThis : typeof self < "u" ? self : typeof window < "u" ? window : global, Fe = (e) => !k(e) && e !== Pe;
function Y() {
  const { caseless: e } = Fe(this) && this || {}, t = {}, n = (r, s) => {
    const o = e && Ne(t, s) || s;
    H(t[o]) && H(r) ? t[o] = Y(t[o], r) : H(r) ? t[o] = Y({}, r) : L(r) ? t[o] = r.slice() : t[o] = r;
  };
  for (let r = 0, s = arguments.length; r < s; r++)
    arguments[r] && j(arguments[r], n);
  return t;
}
const ht = (e, t, n, { allOwnKeys: r } = {}) => (j(t, (s, o) => {
  n && O(s) ? e[o] = Ae(s, n) : e[o] = s;
}, { allOwnKeys: r }), e), pt = (e) => (e.charCodeAt(0) === 65279 && (e = e.slice(1)), e), mt = (e, t, n, r) => {
  e.prototype = Object.create(t.prototype, r), e.prototype.constructor = e, Object.defineProperty(e, "super", {
    value: t.prototype
  }), n && Object.assign(e.prototype, n);
}, yt = (e, t, n, r) => {
  let s, o, i;
  const c = {};
  if (t = t || {}, e == null) return t;
  do {
    for (s = Object.getOwnPropertyNames(e), o = s.length; o-- > 0; )
      i = s[o], (!r || r(i, e, t)) && !c[i] && (t[i] = e[i], c[i] = !0);
    e = n !== !1 && ie(e);
  } while (e && (!n || n(e, t)) && e !== Object.prototype);
  return t;
}, wt = (e, t, n) => {
  e = String(e), (n === void 0 || n > e.length) && (n = e.length), n -= t.length;
  const r = e.indexOf(t, n);
  return r !== -1 && r === n;
}, bt = (e) => {
  if (!e) return null;
  if (L(e)) return e;
  let t = e.length;
  if (!Ce(t)) return null;
  const n = new Array(t);
  for (; t-- > 0; )
    n[t] = e[t];
  return n;
}, Et = /* @__PURE__ */ ((e) => (t) => e && t instanceof e)(typeof Uint8Array < "u" && ie(Uint8Array)), gt = (e, t) => {
  const r = (e && e[Symbol.iterator]).call(e);
  let s;
  for (; (s = r.next()) && !s.done; ) {
    const o = s.value;
    t.call(e, o[0], o[1]);
  }
}, Rt = (e, t) => {
  let n;
  const r = [];
  for (; (n = e.exec(t)) !== null; )
    r.push(n);
  return r;
}, St = A("HTMLFormElement"), Ot = (e) => e.toLowerCase().replace(
  /[-_\s]([a-z\d])(\w*)/g,
  function(n, r, s) {
    return r.toUpperCase() + s;
  }
), de = (({ hasOwnProperty: e }) => (t, n) => e.call(t, n))(Object.prototype), Tt = A("RegExp"), _e = (e, t) => {
  const n = Object.getOwnPropertyDescriptors(e), r = {};
  j(n, (s, o) => {
    let i;
    (i = t(s, o, e)) !== !1 && (r[o] = i || s);
  }), Object.defineProperties(e, r);
}, At = (e) => {
  _e(e, (t, n) => {
    if (O(e) && ["arguments", "caller", "callee"].indexOf(n) !== -1)
      return !1;
    const r = e[n];
    if (O(r)) {
      if (t.enumerable = !1, "writable" in t) {
        t.writable = !1;
        return;
      }
      t.set || (t.set = () => {
        throw Error("Can not rewrite read-only method '" + n + "'");
      });
    }
  });
}, xt = (e, t) => {
  const n = {}, r = (s) => {
    s.forEach((o) => {
      n[o] = !0;
    });
  };
  return L(e) ? r(e) : r(String(e).split(t)), n;
}, Ct = () => {
}, Nt = (e, t) => e != null && Number.isFinite(e = +e) ? e : t, G = "abcdefghijklmnopqrstuvwxyz", he = "0123456789", Le = {
  DIGIT: he,
  ALPHA: G,
  ALPHA_DIGIT: G + G.toUpperCase() + he
}, Pt = (e = 16, t = Le.ALPHA_DIGIT) => {
  let n = "";
  const { length: r } = t;
  for (; e--; )
    n += t[Math.random() * r | 0];
  return n;
};
function Ft(e) {
  return !!(e && O(e.append) && e[Symbol.toStringTag] === "FormData" && e[Symbol.iterator]);
}
const _t = (e) => {
  const t = new Array(10), n = (r, s) => {
    if (W(r)) {
      if (t.indexOf(r) >= 0)
        return;
      if (!("toJSON" in r)) {
        t[s] = r;
        const o = L(r) ? [] : {};
        return j(r, (i, c) => {
          const f = n(i, s + 1);
          !k(f) && (o[c] = f);
        }), t[s] = void 0, o;
      }
    }
    return r;
  };
  return n(e, 0);
}, Lt = A("AsyncFunction"), Bt = (e) => e && (W(e) || O(e)) && O(e.then) && O(e.catch), a = {
  isArray: L,
  isArrayBuffer: xe,
  isBuffer: Qe,
  isFormData: it,
  isArrayBufferView: Ze,
  isString: Ye,
  isNumber: Ce,
  isBoolean: et,
  isObject: W,
  isPlainObject: H,
  isReadableStream: ct,
  isRequest: ut,
  isResponse: lt,
  isHeaders: ft,
  isUndefined: k,
  isDate: tt,
  isFile: nt,
  isBlob: rt,
  isRegExp: Tt,
  isFunction: O,
  isStream: ot,
  isURLSearchParams: at,
  isTypedArray: Et,
  isFileList: st,
  forEach: j,
  merge: Y,
  extend: ht,
  trim: dt,
  stripBOM: pt,
  inherits: mt,
  toFlatObject: yt,
  kindOf: J,
  kindOfTest: A,
  endsWith: wt,
  toArray: bt,
  forEachEntry: gt,
  matchAll: Rt,
  isHTMLForm: St,
  hasOwnProperty: de,
  hasOwnProp: de,
  // an alias to avoid ESLint no-prototype-builtins detection
  reduceDescriptors: _e,
  freezeMethods: At,
  toObjectSet: xt,
  toCamelCase: Ot,
  noop: Ct,
  toFiniteNumber: Nt,
  findKey: Ne,
  global: Pe,
  isContextDefined: Fe,
  ALPHABET: Le,
  generateString: Pt,
  isSpecCompliantForm: Ft,
  toJSONObject: _t,
  isAsyncFn: Lt,
  isThenable: Bt
};
function p(e, t, n, r, s) {
  Error.call(this), Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : this.stack = new Error().stack, this.message = e, this.name = "AxiosError", t && (this.code = t), n && (this.config = n), r && (this.request = r), s && (this.response = s);
}
a.inherits(p, Error, {
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
      status: this.response && this.response.status ? this.response.status : null
    };
  }
});
const Be = p.prototype, Ue = {};
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
  Ue[e] = { value: e };
});
Object.defineProperties(p, Ue);
Object.defineProperty(Be, "isAxiosError", { value: !0 });
p.from = (e, t, n, r, s, o) => {
  const i = Object.create(Be);
  return a.toFlatObject(e, i, function(f) {
    return f !== Error.prototype;
  }, (c) => c !== "isAxiosError"), p.call(i, e.message, t, n, r, s), i.cause = e, i.name = e.name, o && Object.assign(i, o), i;
};
const Ut = null;
function ee(e) {
  return a.isPlainObject(e) || a.isArray(e);
}
function De(e) {
  return a.endsWith(e, "[]") ? e.slice(0, -2) : e;
}
function pe(e, t, n) {
  return e ? e.concat(t).map(function(s, o) {
    return s = De(s), !n && o ? "[" + s + "]" : s;
  }).join(n ? "." : "") : t;
}
function Dt(e) {
  return a.isArray(e) && !e.some(ee);
}
const kt = a.toFlatObject(a, {}, null, function(t) {
  return /^is[A-Z]/.test(t);
});
function $(e, t, n) {
  if (!a.isObject(e))
    throw new TypeError("target must be an object");
  t = t || new FormData(), n = a.toFlatObject(n, {
    metaTokens: !0,
    dots: !1,
    indexes: !1
  }, !1, function(m, g) {
    return !a.isUndefined(g[m]);
  });
  const r = n.metaTokens, s = n.visitor || u, o = n.dots, i = n.indexes, f = (n.Blob || typeof Blob < "u" && Blob) && a.isSpecCompliantForm(t);
  if (!a.isFunction(s))
    throw new TypeError("visitor must be a function");
  function l(d) {
    if (d === null) return "";
    if (a.isDate(d))
      return d.toISOString();
    if (!f && a.isBlob(d))
      throw new p("Blob is not supported. Use a Buffer instead.");
    return a.isArrayBuffer(d) || a.isTypedArray(d) ? f && typeof Blob == "function" ? new Blob([d]) : Buffer.from(d) : d;
  }
  function u(d, m, g) {
    let R = d;
    if (d && !g && typeof d == "object") {
      if (a.endsWith(m, "{}"))
        m = r ? m : m.slice(0, -2), d = JSON.stringify(d);
      else if (a.isArray(d) && Dt(d) || (a.isFileList(d) || a.endsWith(m, "[]")) && (R = a.toArray(d)))
        return m = De(m), R.forEach(function(w, U) {
          !(a.isUndefined(w) || w === null) && t.append(
            // eslint-disable-next-line no-nested-ternary
            i === !0 ? pe([m], U, o) : i === null ? m : m + "[]",
            l(w)
          );
        }), !1;
    }
    return ee(d) ? !0 : (t.append(pe(g, m, o), l(d)), !1);
  }
  const h = [], E = Object.assign(kt, {
    defaultVisitor: u,
    convertValue: l,
    isVisitable: ee
  });
  function y(d, m) {
    if (!a.isUndefined(d)) {
      if (h.indexOf(d) !== -1)
        throw Error("Circular reference detected in " + m.join("."));
      h.push(d), a.forEach(d, function(R, x) {
        (!(a.isUndefined(R) || R === null) && s.call(
          t,
          R,
          a.isString(x) ? x.trim() : x,
          m,
          E
        )) === !0 && y(R, m ? m.concat(x) : [x]);
      }), h.pop();
    }
  }
  if (!a.isObject(e))
    throw new TypeError("data must be an object");
  return y(e), t;
}
function me(e) {
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
function ae(e, t) {
  this._pairs = [], e && $(e, this, t);
}
const ke = ae.prototype;
ke.append = function(t, n) {
  this._pairs.push([t, n]);
};
ke.toString = function(t) {
  const n = t ? function(r) {
    return t.call(this, r, me);
  } : me;
  return this._pairs.map(function(s) {
    return n(s[0]) + "=" + n(s[1]);
  }, "").join("&");
};
function jt(e) {
  return encodeURIComponent(e).replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]");
}
function je(e, t, n) {
  if (!t)
    return e;
  const r = n && n.encode || jt, s = n && n.serialize;
  let o;
  if (s ? o = s(t, n) : o = a.isURLSearchParams(t) ? t.toString() : new ae(t, n).toString(r), o) {
    const i = e.indexOf("#");
    i !== -1 && (e = e.slice(0, i)), e += (e.indexOf("?") === -1 ? "?" : "&") + o;
  }
  return e;
}
class ye {
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
const qe = {
  silentJSONParsing: !0,
  forcedJSONParsing: !0,
  clarifyTimeoutError: !1
}, qt = typeof URLSearchParams < "u" ? URLSearchParams : ae, Ht = typeof FormData < "u" ? FormData : null, It = typeof Blob < "u" ? Blob : null, Mt = {
  isBrowser: !0,
  classes: {
    URLSearchParams: qt,
    FormData: Ht,
    Blob: It
  },
  protocols: ["http", "https", "file", "blob", "url", "data"]
}, ce = typeof window < "u" && typeof document < "u", zt = ((e) => ce && ["ReactNative", "NativeScript", "NS"].indexOf(e) < 0)(typeof navigator < "u" && navigator.product), Jt = typeof WorkerGlobalScope < "u" && // eslint-disable-next-line no-undef
self instanceof WorkerGlobalScope && typeof self.importScripts == "function", Vt = ce && window.location.href || "http://localhost", Wt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  hasBrowserEnv: ce,
  hasStandardBrowserEnv: zt,
  hasStandardBrowserWebWorkerEnv: Jt,
  origin: Vt
}, Symbol.toStringTag, { value: "Module" })), T = {
  ...Wt,
  ...Mt
};
function $t(e, t) {
  return $(e, new T.classes.URLSearchParams(), Object.assign({
    visitor: function(n, r, s, o) {
      return T.isNode && a.isBuffer(n) ? (this.append(r, n.toString("base64")), !1) : o.defaultVisitor.apply(this, arguments);
    }
  }, t));
}
function Kt(e) {
  return a.matchAll(/\w+|\[(\w*)]/g, e).map((t) => t[0] === "[]" ? "" : t[1] || t[0]);
}
function vt(e) {
  const t = {}, n = Object.keys(e);
  let r;
  const s = n.length;
  let o;
  for (r = 0; r < s; r++)
    o = n[r], t[o] = e[o];
  return t;
}
function He(e) {
  function t(n, r, s, o) {
    let i = n[o++];
    if (i === "__proto__") return !0;
    const c = Number.isFinite(+i), f = o >= n.length;
    return i = !i && a.isArray(s) ? s.length : i, f ? (a.hasOwnProp(s, i) ? s[i] = [s[i], r] : s[i] = r, !c) : ((!s[i] || !a.isObject(s[i])) && (s[i] = []), t(n, r, s[i], o) && a.isArray(s[i]) && (s[i] = vt(s[i])), !c);
  }
  if (a.isFormData(e) && a.isFunction(e.entries)) {
    const n = {};
    return a.forEachEntry(e, (r, s) => {
      t(Kt(r), s, n, 0);
    }), n;
  }
  return null;
}
function Gt(e, t, n) {
  if (a.isString(e))
    try {
      return (t || JSON.parse)(e), a.trim(e);
    } catch (r) {
      if (r.name !== "SyntaxError")
        throw r;
    }
  return (n || JSON.stringify)(e);
}
const q = {
  transitional: qe,
  adapter: ["xhr", "http", "fetch"],
  transformRequest: [function(t, n) {
    const r = n.getContentType() || "", s = r.indexOf("application/json") > -1, o = a.isObject(t);
    if (o && a.isHTMLForm(t) && (t = new FormData(t)), a.isFormData(t))
      return s ? JSON.stringify(He(t)) : t;
    if (a.isArrayBuffer(t) || a.isBuffer(t) || a.isStream(t) || a.isFile(t) || a.isBlob(t) || a.isReadableStream(t))
      return t;
    if (a.isArrayBufferView(t))
      return t.buffer;
    if (a.isURLSearchParams(t))
      return n.setContentType("application/x-www-form-urlencoded;charset=utf-8", !1), t.toString();
    let c;
    if (o) {
      if (r.indexOf("application/x-www-form-urlencoded") > -1)
        return $t(t, this.formSerializer).toString();
      if ((c = a.isFileList(t)) || r.indexOf("multipart/form-data") > -1) {
        const f = this.env && this.env.FormData;
        return $(
          c ? { "files[]": t } : t,
          f && new f(),
          this.formSerializer
        );
      }
    }
    return o || s ? (n.setContentType("application/json", !1), Gt(t)) : t;
  }],
  transformResponse: [function(t) {
    const n = this.transitional || q.transitional, r = n && n.forcedJSONParsing, s = this.responseType === "json";
    if (a.isResponse(t) || a.isReadableStream(t))
      return t;
    if (t && a.isString(t) && (r && !this.responseType || s)) {
      const i = !(n && n.silentJSONParsing) && s;
      try {
        return JSON.parse(t);
      } catch (c) {
        if (i)
          throw c.name === "SyntaxError" ? p.from(c, p.ERR_BAD_RESPONSE, this, null, this.response) : c;
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
    FormData: T.classes.FormData,
    Blob: T.classes.Blob
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
  q.headers[e] = {};
});
const Xt = a.toObjectSet([
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
]), Qt = (e) => {
  const t = {};
  let n, r, s;
  return e && e.split(`
`).forEach(function(i) {
    s = i.indexOf(":"), n = i.substring(0, s).trim().toLowerCase(), r = i.substring(s + 1).trim(), !(!n || t[n] && Xt[n]) && (n === "set-cookie" ? t[n] ? t[n].push(r) : t[n] = [r] : t[n] = t[n] ? t[n] + ", " + r : r);
  }), t;
}, we = Symbol("internals");
function D(e) {
  return e && String(e).trim().toLowerCase();
}
function I(e) {
  return e === !1 || e == null ? e : a.isArray(e) ? e.map(I) : String(e);
}
function Zt(e) {
  const t = /* @__PURE__ */ Object.create(null), n = /([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;
  let r;
  for (; r = n.exec(e); )
    t[r[1]] = r[2];
  return t;
}
const Yt = (e) => /^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());
function X(e, t, n, r, s) {
  if (a.isFunction(r))
    return r.call(this, t, n);
  if (s && (t = n), !!a.isString(t)) {
    if (a.isString(r))
      return t.indexOf(r) !== -1;
    if (a.isRegExp(r))
      return r.test(t);
  }
}
function en(e) {
  return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g, (t, n, r) => n.toUpperCase() + r);
}
function tn(e, t) {
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
class S {
  constructor(t) {
    t && this.set(t);
  }
  set(t, n, r) {
    const s = this;
    function o(c, f, l) {
      const u = D(f);
      if (!u)
        throw new Error("header name must be a non-empty string");
      const h = a.findKey(s, u);
      (!h || s[h] === void 0 || l === !0 || l === void 0 && s[h] !== !1) && (s[h || f] = I(c));
    }
    const i = (c, f) => a.forEach(c, (l, u) => o(l, u, f));
    if (a.isPlainObject(t) || t instanceof this.constructor)
      i(t, n);
    else if (a.isString(t) && (t = t.trim()) && !Yt(t))
      i(Qt(t), n);
    else if (a.isHeaders(t))
      for (const [c, f] of t.entries())
        o(f, c, r);
    else
      t != null && o(n, t, r);
    return this;
  }
  get(t, n) {
    if (t = D(t), t) {
      const r = a.findKey(this, t);
      if (r) {
        const s = this[r];
        if (!n)
          return s;
        if (n === !0)
          return Zt(s);
        if (a.isFunction(n))
          return n.call(this, s, r);
        if (a.isRegExp(n))
          return n.exec(s);
        throw new TypeError("parser must be boolean|regexp|function");
      }
    }
  }
  has(t, n) {
    if (t = D(t), t) {
      const r = a.findKey(this, t);
      return !!(r && this[r] !== void 0 && (!n || X(this, this[r], r, n)));
    }
    return !1;
  }
  delete(t, n) {
    const r = this;
    let s = !1;
    function o(i) {
      if (i = D(i), i) {
        const c = a.findKey(r, i);
        c && (!n || X(r, r[c], c, n)) && (delete r[c], s = !0);
      }
    }
    return a.isArray(t) ? t.forEach(o) : o(t), s;
  }
  clear(t) {
    const n = Object.keys(this);
    let r = n.length, s = !1;
    for (; r--; ) {
      const o = n[r];
      (!t || X(this, this[o], o, t, !0)) && (delete this[o], s = !0);
    }
    return s;
  }
  normalize(t) {
    const n = this, r = {};
    return a.forEach(this, (s, o) => {
      const i = a.findKey(r, o);
      if (i) {
        n[i] = I(s), delete n[o];
        return;
      }
      const c = t ? en(o) : String(o).trim();
      c !== o && delete n[o], n[c] = I(s), r[c] = !0;
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
    const r = (this[we] = this[we] = {
      accessors: {}
    }).accessors, s = this.prototype;
    function o(i) {
      const c = D(i);
      r[c] || (tn(s, i), r[c] = !0);
    }
    return a.isArray(t) ? t.forEach(o) : o(t), this;
  }
}
S.accessor(["Content-Type", "Content-Length", "Accept", "Accept-Encoding", "User-Agent", "Authorization"]);
a.reduceDescriptors(S.prototype, ({ value: e }, t) => {
  let n = t[0].toUpperCase() + t.slice(1);
  return {
    get: () => e,
    set(r) {
      this[n] = r;
    }
  };
});
a.freezeMethods(S);
function Q(e, t) {
  const n = this || q, r = t || n, s = S.from(r.headers);
  let o = r.data;
  return a.forEach(e, function(c) {
    o = c.call(n, o, s.normalize(), t ? t.status : void 0);
  }), s.normalize(), o;
}
function Ie(e) {
  return !!(e && e.__CANCEL__);
}
function B(e, t, n) {
  p.call(this, e ?? "canceled", p.ERR_CANCELED, t, n), this.name = "CanceledError";
}
a.inherits(B, p, {
  __CANCEL__: !0
});
function Me(e, t, n) {
  const r = n.config.validateStatus;
  !n.status || !r || r(n.status) ? e(n) : t(new p(
    "Request failed with status code " + n.status,
    [p.ERR_BAD_REQUEST, p.ERR_BAD_RESPONSE][Math.floor(n.status / 100) - 4],
    n.config,
    n.request,
    n
  ));
}
function nn(e) {
  const t = /^([-+\w]{1,25})(:?\/\/|:)/.exec(e);
  return t && t[1] || "";
}
function rn(e, t) {
  e = e || 10;
  const n = new Array(e), r = new Array(e);
  let s = 0, o = 0, i;
  return t = t !== void 0 ? t : 1e3, function(f) {
    const l = Date.now(), u = r[o];
    i || (i = l), n[s] = f, r[s] = l;
    let h = o, E = 0;
    for (; h !== s; )
      E += n[h++], h = h % e;
    if (s = (s + 1) % e, s === o && (o = (o + 1) % e), l - i < t)
      return;
    const y = u && l - u;
    return y ? Math.round(E * 1e3 / y) : void 0;
  };
}
function sn(e, t) {
  let n = 0;
  const r = 1e3 / t;
  let s = null;
  return function() {
    const i = this === !0, c = Date.now();
    if (i || c - n > r)
      return s && (clearTimeout(s), s = null), n = c, e.apply(null, arguments);
    s || (s = setTimeout(() => (s = null, n = Date.now(), e.apply(null, arguments)), r - (c - n)));
  };
}
const M = (e, t, n = 3) => {
  let r = 0;
  const s = rn(50, 250);
  return sn((o) => {
    const i = o.loaded, c = o.lengthComputable ? o.total : void 0, f = i - r, l = s(f), u = i <= c;
    r = i;
    const h = {
      loaded: i,
      total: c,
      progress: c ? i / c : void 0,
      bytes: f,
      rate: l || void 0,
      estimated: l && c && u ? (c - i) / l : void 0,
      event: o,
      lengthComputable: c != null
    };
    h[t ? "download" : "upload"] = !0, e(h);
  }, n);
}, on = T.hasStandardBrowserEnv ? (
  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  function() {
    const t = /(msie|trident)/i.test(navigator.userAgent), n = document.createElement("a");
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
), an = T.hasStandardBrowserEnv ? (
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
function cn(e) {
  return /^([a-z][a-z\d+\-.]*:)?\/\//i.test(e);
}
function un(e, t) {
  return t ? e.replace(/\/?\/$/, "") + "/" + t.replace(/^\/+/, "") : e;
}
function ze(e, t) {
  return e && !cn(t) ? un(e, t) : t;
}
const be = (e) => e instanceof S ? { ...e } : e;
function F(e, t) {
  t = t || {};
  const n = {};
  function r(l, u, h) {
    return a.isPlainObject(l) && a.isPlainObject(u) ? a.merge.call({ caseless: h }, l, u) : a.isPlainObject(u) ? a.merge({}, u) : a.isArray(u) ? u.slice() : u;
  }
  function s(l, u, h) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(l))
        return r(void 0, l, h);
    } else return r(l, u, h);
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
  function c(l, u, h) {
    if (h in t)
      return r(l, u);
    if (h in e)
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
    headers: (l, u) => s(be(l), be(u), !0)
  };
  return a.forEach(Object.keys(Object.assign({}, e, t)), function(u) {
    const h = f[u] || s, E = h(e[u], t[u], u);
    a.isUndefined(E) && h !== c || (n[u] = E);
  }), n;
}
const Je = (e) => {
  const t = F({}, e);
  let { data: n, withXSRFToken: r, xsrfHeaderName: s, xsrfCookieName: o, headers: i, auth: c } = t;
  t.headers = i = S.from(i), t.url = je(ze(t.baseURL, t.url), e.params, e.paramsSerializer), c && i.set(
    "Authorization",
    "Basic " + btoa((c.username || "") + ":" + (c.password ? unescape(encodeURIComponent(c.password)) : ""))
  );
  let f;
  if (a.isFormData(n)) {
    if (T.hasStandardBrowserEnv || T.hasStandardBrowserWebWorkerEnv)
      i.setContentType(void 0);
    else if ((f = i.getContentType()) !== !1) {
      const [l, ...u] = f ? f.split(";").map((h) => h.trim()).filter(Boolean) : [];
      i.setContentType([l || "multipart/form-data", ...u].join("; "));
    }
  }
  if (T.hasStandardBrowserEnv && (r && a.isFunction(r) && (r = r(t)), r || r !== !1 && on(t.url))) {
    const l = s && o && an.read(o);
    l && i.set(s, l);
  }
  return t;
}, ln = typeof XMLHttpRequest < "u", fn = ln && function(e) {
  return new Promise(function(n, r) {
    const s = Je(e);
    let o = s.data;
    const i = S.from(s.headers).normalize();
    let { responseType: c } = s, f;
    function l() {
      s.cancelToken && s.cancelToken.unsubscribe(f), s.signal && s.signal.removeEventListener("abort", f);
    }
    let u = new XMLHttpRequest();
    u.open(s.method.toUpperCase(), s.url, !0), u.timeout = s.timeout;
    function h() {
      if (!u)
        return;
      const y = S.from(
        "getAllResponseHeaders" in u && u.getAllResponseHeaders()
      ), m = {
        data: !c || c === "text" || c === "json" ? u.responseText : u.response,
        status: u.status,
        statusText: u.statusText,
        headers: y,
        config: e,
        request: u
      };
      Me(function(R) {
        n(R), l();
      }, function(R) {
        r(R), l();
      }, m), u = null;
    }
    "onloadend" in u ? u.onloadend = h : u.onreadystatechange = function() {
      !u || u.readyState !== 4 || u.status === 0 && !(u.responseURL && u.responseURL.indexOf("file:") === 0) || setTimeout(h);
    }, u.onabort = function() {
      u && (r(new p("Request aborted", p.ECONNABORTED, s, u)), u = null);
    }, u.onerror = function() {
      r(new p("Network Error", p.ERR_NETWORK, s, u)), u = null;
    }, u.ontimeout = function() {
      let d = s.timeout ? "timeout of " + s.timeout + "ms exceeded" : "timeout exceeded";
      const m = s.transitional || qe;
      s.timeoutErrorMessage && (d = s.timeoutErrorMessage), r(new p(
        d,
        m.clarifyTimeoutError ? p.ETIMEDOUT : p.ECONNABORTED,
        s,
        u
      )), u = null;
    }, o === void 0 && i.setContentType(null), "setRequestHeader" in u && a.forEach(i.toJSON(), function(d, m) {
      u.setRequestHeader(m, d);
    }), a.isUndefined(s.withCredentials) || (u.withCredentials = !!s.withCredentials), c && c !== "json" && (u.responseType = s.responseType), typeof s.onDownloadProgress == "function" && u.addEventListener("progress", M(s.onDownloadProgress, !0)), typeof s.onUploadProgress == "function" && u.upload && u.upload.addEventListener("progress", M(s.onUploadProgress)), (s.cancelToken || s.signal) && (f = (y) => {
      u && (r(!y || y.type ? new B(null, e, u) : y), u.abort(), u = null);
    }, s.cancelToken && s.cancelToken.subscribe(f), s.signal && (s.signal.aborted ? f() : s.signal.addEventListener("abort", f)));
    const E = nn(s.url);
    if (E && T.protocols.indexOf(E) === -1) {
      r(new p("Unsupported protocol " + E + ":", p.ERR_BAD_REQUEST, e));
      return;
    }
    u.send(o || null);
  });
}, dn = (e, t) => {
  let n = new AbortController(), r;
  const s = function(f) {
    if (!r) {
      r = !0, i();
      const l = f instanceof Error ? f : this.reason;
      n.abort(l instanceof p ? l : new B(l instanceof Error ? l.message : l));
    }
  };
  let o = t && setTimeout(() => {
    s(new p(`timeout ${t} of ms exceeded`, p.ETIMEDOUT));
  }, t);
  const i = () => {
    e && (o && clearTimeout(o), o = null, e.forEach((f) => {
      f && (f.removeEventListener ? f.removeEventListener("abort", s) : f.unsubscribe(s));
    }), e = null);
  };
  e.forEach((f) => f && f.addEventListener && f.addEventListener("abort", s));
  const { signal: c } = n;
  return c.unsubscribe = i, [c, () => {
    o && clearTimeout(o), o = null;
  }];
}, hn = function* (e, t) {
  let n = e.byteLength;
  if (!t || n < t) {
    yield e;
    return;
  }
  let r = 0, s;
  for (; r < n; )
    s = r + t, yield e.slice(r, s), r = s;
}, pn = async function* (e, t, n) {
  for await (const r of e)
    yield* hn(ArrayBuffer.isView(r) ? r : await n(String(r)), t);
}, Ee = (e, t, n, r, s) => {
  const o = pn(e, t, s);
  let i = 0;
  return new ReadableStream({
    type: "bytes",
    async pull(c) {
      const { done: f, value: l } = await o.next();
      if (f) {
        c.close(), r();
        return;
      }
      let u = l.byteLength;
      n && n(i += u), c.enqueue(new Uint8Array(l));
    },
    cancel(c) {
      return r(c), o.return();
    }
  }, {
    highWaterMark: 2
  });
}, ge = (e, t) => {
  const n = e != null;
  return (r) => setTimeout(() => t({
    lengthComputable: n,
    total: e,
    loaded: r
  }));
}, K = typeof fetch == "function" && typeof Request == "function" && typeof Response == "function", Ve = K && typeof ReadableStream == "function", te = K && (typeof TextEncoder == "function" ? /* @__PURE__ */ ((e) => (t) => e.encode(t))(new TextEncoder()) : async (e) => new Uint8Array(await new Response(e).arrayBuffer())), mn = Ve && (() => {
  let e = !1;
  const t = new Request(T.origin, {
    body: new ReadableStream(),
    method: "POST",
    get duplex() {
      return e = !0, "half";
    }
  }).headers.has("Content-Type");
  return e && !t;
})(), Re = 64 * 1024, ne = Ve && !!(() => {
  try {
    return a.isReadableStream(new Response("").body);
  } catch {
  }
})(), z = {
  stream: ne && ((e) => e.body)
};
K && ((e) => {
  ["text", "arrayBuffer", "blob", "formData", "stream"].forEach((t) => {
    !z[t] && (z[t] = a.isFunction(e[t]) ? (n) => n[t]() : (n, r) => {
      throw new p(`Response type '${t}' is not supported`, p.ERR_NOT_SUPPORT, r);
    });
  });
})(new Response());
const yn = async (e) => {
  if (e == null)
    return 0;
  if (a.isBlob(e))
    return e.size;
  if (a.isSpecCompliantForm(e))
    return (await new Request(e).arrayBuffer()).byteLength;
  if (a.isArrayBufferView(e))
    return e.byteLength;
  if (a.isURLSearchParams(e) && (e = e + ""), a.isString(e))
    return (await te(e)).byteLength;
}, wn = async (e, t) => {
  const n = a.toFiniteNumber(e.getContentLength());
  return n ?? yn(t);
}, bn = K && (async (e) => {
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
    withCredentials: h = "same-origin",
    fetchOptions: E
  } = Je(e);
  l = l ? (l + "").toLowerCase() : "text";
  let [y, d] = s || o || i ? dn([s, o], i) : [], m, g;
  const R = () => {
    !m && setTimeout(() => {
      y && y.unsubscribe();
    }), m = !0;
  };
  let x;
  try {
    if (f && mn && n !== "get" && n !== "head" && (x = await wn(u, r)) !== 0) {
      let C = new Request(t, {
        method: "POST",
        body: r,
        duplex: "half"
      }), _;
      a.isFormData(r) && (_ = C.headers.get("content-type")) && u.setContentType(_), C.body && (r = Ee(C.body, Re, ge(
        x,
        M(f)
      ), null, te));
    }
    a.isString(h) || (h = h ? "cors" : "omit"), g = new Request(t, {
      ...E,
      signal: y,
      method: n.toUpperCase(),
      headers: u.normalize().toJSON(),
      body: r,
      duplex: "half",
      withCredentials: h
    });
    let w = await fetch(g);
    const U = ne && (l === "stream" || l === "response");
    if (ne && (c || U)) {
      const C = {};
      ["status", "statusText", "headers"].forEach((fe) => {
        C[fe] = w[fe];
      });
      const _ = a.toFiniteNumber(w.headers.get("content-length"));
      w = new Response(
        Ee(w.body, Re, c && ge(
          _,
          M(c, !0)
        ), U && R, te),
        C
      );
    }
    l = l || "text";
    let ve = await z[a.findKey(z, l) || "text"](w, e);
    return !U && R(), d && d(), await new Promise((C, _) => {
      Me(C, _, {
        data: ve,
        headers: S.from(w.headers),
        status: w.status,
        statusText: w.statusText,
        config: e,
        request: g
      });
    });
  } catch (w) {
    throw R(), w && w.name === "TypeError" && /fetch/i.test(w.message) ? Object.assign(
      new p("Network Error", p.ERR_NETWORK, e, g),
      {
        cause: w.cause || w
      }
    ) : p.from(w, w && w.code, e, g);
  }
}), re = {
  http: Ut,
  xhr: fn,
  fetch: bn
};
a.forEach(re, (e, t) => {
  if (e) {
    try {
      Object.defineProperty(e, "name", { value: t });
    } catch {
    }
    Object.defineProperty(e, "adapterName", { value: t });
  }
});
const Se = (e) => `- ${e}`, En = (e) => a.isFunction(e) || e === null || e === !1, We = {
  getAdapter: (e) => {
    e = a.isArray(e) ? e : [e];
    const { length: t } = e;
    let n, r;
    const s = {};
    for (let o = 0; o < t; o++) {
      n = e[o];
      let i;
      if (r = n, !En(n) && (r = re[(i = String(n)).toLowerCase()], r === void 0))
        throw new p(`Unknown adapter '${i}'`);
      if (r)
        break;
      s[i || "#" + o] = r;
    }
    if (!r) {
      const o = Object.entries(s).map(
        ([c, f]) => `adapter ${c} ` + (f === !1 ? "is not supported by the environment" : "is not available in the build")
      );
      let i = t ? o.length > 1 ? `since :
` + o.map(Se).join(`
`) : " " + Se(o[0]) : "as no adapter specified";
      throw new p(
        "There is no suitable adapter to dispatch the request " + i,
        "ERR_NOT_SUPPORT"
      );
    }
    return r;
  },
  adapters: re
};
function Z(e) {
  if (e.cancelToken && e.cancelToken.throwIfRequested(), e.signal && e.signal.aborted)
    throw new B(null, e);
}
function Oe(e) {
  return Z(e), e.headers = S.from(e.headers), e.data = Q.call(
    e,
    e.transformRequest
  ), ["post", "put", "patch"].indexOf(e.method) !== -1 && e.headers.setContentType("application/x-www-form-urlencoded", !1), We.getAdapter(e.adapter || q.adapter)(e).then(function(r) {
    return Z(e), r.data = Q.call(
      e,
      e.transformResponse,
      r
    ), r.headers = S.from(r.headers), r;
  }, function(r) {
    return Ie(r) || (Z(e), r && r.response && (r.response.data = Q.call(
      e,
      e.transformResponse,
      r.response
    ), r.response.headers = S.from(r.response.headers))), Promise.reject(r);
  });
}
const $e = "1.7.2", ue = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach((e, t) => {
  ue[e] = function(r) {
    return typeof r === e || "a" + (t < 1 ? "n " : " ") + e;
  };
});
const Te = {};
ue.transitional = function(t, n, r) {
  function s(o, i) {
    return "[Axios v" + $e + "] Transitional option '" + o + "'" + i + (r ? ". " + r : "");
  }
  return (o, i, c) => {
    if (t === !1)
      throw new p(
        s(i, " has been removed" + (n ? " in " + n : "")),
        p.ERR_DEPRECATED
      );
    return n && !Te[i] && (Te[i] = !0, console.warn(
      s(
        i,
        " has been deprecated since v" + n + " and will be removed in the near future"
      )
    )), t ? t(o, i, c) : !0;
  };
};
function gn(e, t, n) {
  if (typeof e != "object")
    throw new p("options must be an object", p.ERR_BAD_OPTION_VALUE);
  const r = Object.keys(e);
  let s = r.length;
  for (; s-- > 0; ) {
    const o = r[s], i = t[o];
    if (i) {
      const c = e[o], f = c === void 0 || i(c, o, e);
      if (f !== !0)
        throw new p("option " + o + " must be " + f, p.ERR_BAD_OPTION_VALUE);
      continue;
    }
    if (n !== !0)
      throw new p("Unknown option " + o, p.ERR_BAD_OPTION);
  }
}
const se = {
  assertOptions: gn,
  validators: ue
}, N = se.validators;
class P {
  constructor(t) {
    this.defaults = t, this.interceptors = {
      request: new ye(),
      response: new ye()
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
    typeof t == "string" ? (n = n || {}, n.url = t) : n = t || {}, n = F(this.defaults, n);
    const { transitional: r, paramsSerializer: s, headers: o } = n;
    r !== void 0 && se.assertOptions(r, {
      silentJSONParsing: N.transitional(N.boolean),
      forcedJSONParsing: N.transitional(N.boolean),
      clarifyTimeoutError: N.transitional(N.boolean)
    }, !1), s != null && (a.isFunction(s) ? n.paramsSerializer = {
      serialize: s
    } : se.assertOptions(s, {
      encode: N.function,
      serialize: N.function
    }, !0)), n.method = (n.method || this.defaults.method || "get").toLowerCase();
    let i = o && a.merge(
      o.common,
      o[n.method]
    );
    o && a.forEach(
      ["delete", "get", "head", "post", "put", "patch", "common"],
      (d) => {
        delete o[d];
      }
    ), n.headers = S.concat(i, o);
    const c = [];
    let f = !0;
    this.interceptors.request.forEach(function(m) {
      typeof m.runWhen == "function" && m.runWhen(n) === !1 || (f = f && m.synchronous, c.unshift(m.fulfilled, m.rejected));
    });
    const l = [];
    this.interceptors.response.forEach(function(m) {
      l.push(m.fulfilled, m.rejected);
    });
    let u, h = 0, E;
    if (!f) {
      const d = [Oe.bind(this), void 0];
      for (d.unshift.apply(d, c), d.push.apply(d, l), E = d.length, u = Promise.resolve(n); h < E; )
        u = u.then(d[h++], d[h++]);
      return u;
    }
    E = c.length;
    let y = n;
    for (h = 0; h < E; ) {
      const d = c[h++], m = c[h++];
      try {
        y = d(y);
      } catch (g) {
        m.call(this, g);
        break;
      }
    }
    try {
      u = Oe.call(this, y);
    } catch (d) {
      return Promise.reject(d);
    }
    for (h = 0, E = l.length; h < E; )
      u = u.then(l[h++], l[h++]);
    return u;
  }
  getUri(t) {
    t = F(this.defaults, t);
    const n = ze(t.baseURL, t.url);
    return je(n, t.params, t.paramsSerializer);
  }
}
a.forEach(["delete", "get", "head", "options"], function(t) {
  P.prototype[t] = function(n, r) {
    return this.request(F(r || {}, {
      method: t,
      url: n,
      data: (r || {}).data
    }));
  };
});
a.forEach(["post", "put", "patch"], function(t) {
  function n(r) {
    return function(o, i, c) {
      return this.request(F(c || {}, {
        method: t,
        headers: r ? {
          "Content-Type": "multipart/form-data"
        } : {},
        url: o,
        data: i
      }));
    };
  }
  P.prototype[t] = n(), P.prototype[t + "Form"] = n(!0);
});
class le {
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
      r.reason || (r.reason = new B(o, i, c), n(r.reason));
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
  /**
   * Returns an object that contains a new `CancelToken` and a function that, when called,
   * cancels the `CancelToken`.
   */
  static source() {
    let t;
    return {
      token: new le(function(s) {
        t = s;
      }),
      cancel: t
    };
  }
}
function Rn(e) {
  return function(n) {
    return e.apply(null, n);
  };
}
function Sn(e) {
  return a.isObject(e) && e.isAxiosError === !0;
}
const oe = {
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
Object.entries(oe).forEach(([e, t]) => {
  oe[t] = e;
});
function Ke(e) {
  const t = new P(e), n = Ae(P.prototype.request, t);
  return a.extend(n, P.prototype, t, { allOwnKeys: !0 }), a.extend(n, t, null, { allOwnKeys: !0 }), n.create = function(s) {
    return Ke(F(e, s));
  }, n;
}
const b = Ke(q);
b.Axios = P;
b.CanceledError = B;
b.CancelToken = le;
b.isCancel = Ie;
b.VERSION = $e;
b.toFormData = $;
b.AxiosError = p;
b.Cancel = b.CanceledError;
b.all = function(t) {
  return Promise.all(t);
};
b.spread = Rn;
b.isAxiosError = Sn;
b.mergeConfig = F;
b.AxiosHeaders = S;
b.formToJSON = (e) => He(a.isHTMLForm(e) ? new FormData(e) : e);
b.getAdapter = We.getAdapter;
b.HttpStatusCode = oe;
b.default = b;
const An = Ge("auth", {
  persist: !0,
  state: () => ({
    user: null,
    loading: !1,
    error: null
  }),
  getters: {
    isAuthenticated: (e) => e.user !== null
  },
  actions: {
    setUser(e) {
      this.user = e;
    },
    unsetUser() {
      this.user = null;
    },
    async login(e) {
      this.loading = !0, this.error = null, b.post("/account/login", e).then((t) => {
        this.setUser(t.data);
      }).catch((t) => {
        this.error = {
          ...t.response.data,
          style: v.Danger,
          closeBtn: !0
        };
      }).finally(() => {
        this.loading = !1;
      });
    },
    async check() {
      this.loading = !0, this.error = null, b.get("/account/auth-check").then((e) => {
        this.setUser(e.data.user);
      }).catch((e) => {
        this.unsetUser(), this.error = {
          ...e.response.data,
          style: v.Danger,
          closeBtn: !0
        };
      }).finally(() => {
        this.loading = !1;
      });
    },
    async logout() {
      this.loading = !0, this.error = null, this.unsetUser(), b.get("/account/logout").catch((e) => {
        this.error = {
          ...e.response.data,
          style: v.Danger,
          closeBtn: !0
        };
      }).finally(() => {
        this.loading = !1;
      });
    }
  }
});
export {
  An as useAuthStore
};
