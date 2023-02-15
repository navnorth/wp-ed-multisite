/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */





/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
function Edit(props) {
  var display = (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Loading...', 'oese-tabs-block');
  const {
    attributes,
    setAttributes,
    clientId
  } = props;
  const iconList = [{
    value: 'fa-cog',
    label: 'Cog'
  }, {
    value: 'fa-copy',
    label: 'Copy'
  }, {
    value: 'fa-book',
    label: 'Book'
  }, {
    value: 'fa-file-alt',
    label: 'File'
  }, {
    value: 'fa-folder',
    label: 'Folder'
  }, {
    value: 'fa-graduation-cap',
    label: 'Graduation Cap'
  }, {
    value: 'fa-id-card',
    label: 'ID Card'
  }, {
    value: 'fa-laptop',
    label: 'Laptop'
  }, {
    value: 'fa-project-diagram',
    label: 'Project Diagram'
  }, {
    value: 'fa-tools',
    label: 'Tools'
  }, {
    value: 'fa-users',
    label: 'Users'
  }, {
    value: 'fa-user-shield',
    label: 'User Shield'
  }, {
    value: 'fa-wifi',
    label: 'Wifi'
  }];
  const onChangeTabCount = tabCount => {
    setAttributes({
      tabCount: tabCount,
      isChanged: true
    });
  };
  const onChangeTabLabel = (tabLabel, index) => {
    switch (index) {
      case 1:
        setAttributes({
          tab1Label: tabLabel,
          isChanged: true
        });
        break;
      case 2:
        setAttributes({
          tab2Label: tabLabel,
          isChanged: true
        });
        break;
      case 3:
        setAttributes({
          tab3Label: tabLabel,
          isChanged: true
        });
        break;
      case 4:
        setAttributes({
          tab4Label: tabLabel,
          isChanged: true
        });
        break;
      case 5:
        setAttributes({
          tab5Label: tabLabel,
          isChanged: true
        });
        break;
      case 6:
        setAttributes({
          tab6Label: tabLabel,
          isChanged: true
        });
        break;
      case 7:
        setAttributes({
          tab7Label: tabLabel,
          isChanged: true
        });
        break;
      case 8:
        setAttributes({
          tab8Label: tabLabel,
          isChanged: true
        });
        break;
      case 9:
        setAttributes({
          tab9Label: tabLabel,
          isChanged: true
        });
        break;
      case 10:
        setAttributes({
          tab10Label: tabLabel,
          isChanged: true
        });
        break;
    }
  };
  const onChangeTabIcon = (tabIcon, index) => {
    switch (index) {
      case 1:
        setAttributes({
          tab1Icon: tabIcon,
          isChanged: true
        });
        break;
      case 2:
        setAttributes({
          tab2Icon: tabIcon,
          isChanged: true
        });
        break;
      case 3:
        setAttributes({
          tab3Icon: tabIcon,
          isChanged: true
        });
        break;
      case 4:
        setAttributes({
          tab4Icon: tabIcon,
          isChanged: true
        });
        break;
      case 5:
        setAttributes({
          tab5Icon: tabIcon,
          isChanged: true
        });
        break;
      case 6:
        setAttributes({
          tab6Icon: tabIcon,
          isChanged: true
        });
        break;
      case 7:
        setAttributes({
          tab7Icon: tabIcon,
          isChanged: true
        });
        break;
      case 8:
        setAttributes({
          tab8Icon: tabIcon,
          isChanged: true
        });
        break;
      case 9:
        setAttributes({
          tab9Icon: tabIcon,
          isChanged: true
        });
        break;
      case 10:
        setAttributes({
          tab10Icon: tabIcon,
          isChanged: true
        });
        break;
    }
  };
  const onChangeTabContent = (tabContent, index) => {
    switch (index) {
      case 1:
        setAttributes({
          tab1Content: tabContent,
          isChanged: true
        });
        break;
      case 2:
        setAttributes({
          tab2Content: tabContent,
          isChanged: true
        });
        break;
      case 3:
        setAttributes({
          tab3Content: tabContent,
          isChanged: true
        });
        break;
      case 4:
        setAttributes({
          tab4Content: tabContent,
          isChanged: true
        });
        break;
      case 5:
        setAttributes({
          tab5Content: tabContent,
          isChanged: true
        });
        break;
      case 6:
        setAttributes({
          tab6Content: tabContent,
          isChanged: true
        });
        break;
      case 7:
        setAttributes({
          tab7Content: tabContent,
          isChanged: true
        });
        break;
      case 8:
        setAttributes({
          tab8Content: tabContent,
          isChanged: true
        });
        break;
      case 9:
        setAttributes({
          tab9Content: tabContent,
          isChanged: true
        });
        break;
      case 10:
        setAttributes({
          tab10Content: tabContent,
          isChanged: true
        });
        break;
    }
  };
  const onChangeTabEnabled = (tabChecked, index) => {
    switch (index) {
      case 1:
        setAttributes({
          tab1Checked: tabChecked,
          isChanged: true
        });
        break;
      case 2:
        setAttributes({
          tab2Checked: tabChecked,
          isChanged: true
        });
        break;
      case 3:
        setAttributes({
          tab3Checked: tabChecked,
          isChanged: true
        });
        break;
      case 4:
        setAttributes({
          tab4Checked: tabChecked,
          isChanged: true
        });
        break;
      case 5:
        setAttributes({
          tab5Checked: tabChecked,
          isChanged: true
        });
        break;
      case 6:
        setAttributes({
          tab6Checked: tabChecked,
          isChanged: true
        });
        break;
      case 7:
        setAttributes({
          tab7Checked: tabChecked,
          isChanged: true
        });
        break;
      case 8:
        setAttributes({
          tab8Checked: tabChecked,
          isChanged: true
        });
        break;
      case 9:
        setAttributes({
          tab9Checked: tabChecked,
          isChanged: true
        });
        break;
      case 10:
        setAttributes({
          tab10Checked: tabChecked,
          isChanged: true
        });
        break;
    }
  };
  const setBlockId = blockId => {
    setAttributes({
      blockId
    });
  };
  if (clientId !== attributes.blockId) setBlockId(clientId);
  if (attributes.firstLoad) {
    display = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: 'oese-tabs-block'
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("ul", {
      className: "nav nav-tabs",
      id: "oeseTabs",
      role: "tablist",
      "aria-labelledby": "page_header"
    }, attributes.tab1Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link active",
      id: 'Tab' + attributes.blockId + '_1',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_1',
      "data-id": "1",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_1',
      "aria-selected": "true"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab1Icon
    }), " ", attributes.tab1Label)), attributes.tab2Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_2',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_2',
      "data-id": "2",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_2',
      "aria-selected": "false",
      tabindex: "-1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab2Icon
    }), " ", attributes.tab2Label)), attributes.tab3Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_3',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_3',
      "data-id": "3",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_3',
      "aria-selected": "false",
      tabindex: "-1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab3Icon
    }), " ", attributes.tab3Label)), attributes.tab4Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_4',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_4',
      "data-id": "4",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_4',
      "aria-selected": "false",
      tabindex: "-1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab4Icon
    }), " ", attributes.tab4Label)), attributes.tab5Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_5',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_5',
      "data-id": "5",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_5',
      "aria-selected": "false",
      tabindex: "-1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab5Icon
    }), " ", attributes.tab5Label)), attributes.tab6Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_6',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_6',
      "data-id": "6",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_6',
      "aria-selected": "false",
      tabindex: "-1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab6Icon
    }), " ", attributes.tab6Label)), attributes.tab7Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_7',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_7',
      "data-id": "7",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_7',
      "aria-selected": "false",
      tabindex: "-1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab7Icon
    }), " ", attributes.tab7Label)), attributes.tab8Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_8',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_8',
      "data-id": "8",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_8',
      "aria-selected": "false"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab8Icon
    }), " ", attributes.tab8Label)), attributes.tab9Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_9',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_9',
      "data-id": "9",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_9',
      "aria-selected": "false"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab9Icon
    }), " ", attributes.tab9Label)), attributes.tab10Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
      className: "nav-item"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
      className: "nav-link",
      id: 'Tab' + attributes.blockId + '_10',
      "data-toggle": "tab",
      href: '#TabContent' + attributes.blockId + '_10',
      "data-id": "10",
      role: "tab",
      "aria-controls": 'TabContent' + attributes.blockId + '_10',
      "aria-selected": "false"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
      className: 'fas ' + attributes.tab10Icon
    }), " ", attributes.tab10Label))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-content",
      id: 'TabContent' + attributes.blockId
    }, attributes.tab1Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade show active",
      id: 'TabContent' + attributes.blockId + '_1',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_1',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab1Content)), attributes.tab2Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_2',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_2',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab2Content)), attributes.tab3Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_3',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_3',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab3Content)), attributes.tab4Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_4',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_4',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab4Content)), attributes.tab5Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_5',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_5',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab5Content)), attributes.tab6Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_6',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_6',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab6Content)), attributes.tab7Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_7',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_7',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab7Content)), attributes.tab8Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_8',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_8',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab8Content)), attributes.tab9Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_9',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_9',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab9Content)), attributes.tab10Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
      className: "tab-pane fade",
      id: 'TabContent' + attributes.blockId + '_10',
      role: "tabpanel",
      "aria-labelledby": 'Tab' + attributes.blockId + '_10',
      tabindex: "0"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab10Content))));
  }
  let inspector = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    className: "oese-tabs-inspector-control",
    key: attributes.blockId
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Settings', 'oese-tabs-block'),
    initialOpen: true
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 1', 'oese-tabs-block'),
    checked: attributes.tab1Checked,
    onChange: e => onChangeTabEnabled(e, 1)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab1Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 1'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 1 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab1Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab1Label,
    onChange: e => onChangeTabLabel(e, 1)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab1Icon,
    onChange: e => onChangeTabIcon(e, 1)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab1Content,
    onChange: e => onChangeTabContent(e, 1)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 2', 'oese-tabs-block'),
    checked: attributes.tab2Checked,
    onChange: e => onChangeTabEnabled(e, 2)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab2Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 2'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 2 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab2Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab2Label,
    onChange: e => onChangeTabLabel(e, 2)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab2Icon,
    onChange: e => onChangeTabIcon(e, 2)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab2Content,
    onChange: e => onChangeTabContent(e, 2)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 3', 'oese-tabs-block'),
    checked: attributes.tab3Checked,
    onChange: e => onChangeTabEnabled(e, 3)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab3Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 3'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 3 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab3Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab3Label,
    onChange: e => onChangeTabLabel(e, 3)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab3Icon,
    onChange: e => onChangeTabIcon(e, 3)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab3Content,
    onChange: e => onChangeTabContent(e, 3)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 4', 'oese-tabs-block'),
    checked: attributes.tab4Checked,
    onChange: e => onChangeTabEnabled(e, 4)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab4Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 4'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 4 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab4Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab4Label,
    onChange: e => onChangeTabLabel(e, 4)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab4Icon,
    onChange: e => onChangeTabIcon(e, 4)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab4Content,
    onChange: e => onChangeTabContent(e, 4)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 5', 'oese-tabs-block'),
    checked: attributes.tab5Checked,
    onChange: e => onChangeTabEnabled(e, 5)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab5Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 5'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 5 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab5Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab5Label,
    onChange: e => onChangeTabLabel(e, 5)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab5Icon,
    onChange: e => onChangeTabIcon(e, 5)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab5Content,
    onChange: e => onChangeTabContent(e, 5)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 6', 'oese-tabs-block'),
    checked: attributes.tab6Checked,
    onChange: e => onChangeTabEnabled(e, 6)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab6Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 6'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 6 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab6Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab6Label,
    onChange: e => onChangeTabLabel(e, 6)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab6Icon,
    onChange: e => onChangeTabIcon(e, 6)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab6Content,
    onChange: e => onChangeTabContent(e, 6)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 7', 'oese-tabs-block'),
    checked: attributes.tab7Checked,
    onChange: e => onChangeTabEnabled(e, 7)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab7Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 7'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 7 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab7Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab7Label,
    onChange: e => onChangeTabLabel(e, 7)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab7Icon,
    onChange: e => onChangeTabIcon(e, 7)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab7Content,
    onChange: e => onChangeTabContent(e, 7)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 8', 'oese-tabs-block'),
    checked: attributes.tab8Checked,
    onChange: e => onChangeTabEnabled(e, 8)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab8Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 8'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 8 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab8Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab8Label,
    onChange: e => onChangeTabLabel(e, 8)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab8Icon,
    onChange: e => onChangeTabIcon(e, 8)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab8Content,
    onChange: e => onChangeTabContent(e, 8)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 9', 'oese-tabs-block'),
    checked: attributes.tab9Checked,
    onChange: e => onChangeTabEnabled(e, 9)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab9Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 9'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 9 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab9Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab9Label,
    onChange: e => onChangeTabLabel(e, 9)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab9Icon,
    onChange: e => onChangeTabIcon(e, 9)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab9Content,
    onChange: e => onChangeTabContent(e, 9)
  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Enable Tab 10', 'oese-tabs-block'),
    checked: attributes.tab10Checked,
    onChange: e => onChangeTabEnabled(e, 10)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, {
    className: attributes.tab10Checked ? 'oese-tab-row' : 'oese-tab-row oese-tab-row-hidden'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Panel, {
    title: 'Tab 10'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab 10 Settings', 'oese-tabs-block'),
    initialOpen: attributes.tab10Checked ? true : false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Label:', 'oese-tabs-block'),
    value: attributes.tab10Label,
    onChange: e => onChangeTabLabel(e, 10)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.SelectControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Icon:', 'oese-tabs-block'),
    options: iconList,
    value: attributes.tab10Icon,
    onChange: e => onChangeTabIcon(e, 10)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextareaControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Content:', 'oese-tabs-block'),
    value: attributes.tab10Content,
    onChange: e => onChangeTabContent(e, 10)
  }))))))));
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    className: "oese-tabs-block"
  }, (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockProps)()), inspector, display);
}

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./save */ "./src/save.js");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */



