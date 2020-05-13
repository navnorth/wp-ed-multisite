jQuery( document ).ready(function() {
    jQuery('#page_template').on('change', function() {
	  //alert(this.value);
	});
    jQuery('.contact-edit').on("click", function(e){
        e.preventDefault();
        if (confirm('Are you sure that you want to change the global Contact page selection?')==true){
            jQuery('#wp_oese_theme_contact_page').show();
            jQuery(this).hide();
            jQuery('.contact-edit-link').hide();
        }
    });
    jQuery('.oese-tabs').tabs();

  var posttype = getPostType();
  if(posttype != 'undefined' && (posttype == 'page' || posttype == 'post')){
    if(jQuery("#publish").length){
      var btnText = jQuery("#publish").attr('value');
      jQuery("#publish").hide();
      jQuery('#publishing-action').append('<input type="submit" name="publish" id="secondary-publish" class="button button-primary button-large" value="'+btnText+'">')
    }
  }

  jQuery(document).on('click','#secondary-publish',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    jQuery('input[name="post_title"]').trigger('blur');    
    var checkExist = setInterval(function() {
       if (jQuery('span#editable-post-name').length) {
          console.log("Exists!");
          clearInterval(checkExist);
          interceptPublish();
       }
    }, 100); // check every 100ms      
  })
})

var itvl;
function interceptPublish(elm){
    
    if(jQuery('input#new-post-slug').length){
        var slug = jQuery('input#new-post-slug').val(); 
    }else{
        var slug = jQuery('span#editable-post-name').text(); 
    }
    var prhbt = ["admin", "login", "user"];  
    var found = false;
    prhbt.forEach(function(item) {
        var idx = slug.indexOf(item);
        if(idx == 0){//found in the beginning
          found = true;
        }
    });
    if(found){
      var html = '<div class="oese-prohibitedpermalinktext notice notice-error /*is-dismissible*/" style="display:none;"><p>Please make sure the permalink doesn\'t begin with words such as <strong>admin, login, and user</strong> as they are known to cause issues</p></div>';
      if (!jQuery('.oese-prohibitedpermalinktext').length){
        jQuery(html).insertAfter('hr.wp-header-end');
        jQuery('.oese-prohibitedpermalinktext').show(300);
      }
    }else{
      jQuery("#publish").click();
    }

}

function getPostType(){
    var postType; var ret;
    var attrs = jQuery( 'body' ).attr( 'class' ).split( ' ' );
    jQuery( attrs ).each(function() {
      if (this.indexOf("post-type-") >= 0){
				postType = this.split( 'post-type-' );
        postType = postType[ postType.length - 1 ];	
				ret = postType;	
			}	
		});
  return ret;
}
