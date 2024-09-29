import { ref as at, resolveComponent as re, openBlock as H, createElementBlock as M, Fragment as se, createElementVNode as d, createVNode as N, withCtx as j, renderList as Se, toDisplayString as C, createTextVNode as lt } from "vue";
function ve(e, t) {
  return function() {
    return e.apply(t, arguments);
  };
}
const { toString: ct } = Object.prototype, { getPrototypeOf: ye } = Object, Z = /* @__PURE__ */ ((e) => (t) => {
  const r = ct.call(t);
  return e[r] || (e[r] = r.slice(8, -1).toLowerCase());
})(/* @__PURE__ */ Object.create(null)), _ = (e) => (e = e.toLowerCase(), (t) => Z(t) === e), Y = (e) => (t) => typeof t === e, { isArray: q } = Array, J = Y("undefined");
function ut(e) {
  return e !== null && !J(e) && e.constructor !== null && !J(e.constructor) && k(e.constructor.isBuffer) && e.constructor.isBuffer(e);
}
const je = _("ArrayBuffer");
function ft(e) {
  let t;
  return typeof ArrayBuffer < "u" && ArrayBuffer.isView ? t = ArrayBuffer.isView(e) : t = e && e.buffer && je(e.buffer), t;
}
const dt = Y("string"), k = Y("function"), qe = Y("number"), ee = (e) => e !== null && typeof e == "object", pt = (e) => e === !0 || e === !1, K = (e) => {
  if (Z(e) !== "object")
    return !1;
  const t = ye(e);
  return (t === null || t === Object.prototype || Object.getPrototypeOf(t) === null) && !(Symbol.toStringTag in e) && !(Symbol.iterator in e);
}, ht = _("Date"), mt = _("File"), yt = _("Blob"), bt = _("FileList"), wt = (e) => ee(e) && k(e.pipe), Et = (e) => {
  let t;
  return e && (typeof FormData == "function" && e instanceof FormData || k(e.append) && ((t = Z(e)) === "formdata" || // detect form-data instance
  t === "object" && k(e.toString) && e.toString() === "[object FormData]"));
}, gt = _("URLSearchParams"), [Rt, St, Ot, Tt] = ["ReadableStream", "Request", "Response", "Headers"].map(_), At = (e) => e.trim ? e.trim() : e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
function V(e, t, { allOwnKeys: r = !1 } = {}) {
  if (e === null || typeof e > "u")
    return;
  let n, s;
  if (typeof e != "object" && (e = [e]), q(e))
    for (n = 0, s = e.length; n < s; n++)
      t.call(null, e[n], n, e);
  else {
    const o = r ? Object.getOwnPropertyNames(e) : Object.keys(e), i = o.length;
    let l;
    for (n = 0; n < i; n++)
      l = o[n], t.call(null, e[l], l, e);
  }
}
function Ie(e, t) {
  t = t.toLowerCase();
  const r = Object.keys(e);
  let n = r.length, s;
  for (; n-- > 0; )
    if (s = r[n], t === s.toLowerCase())
      return s;
  return null;
}
const D = typeof globalThis < "u" ? globalThis : typeof self < "u" ? self : typeof window < "u" ? window : global, He = (e) => !J(e) && e !== D;
function ce() {
  const { caseless: e } = He(this) && this || {}, t = {}, r = (n, s) => {
    const o = e && Ie(t, s) || s;
    K(t[o]) && K(n) ? t[o] = ce(t[o], n) : K(n) ? t[o] = ce({}, n) : q(n) ? t[o] = n.slice() : t[o] = n;
  };
  for (let n = 0, s = arguments.length; n < s; n++)
    arguments[n] && V(arguments[n], r);
  return t;
}
const xt = (e, t, r, { allOwnKeys: n } = {}) => (V(t, (s, o) => {
  r && k(s) ? e[o] = ve(s, r) : e[o] = s;
}, { allOwnKeys: n }), e), kt = (e) => (e.charCodeAt(0) === 65279 && (e = e.slice(1)), e), Ct = (e, t, r, n) => {
  e.prototype = Object.create(t.prototype, n), e.prototype.constructor = e, Object.defineProperty(e, "super", {
    value: t.prototype
  }), r && Object.assign(e.prototype, r);
}, _t = (e, t, r, n) => {
  let s, o, i;
  const l = {};
  if (t = t || {}, e == null) return t;
  do {
    for (s = Object.getOwnPropertyNames(e), o = s.length; o-- > 0; )
      i = s[o], (!n || n(i, e, t)) && !l[i] && (t[i] = e[i], l[i] = !0);
    e = r !== !1 && ye(e);
  } while (e && (!r || r(e, t)) && e !== Object.prototype);
  return t;
}, Nt = (e, t, r) => {
  e = String(e), (r === void 0 || r > e.length) && (r = e.length), r -= t.length;
  const n = e.indexOf(t, r);
  return n !== -1 && n === r;
}, Pt = (e) => {
  if (!e) return null;
  if (q(e)) return e;
  let t = e.length;
  if (!qe(t)) return null;
  const r = new Array(t);
  for (; t-- > 0; )
    r[t] = e[t];
  return r;
}, Ft = /* @__PURE__ */ ((e) => (t) => e && t instanceof e)(typeof Uint8Array < "u" && ye(Uint8Array)), Lt = (e, t) => {
  const n = (e && e[Symbol.iterator]).call(e);
  let s;
  for (; (s = n.next()) && !s.done; ) {
    const o = s.value;
    t.call(e, o[0], o[1]);
  }
}, Bt = (e, t) => {
  let r;
  const n = [];
  for (; (r = e.exec(t)) !== null; )
    n.push(r);
  return n;
}, Dt = _("HTMLFormElement"), Ut = (e) => e.toLowerCase().replace(
  /[-_\s]([a-z\d])(\w*)/g,
  function(r, n, s) {
    return n.toUpperCase() + s;
  }
), Oe = (({ hasOwnProperty: e }) => (t, r) => e.call(t, r))(Object.prototype), vt = _("RegExp"), Me = (e, t) => {
  const r = Object.getOwnPropertyDescriptors(e), n = {};
  V(r, (s, o) => {
    let i;
    (i = t(s, o, e)) !== !1 && (n[o] = i || s);
  }), Object.defineProperties(e, n);
}, jt = (e) => {
  Me(e, (t, r) => {
    if (k(e) && ["arguments", "caller", "callee"].indexOf(r) !== -1)
      return !1;
    const n = e[r];
    if (k(n)) {
      if (t.enumerable = !1, "writable" in t) {
        t.writable = !1;
        return;
      }
      t.set || (t.set = () => {
        throw Error("Can not rewrite read-only method '" + r + "'");
      });
    }
  });
}, qt = (e, t) => {
  const r = {}, n = (s) => {
    s.forEach((o) => {
      r[o] = !0;
    });
  };
  return q(e) ? n(e) : n(String(e).split(t)), r;
}, It = () => {
}, Ht = (e, t) => e != null && Number.isFinite(e = +e) ? e : t, oe = "abcdefghijklmnopqrstuvwxyz", Te = "0123456789", ze = {
  DIGIT: Te,
  ALPHA: oe,
  ALPHA_DIGIT: oe + oe.toUpperCase() + Te
}, Mt = (e = 16, t = ze.ALPHA_DIGIT) => {
  let r = "";
  const { length: n } = t;
  for (; e--; )
    r += t[Math.random() * n | 0];
  return r;
};
function zt(e) {
  return !!(e && k(e.append) && e[Symbol.toStringTag] === "FormData" && e[Symbol.iterator]);
}
const Jt = (e) => {
  const t = new Array(10), r = (n, s) => {
    if (ee(n)) {
      if (t.indexOf(n) >= 0)
        return;
      if (!("toJSON" in n)) {
        t[s] = n;
        const o = q(n) ? [] : {};
        return V(n, (i, l) => {
          const f = r(i, s + 1);
          !J(f) && (o[l] = f);
        }), t[s] = void 0, o;
      }
    }
    return n;
  };
  return r(e, 0);
}, Vt = _("AsyncFunction"), Wt = (e) => e && (ee(e) || k(e)) && k(e.then) && k(e.catch), Je = ((e, t) => e ? setImmediate : t ? ((r, n) => (D.addEventListener("message", ({ source: s, data: o }) => {
  s === D && o === r && n.length && n.shift()();
}, !1), (s) => {
  n.push(s), D.postMessage(r, "*");
}))(`axios@${Math.random()}`, []) : (r) => setTimeout(r))(
  typeof setImmediate == "function",
  k(D.postMessage)
), $t = typeof queueMicrotask < "u" ? queueMicrotask.bind(D) : typeof process < "u" && process.nextTick || Je, a = {
  isArray: q,
  isArrayBuffer: je,
  isBuffer: ut,
  isFormData: Et,
  isArrayBufferView: ft,
  isString: dt,
  isNumber: qe,
  isBoolean: pt,
  isObject: ee,
  isPlainObject: K,
  isReadableStream: Rt,
  isRequest: St,
  isResponse: Ot,
  isHeaders: Tt,
  isUndefined: J,
  isDate: ht,
  isFile: mt,
  isBlob: yt,
  isRegExp: vt,
  isFunction: k,
  isStream: wt,
  isURLSearchParams: gt,
  isTypedArray: Ft,
  isFileList: bt,
  forEach: V,
  merge: ce,
  extend: xt,
  trim: At,
  stripBOM: kt,
  inherits: Ct,
  toFlatObject: _t,
  kindOf: Z,
  kindOfTest: _,
  endsWith: Nt,
  toArray: Pt,
  forEachEntry: Lt,
  matchAll: Bt,
  isHTMLForm: Dt,
  hasOwnProperty: Oe,
  hasOwnProp: Oe,
  // an alias to avoid ESLint no-prototype-builtins detection
  reduceDescriptors: Me,
  freezeMethods: jt,
  toObjectSet: qt,
  toCamelCase: Ut,
  noop: It,
  toFiniteNumber: Ht,
  findKey: Ie,
  global: D,
  isContextDefined: He,
  ALPHABET: ze,
  generateString: Mt,
  isSpecCompliantForm: zt,
  toJSONObject: Jt,
  isAsyncFn: Vt,
  isThenable: Wt,
  setImmediate: Je,
  asap: $t
};
function y(e, t, r, n, s) {
  Error.call(this), Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : this.stack = new Error().stack, this.message = e, this.name = "AxiosError", t && (this.code = t), r && (this.config = r), n && (this.request = n), s && (this.response = s, this.status = s.status ? s.status : null);
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
const Ve = y.prototype, We = {};
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
  We[e] = { value: e };
});
Object.defineProperties(y, We);
Object.defineProperty(Ve, "isAxiosError", { value: !0 });
y.from = (e, t, r, n, s, o) => {
  const i = Object.create(Ve);
  return a.toFlatObject(e, i, function(f) {
    return f !== Error.prototype;
  }, (l) => l !== "isAxiosError"), y.call(i, e.message, t, r, n, s), i.cause = e, i.name = e.name, o && Object.assign(i, o), i;
};
const Kt = null;
function ue(e) {
  return a.isPlainObject(e) || a.isArray(e);
}
function $e(e) {
  return a.endsWith(e, "[]") ? e.slice(0, -2) : e;
}
function Ae(e, t, r) {
  return e ? e.concat(t).map(function(s, o) {
    return s = $e(s), !r && o ? "[" + s + "]" : s;
  }).join(r ? "." : "") : t;
}
function Gt(e) {
  return a.isArray(e) && !e.some(ue);
}
const Xt = a.toFlatObject(a, {}, null, function(t) {
  return /^is[A-Z]/.test(t);
});
function te(e, t, r) {
  if (!a.isObject(e))
    throw new TypeError("target must be an object");
  t = t || new FormData(), r = a.toFlatObject(r, {
    metaTokens: !0,
    dots: !1,
    indexes: !1
  }, !1, function(b, m) {
    return !a.isUndefined(m[b]);
  });
  const n = r.metaTokens, s = r.visitor || u, o = r.dots, i = r.indexes, f = (r.Blob || typeof Blob < "u" && Blob) && a.isSpecCompliantForm(t);
  if (!a.isFunction(s))
    throw new TypeError("visitor must be a function");
  function c(h) {
    if (h === null) return "";
    if (a.isDate(h))
      return h.toISOString();
    if (!f && a.isBlob(h))
      throw new y("Blob is not supported. Use a Buffer instead.");
    return a.isArrayBuffer(h) || a.isTypedArray(h) ? f && typeof Blob == "function" ? new Blob([h]) : Buffer.from(h) : h;
  }
  function u(h, b, m) {
    let E = h;
    if (h && !m && typeof h == "object") {
      if (a.endsWith(b, "{}"))
        b = n ? b : b.slice(0, -2), h = JSON.stringify(h);
      else if (a.isArray(h) && Gt(h) || (a.isFileList(h) || a.endsWith(b, "[]")) && (E = a.toArray(h)))
        return b = $e(b), E.forEach(function(O, P) {
          !(a.isUndefined(O) || O === null) && t.append(
            // eslint-disable-next-line no-nested-ternary
            i === !0 ? Ae([b], P, o) : i === null ? b : b + "[]",
            c(O)
          );
        }), !1;
    }
    return ue(h) ? !0 : (t.append(Ae(m, b, o), c(h)), !1);
  }
  const p = [], w = Object.assign(Xt, {
    defaultVisitor: u,
    convertValue: c,
    isVisitable: ue
  });
  function R(h, b) {
    if (!a.isUndefined(h)) {
      if (p.indexOf(h) !== -1)
        throw Error("Circular reference detected in " + b.join("."));
      p.push(h), a.forEach(h, function(E, S) {
        (!(a.isUndefined(E) || E === null) && s.call(
          t,
          E,
          a.isString(S) ? S.trim() : S,
          b,
          w
        )) === !0 && R(E, b ? b.concat(S) : [S]);
      }), p.pop();
    }
  }
  if (!a.isObject(e))
    throw new TypeError("data must be an object");
  return R(e), t;
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
  return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g, function(n) {
    return t[n];
  });
}
function be(e, t) {
  this._pairs = [], e && te(e, this, t);
}
const Ke = be.prototype;
Ke.append = function(t, r) {
  this._pairs.push([t, r]);
};
Ke.toString = function(t) {
  const r = t ? function(n) {
    return t.call(this, n, xe);
  } : xe;
  return this._pairs.map(function(s) {
    return r(s[0]) + "=" + r(s[1]);
  }, "").join("&");
};
function Qt(e) {
  return encodeURIComponent(e).replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]");
}
function Ge(e, t, r) {
  if (!t)
    return e;
  const n = r && r.encode || Qt, s = r && r.serialize;
  let o;
  if (s ? o = s(t, r) : o = a.isURLSearchParams(t) ? t.toString() : new be(t, r).toString(n), o) {
    const i = e.indexOf("#");
    i !== -1 && (e = e.slice(0, i)), e += (e.indexOf("?") === -1 ? "?" : "&") + o;
  }
  return e;
}
class ke {
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
  use(t, r, n) {
    return this.handlers.push({
      fulfilled: t,
      rejected: r,
      synchronous: n ? n.synchronous : !1,
      runWhen: n ? n.runWhen : null
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
    a.forEach(this.handlers, function(n) {
      n !== null && t(n);
    });
  }
}
const Xe = {
  silentJSONParsing: !0,
  forcedJSONParsing: !0,
  clarifyTimeoutError: !1
}, Zt = typeof URLSearchParams < "u" ? URLSearchParams : be, Yt = typeof FormData < "u" ? FormData : null, en = typeof Blob < "u" ? Blob : null, tn = {
  isBrowser: !0,
  classes: {
    URLSearchParams: Zt,
    FormData: Yt,
    Blob: en
  },
  protocols: ["http", "https", "file", "blob", "url", "data"]
}, we = typeof window < "u" && typeof document < "u", fe = typeof navigator == "object" && navigator || void 0, nn = we && (!fe || ["ReactNative", "NativeScript", "NS"].indexOf(fe.product) < 0), rn = typeof WorkerGlobalScope < "u" && // eslint-disable-next-line no-undef
self instanceof WorkerGlobalScope && typeof self.importScripts == "function", sn = we && window.location.href || "http://localhost", on = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  hasBrowserEnv: we,
  hasStandardBrowserEnv: nn,
  hasStandardBrowserWebWorkerEnv: rn,
  navigator: fe,
  origin: sn
}, Symbol.toStringTag, { value: "Module" })), A = {
  ...on,
  ...tn
};
function an(e, t) {
  return te(e, new A.classes.URLSearchParams(), Object.assign({
    visitor: function(r, n, s, o) {
      return A.isNode && a.isBuffer(r) ? (this.append(n, r.toString("base64")), !1) : o.defaultVisitor.apply(this, arguments);
    }
  }, t));
}
function ln(e) {
  return a.matchAll(/\w+|\[(\w*)]/g, e).map((t) => t[0] === "[]" ? "" : t[1] || t[0]);
}
function cn(e) {
  const t = {}, r = Object.keys(e);
  let n;
  const s = r.length;
  let o;
  for (n = 0; n < s; n++)
    o = r[n], t[o] = e[o];
  return t;
}
function Qe(e) {
  function t(r, n, s, o) {
    let i = r[o++];
    if (i === "__proto__") return !0;
    const l = Number.isFinite(+i), f = o >= r.length;
    return i = !i && a.isArray(s) ? s.length : i, f ? (a.hasOwnProp(s, i) ? s[i] = [s[i], n] : s[i] = n, !l) : ((!s[i] || !a.isObject(s[i])) && (s[i] = []), t(r, n, s[i], o) && a.isArray(s[i]) && (s[i] = cn(s[i])), !l);
  }
  if (a.isFormData(e) && a.isFunction(e.entries)) {
    const r = {};
    return a.forEachEntry(e, (n, s) => {
      t(ln(n), s, r, 0);
    }), r;
  }
  return null;
}
function un(e, t, r) {
  if (a.isString(e))
    try {
      return (t || JSON.parse)(e), a.trim(e);
    } catch (n) {
      if (n.name !== "SyntaxError")
        throw n;
    }
  return (0, JSON.stringify)(e);
}
const W = {
  transitional: Xe,
  adapter: ["xhr", "http", "fetch"],
  transformRequest: [function(t, r) {
    const n = r.getContentType() || "", s = n.indexOf("application/json") > -1, o = a.isObject(t);
    if (o && a.isHTMLForm(t) && (t = new FormData(t)), a.isFormData(t))
      return s ? JSON.stringify(Qe(t)) : t;
    if (a.isArrayBuffer(t) || a.isBuffer(t) || a.isStream(t) || a.isFile(t) || a.isBlob(t) || a.isReadableStream(t))
      return t;
    if (a.isArrayBufferView(t))
      return t.buffer;
    if (a.isURLSearchParams(t))
      return r.setContentType("application/x-www-form-urlencoded;charset=utf-8", !1), t.toString();
    let l;
    if (o) {
      if (n.indexOf("application/x-www-form-urlencoded") > -1)
        return an(t, this.formSerializer).toString();
      if ((l = a.isFileList(t)) || n.indexOf("multipart/form-data") > -1) {
        const f = this.env && this.env.FormData;
        return te(
          l ? { "files[]": t } : t,
          f && new f(),
          this.formSerializer
        );
      }
    }
    return o || s ? (r.setContentType("application/json", !1), un(t)) : t;
  }],
  transformResponse: [function(t) {
    const r = this.transitional || W.transitional, n = r && r.forcedJSONParsing, s = this.responseType === "json";
    if (a.isResponse(t) || a.isReadableStream(t))
      return t;
    if (t && a.isString(t) && (n && !this.responseType || s)) {
      const i = !(r && r.silentJSONParsing) && s;
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
  W.headers[e] = {};
});
const fn = a.toObjectSet([
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
]), dn = (e) => {
  const t = {};
  let r, n, s;
  return e && e.split(`
`).forEach(function(i) {
    s = i.indexOf(":"), r = i.substring(0, s).trim().toLowerCase(), n = i.substring(s + 1).trim(), !(!r || t[r] && fn[r]) && (r === "set-cookie" ? t[r] ? t[r].push(n) : t[r] = [n] : t[r] = t[r] ? t[r] + ", " + n : n);
  }), t;
}, Ce = Symbol("internals");
function z(e) {
  return e && String(e).trim().toLowerCase();
}
function G(e) {
  return e === !1 || e == null ? e : a.isArray(e) ? e.map(G) : String(e);
}
function pn(e) {
  const t = /* @__PURE__ */ Object.create(null), r = /([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;
  let n;
  for (; n = r.exec(e); )
    t[n[1]] = n[2];
  return t;
}
const hn = (e) => /^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());
function ie(e, t, r, n, s) {
  if (a.isFunction(n))
    return n.call(this, t, r);
  if (s && (t = r), !!a.isString(t)) {
    if (a.isString(n))
      return t.indexOf(n) !== -1;
    if (a.isRegExp(n))
      return n.test(t);
  }
}
function mn(e) {
  return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g, (t, r, n) => r.toUpperCase() + n);
}
function yn(e, t) {
  const r = a.toCamelCase(" " + t);
  ["get", "set", "has"].forEach((n) => {
    Object.defineProperty(e, n + r, {
      value: function(s, o, i) {
        return this[n].call(this, t, s, o, i);
      },
      configurable: !0
    });
  });
}
class x {
  constructor(t) {
    t && this.set(t);
  }
  set(t, r, n) {
    const s = this;
    function o(l, f, c) {
      const u = z(f);
      if (!u)
        throw new Error("header name must be a non-empty string");
      const p = a.findKey(s, u);
      (!p || s[p] === void 0 || c === !0 || c === void 0 && s[p] !== !1) && (s[p || f] = G(l));
    }
    const i = (l, f) => a.forEach(l, (c, u) => o(c, u, f));
    if (a.isPlainObject(t) || t instanceof this.constructor)
      i(t, r);
    else if (a.isString(t) && (t = t.trim()) && !hn(t))
      i(dn(t), r);
    else if (a.isHeaders(t))
      for (const [l, f] of t.entries())
        o(f, l, n);
    else
      t != null && o(r, t, n);
    return this;
  }
  get(t, r) {
    if (t = z(t), t) {
      const n = a.findKey(this, t);
      if (n) {
        const s = this[n];
        if (!r)
          return s;
        if (r === !0)
          return pn(s);
        if (a.isFunction(r))
          return r.call(this, s, n);
        if (a.isRegExp(r))
          return r.exec(s);
        throw new TypeError("parser must be boolean|regexp|function");
      }
    }
  }
  has(t, r) {
    if (t = z(t), t) {
      const n = a.findKey(this, t);
      return !!(n && this[n] !== void 0 && (!r || ie(this, this[n], n, r)));
    }
    return !1;
  }
  delete(t, r) {
    const n = this;
    let s = !1;
    function o(i) {
      if (i = z(i), i) {
        const l = a.findKey(n, i);
        l && (!r || ie(n, n[l], l, r)) && (delete n[l], s = !0);
      }
    }
    return a.isArray(t) ? t.forEach(o) : o(t), s;
  }
  clear(t) {
    const r = Object.keys(this);
    let n = r.length, s = !1;
    for (; n--; ) {
      const o = r[n];
      (!t || ie(this, this[o], o, t, !0)) && (delete this[o], s = !0);
    }
    return s;
  }
  normalize(t) {
    const r = this, n = {};
    return a.forEach(this, (s, o) => {
      const i = a.findKey(n, o);
      if (i) {
        r[i] = G(s), delete r[o];
        return;
      }
      const l = t ? mn(o) : String(o).trim();
      l !== o && delete r[o], r[l] = G(s), n[l] = !0;
    }), this;
  }
  concat(...t) {
    return this.constructor.concat(this, ...t);
  }
  toJSON(t) {
    const r = /* @__PURE__ */ Object.create(null);
    return a.forEach(this, (n, s) => {
      n != null && n !== !1 && (r[s] = t && a.isArray(n) ? n.join(", ") : n);
    }), r;
  }
  [Symbol.iterator]() {
    return Object.entries(this.toJSON())[Symbol.iterator]();
  }
  toString() {
    return Object.entries(this.toJSON()).map(([t, r]) => t + ": " + r).join(`
`);
  }
  get [Symbol.toStringTag]() {
    return "AxiosHeaders";
  }
  static from(t) {
    return t instanceof this ? t : new this(t);
  }
  static concat(t, ...r) {
    const n = new this(t);
    return r.forEach((s) => n.set(s)), n;
  }
  static accessor(t) {
    const n = (this[Ce] = this[Ce] = {
      accessors: {}
    }).accessors, s = this.prototype;
    function o(i) {
      const l = z(i);
      n[l] || (yn(s, i), n[l] = !0);
    }
    return a.isArray(t) ? t.forEach(o) : o(t), this;
  }
}
x.accessor(["Content-Type", "Content-Length", "Accept", "Accept-Encoding", "User-Agent", "Authorization"]);
a.reduceDescriptors(x.prototype, ({ value: e }, t) => {
  let r = t[0].toUpperCase() + t.slice(1);
  return {
    get: () => e,
    set(n) {
      this[r] = n;
    }
  };
});
a.freezeMethods(x);
function ae(e, t) {
  const r = this || W, n = t || r, s = x.from(n.headers);
  let o = n.data;
  return a.forEach(e, function(l) {
    o = l.call(r, o, s.normalize(), t ? t.status : void 0);
  }), s.normalize(), o;
}
function Ze(e) {
  return !!(e && e.__CANCEL__);
}
function I(e, t, r) {
  y.call(this, e ?? "canceled", y.ERR_CANCELED, t, r), this.name = "CanceledError";
}
a.inherits(I, y, {
  __CANCEL__: !0
});
function Ye(e, t, r) {
  const n = r.config.validateStatus;
  !r.status || !n || n(r.status) ? e(r) : t(new y(
    "Request failed with status code " + r.status,
    [y.ERR_BAD_REQUEST, y.ERR_BAD_RESPONSE][Math.floor(r.status / 100) - 4],
    r.config,
    r.request,
    r
  ));
}
function bn(e) {
  const t = /^([-+\w]{1,25})(:?\/\/|:)/.exec(e);
  return t && t[1] || "";
}
function wn(e, t) {
  e = e || 10;
  const r = new Array(e), n = new Array(e);
  let s = 0, o = 0, i;
  return t = t !== void 0 ? t : 1e3, function(f) {
    const c = Date.now(), u = n[o];
    i || (i = c), r[s] = f, n[s] = c;
    let p = o, w = 0;
    for (; p !== s; )
      w += r[p++], p = p % e;
    if (s = (s + 1) % e, s === o && (o = (o + 1) % e), c - i < t)
      return;
    const R = u && c - u;
    return R ? Math.round(w * 1e3 / R) : void 0;
  };
}
function En(e, t) {
  let r = 0, n = 1e3 / t, s, o;
  const i = (c, u = Date.now()) => {
    r = u, s = null, o && (clearTimeout(o), o = null), e.apply(null, c);
  };
  return [(...c) => {
    const u = Date.now(), p = u - r;
    p >= n ? i(c, u) : (s = c, o || (o = setTimeout(() => {
      o = null, i(s);
    }, n - p)));
  }, () => s && i(s)];
}
const X = (e, t, r = 3) => {
  let n = 0;
  const s = wn(50, 250);
  return En((o) => {
    const i = o.loaded, l = o.lengthComputable ? o.total : void 0, f = i - n, c = s(f), u = i <= l;
    n = i;
    const p = {
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
    e(p);
  }, r);
}, _e = (e, t) => {
  const r = e != null;
  return [(n) => t[0]({
    lengthComputable: r,
    total: e,
    loaded: n
  }), t[1]];
}, Ne = (e) => (...t) => a.asap(() => e(...t)), gn = A.hasStandardBrowserEnv ? (
  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  function() {
    const t = A.navigator && /(msie|trident)/i.test(A.navigator.userAgent), r = document.createElement("a");
    let n;
    function s(o) {
      let i = o;
      return t && (r.setAttribute("href", i), i = r.href), r.setAttribute("href", i), {
        href: r.href,
        protocol: r.protocol ? r.protocol.replace(/:$/, "") : "",
        host: r.host,
        search: r.search ? r.search.replace(/^\?/, "") : "",
        hash: r.hash ? r.hash.replace(/^#/, "") : "",
        hostname: r.hostname,
        port: r.port,
        pathname: r.pathname.charAt(0) === "/" ? r.pathname : "/" + r.pathname
      };
    }
    return n = s(window.location.href), function(i) {
      const l = a.isString(i) ? s(i) : i;
      return l.protocol === n.protocol && l.host === n.host;
    };
  }()
) : (
  // Non standard browser envs (web workers, react-native) lack needed support.
  /* @__PURE__ */ function() {
    return function() {
      return !0;
    };
  }()
), Rn = A.hasStandardBrowserEnv ? (
  // Standard browser envs support document.cookie
  {
    write(e, t, r, n, s, o) {
      const i = [e + "=" + encodeURIComponent(t)];
      a.isNumber(r) && i.push("expires=" + new Date(r).toGMTString()), a.isString(n) && i.push("path=" + n), a.isString(s) && i.push("domain=" + s), o === !0 && i.push("secure"), document.cookie = i.join("; ");
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
function Sn(e) {
  return /^([a-z][a-z\d+\-.]*:)?\/\//i.test(e);
}
function On(e, t) {
  return t ? e.replace(/\/?\/$/, "") + "/" + t.replace(/^\/+/, "") : e;
}
function et(e, t) {
  return e && !Sn(t) ? On(e, t) : t;
}
const Pe = (e) => e instanceof x ? { ...e } : e;
function v(e, t) {
  t = t || {};
  const r = {};
  function n(c, u, p) {
    return a.isPlainObject(c) && a.isPlainObject(u) ? a.merge.call({ caseless: p }, c, u) : a.isPlainObject(u) ? a.merge({}, u) : a.isArray(u) ? u.slice() : u;
  }
  function s(c, u, p) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(c))
        return n(void 0, c, p);
    } else return n(c, u, p);
  }
  function o(c, u) {
    if (!a.isUndefined(u))
      return n(void 0, u);
  }
  function i(c, u) {
    if (a.isUndefined(u)) {
      if (!a.isUndefined(c))
        return n(void 0, c);
    } else return n(void 0, u);
  }
  function l(c, u, p) {
    if (p in t)
      return n(c, u);
    if (p in e)
      return n(void 0, c);
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
    headers: (c, u) => s(Pe(c), Pe(u), !0)
  };
  return a.forEach(Object.keys(Object.assign({}, e, t)), function(u) {
    const p = f[u] || s, w = p(e[u], t[u], u);
    a.isUndefined(w) && p !== l || (r[u] = w);
  }), r;
}
const tt = (e) => {
  const t = v({}, e);
  let { data: r, withXSRFToken: n, xsrfHeaderName: s, xsrfCookieName: o, headers: i, auth: l } = t;
  t.headers = i = x.from(i), t.url = Ge(et(t.baseURL, t.url), e.params, e.paramsSerializer), l && i.set(
    "Authorization",
    "Basic " + btoa((l.username || "") + ":" + (l.password ? unescape(encodeURIComponent(l.password)) : ""))
  );
  let f;
  if (a.isFormData(r)) {
    if (A.hasStandardBrowserEnv || A.hasStandardBrowserWebWorkerEnv)
      i.setContentType(void 0);
    else if ((f = i.getContentType()) !== !1) {
      const [c, ...u] = f ? f.split(";").map((p) => p.trim()).filter(Boolean) : [];
      i.setContentType([c || "multipart/form-data", ...u].join("; "));
    }
  }
  if (A.hasStandardBrowserEnv && (n && a.isFunction(n) && (n = n(t)), n || n !== !1 && gn(t.url))) {
    const c = s && o && Rn.read(o);
    c && i.set(s, c);
  }
  return t;
}, Tn = typeof XMLHttpRequest < "u", An = Tn && function(e) {
  return new Promise(function(r, n) {
    const s = tt(e);
    let o = s.data;
    const i = x.from(s.headers).normalize();
    let { responseType: l, onUploadProgress: f, onDownloadProgress: c } = s, u, p, w, R, h;
    function b() {
      R && R(), h && h(), s.cancelToken && s.cancelToken.unsubscribe(u), s.signal && s.signal.removeEventListener("abort", u);
    }
    let m = new XMLHttpRequest();
    m.open(s.method.toUpperCase(), s.url, !0), m.timeout = s.timeout;
    function E() {
      if (!m)
        return;
      const O = x.from(
        "getAllResponseHeaders" in m && m.getAllResponseHeaders()
      ), T = {
        data: !l || l === "text" || l === "json" ? m.responseText : m.response,
        status: m.status,
        statusText: m.statusText,
        headers: O,
        config: e,
        request: m
      };
      Ye(function(B) {
        r(B), b();
      }, function(B) {
        n(B), b();
      }, T), m = null;
    }
    "onloadend" in m ? m.onloadend = E : m.onreadystatechange = function() {
      !m || m.readyState !== 4 || m.status === 0 && !(m.responseURL && m.responseURL.indexOf("file:") === 0) || setTimeout(E);
    }, m.onabort = function() {
      m && (n(new y("Request aborted", y.ECONNABORTED, e, m)), m = null);
    }, m.onerror = function() {
      n(new y("Network Error", y.ERR_NETWORK, e, m)), m = null;
    }, m.ontimeout = function() {
      let P = s.timeout ? "timeout of " + s.timeout + "ms exceeded" : "timeout exceeded";
      const T = s.transitional || Xe;
      s.timeoutErrorMessage && (P = s.timeoutErrorMessage), n(new y(
        P,
        T.clarifyTimeoutError ? y.ETIMEDOUT : y.ECONNABORTED,
        e,
        m
      )), m = null;
    }, o === void 0 && i.setContentType(null), "setRequestHeader" in m && a.forEach(i.toJSON(), function(P, T) {
      m.setRequestHeader(T, P);
    }), a.isUndefined(s.withCredentials) || (m.withCredentials = !!s.withCredentials), l && l !== "json" && (m.responseType = s.responseType), c && ([w, h] = X(c, !0), m.addEventListener("progress", w)), f && m.upload && ([p, R] = X(f), m.upload.addEventListener("progress", p), m.upload.addEventListener("loadend", R)), (s.cancelToken || s.signal) && (u = (O) => {
      m && (n(!O || O.type ? new I(null, e, m) : O), m.abort(), m = null);
    }, s.cancelToken && s.cancelToken.subscribe(u), s.signal && (s.signal.aborted ? u() : s.signal.addEventListener("abort", u)));
    const S = bn(s.url);
    if (S && A.protocols.indexOf(S) === -1) {
      n(new y("Unsupported protocol " + S + ":", y.ERR_BAD_REQUEST, e));
      return;
    }
    m.send(o || null);
  });
}, xn = (e, t) => {
  const { length: r } = e = e ? e.filter(Boolean) : [];
  if (t || r) {
    let n = new AbortController(), s;
    const o = function(c) {
      if (!s) {
        s = !0, l();
        const u = c instanceof Error ? c : this.reason;
        n.abort(u instanceof y ? u : new I(u instanceof Error ? u.message : u));
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
    const { signal: f } = n;
    return f.unsubscribe = () => a.asap(l), f;
  }
}, kn = function* (e, t) {
  let r = e.byteLength;
  if (r < t) {
    yield e;
    return;
  }
  let n = 0, s;
  for (; n < r; )
    s = n + t, yield e.slice(n, s), n = s;
}, Cn = async function* (e, t) {
  for await (const r of _n(e))
    yield* kn(r, t);
}, _n = async function* (e) {
  if (e[Symbol.asyncIterator]) {
    yield* e;
    return;
  }
  const t = e.getReader();
  try {
    for (; ; ) {
      const { done: r, value: n } = await t.read();
      if (r)
        break;
      yield n;
    }
  } finally {
    await t.cancel();
  }
}, Fe = (e, t, r, n) => {
  const s = Cn(e, t);
  let o = 0, i, l = (f) => {
    i || (i = !0, n && n(f));
  };
  return new ReadableStream({
    async pull(f) {
      try {
        const { done: c, value: u } = await s.next();
        if (c) {
          l(), f.close();
          return;
        }
        let p = u.byteLength;
        if (r) {
          let w = o += p;
          r(w);
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
}, ne = typeof fetch == "function" && typeof Request == "function" && typeof Response == "function", nt = ne && typeof ReadableStream == "function", Nn = ne && (typeof TextEncoder == "function" ? /* @__PURE__ */ ((e) => (t) => e.encode(t))(new TextEncoder()) : async (e) => new Uint8Array(await new Response(e).arrayBuffer())), rt = (e, ...t) => {
  try {
    return !!e(...t);
  } catch {
    return !1;
  }
}, Pn = nt && rt(() => {
  let e = !1;
  const t = new Request(A.origin, {
    body: new ReadableStream(),
    method: "POST",
    get duplex() {
      return e = !0, "half";
    }
  }).headers.has("Content-Type");
  return e && !t;
}), Le = 64 * 1024, de = nt && rt(() => a.isReadableStream(new Response("").body)), Q = {
  stream: de && ((e) => e.body)
};
ne && ((e) => {
  ["text", "arrayBuffer", "blob", "formData", "stream"].forEach((t) => {
    !Q[t] && (Q[t] = a.isFunction(e[t]) ? (r) => r[t]() : (r, n) => {
      throw new y(`Response type '${t}' is not supported`, y.ERR_NOT_SUPPORT, n);
    });
  });
})(new Response());
const Fn = async (e) => {
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
    return (await Nn(e)).byteLength;
}, Ln = async (e, t) => {
  const r = a.toFiniteNumber(e.getContentLength());
  return r ?? Fn(t);
}, Bn = ne && (async (e) => {
  let {
    url: t,
    method: r,
    data: n,
    signal: s,
    cancelToken: o,
    timeout: i,
    onDownloadProgress: l,
    onUploadProgress: f,
    responseType: c,
    headers: u,
    withCredentials: p = "same-origin",
    fetchOptions: w
  } = tt(e);
  c = c ? (c + "").toLowerCase() : "text";
  let R = xn([s, o && o.toAbortSignal()], i), h;
  const b = R && R.unsubscribe && (() => {
    R.unsubscribe();
  });
  let m;
  try {
    if (f && Pn && r !== "get" && r !== "head" && (m = await Ln(u, n)) !== 0) {
      let T = new Request(t, {
        method: "POST",
        body: n,
        duplex: "half"
      }), F;
      if (a.isFormData(n) && (F = T.headers.get("content-type")) && u.setContentType(F), T.body) {
        const [B, $] = _e(
          m,
          X(Ne(f))
        );
        n = Fe(T.body, Le, B, $);
      }
    }
    a.isString(p) || (p = p ? "include" : "omit");
    const E = "credentials" in Request.prototype;
    h = new Request(t, {
      ...w,
      signal: R,
      method: r.toUpperCase(),
      headers: u.normalize().toJSON(),
      body: n,
      duplex: "half",
      credentials: E ? p : void 0
    });
    let S = await fetch(h);
    const O = de && (c === "stream" || c === "response");
    if (de && (l || O && b)) {
      const T = {};
      ["status", "statusText", "headers"].forEach((Re) => {
        T[Re] = S[Re];
      });
      const F = a.toFiniteNumber(S.headers.get("content-length")), [B, $] = l && _e(
        F,
        X(Ne(l), !0)
      ) || [];
      S = new Response(
        Fe(S.body, Le, B, () => {
          $ && $(), b && b();
        }),
        T
      );
    }
    c = c || "text";
    let P = await Q[a.findKey(Q, c) || "text"](S, e);
    return !O && b && b(), await new Promise((T, F) => {
      Ye(T, F, {
        data: P,
        headers: x.from(S.headers),
        status: S.status,
        statusText: S.statusText,
        config: e,
        request: h
      });
    });
  } catch (E) {
    throw b && b(), E && E.name === "TypeError" && /fetch/i.test(E.message) ? Object.assign(
      new y("Network Error", y.ERR_NETWORK, e, h),
      {
        cause: E.cause || E
      }
    ) : y.from(E, E && E.code, e, h);
  }
}), pe = {
  http: Kt,
  xhr: An,
  fetch: Bn
};
a.forEach(pe, (e, t) => {
  if (e) {
    try {
      Object.defineProperty(e, "name", { value: t });
    } catch {
    }
    Object.defineProperty(e, "adapterName", { value: t });
  }
});
const Be = (e) => `- ${e}`, Dn = (e) => a.isFunction(e) || e === null || e === !1, st = {
  getAdapter: (e) => {
    e = a.isArray(e) ? e : [e];
    const { length: t } = e;
    let r, n;
    const s = {};
    for (let o = 0; o < t; o++) {
      r = e[o];
      let i;
      if (n = r, !Dn(r) && (n = pe[(i = String(r)).toLowerCase()], n === void 0))
        throw new y(`Unknown adapter '${i}'`);
      if (n)
        break;
      s[i || "#" + o] = n;
    }
    if (!n) {
      const o = Object.entries(s).map(
        ([l, f]) => `adapter ${l} ` + (f === !1 ? "is not supported by the environment" : "is not available in the build")
      );
      let i = t ? o.length > 1 ? `since :
` + o.map(Be).join(`
`) : " " + Be(o[0]) : "as no adapter specified";
      throw new y(
        "There is no suitable adapter to dispatch the request " + i,
        "ERR_NOT_SUPPORT"
      );
    }
    return n;
  },
  adapters: pe
};
function le(e) {
  if (e.cancelToken && e.cancelToken.throwIfRequested(), e.signal && e.signal.aborted)
    throw new I(null, e);
}
function De(e) {
  return le(e), e.headers = x.from(e.headers), e.data = ae.call(
    e,
    e.transformRequest
  ), ["post", "put", "patch"].indexOf(e.method) !== -1 && e.headers.setContentType("application/x-www-form-urlencoded", !1), st.getAdapter(e.adapter || W.adapter)(e).then(function(n) {
    return le(e), n.data = ae.call(
      e,
      e.transformResponse,
      n
    ), n.headers = x.from(n.headers), n;
  }, function(n) {
    return Ze(n) || (le(e), n && n.response && (n.response.data = ae.call(
      e,
      e.transformResponse,
      n.response
    ), n.response.headers = x.from(n.response.headers))), Promise.reject(n);
  });
}
const ot = "1.7.7", Ee = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach((e, t) => {
  Ee[e] = function(n) {
    return typeof n === e || "a" + (t < 1 ? "n " : " ") + e;
  };
});
const Ue = {};
Ee.transitional = function(t, r, n) {
  function s(o, i) {
    return "[Axios v" + ot + "] Transitional option '" + o + "'" + i + (n ? ". " + n : "");
  }
  return (o, i, l) => {
    if (t === !1)
      throw new y(
        s(i, " has been removed" + (r ? " in " + r : "")),
        y.ERR_DEPRECATED
      );
    return r && !Ue[i] && (Ue[i] = !0, console.warn(
      s(
        i,
        " has been deprecated since v" + r + " and will be removed in the near future"
      )
    )), t ? t(o, i, l) : !0;
  };
};
function Un(e, t, r) {
  if (typeof e != "object")
    throw new y("options must be an object", y.ERR_BAD_OPTION_VALUE);
  const n = Object.keys(e);
  let s = n.length;
  for (; s-- > 0; ) {
    const o = n[s], i = t[o];
    if (i) {
      const l = e[o], f = l === void 0 || i(l, o, e);
      if (f !== !0)
        throw new y("option " + o + " must be " + f, y.ERR_BAD_OPTION_VALUE);
      continue;
    }
    if (r !== !0)
      throw new y("Unknown option " + o, y.ERR_BAD_OPTION);
  }
}
const he = {
  assertOptions: Un,
  validators: Ee
}, L = he.validators;
class U {
  constructor(t) {
    this.defaults = t, this.interceptors = {
      request: new ke(),
      response: new ke()
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
  async request(t, r) {
    try {
      return await this._request(t, r);
    } catch (n) {
      if (n instanceof Error) {
        let s;
        Error.captureStackTrace ? Error.captureStackTrace(s = {}) : s = new Error();
        const o = s.stack ? s.stack.replace(/^.+\n/, "") : "";
        try {
          n.stack ? o && !String(n.stack).endsWith(o.replace(/^.+\n.+\n/, "")) && (n.stack += `
` + o) : n.stack = o;
        } catch {
        }
      }
      throw n;
    }
  }
  _request(t, r) {
    typeof t == "string" ? (r = r || {}, r.url = t) : r = t || {}, r = v(this.defaults, r);
    const { transitional: n, paramsSerializer: s, headers: o } = r;
    n !== void 0 && he.assertOptions(n, {
      silentJSONParsing: L.transitional(L.boolean),
      forcedJSONParsing: L.transitional(L.boolean),
      clarifyTimeoutError: L.transitional(L.boolean)
    }, !1), s != null && (a.isFunction(s) ? r.paramsSerializer = {
      serialize: s
    } : he.assertOptions(s, {
      encode: L.function,
      serialize: L.function
    }, !0)), r.method = (r.method || this.defaults.method || "get").toLowerCase();
    let i = o && a.merge(
      o.common,
      o[r.method]
    );
    o && a.forEach(
      ["delete", "get", "head", "post", "put", "patch", "common"],
      (h) => {
        delete o[h];
      }
    ), r.headers = x.concat(i, o);
    const l = [];
    let f = !0;
    this.interceptors.request.forEach(function(b) {
      typeof b.runWhen == "function" && b.runWhen(r) === !1 || (f = f && b.synchronous, l.unshift(b.fulfilled, b.rejected));
    });
    const c = [];
    this.interceptors.response.forEach(function(b) {
      c.push(b.fulfilled, b.rejected);
    });
    let u, p = 0, w;
    if (!f) {
      const h = [De.bind(this), void 0];
      for (h.unshift.apply(h, l), h.push.apply(h, c), w = h.length, u = Promise.resolve(r); p < w; )
        u = u.then(h[p++], h[p++]);
      return u;
    }
    w = l.length;
    let R = r;
    for (p = 0; p < w; ) {
      const h = l[p++], b = l[p++];
      try {
        R = h(R);
      } catch (m) {
        b.call(this, m);
        break;
      }
    }
    try {
      u = De.call(this, R);
    } catch (h) {
      return Promise.reject(h);
    }
    for (p = 0, w = c.length; p < w; )
      u = u.then(c[p++], c[p++]);
    return u;
  }
  getUri(t) {
    t = v(this.defaults, t);
    const r = et(t.baseURL, t.url);
    return Ge(r, t.params, t.paramsSerializer);
  }
}
a.forEach(["delete", "get", "head", "options"], function(t) {
  U.prototype[t] = function(r, n) {
    return this.request(v(n || {}, {
      method: t,
      url: r,
      data: (n || {}).data
    }));
  };
});
a.forEach(["post", "put", "patch"], function(t) {
  function r(n) {
    return function(o, i, l) {
      return this.request(v(l || {}, {
        method: t,
        headers: n ? {
          "Content-Type": "multipart/form-data"
        } : {},
        url: o,
        data: i
      }));
    };
  }
  U.prototype[t] = r(), U.prototype[t + "Form"] = r(!0);
});
class ge {
  constructor(t) {
    if (typeof t != "function")
      throw new TypeError("executor must be a function.");
    let r;
    this.promise = new Promise(function(o) {
      r = o;
    });
    const n = this;
    this.promise.then((s) => {
      if (!n._listeners) return;
      let o = n._listeners.length;
      for (; o-- > 0; )
        n._listeners[o](s);
      n._listeners = null;
    }), this.promise.then = (s) => {
      let o;
      const i = new Promise((l) => {
        n.subscribe(l), o = l;
      }).then(s);
      return i.cancel = function() {
        n.unsubscribe(o);
      }, i;
    }, t(function(o, i, l) {
      n.reason || (n.reason = new I(o, i, l), r(n.reason));
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
    const r = this._listeners.indexOf(t);
    r !== -1 && this._listeners.splice(r, 1);
  }
  toAbortSignal() {
    const t = new AbortController(), r = (n) => {
      t.abort(n);
    };
    return this.subscribe(r), t.signal.unsubscribe = () => this.unsubscribe(r), t.signal;
  }
  /**
   * Returns an object that contains a new `CancelToken` and a function that, when called,
   * cancels the `CancelToken`.
   */
  static source() {
    let t;
    return {
      token: new ge(function(s) {
        t = s;
      }),
      cancel: t
    };
  }
}
function vn(e) {
  return function(r) {
    return e.apply(null, r);
  };
}
function jn(e) {
  return a.isObject(e) && e.isAxiosError === !0;
}
const me = {
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
Object.entries(me).forEach(([e, t]) => {
  me[t] = e;
});
function it(e) {
  const t = new U(e), r = ve(U.prototype.request, t);
  return a.extend(r, U.prototype, t, { allOwnKeys: !0 }), a.extend(r, t, null, { allOwnKeys: !0 }), r.create = function(s) {
    return it(v(e, s));
  }, r;
}
const g = it(W);
g.Axios = U;
g.CanceledError = I;
g.CancelToken = ge;
g.isCancel = Ze;
g.VERSION = ot;
g.toFormData = te;
g.AxiosError = y;
g.Cancel = g.CanceledError;
g.all = function(t) {
  return Promise.all(t);
};
g.spread = vn;
g.isAxiosError = jn;
g.mergeConfig = v;
g.AxiosHeaders = x;
g.formToJSON = (e) => Qe(a.isHTMLForm(e) ? new FormData(e) : e);
g.getAdapter = st.getAdapter;
g.HttpStatusCode = me;
g.default = g;
const qn = {
  class: "uk-grid uk-child-width-1-3",
  "uk-grid": ""
}, In = {
  class: "uk-grid uk-child-width-1-2",
  "uk-grid": ""
}, Hn = { class: "uk-card uk-card-default uk-card-small" }, Mn = { class: "uk-card-body" }, zn = {
  class: "uk-grid uk-flex-center",
  "uk-grid": ""
}, Jn = ["src"], Vn = { class: "uk-margin-remove" }, Wn = { class: "uk-margin-remove uk-text-meta" }, $n = { class: "uk-card-footer uk-text-center" }, Kn = { class: "uk-description-list" }, Gn = { class: "uk-list uk-list-disc uk-list-collapse" }, Qn = {
  __name: "DashboardView",
  setup(e) {
    const t = at({
      counter: {
        users: 0,
        roles: 0,
        groups: 0
      },
      info: {
        version: {
          framework: "",
          php: ""
        },
        database: {
          connection: "",
          name: "",
          type: "",
          version: ""
        },
        environment: {},
        path: {
          project: ""
        }
      },
      sprinkles: {},
      users: []
    });
    return g.get("/api/dashboard").then((r) => {
      t.value = r.data;
    }).catch((r) => {
      console.error(r);
    }), (r, n) => {
      const s = re("UFInfoBox"), o = re("RouterLink"), i = re("UFCardBox");
      return H(), M(se, null, [
        n[13] || (n[13] = d("h3", null, "Dashboard", -1)),
        d("div", qn, [
          d("div", null, [
            N(o, {
              to: { name: "admin.users" },
              class: "uk-text-decoration-none"
            }, {
              default: j(() => [
                N(s, {
                  value: t.value.counter.users,
                  label: "Users",
                  faIcon: "user"
                }, null, 8, ["value"])
              ]),
              _: 1
            })
          ]),
          d("div", null, [
            N(o, {
              to: { name: "admin.roles" },
              class: "uk-text-decoration-none"
            }, {
              default: j(() => [
                N(s, {
                  value: t.value.counter.roles,
                  label: "Roles",
                  faIcon: "address-card"
                }, null, 8, ["value"])
              ]),
              _: 1
            })
          ]),
          d("div", null, [
            N(o, {
              to: { name: "admin.groups" },
              class: "uk-text-decoration-none"
            }, {
              default: j(() => [
                N(s, {
                  value: t.value.counter.groups,
                  label: "Groups",
                  faIcon: "users"
                }, null, 8, ["value"])
              ]),
              _: 1
            })
          ])
        ]),
        d("div", In, [
          d("div", null, [
            d("div", Hn, [
              n[1] || (n[1] = d("div", { class: "uk-card-header" }, [
                d("div", { class: "uk-grid uk-grid-small" }, [
                  d("div", { class: "uk-width-auto" }, [
                    d("h4", { "data-test": "title" }, "Latest Users")
                  ])
                ])
              ], -1)),
              d("div", Mn, [
                d("div", zn, [
                  (H(!0), M(se, null, Se(t.value.users, (l) => (H(), M("div", {
                    key: l.id,
                    class: "uk-text-center"
                  }, [
                    N(o, {
                      to: { name: "admin.user", params: { user_name: l.user_name } },
                      class: "uk-text-decoration-none uk-link-text"
                    }, {
                      default: j(() => [
                        d("img", {
                          src: l.avatar,
                          alt: "User Image",
                          class: "uk-border-circle"
                        }, null, 8, Jn),
                        d("p", Vn, C(l.full_name), 1),
                        d("p", Wn, C(l.registered), 1)
                      ]),
                      _: 2
                    }, 1032, ["to"])
                  ]))), 128))
                ])
              ]),
              d("div", $n, [
                N(o, {
                  to: { name: "admin.users" },
                  class: "uk-button uk-button-text"
                }, {
                  default: j(() => n[0] || (n[0] = [
                    lt("View All Users")
                  ])),
                  _: 1
                })
              ])
            ]),
            n[12] || (n[12] = d("br", null, null, -1)),
            N(i, { title: "System Information" }, {
              default: j(() => [
                d("dl", Kn, [
                  n[2] || (n[2] = d("dt", null, "Frameword version", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.version.framework), 1)
                    ])
                  ]),
                  n[3] || (n[3] = d("dt", null, "PHP version", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.version.php), 1)
                    ])
                  ]),
                  n[4] || (n[4] = d("dt", null, "Webserver software", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.environment.SERVER_SOFTWARE), 1)
                    ])
                  ]),
                  n[5] || (n[5] = d("dt", null, "Database connection", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.database.connection), 1)
                    ])
                  ]),
                  n[6] || (n[6] = d("dt", null, "Database version", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.database.type) + " " + C(t.value.info.database.version), 1)
                    ])
                  ]),
                  n[7] || (n[7] = d("dt", null, "Database name", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.database.name), 1)
                    ])
                  ]),
                  n[8] || (n[8] = d("dt", null, "Project directory", -1)),
                  d("dd", null, [
                    d("pre", null, [
                      d("code", null, C(t.value.info.path.project), 1)
                    ])
                  ]),
                  n[9] || (n[9] = d("dt", null, "Site root url", -1)),
                  n[10] || (n[10] = d("dd", null, [
                    d("pre", null, [
                      d("code")
                    ])
                  ], -1)),
                  n[11] || (n[11] = d("dt", null, "Loaded sprinkles", -1)),
                  d("dd", null, [
                    d("ul", Gn, [
                      (H(!0), M(se, null, Se(t.value.sprinkles, (l) => (H(), M("li", {
                        key: l.name
                      }, C(l), 1))), 128))
                    ])
                  ])
                ])
              ]),
              _: 1
            })
          ]),
          d("div", null, [
            N(i, { title: "Activities" })
          ])
        ])
      ], 64);
    };
  }
};
export {
  Qn as default
};