/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */



/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)('oese-block/oese-tabs', {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Tabs', 'oese-tabs-block'),
  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Displays a tabbed content section on a page.', 'oese-tabs-block'),
  category: 'oese-block-category',
  icon: 'index-card',
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OESE', 'oese-tabs-block'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Tabs', 'oese-tabs-block'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Tab', 'oese-tabs-block')],
  attributes: {
    tabCount: {
      type: 'number'
    },
    tab1Checked: {
      type: 'boolean'
    },
    tab1Label: {
      type: 'string'
    },
    tab1Icon: {
      type: 'string'
    },
    tab1BGColor: {
      type: 'string'
    },
    tab1Content: {
      type: 'string'
    },
    tab2Checked: {
      type: 'boolean'
    },
    tab2Label: {
      type: 'string'
    },
    tab2Icon: {
      type: 'string'
    },
    tab2BGColor: {
      type: 'string'
    },
    tab2Content: {
      type: 'string'
    },
    tab3Checked: {
      type: 'boolean'
    },
    tab3Label: {
      type: 'string'
    },
    tab3Icon: {
      type: 'string'
    },
    tab3BGColor: {
      type: 'string'
    },
    tab3Content: {
      type: 'string'
    },
    tab4Checked: {
      type: 'boolean'
    },
    tab4Label: {
      type: 'string'
    },
    tab4Icon: {
      type: 'string'
    },
    tab4BGColor: {
      type: 'string'
    },
    tab4Content: {
      type: 'string'
    },
    tab5Checked: {
      type: 'boolean'
    },
    tab5Label: {
      type: 'string'
    },
    tab5Icon: {
      type: 'string'
    },
    tab5BGColor: {
      type: 'string'
    },
    tab5Content: {
      type: 'string'
    },
    tab6Checked: {
      type: 'boolean'
    },
    tab6Label: {
      type: 'string'
    },
    tab6Icon: {
      type: 'string'
    },
    tab6BGColor: {
      type: 'string'
    },
    tab6Content: {
      type: 'string'
    },
    tab7Checked: {
      type: 'boolean'
    },
    tab7Label: {
      type: 'string'
    },
    tab7Icon: {
      type: 'string'
    },
    tab7BGColor: {
      type: 'string'
    },
    tab7Content: {
      type: 'string'
    },
    tab8Checked: {
      type: 'boolean'
    },
    tab8Label: {
      type: 'string'
    },
    tab8Icon: {
      type: 'string'
    },
    tab8BGColor: {
      type: 'string'
    },
    tab8Content: {
      type: 'string'
    },
    tab9Checked: {
      type: 'boolean'
    },
    tab9Label: {
      type: 'string'
    },
    tab9Icon: {
      type: 'string'
    },
    tab9BGColor: {
      type: 'string'
    },
    tab9Content: {
      type: 'string'
    },
    tab10Checked: {
      type: 'boolean'
    },
    tab10Label: {
      type: 'string'
    },
    tab10Icon: {
      type: 'string'
    },
    tab10BGColor: {
      type: 'string'
    },
    tab10Content: {
      type: 'string'
    },
    tabs: {
      type: 'array'
    },
    isChanged: {
      type: 'boolean',
      default: false
    },
    blockId: {
      type: 'string'
    },
    firstLoad: {
      type: 'boolean',
      default: true
    }
  },
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_3__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_4__["default"]
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);


/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */




/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */


/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
function save(props) {
  const {
    attributes
  } = props;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    className: "oese-tabs-block"
  }, _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.useBlockProps.save()), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: 'oese-tabs-block'
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("ul", {
    className: "nav nav-tabs",
    id: "oeseTabs",
    role: "tablist",
    "aria-labelledby": "page_header"
  }, attributes.tab1Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link active",
    id: 'Tab' + attributes.blockId + '_1',
    "data-id": "1",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_1',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_1',
    "aria-selected": "true"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab1Icon
  }), " ", attributes.tab1Label)), attributes.tab2Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_2',
    "data-id": "2",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_2',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_2',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab2Icon
  }), " ", attributes.tab2Label)), attributes.tab3Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_3',
    "data-id": "3",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_3',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_3',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab3Icon
  }), " ", attributes.tab3Label)), attributes.tab4Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_4',
    "data-id": "4",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_4',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_4',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab4Icon
  }), " ", attributes.tab4Label)), attributes.tab5Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_5',
    "data-id": "5",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_5',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_5',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab5Icon
  }), " ", attributes.tab5Label)), attributes.tab6Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_6',
    "data-id": "6",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_6',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_6',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab6Icon
  }), " ", attributes.tab6Label)), attributes.tab7Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_7',
    "data-id": "7",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_7',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_7',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab7Icon
  }), " ", attributes.tab7Label)), attributes.tab8Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_8',
    "data-id": "8",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_8',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_8',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab8Icon
  }), " ", attributes.tab8Label)), attributes.tab9Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_9',
    "data-id": "9",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_9',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_9',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab9Icon
  }), " ", attributes.tab9Label)), attributes.tab10Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("li", {
    className: "nav-item"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("a", {
    className: "nav-link",
    id: 'Tab' + attributes.blockId + '_10',
    "data-id": "10",
    "data-toggle": "tab",
    href: '#TabContent' + attributes.blockId + '_10',
    role: "tab",
    "aria-controls": 'TabContent' + attributes.blockId + '_10',
    "aria-selected": "false",
    tabindex: "-1"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("i", {
    className: 'fas ' + attributes.tab10Icon
  }), " ", attributes.tab10Label))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-content",
    id: 'TabContent' + attributes.blockId
  }, attributes.tab1Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade show active",
    id: 'TabContent' + attributes.blockId + '_1',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_1',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab1Content)), attributes.tab2Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_2',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_2',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab2Content)), attributes.tab3Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_3',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_3',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab3Content)), attributes.tab4Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_4',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_4',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab4Content)), attributes.tab5Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_5',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_5',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab5Content)), attributes.tab6Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_6',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_6',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab6Content)), attributes.tab7Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_7',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_7',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab7Content)), attributes.tab8Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_8',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_8',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab8Content)), attributes.tab9Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_9',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_9',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab9Content)), attributes.tab10Checked && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: "tab-pane fade",
    id: 'TabContent' + attributes.blockId + '_10',
    role: "tabpanel",
    "aria-labelledby": 'Tab' + attributes.blockId + '_10',
    tabindex: "0"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.RawHTML, null, attributes.tab10Content)))));
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = window["jQuery"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ _extends)
/* harmony export */ });
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkoese_tabs"] = globalThis["webpackChunkoese_tabs"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map