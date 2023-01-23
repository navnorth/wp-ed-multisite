(window.webpackJsonp_oet_medium_embed_block = window.webpackJsonp_oet_medium_embed_block || []).push([[1], { 6: function (e, t, l) {} }]),
    (function (e) {
        function t(t) {
            for (var n, i, r = t[0], c = t[1], m = t[2], s = 0, d = []; s < r.length; s++) (i = r[s]), Object.prototype.hasOwnProperty.call(o, i) && o[i] && d.push(o[i][0]), (o[i] = 0);
            for (n in c) Object.prototype.hasOwnProperty.call(c, n) && (e[n] = c[n]);
            for (u && u(t); d.length; ) d.shift()();
            return a.push.apply(a, m || []), l();
        }
        function l() {
            for (var e, t = 0; t < a.length; t++) {
                for (var l = a[t], n = !0, r = 1; r < l.length; r++) {
                    var c = l[r];
                    0 !== o[c] && (n = !1);
                }
                n && (a.splice(t--, 1), (e = i((i.s = l[0]))));
            }
            return e;
        }
        var n = {},
            o = { 0: 0 },
            a = [];
        function i(t) {
            if (n[t]) return n[t].exports;
            var l = (n[t] = { i: t, l: !1, exports: {} });
            return e[t].call(l.exports, l, l.exports, i), (l.l = !0), l.exports;
        }
        (i.m = e),
            (i.c = n),
            (i.d = function (e, t, l) {
                i.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: l });
            }),
            (i.r = function (e) {
                "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
            }),
            (i.t = function (e, t) {
                if ((1 & t && (e = i(e)), 8 & t)) return e;
                if (4 & t && "object" == typeof e && e && e.__esModule) return e;
                var l = Object.create(null);
                if ((i.r(l), Object.defineProperty(l, "default", { enumerable: !0, value: e }), 2 & t && "string" != typeof e))
                    for (var n in e)
                        i.d(
                            l,
                            n,
                            function (t) {
                                return e[t];
                            }.bind(null, n)
                        );
                return l;
            }),
            (i.n = function (e) {
                var t =
                    e && e.__esModule
                        ? function () {
                              return e.default;
                          }
                        : function () {
                              return e;
                          };
                return i.d(t, "a", t), t;
            }),
            (i.o = function (e, t) {
                return Object.prototype.hasOwnProperty.call(e, t);
            }),
            (i.p = "");
        var r = (window.webpackJsonp_oet_medium_embed_block = window.webpackJsonp_oet_medium_embed_block || []),
            c = r.push.bind(r);
        (r.push = t), (r = r.slice());
        for (var m = 0; m < r.length; m++) t(r[m]);
        var u = c;
        a.push([7, 1]), l();
    })([
        function (e, t) {
            e.exports = window.wp.element;
        },
        function (e, t) {
            e.exports = window.wp.components;
        },
        function (e, t) {
            e.exports = window.jQuery;
        },
        function (e, t) {
            e.exports = window.wp.i18n;
        },
        function (e, t) {
            e.exports = window.wp.blockEditor;
        },
        function (e, t) {
            e.exports = window.wp.blocks;
        },
        ,
        function (e, t, l) {
            "use strict";
            l.r(t);
            var n = l(5),
                o = l(3),
                a = (l(6), l(0)),
                i = l(4),
                r = l(1),
                c = l(2),
                m = l.n(c);
            m()(function () {
                m()(".oet-medium-embed-block").on("click", ".notice.is-dismissible .notice-dismiss", function () {
                    m()(this).parent(".notice").remove();
                });
            }),
                Object(n.registerBlockType)("oet-block/oet-medium-embed-block", {
                    title: Object(o.__)("OET Medium Embed", "oet-medium-embed-block"),
                    category: "oet-block-category",
                    icon: "embed-generic",
                    supports: { html: !1 },
                    attributes: {
                        url: { type: "string", default: "" },
                        title: { type: "string", default: "" },
                        description: { type: "string", default: "" },
                        bgcolor: { type: "string", default: "" },
                        bgImage: { type: "string" },
                        textalign: { type: "string", default: "" },
                        align: { type: "string", default: "" },
                        authorurl: { type: "string", default: "" },
                        authorname: { type: "string", default: "" },
                        authorlogo: { type: "string", default: "" },
                        embedCode: { type: "string", default: "" },
                        isChanged: { type: "boolean", default: !1 },
                        blockId: { type: "string" },
                        firstLoad: { type: "boolean", default: !0 },
                        mediumUrl: { type: "string" },
                        heading: { type: "string", default:"h2" },
                    },
                    edit: function (e) {
                        const { attributes: t, setAttributes: l, isSelected: n, clientId: c } = e,
                            u = [
                                { label: "Select Alignment", value: "" },
                                { label: "Left", value: "left" },
                                { label: "Center", value: "center" },
                                { label: "Right", value: "right" },
                            ],
                            h = [
                            	{ label: "H1", value: "h1" },
                            	{ label: "H2", value: "h2" },
                            	{ label: "H3", value: "h3" },
                            	{ label: "H4", value: "h4" },
                            	{ label: "H5", value: "h5" },
                            	{ label: "H6", value: "h6" }
                            ];
                        var s,
                            d,
                            b,
                            p = Object(a.createElement)(
                                "div",
                                { className: "admin-medium-heading" },
                                Object(a.createElement)(
                                    "h2",
                                    { className: "medium-heading components-placeholder__label" },
                                    Object(a.createElement)(
                                        "svg",
                                        { height: "24", width: "24", xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 195 195" },
                                        Object(a.createElement)(
                                            "g",
                                            { fill: "none" },
                                            Object(a.createElement)("path", { d: "M0 0h195v195H0z", fill: "#12100e" }),
                                            Object(a.createElement)("path", {
                                                d:
                                                    "M46.534 65.216a5.074 5.074 0 0 0-1.651-4.28L32.65 46.2V44h37.98l29.355 64.381L125.795 44H162v2.201l-10.458 10.027a3.057 3.057 0 0 0-1.162 2.935v73.674a3.057 3.057 0 0 0 1.162 2.935l10.213 10.027V148h-51.372v-2.201l10.58-10.272c1.04-1.04 1.04-1.345 1.04-2.934V73.042l-29.417 74.713H88.61L54.362 73.042v50.074a6.908 6.908 0 0 0 1.896 5.747l13.76 16.691v2.201H31v-2.2l13.76-16.692a6.663 6.663 0 0 0 1.774-5.747z",
                                                fill: "#fff",
                                            })
                                        )
                                    ),
                                    " Medium Blog Post Embed"
                                ),
                                Object(a.createElement)(
                                    "div",
                                    { className: "admin-medium-body components-placeholder__instructions" },
                                    Object(a.createElement)("p", null, "The easiest way to start embedding a blog post is by importing the data using the post URL.")
                                ),
                                Object(a.createElement)(
                                    "div",
                                    { className: "admin-medium-input-block components-placeholder__fieldset" },
                                    Object(a.createElement)(
                                        "form",
                                        null,
                                        Object(a.createElement)("span", { className: "admin-medium-input-label" }, "Post URL: "),
                                        Object(a.createElement)(r.TextControl, {
                                            value: t.mediumUrl,
                                            onChange: (e) => {
                                                l({ mediumUrl: e });
                                            },
                                            className: Object(o.__)("components-placeholder__input medium-post-url", "wp-oet-theme"),
                                            id: Object(o.__)("mediumPostUrl", "wp-oet-theme"),
                                        }),
                                        Object(a.createElement)(
                                            r.Button,
                                            {
                                                className: "btn-import-mediumUrl components-button is-primary",
                                                onClick: () => {
                                                    if (
                                                        (m()("#block-" + c + " .oet-medium-embed-block .admin-medium-input-block .notice").length && m()("#block-" + c + " .oet-medium-embed-block .admin-medium-input-block .notice").remove(),
                                                        "" !== t.mediumUrl)
                                                    ) {
                                                        var e = { action: "get_medium_post", medium_url: t.mediumUrl };
                                                        m.a.ajax({
                                                            url: oet_medium_embed.ajaxurl,
                                                            type: "POST",
                                                            data: e,
                                                            dataType: "json",
                                                            success: function (e) {
                                                                "object" != typeof e
                                                                    ? m()("#block-" + c + " .oet-medium-embed-block .admin-medium-input-block").append(
                                                                          '<div class="notice notice-warning is-dismissible"><p>Medium Post not found. Please set options manually on the block settings.</p></div>'
                                                                      )
                                                                    : l({ url: e.url, title: e.title, description: e.description, authorurl: e.authorurl, authorlogo: e.authorlogo, isChanged: !0 });
                                                            },
                                                            error: function (e, t, l) {
                                                                m()("#block-" + c + " .oet-medium-embed-block .admin-medium-input-block").append(
                                                                    '<div class="notice notice-error is-dismissible"><p>An error was encountered: ' + l + ". Please set options manually on the block settings.</p></div>"
                                                                );
                                                            },
                                                        });
                                                    }
                                                },
                                                isPrimary: !0,
                                            },
                                            "Import"
                                        )
                                    )
                                )
                            );
                        return (
                            c !== t.blockId && l({ blockId: c }),
                            t.isChanged &&
                                ((s = t),
                                (d = t.blockId),
                                (b = { action: "display_medium_embed", attributes: s }),
                                "" !== s.title &&
                                    m.a.ajax({
                                        url: oet_medium_embed.ajaxurl,
                                        type: "POST",
                                        data: b,
                                        success: function (e) {
                                            m()("#block-" + d + " .oet-medium-embed-block").html(""), m()("#block-" + d + " .oet-medium-embed-block").html(e);
                                        },
                                        error: function (e, t, l) {
                                            console.log(l);
                                        },
                                    })),
                            [
                                Object(a.createElement)(
                                    a.Fragment,
                                    null,
                                    Object(a.createElement)(
                                        i.InspectorControls,
                                        { key: t.blockId },
                                        Object(a.createElement)(
                                            r.PanelBody,
                                            { title: Object(o.__)("Medium Embed Settings", "wp-oet-theme"), initialOpen: !0 },
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.TextControl, {
                                                    label: "Medium Url:",
                                                    value: t.url,
                                                    onChange: (e) => {
                                                        l({ url: e, isChanged: !0 });
                                                    },
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.TextControl, {
                                                    label: "Title:",
                                                    value: t.title,
                                                    onChange: (e) => {
                                                        l({ title: e, isChanged: !0 });
                                                    },
                                                    className: Object(o.__)("medium-title", "wp-oet-theme"),
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.SelectControl, {
                                                    className: Object(o.__)("medium-embed-block-heading", "wp-oet-theme"),
                                                    label: "Heading Tag:",
                                                    value: t.heading,
                                                    options: h,
                                                    onChange: (e) => {
                                                        l({ heading: e, isChanged: !0 });
                                                    },
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.TextareaControl, {
                                                    label: "Description:",
                                                    value: t.description,
                                                    onChange: (e) => {
                                                        l({ description: e, isChanged: !0 });
                                                    },
                                                    rows: "6",
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.SelectControl, {
                                                    className: Object(o.__)("medium-embed-block-alignment", "wp-oet-theme"),
                                                    label: "Block Alignment:",
                                                    value: t.align,
                                                    options: u,
                                                    onChange: (e) => {
                                                        l({ align: e, isChanged: !0 });
                                                    },
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.SelectControl, {
                                                    className: Object(o.__)("medium-embed-alignment", "wp-oet-theme"),
                                                    label: "Text Alignment:",
                                                    value: t.textalign,
                                                    options: u,
                                                    onChange: (e) => {
                                                        l({ textalign: e, isChanged: !0 });
                                                    },
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                { className: "multi-input" },
                                                Object(a.createElement)(r.TextControl, {
                                                    label: "Background Image:",
                                                    className: Object(o.__)("medium-embed-bgimage", "wp-oet-theme"),
                                                    value: t.bgImage,
                                                    onChange: (e) => {
                                                        l({ bgImage: e, isChanged: !0 });
                                                    },
                                                }),
                                                Object(a.createElement)(
                                                    r.Button,
                                                    {
                                                        className: "btn-medium-image",
                                                        onClick: () => {
                                                            window.frame && (window.frame = null),
                                                                (window.frame = new wp.media({ title: "Select or upload local resource", button: { text: "Use this image as background" }, multiple: !1 })),
                                                                window.frame.on("select", function () {
                                                                    var e = window.frame.state().get("selection").first().toJSON();
                                                                    l({ bgImage: e.url, isChanged: !0 });
                                                                }),
                                                                window.frame.open();
                                                        },
                                                        isPrimary: !0,
                                                    },
                                                    "..."
                                                )
                                            ),
                                            Object(a.createElement)(r.PanelRow, { className: "label-only" }, Object(a.createElement)("label", { className: "components-base-control__label" }, "Background Color:")),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                { className: "colorpicker-only" },
                                                Object(a.createElement)(r.ColorPicker, {
                                                    label: "Background Color:",
                                                    color: t.bgcolor,
                                                    onChangeComplete: (e) => {
                                                        l({ bgcolor: e.hex, isChanged: !0 });
                                                    },
                                                    disableAlpha: !0,
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.TextControl, {
                                                    label: "Author Url:",
                                                    value: t.authorurl,
                                                    onChange: (e) => {
                                                        l({ authorurl: e, isChanged: !0 });
                                                    },
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.TextControl, {
                                                    label: "Author Name:",
                                                    value: t.authorname,
                                                    onChange: (e) => {
                                                        l({ authorname: e, isChanged: !0 });
                                                    },
                                                })
                                            ),
                                            Object(a.createElement)(
                                                r.PanelRow,
                                                null,
                                                Object(a.createElement)(r.TextControl, {
                                                    label: "Author Logo:",
                                                    value: t.authorlogo,
                                                    onChange: (e) => {
                                                        l({ authorlogo: e, isChanged: !0 });
                                                    },
                                                })
                                            )
                                        )
                                    )
                                ),
                                Object(a.createElement)("div", { className: "oet-medium-embed-block" }, p),
                            ]
                        );
                    },
                });
        },
    ]);