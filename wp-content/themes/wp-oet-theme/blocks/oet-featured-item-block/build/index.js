!(function () {
    "use strict";
    var e,
        t = {
            502: function () {
                var e = window.wp.blocks,
                    t = JSON.parse(
                        '{"TN":"Featured Item","W3":"oet-block-category","qv":"pressthis","WL":"Add featured item block","Y4":{"blockid":{"type":"string"},"oetblkFeaturedItemHeading":{"type":"string"},"oetblkFeaturedItemTitle":{"type":"string"},"oetblkFeaturedItemDate":{"type":"string"},"oetblkFeaturedItemButtonDisplay":{"type":"boolean","default":true},"mediaID":{"type":"number","source":"attribute","attribute":"data-id","selector":"img"},"mediaURL":{"type":"string","source":"attribute","attribute":"src","selector":"img"},"thumbnail":{"type":"string","source":"attribute","attribute":"data-thumb","selector":"img"},"thumbnailsize":{"type":"integer"}}}'
                    ),
                    j = window.jQuery,
                    a = window.wp.element,
                    l = window.wp.i18n,
                    o = window.wp.blockEditor,
                    i = window.wp.components;
                const r = ["image"];
                function n(e) {
                    let { mediaID: t, onSelect: l } = e;
                    return (0, a.createElement)(
                        o.MediaUploadCheck,
                        null,
                        (0, a.createElement)(o.MediaUpload, {
                            onSelect: l,
                            allowedTypes: r,
                            value: t,
                            render: (e) => {
                                let { open: t } = e;
                                return (0, a.createElement)(i.Button, { onClick: t, className: "button button-large oet-featured-item-addedit-image-button noimage" }, "Upload Image");
                            },
                        })
                    );
                }
                function d(e) {
                    const t = e.attributes,
                        r = e.setAttributes;
                    let d = window.oercurrBlocksJson ? (0, o.useBlockProps)() : "";
                    function c(e) {
                        e.map((e) => {
                            if ("oet-block/oet-featured-item-block" == e.name) {
                                var t = "cb" + new Date().getTime(),
                                    a = e.clientId;
                                wp.data.select("core/block-editor").getBlockAttributes(a).blockid || wp.data.dispatch("core/block-editor").updateBlockAttributes(a, { blockid: t });
                            }
                            e.innerBlocks.length > 0 && c(e.innerBlocks);
                        });
                    }
                    document.body.addEventListener("keydown", function (e) {
                        if ("Backspace" == e.key) {
                            let t = wp.data.select("core/block-editor").getSelectionStart();
                            j(e.target).closest(".oet_featured_item_block_wrapper").length && "offset" in t && 0 === t.offset && e.preventDefault();
                        }
                    }),
                        wp.data
                            .select("core/block-editor")
                            .getBlocks()
                            .map((e) => {
                                if ("oet-block/oet-featured-item-block" == e.name) {
                                    var t = "cb" + new Date().getTime(),
                                        a = e.clientId;
                                    wp.data.select("core/block-editor").getBlockAttributes(a).blockid || wp.data.dispatch("core/block-editor").updateBlockAttributes(a, { blockid: t });
                                } else ("core/group" != e.name && "core/columns" != e.name) || c(e.innerBlocks);
                            });
                    new Date();
                    let s = [];
                    const u = [
                        { value: "h1", label: "H1" },
                        { value: "h2", label: "H2" },
                        { value: "h3", label: "H3" },
                        { value: "h4", label: "H4" },
                        { value: "h5", label: "H5" },
                        { value: "h6", label: "H6" },
                    ];
                    return (
                        (s = t.oetblkFeaturedItemButtonDisplay
                            ? [
                                  [
                                      "core/paragraph",
                                      { placeholder: "Featured Item Description", className: "oet-featured-item-content oet-featured-item-content-ytr85g9wer", align: "left", textColor: "oet-color-pallete-black", fontSize: "normal" },
                                  ],
                                  ["core/button", { className: "oet-featured-item-button oet-featured-item-button-ytr85g9wer", align: "left", text: "Button Text", backgroundColor: "oet-color-pallete-orange", textColor: "white" }],
                              ]
                            : [
                                  [
                                      "core/paragraph",
                                      { placeholder: "Featured Item Description", className: "oet-featured-item-content oet-featured-item-content-ytr85g9wer", align: "left", textColor: "oet-color-pallete-black", fontSize: "normal" },
                                  ],
                                  ["core/button", { className: "oet-featured-item-button oet-featured-item-button-ytr85g9wer hidden", align: "left", text: "Button Text", backgroundColor: "oet-color-pallete-orange", textColor: "white" }],
                              ]),
                        (0, a.createElement)(
                            "div",
                            d,
                            (0, a.createElement)(
                                "div",
                                { className: "oet_featured_item_block_wrapper" },
                                (0, a.createElement)(
                                    o.InspectorControls,
                                    null,
                                    (0, a.createElement)(
                                        PanelBody,
                                        { title: (0, l.__)("Featured Item Block settings"), initialOpen: !0 },
                                        (0, a.createElement)(
                                            "div",
                                            { class: "oet_featured_item_inspector_wrapper" },
                                            (0, a.createElement)(i.SelectControl, {
                                                label: (0, l.__)("Heading Tag"),
                                                value: t.oetblkHeadingTag,
                                                options: u,
                                                onChange: (e) => {
                                                    r({ oetblkHeadingTag: e });
                                                },
                                            }),
                                            (0, a.createElement)(i.SelectControl, {
                                                label: (0, l.__)("Title Tag"),
                                                value: t.oetblkTitleTag,
                                                options: u,
                                                onChange: (e) => {
                                                    r({ oetblkTitleTag: e });
                                                },
                                            }),
                                            (0, a.createElement)(i.SelectControl, {
                                                label: (0, l.__)("Publishing Date Tag"),
                                                value: t.oetblkDateTag,
                                                options: u,
                                                onChange: (e) => {
                                                    r({ oetblkDateTag: e });
                                                },
                                            }),
                                            (0, a.createElement)(i.ToggleControl, {
                                                label: (0, l.__)("Show Button"),
                                                help: t.oetblkFeaturedItemButtonDisplay ? (0, l.__)("Show Featured Item Button", "five") : (0, l.__)("Hide Featured Item Button", "five"),
                                                checked: !!t.oetblkFeaturedItemButtonDisplay,
                                                onChange: (e) => {
                                                    return (a = !t.oetblkFeaturedItemButtonDisplay), void r({ oetblkFeaturedItemButtonDisplay: a });
                                                    var a;
                                                },
                                            }),
                                            (() => {
                                                if (t.mediaURL)
                                                    return (0, a.createElement)(i.RangeControl, {
                                                        label: (0, l.__)("Image Size"),
                                                        value: t.thumbnailsize,
                                                        onChange: (e) => {
                                                            r({ thumbnailsize: e, titlesize: 100 - e });
                                                        },
                                                        help: (0, l.__)("Image width in percentage", "five"),
                                                        min: 1,
                                                        max: 100,
                                                    });
                                            })()
                                        )
                                    )
                                ),
                                (0, a.createElement)(
                                    "div",
                                    { class: t.oetblkFeaturedItemButtonDisplay ? "oet-shortcode oet_featured_item_block oetblk-" + t.blockid : "oet-shortcode oet_featured_item_block oetblk-" + t.blockid + " hidebutton" },
                                    (0, a.createElement)(
                                        "div",
                                        { class: "col-md-12 col-sm-12 col-xs-12 rght_sid_mtr lft_sid_mtr" },
                                        (0, a.createElement)(
                                            t.oetblkHeadingTag,
                                            { class: "oet_featured_item_header" },
                                            (0, a.createElement)("input", {
                                                type: "text",
                                                class: "oet-featured-item-header-input",
                                                onChange: (e) => {
                                                    r({ oetblkFeaturedItemHeading: e.target.value });
                                                },
                                                placeholder: "Featured Item Heading",
                                                value: t.oetblkFeaturedItemHeading,
                                            })
                                        ),
                                        (0, a.createElement)(
                                            "div",
                                            {
                                                class: t.mediaURL ? "oet-featured-item-image-wrapper-float-left" : "oet-featured-item-image-wrapper-float-left minheight",
                                                style: void 0 !== t.thumbnailsize ? { width: t.thumbnailsize + "%" } : { width: "110px" },
                                            },
                                            (0, a.createElement)("img", { src: t.mediaURL, class: t.mediaURL ? "featured_item_image oet-featured-item-image" : "hidden", alt: "featured_item_image" }),
                                            t.mediaURL
                                                ? (0, a.createElement)(
                                                      i.Button,
                                                      {
                                                          onClick: (t) => {
                                                              e.setAttributes({ mediaID: void 0, mediaURL: void 0, thumbnail: void 0, thumbnailsize: void 0 });
                                                          },
                                                          className: "button button-large oet-featured-item-delete-image-button noimage",
                                                      },
                                                      (0, a.createElement)("span", { class: "dashicons dashicons-trash" })
                                                  )
                                                : (0, a.createElement)(n, {
                                                      mediaID: t.mediaID,
                                                      onSelect: (e) => {
                                                          r({ mediaID: e.id, mediaURL: e.url, thumbnail: e.sizes.thumbnail.url, thumbnailsize: 50 });
                                                      },
                                                  })
                                        ),
                                        void 0 === t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h3",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h1" == t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h1",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h2" == t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h2",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h3" == t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h3",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h4" == t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h4",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h5" == t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h5",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h6" == t.oetblkTitleTag
                                            ? (0, a.createElement)(
                                                  "h6",
                                                  { class: "oet-featured-item-title" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemTitle: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemTitle,
                                                      class: "oet-color-pallete-orange-color oet-featured-item-title nolink",
                                                      placeholder: "Featured Item Title",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : void 0,
                                        "h1" == t.oetblkDateTag
                                            ? (0, a.createElement)(
                                                  "h1",
                                                  { class: "oet-featured-item-date" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemDate: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemDate,
                                                      class: "oet-featured-item-date-input nolink",
                                                      placeholder: "Publishing Date",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h2" == t.oetblkDateTag
                                            ? (0, a.createElement)(
                                                  "h2",
                                                  { class: "oet-featured-item-date" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemDate: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemDate,
                                                      class: "oet-featured-item-date-input nolink",
                                                      placeholder: "Publishing Date",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h3" == t.oetblkDateTag
                                            ? (0, a.createElement)(
                                                  "h3",
                                                  { class: "oet-featured-item-date" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemDate: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemDate,
                                                      class: "oet-featured-item-date-input nolink",
                                                      placeholder: "Publishing Date",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h4" == t.oetblkDateTag
                                            ? (0, a.createElement)(
                                                  "h4",
                                                  { class: "oet-featured-item-date" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemDate: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemDate,
                                                      class: "oet-featured-item-date-input nolink",
                                                      placeholder: "Publishing Date",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h5" == t.oetblkDateTag
                                            ? (0, a.createElement)(
                                                  "h5",
                                                  { class: "oet-featured-item-date" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemDate: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemDate,
                                                      class: "oet-featured-item-date-input nolink",
                                                      placeholder: "Publishing Date",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : "h6" == t.oetblkDateTag
                                            ? (0, a.createElement)(
                                                  "h6",
                                                  { class: "oet-featured-item-date" },
                                                  (0, a.createElement)("input", {
                                                      type: "text",
                                                      onChange: (e) => {
                                                          r({ oetblkFeaturedItemDate: e.target.value });
                                                      },
                                                      value: t.oetblkFeaturedItemDate,
                                                      class: "oet-featured-item-date-input nolink",
                                                      placeholder: "Publishing Date",
                                                      style: t.titlesize > 10 ? { width: "auto", resize: "none" } : { width: "100%", resize: "none" },
                                                  })
                                              )
                                            : void 0,
                                        (0, a.createElement)(o.InnerBlocks, { allowedBlocks: ["core/paragraph"], templateInsertUpdatesSelection: !1, template: s, templateLock: "all" })
                                    )
                                )
                            )
                        )
                    );
                }
                function c(e) {
                    const t = e.attributes;
                    if (t.oetblkHeadingTag=="" || typeof t.oetblkHeadingTag === 'undefined')
                        t.oetblkHeadingTag="h2";
                    if (t.oetblkTitleTag=="" || typeof t.oetblkTitleTag === 'undefined')
                        t.oetblkTitleTag="h3";
                    if (t.oetblkDateTag=="" || typeof t.oetblkDateTag === 'undefined')
                        t.oetblkDateTag="h4";
                    return (0, a.createElement)(
                        "div",
                        null,
                        (0, a.createElement)(
                            "div",
                            { className: "oet_featured_item_block_wrapper" },
                            (0, a.createElement)(
                                "div",
                                { class: t.oetblkFeaturedItemButtonDisplay ? "oet-shortcode oet_featured_item_block oetblk-" + t.blockid : "oet-shortcode oet_featured_item_block oetblk-" + t.blockid + " hidebutton" },
                                (0, a.createElement)(
                                    "div",
                                    { class: "col-md-12 col-sm-12 col-xs-12 rght_sid_mtr lft_sid_mtr" },
                                    (0, a.createElement)(t.oetblkHeadingTag, { class: "oet_featured_item_header" }, t.oetblkFeaturedItemHeading),
                                    (0, a.createElement)(
                                        "div",
                                        { class: "oet-featured-item-image-wrapper-float-left", style: void 0 !== t.thumbnailsize ? { width: t.thumbnailsize + "%" } : { margin: "0" } },
                                        t.mediaURL && (0, a.createElement)("img", { src: t.mediaURL, class: "featured_item_image oet-featured-item-image", alt: "" })
                                    ),
                                    (0, a.createElement)(t.oetblkTitleTag, { class: "oet-featured-item-title oet-featured-item-title-ytr85g9wer has-oet-color-pallete-orange-color has-text-color" }, t.oetblkFeaturedItemTitle),
                                    (0, a.createElement)(t.oetblkDateTag, { class: "oet-featured-item-date oet-featured-item-date-ytr85g9wer has-oet-color-pallete-black-color has-text-color" }, t.oetblkFeaturedItemDate),
                                    (0, a.createElement)(o.InnerBlocks.Content, null)
                                )
                            )
                        )
                    );
                }
                const { __: s } = wp.i18n;
                (window.oercurrBlocksJson = "undefined" == typeof oet_featured_item_legacy_marker),
                    window.oercurrBlocksJson
                        ? (0, e.registerBlockType)("oet-block/oet-featured-item-block", { edit: d, save: c, example: () => {} })
                        : (0, e.registerBlockType)("oet-block/oet-featured-item-block", {
                              title: s(t.TN),
                              icon: t.qv,
                              description: s(t.WL),
                              category: t.W3,
                              keywords: [s("oet"), s("featured"), s("item"), s("block")],
                              attributes: t.Y4,
                              edit: d,
                              save: c,
                              example: () => {},
                          });
            },
        },
        a = {};
    function l(e) {
        var o = a[e];
        if (void 0 !== o) return o.exports;
        var i = (a[e] = { exports: {} });
        return t[e](i, i.exports, l), i.exports;
    }
    (l.m = t),
        (e = []),
        (l.O = function (t, a, o, i) {
            if (!a) {
                var r = 1 / 0;
                for (s = 0; s < e.length; s++) {
                    (a = e[s][0]), (o = e[s][1]), (i = e[s][2]);
                    for (var n = !0, d = 0; d < a.length; d++)
                        (!1 & i || r >= i) &&
                        Object.keys(l.O).every(function (e) {
                            return l.O[e](a[d]);
                        })
                            ? a.splice(d--, 1)
                            : ((n = !1), i < r && (r = i));
                    if (n) {
                        e.splice(s--, 1);
                        var c = o();
                        void 0 !== c && (t = c);
                    }
                }
                return t;
            }
            i = i || 0;
            for (var s = e.length; s > 0 && e[s - 1][2] > i; s--) e[s] = e[s - 1];
            e[s] = [a, o, i];
        }),
        (l.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (function () {
            var e = { 826: 0, 46: 0 };
            l.O.j = function (t) {
                return 0 === e[t];
            };
            var t = function (t, a) {
                    var o,
                        i,
                        r = a[0],
                        n = a[1],
                        d = a[2],
                        c = 0;
                    if (
                        r.some(function (t) {
                            return 0 !== e[t];
                        })
                    ) {
                        for (o in n) l.o(n, o) && (l.m[o] = n[o]);
                        if (d) var s = d(l);
                    }
                    for (t && t(a); c < r.length; c++) (i = r[c]), l.o(e, i) && e[i] && e[i][0](), (e[r[c]] = 0);
                    return l.O(s);
                },
                a = (self.webpackChunkoese_featured_item_block = self.webpackChunkoese_featured_item_block || []);
            a.forEach(t.bind(null, 0)), (a.push = t.bind(null, a.push.bind(a)));
        })();
    var o = l.O(void 0, [46], function () {
        return l(502);
    });
    o = l.O(o);
})();