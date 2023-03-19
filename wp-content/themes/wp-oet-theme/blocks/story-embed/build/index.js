!(function () {
    "use strict";
    var e,
        t = {
            557: function (e, t, o) {
                var l = window.wp.blocks,
                    r = window.wp.i18n,
                    n = window.wp.element,
                    a = window.wp.blockEditor,
                    c = window.wp.components,
                    s = window.jQuery,
                    i = o.n(s);
                function b(e) {
                    var t = "Loading...";
                    const o = [
                            { label: (0, r.__)("Select alignment", "oet-story-embed-block"), value: "" },
                            { label: (0, r.__)("Left", "oet-story-embed-block"), value: "left" },
                            { label: (0, r.__)("Right", "oet-story-embed-block"), value: "right" },
                        ],
                        l = [
                            { label: (0, r.__)("None", "oet-callout-box-block"), value: "" },
                            { label: (0, r.__)("Checkmark", "oet-callout-box-block"), value: "checkmark" },
                            { label: (0, r.__)("Book", "oet-callout-box-block"), value: "book" },
                            { label: (0, r.__)("Light bulb", "oet-callout-box-block"), value: "light-bulb" },
                            { label: (0, r.__)("Exclamation", "oet-callout-box-block"), value: "exclamation" },
                            { label: (0, r.__)("Sun", "oet-callout-box-block"), value: "sun" },
                        ],
                        { attributes: s, setAttributes: b, isSelected: d, clientId: m } = e,
                        u = (e) => {
                            0 == oet_story_embed.version_58 && (e = e.hex), b({ calloutColor: e, isChanged: !0 });
                        };
                    return (
                        m !== s.blockId && b({ blockId: m }),
                        (void 0 !== s.isChanged && 0 != s.isChanged) ||
                            (t = (0, n.createElement)(
                                "div",
                                { className: "admin-story-embed-heading" },
                                (0, n.createElement)(
                                    "div",
                                    { className: "oet-story-embed-block" },
                                    (0, n.createElement)(
                                        "div",
                                        { className: "story-embed-box col-sm-6 col-md-6 " },
                                        (0, n.createElement)(
                                            "div",
                                            { className: "story-embed-content" },
                                            (0, n.createElement)(
                                                "div",
                                                { className: "story-embed-desc" },
                                                (0, n.createElement)(c.SelectControl, {
                                                    label: (0, r.__)("Import a story:", "oet-story-embed-block"),
                                                    options: s.stories,
                                                    value: s.storyId,
                                                    onChange: (e) => {
                                                        b({ storyId: e });
                                                    },
                                                }),
                                                (0, n.createElement)(
                                                    "div",
                                                    { className: "btnImportStory" },
                                                    (0, n.createElement)(
                                                        c.Button,
                                                        {
                                                            className: "btn-save-story components-button is-primary",
                                                            onClick: () => {
                                                                0 != s.storyId
                                                                    ? wp.apiFetch({ url: oet_story_embed.home_url + "/wp-json/oet/v2/story/" + s.storyId }).then((e) => {
                                                                          console.log(e), b({ title: e.title, content: e.content, isChanged: !0 });
                                                                      })
                                                                    : (i()("#block-" + s.blockId + " .oet-story-embed-block .error-notice").html(""),
                                                                      i()("#block-" + s.blockId + " .oet-story-embed-block .error-notice").html("Please select a story to import."));
                                                            },
                                                            isPrimary: !0,
                                                        },
                                                        "Import"
                                                    )
                                                ),
                                                (0, n.createElement)("div", { className: "error-notice" })
                                            )
                                        )
                                    )
                                )
                            )),
                        s.isChanged &&
                            ((y = s),
                            (p = s.blockId),
                            (k = { action: "display_story_embed", attributes: y }),
                            i().ajax({
                                url: oet_story_embed.ajax_url,
                                type: "POST",
                                data: k,
                                success: function (e) {
                                    e.error
                                        ? (i()("#block-" + p + " .oet-story-embed-block").html(""), i()("#block-" + p + " .oet-story-embed-block").html(e.message))
                                        : (i()("#block-" + p + " .oet-story-embed-block").html(""), i()("#block-" + p + " .oet-story-embed-block").html(e));
                                },
                                error: function (e, t, o) {
                                    console.log(o);
                                },
                            })),
                        s.firstLoad &&
                            (wp.apiFetch({ url: oet_story_embed.home_url + "/wp-json/oet/v2/stories" }).then((e) => {
                                b({ stories: e });
                            }),
                            b({ firstLoad: !1 })),
                        [
                            (0, n.createElement)(
                                n.Fragment,
                                null,
                                (0, n.createElement)(
                                    a.InspectorControls,
                                    { key: s.blockId },
                                    (0, n.createElement)(
                                        c.PanelBody,
                                        { title: (0, r.__)("Settings", "oet-story-embed-block"), initialOpen: !0 },
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(c.SelectControl, {
                                                label: (0, r.__)("Story", "oet-story-embed-block"),
                                                options: s.stories,
                                                value: s.storyId,
                                                onChange: (e) => {
                                                    0 != e
                                                        ? wp.apiFetch({ url: oet_story_embed.home_url + "/wp-json/oet/v2/story/" + e }).then((t) => {
                                                              b({ storyId: e, title: t.title, content: t.content, isChanged: !0 });
                                                          })
                                                        : b({ storyId: e, isChanged: !0 });
                                                },
                                            })
                                        ),
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(c.TextControl, {
                                                label: (0, r.__)("Title", "oet-story-embed-block"),
                                                value: s.title,
                                                onChange: (e) => {
                                                    b({ title: e, isChanged: !0 });
                                                },
                                            })
                                        ),
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(c.TextareaControl, {
                                                label: (0, r.__)("Content", "oet-story-embed-block"),
                                                value: s.content,
                                                onChange: (e) => {
                                                    b({ content: e, isChanged: !0 });
                                                },
                                            })
                                        ),
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(c.RangeControl, {
                                                label: (0, r.__)("Width", "oet-story-embed-block"),
                                                value: s.width,
                                                onChange: (e) => {
                                                    b({ width: e, isChanged: !0 });
                                                },
                                                min: 1,
                                                max: 12,
                                            })
                                        ),
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(c.SelectControl, {
                                                label: (0, r.__)("Alignment", "oet-story-embed-block"),
                                                options: o,
                                                value: s.alignment,
                                                onChange: (e) => {
                                                    b({ alignment: e, isChanged: !0 });
                                                },
                                            })
                                        ),
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(
                                                c.BaseControl,
                                                { id: "calloutColor", label: (0, r.__)("Callout color", "oet-story-embed-block") },
                                                1 == oet_story_embed.version_58 && (0, n.createElement)(c.ColorPicker, { color: s.calloutColor, onChange: u, copyFormat: "hex" }),
                                                0 == oet_story_embed.version_58 && (0, n.createElement)(c.ColorPicker, { color: s.calloutColor, onChangeComplete: u, disableAlpha: !0 })
                                            )
                                        ),
                                        (0, n.createElement)(
                                            c.PanelRow,
                                            null,
                                            (0, n.createElement)(c.SelectControl, {
                                                label: (0, r.__)("Callout type", "oet-story_  -block"),
                                                options: l,
                                                value: s.calloutType,
                                                onChange: (e) => {
                                                    b({ calloutType: e, isChanged: !0 });
                                                },
                                            })
                                        )
                                    )
                                )
                            ),
                            (0, n.createElement)("div", (0, a.useBlockProps)(), (0, n.createElement)("div", { className: "oet-story-embed-block" }, t)),
                        ]
                    );
                    var y, p, k;
                }
                var d = JSON.parse(
                    '{"$schema":"https://json.schemastore.org/block.json","apiVersion":2,"name":"oet-block/oet-story-embed-block","version":"0.1.0","title":"Story Embed","category":"oet-block-category","icon":"feedback","description":"Embed story on a page","supports":{"html":false},"attributes":{"storyId":{"type":"string","default":0},"title":{"type":"string"},"content":{"type":"string"},"width":{"type":"number","default":6},"alignment":{"type":"string"},"calloutColor":{"type":"string"},"calloutType":{"type":"string","default":"checkmark"},"stories":{"type":"array"},"isChanged":{"type":"boolean","default":false},"blockId":{"type":"string"},"firstLoad":{"type":"boolean","default":true}},"textdomain":"oet-callout-box-block","editorScript":"file:./build/index.js","editorStyle":"file:./build/index.css","style":"file:./build/style-index.css"}'
                );
                1 == oet_story_embed.version_58
                    ? (0, l.registerBlockType)(d, { edit: b })
                    : (0, l.registerBlockType)("oet-block/oet-story-embed-block", {
                          title: (0, r.__)("Story Embed", "oet-story-embed-block"),
                          category: "oet-block-category",
                          icon: "feedback",
                          supports: { html: !1 },
                          attributes: {
                              storyId: { type: "string", default: 0 },
                              title: { type: "string" },
                              content: { type: "string" },
                              width: { type: "number", default: 6 },
                              alignment: { type: "string" },
                              calloutColor: { type: "string" },
                              calloutType: { type: "string", default: "checkmark" },
                              stories: { type: "array" },
                              isChanged: { type: "boolean", default: !1 },
                              blockId: { type: "string" },
                              firstLoad: { type: "boolean", default: !0 },
                          },
                          edit: b,
                      });
            },
        },
        o = {};
    function l(e) {
        var r = o[e];
        if (void 0 !== r) return r.exports;
        var n = (o[e] = { exports: {} });
        return t[e](n, n.exports, l), n.exports;
    }
    (l.m = t),
        (e = []),
        (l.O = function (t, o, r, n) {
            if (!o) {
                var a = 1 / 0;
                for (b = 0; b < e.length; b++) {
                    (o = e[b][0]), (r = e[b][1]), (n = e[b][2]);
                    for (var c = !0, s = 0; s < o.length; s++)
                        (!1 & n || a >= n) &&
                        Object.keys(l.O).every(function (e) {
                            return l.O[e](o[s]);
                        })
                            ? o.splice(s--, 1)
                            : ((c = !1), n < a && (a = n));
                    if (c) {
                        e.splice(b--, 1);
                        var i = r();
                        void 0 !== i && (t = i);
                    }
                }
                return t;
            }
            n = n || 0;
            for (var b = e.length; b > 0 && e[b - 1][2] > n; b--) e[b] = e[b - 1];
            e[b] = [o, r, n];
        }),
        (l.n = function (e) {
            var t =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return l.d(t, { a: t }), t;
        }),
        (l.d = function (e, t) {
            for (var o in t) l.o(t, o) && !l.o(e, o) && Object.defineProperty(e, o, { enumerable: !0, get: t[o] });
        }),
        (l.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (function () {
            var e = { 826: 0, 431: 0 };
            l.O.j = function (t) {
                return 0 === e[t];
            };
            var t = function (t, o) {
                    var r,
                        n,
                        a = o[0],
                        c = o[1],
                        s = o[2],
                        i = 0;
                    if (
                        a.some(function (t) {
                            return 0 !== e[t];
                        })
                    ) {
                        for (r in c) l.o(c, r) && (l.m[r] = c[r]);
                        if (s) var b = s(l);
                    }
                    for (t && t(o); i < a.length; i++) (n = a[i]), l.o(e, n) && e[n] && e[n][0](), (e[n] = 0);
                    return l.O(b);
                },
                o = (self.webpackChunkoet_story_embed = self.webpackChunkoet_story_embed || []);
            o.forEach(t.bind(null, 0)), (o.push = t.bind(null, o.push.bind(o)));
        })();
    var r = l.O(void 0, [431], function () {
        return l(557);
    });
    r = l.O(r);
})();
