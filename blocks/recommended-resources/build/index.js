!(function () {
    "use strict";
    var e,
        t = {
            557: function (e, t, o) {
                var n = window.wp.blocks,
                    r = window.wp.i18n,
                    l = window.wp.element,
                    a = window.wp.blockEditor,
                    c = window.wp.components,
                    d = window.jQuery,
                    i = o.n(d);
                function m(e) {
                    var t = "Loading...";
                    const { attributes: o, setAttributes: n, isSelected: d, clientId: m } = e,
                        s = [
                            { label: (0, r.__)("Select media type", "oet-recommended-resources-block"), value: "" },
                            { label: (0, r.__)("Video", "oet-recommended-resources-block"), value: "video" },
                            { label: (0, r.__)("Website", "oet-recommended-resources-block"), value: "website" },
                        ],
                        u = (e) => (t) => {
                            n(1 == e ? { mediaType1: t, isChanged: !0 } : 2 == e ? { mediaType2: t, isChanged: !0 } : { mediaType3: t, isChanged: !0 });
                        },
                        p = (e) => (t) => {
                            n(1 == e ? { mediaType1: t } : 2 == e ? { mediaType2: t } : { mediaType3: t });
                        },
                        g = (e) => (t) => {
                            n(1 == e ? { mediaSource1: t, isChanged: !0 } : 2 == e ? { mediaSource2: t, isChanged: !0 } : { mediaSource3: t, isChanged: !0 });
                        },
                        b = (e) => (t) => {
                            n(1 == e ? { mediaSource1: t } : 2 == e ? { mediaSource2: t } : { mediaSource3: t });
                        },
                        h = (e) => (t) => {
                            n(1 == e ? { mediaText1: t, isChanged: !0 } : 2 == e ? { mediaText2: t, isChanged: !0 } : { mediaText3: t, isChanged: !0 });
                        },
                        v = (e) => (t) => {
                            n(1 == e ? { mediaText1: t } : 2 == e ? { mediaText2: t } : { mediaText3: t });
                        },
                        _ = (e) => (t) => {
                            n(1 == e ? { mediaLink1: t, isChanged: !0 } : 2 == e ? { mediaLink2: t, isChanged: !0 } : { mediaLink3: t, isChanged: !0 });
                        };
                    return (
                        m !== o.blockId && n({ blockId: m }),
                        (void 0 !== o.isChanged && 0 != o.isChanged) ||
                            (t = (0, l.createElement)(
                                "div",
                                { className: "admin-recommended-resources-heading" },
                                (0, l.createElement)(
                                    "div",
                                    { className: "oet-recommended-resources-block" },
                                    (0, l.createElement)(
                                        "p",
                                        { className: "pblctn_scl_icn_hedng" },
                                        (0, l.createElement)(c.TextControl, {
                                            placeholder: (0, r.__)("Enter heading here...", "oet-recommended-resources-block"),
                                            value: o.heading,
                                            onChange: (e) => {
                                                n({ heading: e });
                                            },
                                            id: "recommended-resources-heading",
                                        })
                                    ),
                                    (0, l.createElement)(
                                        "div",
                                        { className: "col-md-12 col-sm-12 col-xs-12 padding_left padding_right tlkt_stp_vdo_cntnr" },
                                        (0, l.createElement)(
                                            "div",
                                            { className: "col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg" },
                                            (0, l.createElement)("p", null, (0, l.createElement)(c.SelectControl, { options: s, value: o.mediaType1, onChange: p(1) })),
                                            (0, l.createElement)(
                                                "p",
                                                null,
                                                (0, l.createElement)(c.TextControl, { placeholder: (0, r.__)("YouTube video or image url", "oet-recommended-resources-block"), value: o.mediaSource1, onChange: b(1) })
                                            ),
                                            (0, l.createElement)("p", null, (0, l.createElement)(c.TextControl, { placeholder: (0, r.__)("Enter text here...", "oet-recommended-resources-block"), value: o.mediaText1, onChange: v(1) }))
                                        ),
                                        (0, l.createElement)(
                                            "div",
                                            { className: "col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg" },
                                            (0, l.createElement)("p", null, (0, l.createElement)(c.SelectControl, { options: s, value: o.mediaType2, onChange: p(2) })),
                                            (0, l.createElement)(
                                                "p",
                                                null,
                                                (0, l.createElement)(c.TextControl, { placeholder: (0, r.__)("YouTube video or image url", "oet-recommended-resources-block"), value: o.mediaSource2, onChange: b(2) })
                                            ),
                                            (0, l.createElement)("p", null, (0, l.createElement)(c.TextControl, { placeholder: (0, r.__)("Enter text here...", "oet-recommended-resources-block"), value: o.mediaText2, onChange: v(2) }))
                                        ),
                                        (0, l.createElement)(
                                            "div",
                                            { className: "col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg" },
                                            (0, l.createElement)("p", null, (0, l.createElement)(c.SelectControl, { options: s, value: o.mediaType3, onChange: p(3) })),
                                            (0, l.createElement)(
                                                "p",
                                                null,
                                                (0, l.createElement)(c.TextControl, { placeholder: (0, r.__)("YouTube video or image url", "oet-recommended-resources-block"), value: o.mediaSource3, onChange: b(3) })
                                            ),
                                            (0, l.createElement)("p", null, (0, l.createElement)(c.TextControl, { placeholder: (0, r.__)("Enter text here...", "oet-recommended-resources-block"), value: o.mediaText3, onChange: v(3) }))
                                        )
                                    ),
                                    (0, l.createElement)(
                                        "div",
                                        { className: "btnSaveRecommendedResources" },
                                        (0, l.createElement)(
                                            c.Button,
                                            {
                                                className: "btn-save-resources components-button is-primary",
                                                onClick: () => {
                                                    n({ isChanged: !0 });
                                                },
                                                isPrimary: !0,
                                            },
                                            "Save"
                                        )
                                    )
                                )
                            )),
                        o.isChanged &&
                            ((k = o),
                            (y = o.blockId),
                            (C = { action: "display_recommended_resources", attributes: k }),
                            i().ajax({
                                url: oet_recommended_resources.ajax_url,
                                type: "POST",
                                data: C,
                                success: function (e) {
                                    e.error
                                        ? (i()("#block-" + y + " .oet-recommended-resources-block").html(""), i()("#block-" + y + " .oet-recommended-resources-block").html(e.message))
                                        : (i()("#block-" + y + " .oet-recommended-resources-block").html(""), i()("#block-" + y + " .oet-recommended-resources-block").html(e));
                                },
                                error: function (e, t, o) {
                                    console.log(o);
                                },
                            })),
                        [
                            (0, l.createElement)(
                                l.Fragment,
                                null,
                                (0, l.createElement)(
                                    a.InspectorControls,
                                    { key: o.blockId },
                                    (0, l.createElement)(
                                        c.PanelBody,
                                        { title: (0, r.__)("Settings", "oet-recommended-resources-block"), initialOpen: !0 },
                                        (0, l.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, l.createElement)(c.TextControl, {
                                                label: (0, r.__)("Heading", "oet-recommended-resources-block"),
                                                value: o.heading,
                                                onChange: (e) => {
                                                    n({ heading: e, isChanged: !0 });
                                                },
                                            })
                                        ),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.SelectControl, { label: (0, r.__)("Media Type 1", "oet-recommended-resources-block"), options: s, value: o.mediaType1, onChange: u(1) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Source/Image 1", "oet-recommended-resources-block"), value: o.mediaSource1, onChange: g(1) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Text 1", "oet-recommended-resources-block"), value: o.mediaText1, onChange: h(1) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Link 1", "oet-recommended-resources-block"), value: o.mediaLink1, onChange: _(1) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.SelectControl, { label: (0, r.__)("Media Type 2", "oet-recommended-resources-block"), options: s, value: o.mediaType2, onChange: u(2) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Source/Image 2", "oet-recommended-resources-block"), value: o.mediaSource2, onChange: g(2) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Text 2", "oet-recommended-resources-block"), value: o.mediaText2, onChange: h(2) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Link 2", "oet-recommended-resources-block"), value: o.mediaLink2, onChange: _(2) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.SelectControl, { label: (0, r.__)("Media Type 3", "oet-recommended-resources-block"), options: s, value: o.mediaType3, onChange: u(3) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Source/Image 3", "oet-recommended-resources-block"), value: o.mediaSource3, onChange: g(3) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Text 3", "oet-recommended-resources-block"), value: o.mediaText3, onChange: h(3) })),
                                        (0, l.createElement)(c.PanelRow, null, (0, l.createElement)(c.TextControl, { label: (0, r.__)("Media Link 3", "oet-recommended-resources-block"), value: o.mediaLink3, onChange: _(3) }))
                                    )
                                )
                            ),
                            (0, l.createElement)("div", (0, a.useBlockProps)(), (0, l.createElement)("div", { className: "oet-recommended-resources-block" }, t)),
                        ]
                    );
                    var k, y, C;
                }
                var s = JSON.parse(
                    '{"$schema":"https://json.schemastore.org/block.json","apiVersion":2,"name":"oet-block/oet-recommended-resources-block","version":"0.1.0","title":"Recommended Resources","category":"oet-block-category","icon":"list-view","description":"Displays recommended resources section on a page.","supports":{"html":false},"attributes":{"heading":{"type":"string"},"mediaType1":{"type":"string","default":"video"},"mediaSource1":{"type":"string"},"mediaText1":{"type":"string"},"mediaLink1":{"type":"string","default":""},"mediaType2":{"type":"string","default":"video"},"mediaSource2":{"type":"string"},"mediaText2":{"type":"string"},"mediaLink2":{"type":"string"},"mediaType3":{"type":"string","default":"video"},"mediaSource3":{"type":"string"},"mediaText3":{"type":"string"},"mediaLink3":{"type":"string"},"isChanged":{"type":"boolean","default":false},"blockId":{"type":"string"},"firstLoad":{"type":"boolean","default":true}},"textdomain":"oet-recommended-resources-block","editorScript":"file:./build/index.js","editorStyle":"file:./build/index.css","style":"file:./build/style-index.css"}'
                );
                1 == oet_recommended_resources.version_58
                    ? (0, n.registerBlockType)(s, { edit: m })
                    : (0, n.registerBlockType)("oet-block/oet-recommended-resources-block", {
                          title: (0, r.__)("Recommended Resources", "oet-recommended-resources-block"),
                          category: "oet-block-category",
                          icon: "list-view",
                          supports: { html: !1 },
                          attributes: {
                              heading: { type: "string" },
                              mediaType1: { type: "string", default: "video" },
                              mediaSource1: { type: "string" },
                              mediaText1: { type: "string" },
                              mediaLink1: { type: "string", default: "" },
                              mediaType2: { type: "string", default: "video" },
                              mediaSource2: { type: "string" },
                              mediaText2: { type: "string" },
                              mediaLink2: { type: "string" },
                              mediaType3: { type: "string", default: "video" },
                              mediaSource3: { type: "string" },
                              mediaText3: { type: "string" },
                              mediaLink3: { type: "string" },
                              isChanged: { type: "boolean", default: !1 },
                              blockId: { type: "string" },
                              firstLoad: { type: "boolean", default: !0 },
                          },
                          edit: m,
                      });
            },
        },
        o = {};
    function n(e) {
        var r = o[e];
        if (void 0 !== r) return r.exports;
        var l = (o[e] = { exports: {} });
        return t[e](l, l.exports, n), l.exports;
    }
    (n.m = t),
        (e = []),
        (n.O = function (t, o, r, l) {
            if (!o) {
                var a = 1 / 0;
                for (m = 0; m < e.length; m++) {
                    (o = e[m][0]), (r = e[m][1]), (l = e[m][2]);
                    for (var c = !0, d = 0; d < o.length; d++)
                        (!1 & l || a >= l) &&
                        Object.keys(n.O).every(function (e) {
                            return n.O[e](o[d]);
                        })
                            ? o.splice(d--, 1)
                            : ((c = !1), l < a && (a = l));
                    if (c) {
                        e.splice(m--, 1);
                        var i = r();
                        void 0 !== i && (t = i);
                    }
                }
                return t;
            }
            l = l || 0;
            for (var m = e.length; m > 0 && e[m - 1][2] > l; m--) e[m] = e[m - 1];
            e[m] = [o, r, l];
        }),
        (n.n = function (e) {
            var t =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return n.d(t, { a: t }), t;
        }),
        (n.d = function (e, t) {
            for (var o in t) n.o(t, o) && !n.o(e, o) && Object.defineProperty(e, o, { enumerable: !0, get: t[o] });
        }),
        (n.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (function () {
            var e = { 826: 0, 46: 0 };
            n.O.j = function (t) {
                return 0 === e[t];
            };
            var t = function (t, o) {
                    var r,
                        l,
                        a = o[0],
                        c = o[1],
                        d = o[2],
                        i = 0;
                    if (
                        a.some(function (t) {
                            return 0 !== e[t];
                        })
                    ) {
                        for (r in c) n.o(c, r) && (n.m[r] = c[r]);
                        if (d) var m = d(n);
                    }
                    for (t && t(o); i < a.length; i++) (l = a[i]), n.o(e, l) && e[l] && e[l][0](), (e[a[i]] = 0);
                    return n.O(m);
                },
                o = (self.webpackChunkoet_recommended_resources = self.webpackChunkoet_recommended_resources || []);
            o.forEach(t.bind(null, 0)), (o.push = t.bind(null, o.push.bind(o)));
        })();
    var r = n.O(void 0, [46], function () {
        return n(557);
    });
    r = n.O(r);
})();
