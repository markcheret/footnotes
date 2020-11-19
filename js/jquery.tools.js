/*!
 * jQuery Tools v1.2.7 - The missing UI library for the Web
 * 
 * toolbox/toolbox.expose.js
 * toolbox/toolbox.flashembed.js
 * toolbox/toolbox.history.js
 * toolbox/toolbox.mousewheel.js
 * tooltip/tooltip.js
 * tooltip/tooltip.dynamic.js
 * tooltip/tooltip.slide.js
 * 
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * 
 * http://flowplayer.org/tools/
 * 
 * jquery.event.wheel.js - rev 1 
 * Copyright (c) 2008, Three Dub Media (http://threedubmedia.com)
 * Liscensed under the MIT License (MIT-LICENSE.txt)
 * http://www.opensource.org/licenses/mit-license.php
 * Created: 2008-07-01 | Updated: 2008-07-14
 * 
 * -----
 * 
 * Added checks whether jQuery.browser exists    2020-10-26T2005+0100
 * <https://wordpress.org/support/topic/tooltip-hover-not-showing/#post-13456762>
 * 
 * Removed usage of jQuery browser check function   2020-11-12T0127+0100
 * ‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
 * See also on the Forum: <https://wordpress.org/support/topic/after-wp-5-5-upgrade-jquery-is-deprecated/>,
 * lastly <https://wordpress.org/support/topic/jquery-issues-13/>
 * 
 * #1  (54) This was only a tweak to adjust width and height in Internet Explorer.
 * 
 * #2 (226) This was only for very old Internet Explorer (older than IE8).
 * 
 * #3 (266) This was only about a naming convention of Firefox: 'DOMMouseScroll' vs 'mousewheel',
 *          or 'mousemove' in very old Firefox (older than v1.9).
 *          When making jQuery.browser optional, an 'if(a.browser)' condition was added around.
 * 
 * #4 (293) This disabled fade-in for Internet Explorer other than FadeIE.
 * 
 * #5 (296) This disabled fade-out for Internet Explorer other than FadeIE.
 * 
 * #6 (420) This disabled slide-fade for Internet Explorer.
 *          Browsers not supporting an effect simply don’t execute it, they won’t throw an error.
 * 
 * Re-formatted minified file. Last modified: 2020-11-13T0444+0100
 */
