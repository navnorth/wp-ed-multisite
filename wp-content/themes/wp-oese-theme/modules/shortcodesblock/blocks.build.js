/**
 * BLOCK: oese-shortcodes-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
//  Import CSS.
const { __ } = wp.i18n; // Import __() from wp.i18n

const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

const { InspectorControls } = wp.blockEditor;
const { BaseControl, Panel, PanelRow, PanelBody, } = wp.components;

const {
  CheckboxControl,
  RadioControl,
  TextControl,
  ToggleControl,
  SelectControl
} = wp.components;


const { withSelect } = wp.data;
/**
 * Register: aa Gutenberg Block.
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

registerBlockType("cgb/block-oese-shortcodes-block", {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __("OESE Shortcode Block"),
  // Block title.
  icon: "shortcode",
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: "common",
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [__("OESE Shortcode Block"), __("shortcode")],
  attributes: {
    blockid: {
      type: "string"
    },
    oeseShortcodeOption: {
      type: "object"
    },
    selectedShortode: {
      type: "string"
    },
    selectedShortodeValue: {
      type: "string"
    },
    selectedShortodeHtml: {
      type: "string"
    },
    displayflex: {
      type: "boolean",
      default: false
    }
  },

  /**
   * The edit function describes the structure of your block in the context of the editor.
   * This represents what the editor will render when the block is used.
   *
   * The "edit" property must be a valid function.
   *
   * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
   *
   * @param {Object} props Props.
   * @returns {Mixed} JSX Component.
   */
  edit: (props) => {
    // Creates a <p class='wp-block-cgb-block-oese-shortcodes-block'></p>.
    const attributes = props.attributes;
    const setAttributes = props.setAttributes;
    const blocks = wp.data.select("core/block-editor").getBlocks();
    blocks.map((val) => {
      if (val.name == "cgb/block-oese-shortcodes-block") {
        var uniq = "cb" + new Date().getTime();
        var cid = val.clientId;
        var attr = wp.data.select("core/block-editor").getBlockAttributes(cid);

        if (!attr.blockid) {
          wp.data.dispatch("core/block-editor").updateBlockAttributes(cid, {
            blockid: uniq
          });
        }
      }
    });

    if (!attributes.oeseShortcodeOption) {
      wp.apiFetch({
        url: "/wp-json/oeseshortcodeblock/v2/optionsquery?param=test"
      }).then((data) => {
        setAttributes({
          oeseShortcodeOption: data
        });
      });
    }

    if (!attributes.oeseShortcodeOption) {
      return "Loading OESE Shortcode Options...";
    }

    let cur_options = [];
    cur_options = attributes.oeseShortcodeOption;

    function updateSelectedShortcode(e) {
      let idx = e.target.options[e.target.selectedIndex].getAttribute("idx");
      setAttributes({
        selectedShortode: e.target.value
      });
      let selshort = cur_options[idx]["value"];
      setAttributes({
        selectedShortodeValue: selshort
      });
      updateShortcodeHtml(selshort);
    }

    function updateShortcodeValue(e) {
      setAttributes({
        selectedShortodeValue: e.target.value
      });
      updateShortcodeHtml(e.target.value);
    }

    function updateShortcodeHtml(shrtcd) {
      wp.apiFetch({
        url:
          "/wp-json/oeseshortcodeblock/v2/shortcodequery?shrtcd=" +
          encodeURIComponent(shrtcd)
      }).then((data) => {
        setAttributes({
          selectedShortodeHtml: data
        });
      });
    }

    function oeseshortcodeblock_shortcode_reset(e) {
      if (attributes.selectedShortode !== undefined) {
        var i;

        for (i = 0; i < cur_options.length; i++) {
          if (cur_options[i]["name"] == attributes.selectedShortode) {
            setAttributes({
              selectedShortodeValue: cur_options[i]["value"]
            });
            updateShortcodeHtml(cur_options[i]["value"]);
          }
        }
      }
    }

    const onChangeDisplayflex = (e) => {
      setAttributes({
        displayflex: e
      });
    };

    return /*#__PURE__*/ React.createElement(
      "div",
      null,
      /*#__PURE__*/ React.createElement(
        InspectorControls,
        null,
        /*#__PURE__*/ React.createElement(
          BaseControl,
          {
            className: "oese_shortcodes_block_control"
          },
          /*#__PURE__*/ React.createElement(
            PanelBody,
            {
              title: __("OESE Shortcodes Settings"),
              initialOpen: true,
              className: "components-base-control__label"
            },
            /*#__PURE__*/ React.createElement(
              PanelRow,
              null,
              /*#__PURE__*/ React.createElement(
                "div",
                {
                  class: "lp_inspector_wrapper lp_inspector_Postperpage"
                },
                /*#__PURE__*/ React.createElement(
                  "label",
                  {
                    class: "components-base-control__label",
                    for: "oeseshortcodeblock_shortcode_option"
                  },
                  "Option:"
                ),
                /*#__PURE__*/ React.createElement(
                  "select",
                  {
                    id: "oeseshortcodeblock_shortcode_option",
                    onChange: updateSelectedShortcode
                  },
                  /*#__PURE__*/ React.createElement(
                    "option",
                    {
                      selected: true,
                      value: ""
                    },
                    "Select Shortcode"
                  ),
                  cur_options.map((incr, index) => {
                    if (incr["name"] == attributes.selectedShortode) {
                      return /*#__PURE__*/ React.createElement(
                        "option",
                        {
                          selected: true,
                          idx: index,
                          value: incr["name"]
                        },
                        incr["name"]
                      );
                    } else {
                      return /*#__PURE__*/ React.createElement(
                        "option",
                        {
                          idx: index,
                          value: incr["name"]
                        },
                        incr["name"]
                      );
                    }
                  })
                ),
                /*#__PURE__*/ React.createElement(
                  "label",
                  {
                    class: "components-base-control__label padded",
                    for: "oeseshortcodeblock_shortcode_editor"
                  },
                  "Shortcode:"
                ),
                /*#__PURE__*/ React.createElement("textarea", {
                  id: "oeseshortcodeblock_shortcode_editor",
                  onChange: updateShortcodeValue,
                  name: "oeseshortcodeblock_shortcode_textarea",
                  rows: "20",
                  cols: "24",
                  value: attributes.selectedShortodeValue
                }),
                /*#__PURE__*/ React.createElement(ToggleControl, {
                  label: __("Display as Flex"),
                  help: attributes.displayflex
                    ? __("Shortcode will be displayed as as flex", "five")
                    : __(
                        "Shortcode will be displayed as block and text will wrap around the shortcode.",
                        "five"
                      ),
                  checked: !!attributes.displayflex,
                  onChange: (value) =>
                    onChangeDisplayflex(attributes.displayflex ? false : true)
                }),
                /*#__PURE__*/ React.createElement("input", {
                  class: "oeseshortcodeblock_shortcode_reset",
                  type: "button",
                  onClick: oeseshortcodeblock_shortcode_reset,
                  value: "Reset",
                  selshrt: attributes.selectedShortode
                })
              )
            )
          )
        )
      ),
      /*#__PURE__*/ React.createElement(
        "div",
        null,
        /*#__PURE__*/ React.createElement("div", {
          className: attributes.displayflex
            ? "oese_shortcode_cgb_container flx"
            : "oese_shortcode_cgb_container",
          dangerouslySetInnerHTML: {
            __html: attributes.selectedShortodeHtml
          }
        })
      )
    );
  },

  /**
   * The save function defines the way in which the different attributes should be combined
   * into the final markup, which is then serialized by Gutenberg into post_content.
   *
   * The "save" property must be specified and must be a valid function.
   *
   * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
   *
   * @param {Object} props Props.
   * @returns {Mixed} JSX Frontend HTML.
   */
  save: (props) => {
    return /*#__PURE__*/ React.createElement(
      "div",
      {
        className: props.className
      },
      /*#__PURE__*/ React.createElement(
        "p",
        null,
        "\u2014 Hello from the frontend."
      ),
      /*#__PURE__*/ React.createElement(
        "p",
        null,
        "CGB BLOCK: ",
        /*#__PURE__*/ React.createElement(
          "code",
          null,
          "oese-shortcodes-block"
        ),
        " is a new Gutenberg block."
      ),
      /*#__PURE__*/ React.createElement(
        "p",
        null,
        "It was created via",
        " ",
        /*#__PURE__*/ React.createElement(
          "code",
          null,
          /*#__PURE__*/ React.createElement(
            "a",
            {
              href: "https://github.com/ahmadawais/create-guten-block"
            },
            "create-guten-block"
          )
        ),
        "."
      )
    );
  }
});
