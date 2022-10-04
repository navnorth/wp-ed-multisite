/**
 * BLOCK: oet-accordion-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
const { __ } = wp.i18n; // Import __() from wp.i18n

const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

const { InspectorControls, InnerBlocks, useBlockProps } = wp.blockEditor;
const { BaseControl, Panel, PanelRow, PanelBody } = wp.components;
const {
  CheckboxControl,
  RadioControl,
  TextControl,
  ToggleControl,
  SelectControl
} = wp.components;
const { withSelect } = wp.data;
const accordionicon = wp.element.createElement(
  "svg",
  {
    width: 24,
    height: 24,
    role: "img",
    viewBox: "0 0 6.35 6.35"
  },
  wp.element.createElement(
    "g",
    {
      transform: "translate(0 -290.65)",
      fill: "none",
      stroke: "#000",
      "stroke-width": ".26458px"
    },
    wp.element.createElement("path", {
      d: "m0.31955 290.93c-0.086366 1.52-0.13818 1.5373-0.086366 1.52 0.051819-0.0173 5.9419 9e-3 5.9419 9e-3l-0.017272-1.52z"
    }),
    wp.element.createElement("path", {
      d: "m4.681 291.32 0.55274 0.6391 0.46637-0.63046"
    }),
    wp.element.createElement("path", {
      d: "m4.0678 291.67-3.1783-0.0259"
    }),
    wp.element.createElement("path", {
      d: "m0.29467 293.01c-0.086365 1.52-0.13818 1.5373-0.086365 1.52 0.051819-0.0173 5.9419 9e-3 5.9419 9e-3l-0.017272-1.52z"
    }),
    wp.element.createElement("path", {
      d: "m4.6561 293.4 0.55274 0.6391 0.46637-0.63046"
    }),
    wp.element.createElement("path", {
      d: "m4.0429 293.76-3.1783-0.0259"
    }),
    wp.element.createElement("path", {
      d: "m0.30331 295.11c-0.086366 1.52-0.13818 1.5373-0.086366 1.52 0.051819-0.0173 5.9419 9e-3 5.9419 9e-3l-0.017272-1.52z"
    }),
    wp.element.createElement("path", {
      d: "m4.6648 295.5 0.55274 0.6391 0.46637-0.63046"
    }),
    wp.element.createElement("path", {
      d: "m4.0516 295.86-3.1783-0.0259"
    })
  )
);
/**
 * Register: a Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType("cgb/oet-accordion-block", {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __("Accordion Block"),
  // Block title.
  icon: accordionicon,
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: "oet-block-category",
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [__("oet-accordion-block"), __("accordion")],
  attributes: {
    blockid: {
      type: "string"
    },
    accordionexpanded: {
      type: "boolean",
      default: true
    },
    accordiontitle: {
      type: "string"
    },
    accordionheading: {
      type: "string",
      default: "h2"
    }
  },
  edit: (props) => {
    const attributes = props.attributes;
    const setAttributes = props.setAttributes; //Set block instance ID
    const clientId = props.clientId;

    const headingLevels = [
                            { value: "h1", label: "H1"},
                            { value: "h2", label: "H2"},
                            { value: "h3", label: "H3"},
                            { value: "h4", label: "H4"},
                            { value: "h5", label: "H5"},
                            { value: "h6", label: "H6"}
                          ];

    let oetblk_accordion_list = [];
    const blocks = wp.data.select("core/block-editor").getBlocks();
    const CONTENT_TEMPLATE = [
      [
        "core/paragraph",
        {
          placeholder: "Your accordion content here."
        }
      ]
    ];
    blocks.map((val) => {
  
      if (val.name == "cgb/oet-accordion-block") {
        var uniq = "cb" + new Date().getTime();
        var cid = val.clientId;
        var attr = wp.data.select("core/block-editor").getBlockAttributes(cid);

        if (!attr.blockid) {
          wp.data.dispatch("core/block-editor").updateBlockAttributes(cid, {
            blockid: uniq,
            postsPerPage: 5,
            sortBy: "modified"
          });
        }
      } else if (val.name == "core/group" || val.name == "core/columns") {
        getInnerBlocks(val.innerBlocks);
      }
    });

    function getInnerBlocks(innerblock) {
      innerblock.map((blk) => {
        if (blk.name == "cgb/oet-accordion-block") {
          var inuniq = "cb" + new Date().getTime();
          var incid = blk.clientId;
          var inattr = wp.data
            .select("core/block-editor")
            .getBlockAttributes(incid); 

          if (!inattr.blockid) {
            wp.data.dispatch("core/block-editor").updateBlockAttributes(incid, {
              blockid: inuniq,
              postsPerPage: 5,
              sortBy: "modified"
            });
          }
        }

        if (blk.innerBlocks.length > 0) {
          getInnerBlocks(blk.innerBlocks);
        }
      });
    }

    const accordiontitlechange = (e) => {
      setAttributes({
        accordiontitle: e.target.value
      });
    };

    const accordioncollapsetoggle = (e) => {
      setAttributes({
        accordionexpanded: e
      });
    };

    const accordionheadingchange = (e) => {
      setAttributes({ accordionheading: e });
    }

    let arr = Array.apply(null, {
      length: 10
    }).map(Number.call, Number); // Creates a <p class='wp-block-cgb-block-oet-accordion-block'></p>.

    const setBlockId = (blockid) =>  { setAttributes( { blockid } ); }

    if( clientId !== attributes.blockid ){
      setBlockId(clientId);
    }
    return React.createElement(
      "div",
      {
        className: props.className
      },
      React.createElement(
        InspectorControls,
        null,
        React.createElement(
          PanelBody,
          {
            title: __("Accordion Block settings"),
            initialOpen: true
          },
          React.createElement(
            "div",
            {
              class:
                "oer_curriculum_inspector_wrapper oer_curriculum_inspector_Postperpage"
            },
            React.createElement(ToggleControl, {
              label: __("Expanded"),
              help: attributes.accordionexpanded
                ? __("Accordion content will be shown initially", "five")
                : __("Accordion content will be hidden initially", "five"),
              checked: !!attributes.accordionexpanded,
              onChange: (value) =>
                accordioncollapsetoggle(
                  attributes.accordionexpanded ? false : true
                )
            }),
          ),
          React.createElement(
            "div",
            {
              class:
                "oer_curriculum_inspector_wrapper oer_curriculum_inspector_Postperpage"
            },
            React.createElement(SelectControl, {
              label: __("Heading Tag"),
              value: attributes.accordionheading,
              options: headingLevels,
              onChange: (value) =>
                accordionheadingchange(value)
            }),
          ),
        )
      ),
      React.createElement(
        "div",
        {
          class: "oetblk-" + attributes.blockid
        },
        React.createElement(
          "div",
          {
            class: "oet-blk-accordion",
            id: "oet-blk-accordion-parent-" + attributes.blockid
          },
          React.createElement(
            "div",
            {
              class: "z-depth-0 bordered"
            },
            React.createElement(
              "div",
              {
                class: "oet-blk-accordion-header",
                id: "headingOne"
              },
              React.createElement(
                attributes.accordionheading,
                {
                  class: "mb-0 oet-blk-accordion-title"
                },
                React.createElement(
                  "a",
                  {
                    class: attributes.accordionexpanded
                      ? "btn btn-primary oet-blk-accordion-button"
                      : "btn btn-primary oet-blk-accordion-button collapsed",
                    "data-toggle": "collapse",
                    href: "#" + attributes.blockid + "-oetCollapse",
                    role: "button",
                    "aria-expanded": attributes.accordionexpanded,
                    "aria-controls": attributes.blockid+"-oetCollapse"
                  },
                  React.createElement("input", {
                    type: "text",
                    onChange: accordiontitlechange,
                    placeholder: "Accordion Title",
                    value: attributes.accordiontitle
                  })
                )
              )
            ),
            React.createElement(
              "div",
              {
                id: attributes.blockid + "-oetCollapse",
                class: attributes.accordionexpanded
                  ? "oet-blk-accordion-content collapse show in"
                  : "oet-blk-accordion-content collapse",
                "aria-labelledby": "headingOne",
                tabindex: "0"
              },
              React.createElement(
                "div",
                {
                  class: "card-body"
                },
                React.createElement(InnerBlocks, {
                  allowedBlocks: ["core/image", "core/paragraph"],
                  templateInsertUpdatesSelection: false,
                  template: CONTENT_TEMPLATE
                  /*templateLock="all"*/
                })
              )
            )
          )
        )
      )
    );
  },
  save: (props) => {
    const attributes = props.attributes;
    return React.createElement(
      "div",
      {
        className: props.className
      },
      React.createElement(
        "div",
        {
          class: "oetblk-" + attributes.blockid
        },
        React.createElement(
          "div",
          {
            class: "oet-blk-accordion",
            id: "oet-blk-accordion-parent-" + attributes.blockid
          },
          React.createElement(
            "div",
            {
              class: "z-depth-0 bordered"
            },
            React.createElement(
              "div",
              {
                class: "oet-blk-accordion-header",
                id: "headingOne"
              },
              React.createElement(
                attributes.accordionheading,
                {
                  class: "mb-0 oet-blk-accordion-title"
                },
                React.createElement(
                  "a",
                  {
                    class: attributes.accordionexpanded
                      ? "btn btn-primary oet-blk-accordion-button"
                      : "btn btn-primary oet-blk-accordion-button collapsed",
                    "data-toggle": "collapse",
                    href: "#" + attributes.blockid + "-oetCollapse",
                    role: "button",
                    "aria-expanded": attributes.accordionexpanded,
                    "aria-controls": attributes.blockid+"-oetCollapse",
                    "aria-label": attributes.accordiontitle
                  },
                  attributes.accordiontitle
                )
              )
            ),
            React.createElement(
              "div",
              {
                id: attributes.blockid + "-oetCollapse",
                class: attributes.accordionexpanded
                  ? "oet-blk-accordion-content collapse show in"
                  : "oet-blk-accordion-content collapse",
                tabindex: "0"
              },
              React.createElement(
                "div",
                {
                  class: "card-body"
                },
                React.createElement(InnerBlocks.Content, null)
              )
            )
          )
        )
      )
    );
  },
  example: {}
});