(function (a) {
	a.tools = a.tools || {version: "v1.2.7"};
	var b;
	b = a.tools.expose = {conf: {maskId: "exposeMask", loadSpeed: "slow", closeSpeed: "fast", closeOnClick: !0, closeOnEsc: !0, zIndex: 9998, opacity: .8, startOpacity: 0, color: "#fff", onLoad: null, onClose: null}};
	function c() {
		/*if (a.browser && a.browser.msie) {
			var b = a(document).height(), c = a(window).height();
			return[window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth, b - c < 20 ? c : b]
		}*/
		return[a(document).width(), a(document).height()]
	}

	function d(b) {
		if (b)return b.call(a.mask)
	}

	var e, f, g, h, i;
	a.mask = {load: function (j, k) {
		if (g)return this;
		typeof j == "string" && (j = {color: j}), j = j || h, h = j = a.extend(a.extend({}, b.conf), j), e = a("#" + j.maskId), e.length || (e = a("<div/>").attr("id", j.maskId), a("body").append(e));
		var l = c();
		e.css({position: "absolute", top: 0, left: 0, width: l[0], height: l[1], display: "none", opacity: j.startOpacity, zIndex: j.zIndex}), j.color && e.css("backgroundColor", j.color);
		if (d(j.onBeforeLoad) === !1)return this;
		j.closeOnEsc && a(document).on("keydown.mask", function (b) {
			b.keyCode == 27 && a.mask.close(b)
		}), j.closeOnClick && e.on("click.mask", function (b) {
			a.mask.close(b)
		}), a(window).on("resize.mask", function () {
			a.mask.fit()
		}), k && k.length && (i = k.eq(0).css("zIndex"), a.each(k, function () {
			var b = a(this);
			/relative|absolute|fixed/i.test(b.css("position")) || b.css("position", "relative")
		}), f = k.css({zIndex: Math.max(j.zIndex + 1, i == "auto" ? 0 : i)})), e.css({display: "block"}).fadeTo(j.loadSpeed, j.opacity, function () {
			a.mask.fit(), d(j.onLoad), g = "full"
		}), g = !0;
		return this
	}, close: function () {
		if (g) {
			if (d(h.onBeforeClose) === !1)return this;
			e.fadeOut(h.closeSpeed, function () {
				d(h.onClose), f && f.css({zIndex: i}), g = !1
			}), a(document).off("keydown.mask"), e.off("click.mask"), a(window).off("resize.mask")
		}
		return this
	}, fit: function () {
		if (g) {
			var a = c();
			e.css({width: a[0], height: a[1]})
		}
	}, getMask: function () {
		return e
	}, isLoaded: function (a) {
		return a ? g == "full" : g
	}, getConf: function () {
		return h
	}, getExposed: function () {
		return f
	}}, a.fn.mask = function (b) {
		a.mask.load(b);
		return this
	}, a.fn.expose = function (b) {
		a.mask.load(b, this);
		return this
	}
})(jQuery);
(function () {
	var a = document.all, b = "http://www.adobe.com/go/getflashplayer", c = typeof jQuery == "function", d = /(\d+)[^\d]+(\d+)[^\d]*(\d*)/, e = {width: "100%", height: "100%", id: "_" + ("" + Math.random()).slice(9), allowfullscreen: !0, allowscriptaccess: "always", quality: "high", version: [3, 0], onFail: null, expressInstall: null, w3c: !1, cachebusting: !1};
	window.attachEvent && window.attachEvent("onbeforeunload", function () {
		__flash_unloadHandler = function () {
		}, __flash_savedUnloadHandler = function () {
		}
	});
	function f(a, b) {
		if (b)for (var c in b)b.hasOwnProperty(c) && (a[c] = b[c]);
		return a
	}

	function g(a, b) {
		var c = [];
		for (var d in a)a.hasOwnProperty(d) && (c[d] = b(a[d]));
		return c
	}

	window.flashembed = function (a, b, c) {
		typeof a == "string" && (a = document.getElementById(a.replace("#", "")));
		if (a) {
			typeof b == "string" && (b = {src: b});
			return new j(a, f(f({}, e), b), c)
		}
	};
	var h = f(window.flashembed, {conf: e, getVersion: function () {
		var a, b;
		try {
			b = navigator.plugins["Shockwave Flash"].description.slice(16)
		} catch (c) {
			try {
				a = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7"), b = a && a.GetVariable("$version")
			} catch (e) {
				try {
					a = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6"), b = a && a.GetVariable("$version")
				} catch (f) {
				}
			}
		}
		b = d.exec(b);
		return b ? [b[1], b[3]] : [0, 0]
	}, asString: function (a) {
		if (a === null || a === undefined)return null;
		var b = typeof a;
		b == "object" && a.push && (b = "array");
		switch (b) {
			case"string":
				a = a.replace(new RegExp("([\"\\\\])", "g"), "\\$1"), a = a.replace(/^\s?(\d+\.?\d*)%/, "$1pct");
				return"\"" + a + "\"";
			case"array":
				return"[" + g(a,function (a) {
					return h.asString(a)
				}).join(",") + "]";
			case"function":
				return"\"function()\"";
			case"object":
				var c = [];
				for (var d in a)a.hasOwnProperty(d) && c.push("\"" + d + "\":" + h.asString(a[d]));
				return"{" + c.join(",") + "}"
		}
		return String(a).replace(/\s/g, " ").replace(/\'/g, "\"")
	}, getHTML: function (b, c) {
		b = f({}, b);
		var d = "<object width=\"" + b.width + "\" height=\"" + b.height + "\" id=\"" + b.id + "\" name=\"" + b.id + "\"";
		b.cachebusting && (b.src += (b.src.indexOf("?") != -1 ? "&" : "?") + Math.random()), b.w3c || !a ? d += " data=\"" + b.src + "\" type=\"application/x-shockwave-flash\"" : d += " classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"", d += ">";
		if (b.w3c || a)d += "<param name=\"movie\" value=\"" + b.src + "\" />";
		b.width = b.height = b.id = b.w3c = b.src = null, b.onFail = b.version = b.expressInstall = null;
		for (var e in b)b[e] && (d += "<param name=\"" + e + "\" value=\"" + b[e] + "\" />");
		var g = "";
		if (c) {
			for (var i in c)if (c[i]) {
				var j = c[i];
				g += i + "=" + encodeURIComponent(/function|object/.test(typeof j) ? h.asString(j) : j) + "&"
			}
			g = g.slice(0, -1), d += "<param name=\"flashvars\" value='" + g + "' />"
		}
		d += "</object>";
		return d
	}, isSupported: function (a) {
		return i[0] > a[0] || i[0] == a[0] && i[1] >= a[1]
	}}), i = h.getVersion();

	function j(c, d, e) {
		if (h.isSupported(d.version))c.innerHTML = h.getHTML(d, e); else if (d.expressInstall && h.isSupported([6, 65]))c.innerHTML = h.getHTML(f(d, {src: d.expressInstall}), {MMredirectURL: location.href, MMplayerType: "PlugIn", MMdoctitle: document.title}); else {
			c.innerHTML.replace(/\s/g, "") || (c.innerHTML = "<h2>Flash version " + d.version + " or greater is required</h2><h3>" + (i[0] > 0 ? "Your version is " + i : "You have no flash plugin installed") + "</h3>" + (c.tagName == "A" ? "<p>Click here to download latest version</p>" : "<p>Download latest version from <a href='" + b + "'>here</a></p>"), c.tagName == "A" && (c.onclick = function () {
				location.href = b
			}));
			if (d.onFail) {
				var g = d.onFail.call(this);
				typeof g == "string" && (c.innerHTML = g)
			}
		}
		a && (window[d.id] = document.getElementById(d.id)), f(this, {getRoot: function () {
			return c
		}, getOptions: function () {
			return d
		}, getConf: function () {
			return e
		}, getApi: function () {
			return c.firstChild
		}})
	}

	c && (jQuery.tools = jQuery.tools || {version: "v1.2.7"}, jQuery.tools.flashembed = {conf: e}, jQuery.fn.flashembed = function (a, b) {
		return this.each(function () {
			jQuery(this).data("flashembed", flashembed(this, a, b))
		})
	})
})();
(function (a) {
	var b, c, d, e;
	a.tools = a.tools || {version: "v1.2.7"}, a.tools.history = {init: function (g) {
		e || (/*a.browser && a.browser.msie && a.browser.version < "8" ? c || (c = a("<iframe/>").attr("src", "javascript:false;").hide().get(0), a("body").append(c), setInterval(function () {
			var d = c.contentWindow.document, e = d.location.hash;
			b !== e && a(window).trigger("hash", e)
		}, 100), f(location.hash || "#")) :*/ setInterval(function () {
			var c = location.hash;
			c !== b && a(window).trigger("hash", c)
		}, 100), d = d ? d.add(g) : g, g.click(function (b) {
			var d = a(this).attr("href");
			c && f(d);
			if (d.slice(0, 1) != "#") {
				location.href = "#" + d;
				return b.preventDefault()
			}
		}), e = !0)
	}};
	function f(a) {
		if (a) {
			var b = c.contentWindow.document;
			b.open().close(), b.location.hash = a
		}
	}

	a(window).on("hash", function (c, e) {
		e ? d.filter(function () {
			var b = a(this).attr("href");
			return b == e || b == e.replace("#", "")
		}).trigger("history", [e]) : d.eq(0).trigger("history", [e]), b = e
	}), a.fn.history = function (b) {
		a.tools.history.init(this);
		return this.on("history", b)
	}
})(jQuery);
(function (a) {
	a.fn.mousewheel = function (a) {
		return this[a ? "on" : "trigger"]("wheel", a)
	}, a.event.special.wheel = {setup: function () {
		a.event.add(this, b, c, {})
	}, teardown: function () {
		a.event.remove(this, b, c)
	}};
	var b = /*a.browser.mozilla ? "DOMMouseScroll" + (a.browser.version < "1.9" ? " mousemove" : "") :*/ "mousewheel";

	function c(b) {
		switch (b.type) {
			case"mousemove":
				return a.extend(b.data, {clientX: b.clientX, clientY: b.clientY, pageX: b.pageX, pageY: b.pageY});
			case"DOMMouseScroll":
				a.extend(b, b.data), b.delta = -b.detail / 3;
				break;
			case"mousewheel":
				b.delta = b.wheelDelta / 120
		}
		b.type = "wheel";
		return a.event.handle.call(this, b, b.delta)
	}
})(jQuery);
(function (a) {
	a.tools = a.tools || {version: "v1.2.7"}, a.tools.tooltip = {conf: {effect: "toggle", fadeOutSpeed: "fast", predelay: 0, delay: 30, opacity: 1, tip: 0, fadeIE: !1, position: ["top", "center"], offset: [0, 0], relative: !1, cancelDefault: !0, events: {def: "mouseenter,mouseleave", input: "focus,blur", widget: "focus mouseenter,blur mouseleave", tooltip: "mouseenter,mouseleave"}, layout: "<div/>", tipClass: "tooltip"}, addEffect: function (a, c, d) {
		b[a] = [c, d]
	}};
	var b = {toggle: [function (a) {
		var b = this.getConf(), c = this.getTip(), d = b.opacity;
		d < 1 && c.css({opacity: d}), c.show(), a.call()
	}, function (a) {
		this.getTip().hide(), a.call()
	}], fade: [function (b) {
		var c = this.getConf();
		/*!(a.browser && a.browser.msie) || c.fadeIE ?*/ this.getTip().fadeTo(c.fadeInSpeed, c.opacity, b) /*: (this.getTip().show(), b())*/
	}, function (b) {
		var c = this.getConf();
		/*!(a.browser && a.browser.msie) || c.fadeIE ?*/ this.getTip().fadeOut(c.fadeOutSpeed, b) /*: (this.getTip().hide(), b())*/
	}]};

	function c(b, c, d) {
		var e = d.relative ? b.position().top : b.offset().top, f = d.relative ? b.position().left : b.offset().left, g = d.position[0];
		e -= c.outerHeight() - d.offset[0], f += b.outerWidth() + d.offset[1], /iPad/i.test(navigator.userAgent) && (e -= a(window).scrollTop());
		var h = c.outerHeight() + b.outerHeight();
		g == "center" && (e += h / 2), g == "bottom" && (e += h), g = d.position[1];
		var i = c.outerWidth() + b.outerWidth();
		g == "center" && (f -= i / 2), g == "left" && (f -= i);
		return{top: e, left: f}
	}

	function d(d, e) {
		var f = this, g = d.add(f), h, i = 0, j = 0, k = d.attr("title"), l = d.attr("data-tooltip"), m = b[e.effect], n, o = d.is(":input"), p = o && d.is(":checkbox, :radio, select, :button, :submit"), q = d.attr("type"), r = e.events[q] || e.events[o ? p ? "widget" : "input" : "def"];
		if (!m)throw"Nonexistent effect \"" + e.effect + "\"";
		r = r.split(/,\s*/);
		if (r.length != 2)throw"Tooltip: bad events configuration for " + q;
		d.on(r[0],function (a) {
			clearTimeout(i), e.predelay ? j = setTimeout(function () {
				f.show(a)
			}, e.predelay) : f.show(a)
		}).on(r[1], function (a) {
			clearTimeout(j), e.delay ? i = setTimeout(function () {
				f.hide(a)
			}, e.delay) : f.hide(a)
		}), k && e.cancelDefault && (d.removeAttr("title"), d.data("title", k)), a.extend(f, {show: function (b) {
			if (!h) {
				l ? h = a(l) : e.tip ? h = a(e.tip).eq(0) : k ? h = a(e.layout).addClass(e.tipClass).appendTo(document.body).hide().append(k) : (h = d.next(), h.length || (h = d.parent().next()));
				if (!h.length)throw"Cannot find tooltip for " + d
			}
			if (f.isShown())return f;
			h.stop(!0, !0);
			var o = c(d, h, e);
			e.tip && h.html(d.data("title")), b = a.Event(), b.type = "onBeforeShow", g.trigger(b, [o]);
			if (b.isDefaultPrevented())return f;
			o = c(d, h, e), h.css({position: "absolute", top: o.top, left: o.left}), n = !0, m[0].call(f, function () {
				b.type = "onShow", n = "full", g.trigger(b)
			});
			var p = e.events.tooltip.split(/,\s*/);
			h.data("__set") || (h.off(p[0]).on(p[0], function () {
				clearTimeout(i), clearTimeout(j)
			}), p[1] && !d.is("input:not(:checkbox, :radio), textarea") && h.off(p[1]).on(p[1], function (a) {
				a.relatedTarget != d[0] && d.trigger(r[1].split(" ")[0])
			}), e.tip || h.data("__set", !0));
			return f
		}, hide: function (c) {
			if (!h || !f.isShown())return f;
			c = a.Event(), c.type = "onBeforeHide", g.trigger(c);
			if (!c.isDefaultPrevented()) {
				n = !1, b[e.effect][1].call(f, function () {
					c.type = "onHide", g.trigger(c)
				});
				return f
			}
		}, isShown: function (a) {
			return a ? n == "full" : n
		}, getConf: function () {
			return e
		}, getTip: function () {
			return h
		}, getTrigger: function () {
			return d
		}}), a.each("onHide,onBeforeShow,onShow,onBeforeHide".split(","), function (b, c) {
			a.isFunction(e[c]) && a(f).on(c, e[c]), f[c] = function (b) {
				b && a(f).on(c, b);
				return f
			}
		})
	}

	a.fn.tooltip = function (b) {
		var c = this.data("tooltip");
		if (c)return c;
		b = a.extend(!0, {}, a.tools.tooltip.conf, b), typeof b.position == "string" && (b.position = b.position.split(/,?\s/)), this.each(function () {
			c = new d(a(this), b), a(this).data("tooltip", c)
		});
		return b.api ? c : this
	}
})(jQuery);
(function (a) {
	var b = a.tools.tooltip;
	b.dynamic = {conf: {classNames: "top right bottom left"}};
	function c(b) {
		var c = a(window), d = c.width() + c.scrollLeft(), e = c.height() + c.scrollTop();
		return[b.offset().top <= c.scrollTop(), d <= b.offset().left + b.width(), e <= b.offset().top + b.height(), c.scrollLeft() >= b.offset().left]
	}

	function d(a) {
		var b = a.length;
		while (b--)if (a[b])return!1;
		return!0
	}

	a.fn.dynamic = function (e) {
		typeof e == "number" && (e = {speed: e}), e = a.extend({}, b.dynamic.conf, e);
		var f = a.extend(!0, {}, e), g = e.classNames.split(/\s/), h;
		this.each(function () {
			var b = a(this).tooltip().onBeforeShow(function (b, e) {
				var i = this.getTip(), j = this.getConf();
				h || (h = [j.position[0], j.position[1], j.offset[0], j.offset[1], a.extend({}, j)]), a.extend(j, h[4]), j.position = [h[0], h[1]], j.offset = [h[2], h[3]], i.css({visibility: "hidden", position: "absolute", top: e.top, left: e.left}).show();
				var k = a.extend(!0, {}, f), l = c(i);
				if (!d(l)) {
					l[2] && (a.extend(j, k.top), j.position[0] = "top", i.addClass(g[0])), l[3] && (a.extend(j, k.right), j.position[1] = "right", i.addClass(g[1])), l[0] && (a.extend(j, k.bottom), j.position[0] = "bottom", i.addClass(g[2])), l[1] && (a.extend(j, k.left), j.position[1] = "left", i.addClass(g[3]));
					if (l[0] || l[2])j.offset[0] *= -1;
					if (l[1] || l[3])j.offset[1] *= -1
				}
				i.css({visibility: "visible"}).hide()
			});
			b.onBeforeShow(function () {
				var a = this.getConf(), b = this.getTip();
				setTimeout(function () {
					a.position = [h[0], h[1]], a.offset = [h[2], h[3]]
				}, 0)
			}), b.onHide(function () {
				var a = this.getTip();
				a.removeClass(e.classNames)
			}), ret = b
		});
		return e.api ? ret : this
	}
})(jQuery);
(function (a) {
	var b = a.tools.tooltip;
	a.extend(b.conf, {direction: "up", bounce: !1, slideOffset: 10, slideInSpeed: 200, slideOutSpeed: 200, slideFade: true /*!(a.browser && a.browser.msie)*/});
	var c = {up: ["-", "top"], down: ["+", "top"], left: ["-", "left"], right: ["+", "left"]};
	b.addEffect("slide", function (a) {
		var b = this.getConf(), d = this.getTip(), e = b.slideFade ? {opacity: b.opacity} : {}, f = c[b.direction] || c.up;
		e[f[1]] = f[0] + "=" + b.slideOffset, b.slideFade && d.css({opacity: 0}), d.show().animate(e, b.slideInSpeed, a)
	}, function (b) {
		var d = this.getConf(), e = d.slideOffset, f = d.slideFade ? {opacity: 0} : {}, g = c[d.direction] || c.up, h = "" + g[0];
		d.bounce && (h = h == "+" ? "-" : "+"), f[g[1]] = h + "=" + e, this.getTip().animate(f, d.slideOutSpeed, function () {
			a(this).hide(), b.call()
		})
	})
})(jQuery);
