!function() {
    function e() {
        var e = !1;
        e && c("keydown", r),
        v.keyboardSupport && !e && u("keydown", r)
    }
    function t() {
        if (document.body) {
            var t = document.body
              , n = document.documentElement
              , o = window.innerHeight
              , r = t.scrollHeight;
            if (S = document.compatMode.indexOf("CSS") >= 0 ? n : t,
            w = t,
            e(),
            x = !0,
            top != self)
                y = !0;
            else if (r > o && (t.offsetHeight <= o || n.offsetHeight <= o)) {
                var a = !1
                  , i = function() {
                    a || n.scrollHeight == document.height || (a = !0,
                    setTimeout(function() {
                        n.style.height = document.height + "px",
                        a = !1
                    }, 500))
                };
                if (n.style.height = "auto",
                setTimeout(i, 10),
                S.offsetHeight <= o) {
                    var l = document.createElement("div");
                    l.style.clear = "both",
                    t.appendChild(l)
                }
            }
            v.fixedBackground || b || (t.style.backgroundAttachment = "scroll",
            n.style.backgroundAttachment = "scroll")
        }
    }
    function n(e, t, n, o) {
        if (o || (o = 1e3),
        d(t, n),
        1 != v.accelerationMax) {
            var r = +new Date
              , a = r - C;
            if (a < v.accelerationDelta) {
                var i = (1 + 30 / a) / 2;
                i > 1 && (i = Math.min(i, v.accelerationMax),
                t *= i,
                n *= i)
            }
            C = +new Date
        }
        if (M.push({
            x: t,
            y: n,
            lastX: 0 > t ? .99 : -.99,
            lastY: 0 > n ? .99 : -.99,
            start: +new Date
        }),
        !T) {
            var l = e === document.body
              , u = function(r) {
                for (var a = +new Date, i = 0, c = 0, s = 0; s < M.length; s++) {
                    var d = M[s]
                      , f = a - d.start
                      , h = f >= v.animationTime
                      , m = h ? 1 : f / v.animationTime;
                    v.pulseAlgorithm && (m = p(m));
                    var w = d.x * m - d.lastX >> 0
                      , g = d.y * m - d.lastY >> 0;
                    i += w,
                    c += g,
                    d.lastX += w,
                    d.lastY += g,
                    h && (M.splice(s, 1),
                    s--)
                }
                l ? window.scrollBy(i, c) : (i && (e.scrollLeft += i),
                c && (e.scrollTop += c)),
                t || n || (M = []),
                M.length ? N(u, e, o / v.frameRate + 1) : T = !1
            };
            N(u, e, 0),
            T = !0
        }
    }
    function o(e) {
        x || t();
        var o = e.target
          , r = l(o);
        if (!r || e.defaultPrevented || s(w, "embed") || s(o, "embed") && /\.pdf/i.test(o.src))
            return !0;
        var a = e.wheelDeltaX || 0
          , i = e.wheelDeltaY || 0;
        return a || i || (i = e.wheelDelta || 0),
        !v.touchpadSupport && f(i) ? !0 : (Math.abs(a) > 1.2 && (a *= v.stepSize / 120),
        Math.abs(i) > 1.2 && (i *= v.stepSize / 120),
        n(r, -a, -i),
        void e.preventDefault())
    }
    function r(e) {
        var t = e.target
          , o = e.ctrlKey || e.altKey || e.metaKey || e.shiftKey && e.keyCode !== H.spacebar;
        if (/input|textarea|select|embed/i.test(t.nodeName) || t.isContentEditable || e.defaultPrevented || o)
            return !0;
        if (s(t, "button") && e.keyCode === H.spacebar)
            return !0;
        var r, a = 0, i = 0, u = l(w), c = u.clientHeight;
        switch (u == document.body && (c = window.innerHeight),
        e.keyCode) {
        case H.up:
            i = -v.arrowScroll;
            break;
        case H.down:
            i = v.arrowScroll;
            break;
        case H.spacebar:
            r = e.shiftKey ? 1 : -1,
            i = -r * c * .9;
            break;
        case H.pageup:
            i = .9 * -c;
            break;
        case H.pagedown:
            i = .9 * c;
            break;
        case H.home:
            i = -u.scrollTop;
            break;
        case H.end:
            var d = u.scrollHeight - u.scrollTop - c;
            i = d > 0 ? d + 10 : 0;
            break;
        case H.left:
            a = -v.arrowScroll;
            break;
        case H.right:
            a = v.arrowScroll;
            break;
        default:
            return !0
        }
        n(u, a, i),
        e.preventDefault()
    }
    function a(e) {
        w = e.target
    }
    function i(e, t) {
        for (var n = e.length; n--; )
            E[A(e[n])] = t;
        return t
    }
    function l(e) {
        var t = []
          , n = S.scrollHeight;
        do {
            var o = E[A(e)];
            if (o)
                return i(t, o);
            if (t.push(e),
            n === e.scrollHeight) {
                if (!y || S.clientHeight + 10 < n)
                    return i(t, document.body)
            } else if (e.clientHeight + 10 < e.scrollHeight && (overflow = getComputedStyle(e, "").getPropertyValue("overflow-y"),
            "scroll" === overflow || "auto" === overflow))
                return i(t, e)
        } while (e = e.parentNode)
    }
    function u(e, t, n) {
        window.addEventListener(e, t, { passive: false } || !1)
    }
    function c(e, t, n) {
        window.removeEventListener(e, t, { passive: false } || !1)
    }
    function s(e, t) {
        return (e.nodeName || "").toLowerCase() === t.toLowerCase()
    }
    function d(e, t) {
        e = e > 0 ? 1 : -1,
        t = t > 0 ? 1 : -1,
        (k.x !== e || k.y !== t) && (k.x = e,
        k.y = t,
        M = [],
        C = 0)
    }
    function f(e) {
        if (e) {
            e = Math.abs(e),
            D.push(e),
            D.shift(),
            clearTimeout(z);
            var t = h(D[0], 120) && h(D[1], 120) && h(D[2], 120);
            return !t
        }
    }
    function h(e, t) {
        return Math.floor(e / t) == e / t
    }
    function m(e) {
        var t, n, o;
        return e *= v.pulseScale,
        1 > e ? t = e - (1 - Math.exp(-e)) : (n = Math.exp(-1),
        e -= 1,
        o = 1 - Math.exp(-e),
        t = n + o * (1 - n)),
        t * v.pulseNormalize
    }
    function p(e) {
        return e >= 1 ? 1 : 0 >= e ? 0 : (1 == v.pulseNormalize && (v.pulseNormalize /= m(1)),
        m(e))
    }
    var w, g = {
        frameRate: 300,
        animationTime: 1200,
        stepSize: 300,
        pulseAlgorithm: !0,
        pulseScale: 8,
        pulseNormalize: 1,
        accelerationDelta: 20,
        accelerationMax: 1,
        keyboardSupport: !0,
        arrowScroll: 50,
        touchpadSupport: !0,
        fixedBackground: !0,
        excluded: ""
    }, v = g, b = !1, y = !1, k = {
        x: 0,
        y: 0
    }, x = !1, S = document.documentElement, D = [120, 120, 120], H = {
        left: 37,
        up: 38,
        right: 39,
        down: 40,
        spacebar: 32,
        pageup: 33,
        pagedown: 34,
        end: 35,
        home: 36
    }, v = g, M = [], T = !1, C = +new Date, E = {};
    setInterval(function() {
        E = {}
    }, 1e4);
    var z, A = function() {
        var e = 0;
        return function(t) {
            return t.uniqueID || (t.uniqueID = e++)
        }
    }(), N = function() {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || function(e, t, n) {
            window.setTimeout(e, n || 1e3 / 60)
        }
    }(), K = /chrome/i.test(window.navigator.userAgent), L = null;
    "onwheel"in document.createElement("div") ? L = "wheel" : "onmousewheel"in document.createElement("div") && (L = "mousewheel"),
    L && K && (u(L, o),
    u("mousedown", a),
    u("load", t))
}();