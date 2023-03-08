jQuery( document ).ready(function() {
  jQuery(document).on('click','.oet-shrtcdv2_tab',function(e){
    var data = jQuery(this).attr('data');
    var scode = get_myshortcode(data);
    //console.log(scode);
    jQuery('.oet-shrtcdv2_shortcode').val(scode);
    jQuery('.oet-shrtcdv2_tab').removeClass('selected');
    jQuery(this).addClass('selected');
    displayPreview(scode);
    jQuery('.oet-shrtcdv2_shortcode').prop('disabled', false);
  });
  var timeout = null;
  var prev = null;
  jQuery(document).on('keyup','.oet-shrtcdv2_shortcode',function(){  
    clearTimeout(timeout);
    var scode = jQuery(this).val();
    //console.log(scode);
    if (scode.length >= 1) {
      timeout = setTimeout(function() {
        if(prev != scode){
          prev = scode;
          var tmp_html = '<div class="oet-shortcode-spinner-table">';
                tmp_html += '<div class="oet-shortcode-spinner-cell">';
                  tmp_html += '<div class="oet-shortcode-spinner"><div></div><div></div></div>';
                tmp_html += '</div>';
            tmp_html += '</div>';
          jQuery('.oet-shrtcdv2_preview').html(tmp_html);
          displayPreview(scode);
        }
      }, 1000);
    }
  });
});

function displayPreview(scode){
  var attributes = {};
  attributes['action'] = 'previewshortcode';
  attributes['data'] = scode;  
  var ret = '';
  jQuery.ajax({
    type:'POST',
    url: oet_ajax_object.ajaxurl,
    data: attributes,
    success:function(response){
      jQuery('.oet-shrtcdv2_preview').html(response);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
       alert("Error rendering preview, please try again.");
    }
  });
  return ret;
}

function oetInsertShortcode(){
  console.log('in');
  var shortcode_type = jQuery(".oet-shrtcdv2_tab.selected").attr("data");
  console.log(shortcode_type);
  var shortcode = jQuery('.oet-shrtcdv2_shortcode').val();
  if(typeof tinyMCE != "undefined" && ( ed = tinyMCE.activeEditor ) && !ed.isHidden()){
    tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
    tinymce.EditorManager.execCommand("mceRemoveControl",true, "content");
  }
  else
  {
    var editorid = '#'+jQuery('body').attr('currenteditor');
    var cursor = jQuery(editorid).prop("selectionStart");
    if(!cursor) cursor = 0;
    var content = jQuery(editorid).val();
    var textBefore = content.substring(0,  cursor );
    var textAfter  = content.substring( cursor, content.length );
    jQuery(editorid).val( textBefore + shortcode + textAfter );
  }
  tb_remove();
}


jQuery(document).on('click','.quicktags-toolbar input[value="add shortcodes"]',function(){
  var eid = jQuery(this).attr('id');
  eid = eid.replace('qt_','');
  eid = eid.replace('_shortcodes','');
  jQuery('body').attr('currenteditor',eid);
});


// ********************
// *** FRONT SCRIPT ***
// ********************

