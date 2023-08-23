!function(){"use strict";var e,n={502:function(){var e=window.wp.blocks,n=JSON.parse('{"TN":"Audience Link","W3":"oese-block-category","qv":"admin-links","WL":"Add Audience Link Block","Y4":{"blockid":{"type":"string"},"text":{"type":"string","default":"Audience Name Goes Here"},"link":{"type":"string"},"OpenInNewTab":{"type":"boolean","default":false}}}'),t=window.wp.element,o=window.wp.i18n,r=window.wp.blockEditor,i=window.wp.components;const{__:__}=wp.i18n;window.oercurrBlocksJson="undefined"==typeof oese_audience_link_legacy_marker,(0,e.registerBlockType)("oese-block/oese-audience-link-block",{title:__(n.TN),icon:n.qv,description:__(n.WL),category:n.W3,keywords:[__("oese"),__("publication"),__("intro")],attributes:n.Y4,edit:function(e){const n=e.attributes,l=e.setAttributes;let a=window.oercurrBlocksJson?(0,r.useBlockProps)():"";n.OpenInNewTab;let c=n.text&&n.text.length>0?n.text:"Audience Name Goes Here",s=n.link&&n.link.length>0?"pointer":"";return(0,t.createElement)("div",a,(0,t.createElement)(r.InspectorControls,null,(0,t.createElement)(PanelBody,{title:(0,o.__)("Audience Link Settings"),initialOpen:!0},(0,t.createElement)("div",{class:"oese_audience_link_inspector_wrapper css-wdf2ti-Wrapper"},(0,t.createElement)("label",{class:"components-base-control__label"},"Link Text",(0,t.createElement)("input",{type:"text",class:"oese_audience_link_text_inspector_input",onChange:e=>{l({text:e.target.value})},value:n.text}))),(0,t.createElement)("div",{class:"oese_audience_link_inspector_wrapper css-wdf2ti-Wrapper"},(0,t.createElement)("label",{class:"components-base-control__label"},"Link URL",(0,t.createElement)("input",{type:"text",class:"oese_audience_link_URL_inspector_input",onChange:e=>{l({link:e.target.value})},value:n.link}))),(0,t.createElement)("div",{class:"oese_audience_link_inspector_wrapper css-wdf2ti-Wrapper"},(0,t.createElement)("label",{class:"components-base-control__label"},"Link Target",(0,t.createElement)(i.ToggleControl,{help:n.OpenInNewTab?(0,o.__)("Open link in new tab","five"):(0,o.__)("Open link in the current tab","five"),checked:!!n.OpenInNewTab,onChange:e=>{return t=!n.OpenInNewTab,void l({OpenInNewTab:t});var t}}))))),(0,t.createElement)("div",{class:"oese_audience_link_block_container"},(0,t.createElement)("div",{class:"oese_audience_link_block_anchor_faux "+s},c)))},save:function(e){const n=e.attributes;let o=n.OpenInNewTab?"_blank":"_self";return(0,t.createElement)("div",null,(0,t.createElement)("div",{class:"oese_audience_link_block_container"},n.link&&n.link.length>0?(0,t.createElement)("a",{href:n.link,class:"oese_audience_link_block_anchor no_target_change",alt:"Audience name goes here",target:o,rel:"noopener"},n.text):(0,t.createElement)("div",{class:"oese_audience_link_block_anchor_faux"},n.text)))},example:()=>{}})}},t={};function o(e){var r=t[e];if(void 0!==r)return r.exports;var i=t[e]={exports:{}};return n[e](i,i.exports,o),i.exports}o.m=n,e=[],o.O=function(n,t,r,i){if(!t){var l=1/0;for(u=0;u<e.length;u++){t=e[u][0],r=e[u][1],i=e[u][2];for(var a=!0,c=0;c<t.length;c++)(!1&i||l>=i)&&Object.keys(o.O).every((function(e){return o.O[e](t[c])}))?t.splice(c--,1):(a=!1,i<l&&(l=i));if(a){e.splice(u--,1);var s=r();void 0!==s&&(n=s)}}return n}i=i||0;for(var u=e.length;u>0&&e[u-1][2]>i;u--)e[u]=e[u-1];e[u]=[t,r,i]},o.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},function(){var e={826:0,46:0};o.O.j=function(n){return 0===e[n]};var n=function(n,t){var r,i,l=t[0],a=t[1],c=t[2],s=0;if(l.some((function(n){return 0!==e[n]}))){for(r in a)o.o(a,r)&&(o.m[r]=a[r]);if(c)var u=c(o)}for(n&&n(t);s<l.length;s++)i=l[s],o.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return o.O(u)},t=self.webpackChunkoese_featured_content_box_block=self.webpackChunkoese_featured_content_box_block||[];t.forEach(n.bind(null,0)),t.push=n.bind(null,t.push.bind(t))}();var r=o.O(void 0,[46],(function(){return o(502)}));r=o.O(r)}();