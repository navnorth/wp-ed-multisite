/**
 * OET Dynamic Sidebar
 */
jQuery( document ).ready(function($) {
    var active_editors = [];
    var OET_Dynamic_Sidebar = {
        addSidebarSection: function(){
            $(document).on("click", '.oet-add-sidebar-section', function(e){
                e.preventDefault();
                var btn = $(this).closest('.button-row.form-group');
                        
                var total_sections = parseInt($('.oet-sidebar-section-wrapper').length, 10);
                var id = total_sections + 1;
                $.post(oet_ajax_object.ajaxurl,
                {
                 action:'oet_add_sidebar_section_callback',
                 row_id: id
                }).done(function (response) {
                    btn.before(response);
                    var textAreaId = 'oet-sidebar-section-' + id;
                    var cloned_element = $('')
                    tinymce.execCommand( 'mceRemoveEditor', false, textAreaId );
                    tinymce.execCommand( 'mceAddEditor', false, textAreaId );
                    quicktags({ id: textAreaId });
                });
            });
        },
        
        /** Initialize WP Editor **/
        initializeActiveEditors: function(){
            $.each( $('.oet-wp-editor'), function( i, editor ) {
                var editor_id = $(editor).attr('id');
                wp.editor.initialize(
                  editor_id,
                  {
                    tinymce: {
                      wpautop: true,
                      plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                      toolbar1: 'bold italic underline strikethrough | bullist numlist | blockquote hr wp_more | alignleft aligncenter alignright | link unlink | fullscreen | wp_adv',
                      toolbar2: 'formatselect alignjustify forecolor | pastetext removeformat charmap | outdent indent | undo redo | wp_help'
                    },
                    quicktags: true,
                    mediaButtons: true,
                  }
                );
            
                var mce_editor = tinymce.get(editor_id);
                if(mce_editor) {
                  val = wp.editor.getContent(editor_id); // Visual tab is active
                } else {
                  val = $('#'+editor_id).val(); // HTML tab is active
                }
             
                // Save id for removal later on
                active_editors.push(editor_id);
            
              });
        },
        
        /** Display Content Type Editor **/
        displayContentTypeEditor: function(){
             $(document).on("change", '.oet-sidebar-section-type', function(e){
                e.preventDefault();
                var content_section = $(this).closest('.oet-sidebar-section-wrapper').find('.oet-content-sections');
                var helper_text = $(this).parent().next('.oet-related-content-helper');
                helper_text.hide();
                content_section.html('').removeClass('subsection-visible');
                        
                var content_count = parseInt(content_section.find('.oet-sidebar-section-type-wrapper').length, 10);
                var id = content_count + 1;
                var type = $(this).children("option:selected").val();
                
                $.post(oet_ajax_object.ajaxurl,
                {
                    action:'oet_sidebar_content_type_callback',
                    row_id: id,
                    type: type
                }).done(function (response) {
                    if (type=="related"){
                        helper_text.removeClass('hidden');
                        helper_text.show();
                    } else { 
                        helper_text.hide();
                        helper_text.addClass('hidden');
                    }
                    content_section.append(response).addClass('subsection-visible');
                    var textAreaId = 'oet-sidebar-section-type-' + id;
                    tinymce.execCommand( 'mceRemoveEditor', false, textAreaId );
                    tinymce.execCommand( 'mceAddEditor', false, textAreaId );
                    quicktags({ id: textAreaId });
                    if (type == "medium"){
                        OET_Dynamic_Sidebar.mediumBackgroundImage();
                        OET_Dynamic_Sidebar.mediumBGColorSelection();
                    }
                });
            });
        },
        
        /** Add Content Type Editor **/
        addContentTypeEditor: function(){
            $(document).on("click", '.oet-add-sidebar-section-content', function(e){
                e.preventDefault();
                var btn = $(this).closest('.button-row-content');
                        
                var content_count = parseInt($(this).closest('.oet-content-sections').find('.oet-sidebar-section-type-wrapper').length, 10);
                var id = content_count + 1;
                var type =  $(this).closest('.oet-sidebar-section-wrapper').find('.oet-sidebar-section-type').children("option:selected").val();
                
                $.post(oet_ajax_object.ajaxurl,
                {
                    action:'oet_sidebar_content_type_callback',
                    row_id: id,
                    type: type
                }).done(function (response) {
                    btn.before(response);
                    
                    var textAreaId = 'oet-sidebar-section-type-' + id;
                    tinymce.execCommand( 'mceRemoveEditor', false, textAreaId );
                    tinymce.execCommand( 'mceAddEditor', false, textAreaId );
                    quicktags({ id: textAreaId });

                    if (type == "medium"){
                        OET_Dynamic_Sidebar.mediumBackgroundImage();
                        OET_Dynamic_Sidebar.mediumBGColorSelection();
                    }
                });
            });
        },
        
        /** Select Image for Image Content Type **/
        selectSidebarSectionImage: function(){
            var frame, metabox, btn, input, imageholder;
            $(document).on('click', 'button.oet_sidebar_section_image_button',function(e) {
                metabox = $(this).closest(".oet-sidebar-section-type-wrapper");
                btn = $(this);
                input = metabox.find('.oet_sidebar_section_image_url');
                imageholder = metabox.find('.oet_section_image_thumbnail_holder');
                
                e.preventDefault();
        
                if (frame) {
                    frame.open();
                    return;
                }
        
                frame = wp.media({
                    title: 'Select or upload thumbnail image',
                    button: {
                        text: "Use this image"
                    },
                    multiple:false
                });
        
                frame.on("select", function(){
                    imageholder.find(".oet-section-image-thumbnail,.oet-remove-section-image").remove();
                    var attachment = frame.state().get("selection").first().toJSON();
                    
                    input.val(attachment.url);
                    imageholder.append('<img src="' + attachment.url + '" class="oet-section-image-thumbnail" width="200"><span class="btn btn-danger btn-sm oet-remove-section-image" title="Remove Image"><i class="fa fa-minus-circle"></i></span>');
                    btn.text("Change Image");
                });
                
                frame.open();
            });
        },
        
        // Drag and drop elements
        sidebarSectionSortable: function () {
            // Sidebar sections re-order function
            $(document).on('click', '.sidebar-section-reorder-up', function(){
                var $current = $(this).closest('.oet-sidebar-section-wrapper');
                var $previous = $current.prev('.oet-sidebar-section-wrapper');
                if($previous.length !== 0){
                    $current.insertBefore($previous);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });

            $(document).on('click', '.sidebar-section-reorder-down', function(){
                var $current = $(this).closest('.oet-sidebar-section-wrapper');
                var $next = $current.next('.oet-sidebar-section-wrapper');
                if($next.length !== 0){
                    $current.insertAfter($next);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });
            
            // Image reorder function
            $(document).on('click', '.sidebar-section-image-reorder-up', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $previous = $current.prev('.oet-sidebar-section-type-wrapper');
                if($previous.length !== 0){
                    $current.insertBefore($previous);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });

            $(document).on('click', '.sidebar-section-image-reorder-down', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $next = $current.next('.oet-sidebar-section-type-wrapper');
                if($next.length !== 0){
                    $current.insertAfter($next);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });
            
            // Link reorder function
            $(document).on('click', '.sidebar-section-link-reorder-up', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $previous = $current.prev('.oet-sidebar-section-type-wrapper');
                if($previous.length !== 0){
                    $current.insertBefore($previous);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });

            $(document).on('click', '.sidebar-section-link-reorder-down', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $next = $current.next('.oet-sidebar-section-type-wrapper');
                if($next.length !== 0){
                    $current.insertAfter($next);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });
            
            // Youtube reorder function
            $(document).on('click', '.sidebar-section-youtube-reorder-up', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $previous = $current.prev('.oet-sidebar-section-type-wrapper');
                if($previous.length !== 0){
                    $current.insertBefore($previous);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });

            $(document).on('click', '.sidebar-section-youtube-reorder-down', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $next = $current.next('.oet-sidebar-section-type-wrapper');
                if($next.length !== 0){
                    $current.insertAfter($next);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });
            
            // Story reorder function
            $(document).on('click', '.sidebar-section-story-reorder-up', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $previous = $current.prev('.oet-sidebar-section-type-wrapper');
                if($previous.length !== 0){
                    $current.insertBefore($previous);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });

            $(document).on('click', '.sidebar-section-story-reorder-down', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $next = $current.next('.oet-sidebar-section-type-wrapper');
                if($next.length !== 0){
                    $current.insertAfter($next);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });
            
            // Medium reorder function
            $(document).on('click', '.sidebar-section-medium-reorder-up', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $previous = $current.prev('.oet-sidebar-section-type-wrapper');
                if($previous.length !== 0){
                    $current.insertBefore($previous);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });

            $(document).on('click', '.sidebar-section-medium-reorder-down', function(){
                var $current = $(this).closest('.oet-sidebar-section-type-wrapper');
                var $next = $current.next('.oet-sidebar-section-type-wrapper');
                if($next.length !== 0){
                    $current.insertAfter($next);
                    OET_Dynamic_Sidebar.changeElementOrder();
                }
                return false;
            });
        },

        // Change order value in hidden field and reinitialize the text editor
        changeElementOrder: function() {
            $(".oet_dynamic_sidebar_wrapper .oet-sidebar-section-wrapper").each(function (index) {
                var count = index + 1;

                var position = $(this).find('.element-order').val();
                var newvalue = $(this).find('.element-order').val(count);
                // reassign all of the numbers once it's loaded.

                var textAreaId = $(this).find('textarea').attr('id');

                if (typeof textAreaId !== 'undefined') {
                    tinymce.execCommand( 'mceRemoveEditor', false, textAreaId );
                    tinymce.execCommand( 'mceAddEditor', false, textAreaId );
                }
            });

            OET_Dynamic_Sidebar.toggleUpDownButton();
        },

        // Show/Hide up/down button
        toggleUpDownButton: function() {
            // Hide the up button in the main sidebar section
            $('.sidebar-section-reorder-up').removeClass('hide');
            $('.sidebar-section-reorder-down').removeClass('hide');
            $('.sidebar-section-reorder-up').first().addClass('hide');
            $('.sidebar-section-reorder-down').last().addClass('hide');
            
            // Hide the up/down button in the image content type fields section
            $('.sidebar-section-image-reorder-up').removeClass('hide');
            $('.sidebar-section-image-reorder-down').removeClass('hide');
            $('.sidebar-section-image-reorder-up').first().addClass('hide');
            $('.sidebar-section-image-reorder-down').last().addClass('hide');
            
            // Hide the up/down button in the link content type fields section
            $('.sidebar-section-link-reorder-up').removeClass('hide');
            $('.sidebar-section-link-reorder-down').removeClass('hide');
            $('.sidebar-section-link-reorder-up').first().addClass('hide');
            $('.sidebar-section-link-reorder-down').last().addClass('hide');
            
            // Hide the up/down button in the youtube content type fields section
            $('.sidebar-section-youtube-reorder-up').removeClass('hide');
            $('.sidebar-section-youtube-reorder-down').removeClass('hide');
            $('.sidebar-section-youtube-reorder-up').first().addClass('hide');
            $('.sidebar-section-youtube-reorder-down').last().addClass('hide');
            
            // Hide the up/down button in the story content type fields section
            $('.sidebar-section-story-reorder-up').removeClass('hide');
            $('.sidebar-section-story-reorder-down').removeClass('hide');
            $('.sidebar-section-story-reorder-up').first().addClass('hide');
            $('.sidebar-section-story-reorder-down').last().addClass('hide');
            
            // Hide the up/down button in the medium content type fields section
            $('.sidebar-section-medium-reorder-up').removeClass('hide');
            $('.sidebar-section-medium-reorder-down').removeClass('hide');
            $('.sidebar-section-medium-reorder-up').first().addClass('hide');
            $('.sidebar-section-medium-reorder-down').last().addClass('hide');
        },
        
        // Delete sidebar section
        deleteSidebarSection: function () {
            $(document).on('click', '.oet-remove-sidebar-section',function(e) {
                var moduleId = $(this).closest('.panel-default').attr('id');
                e.preventDefault();
                $('#oet-delete-section-confirm-popup').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                .on('click', '#oet-delete-section-confirm-popup-btn', function(e) {
                    $('#' + moduleId).remove();
                    $('#oet-delete-section-confirm-popup').modal('hide');
                });
            });
        },
        
        // Delete sidebar section
        deleteSectionContentFields: function () {
            $(document).on('click', '.oet-remove-sidebar-section-content',function(e) {
                var moduleId = $(this).closest('.panel-default').attr('id');
                e.preventDefault();
                $('#oet-delete-section-confirm-popup').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                .on('click', '#oet-delete-section-confirm-popup-btn', function(e) {
                    $('#' + moduleId).remove();
                    $('#oet-delete-section-confirm-popup').modal('hide');
                });
            });
        },

        // Medium Background Color
        mediumBGColorSelection: function() {
            $('.oet_medium_color_picker').wpColorPicker();
        },

        // Medium Background Image
        mediumBackgroundImage: function() {
            $(document).ready(function() {
                var frame,
                    metabox = $("#oet-sidebar-metabox.postbox"),
                    btn = metabox.find('button.oet_select_medium_background_image'),
                    input = btn.prev('input.oet_medium_background_image_url');
                
                btn.on("click", function( e ){
                    e.preventDefault();
                    
                    if (frame) {
                        frame.open();
                        return;
                    }
                    
                    frame = wp.media({
                        title: 'Select or Upload background image',
                        button: {
                            text: "Use this image"
                        },
                        multiple:false
                    });
                    
                    frame.on("select", function(){
                        var attachment = frame.state().get("selection").first().toJSON();
                        
                        input.val(attachment.url);
                    });
                    
                    frame.open();
                });
            });
        },

        // Get Story URL
        getStoryURL: function(){
            $(document).on("change", '.oet-sidebar-section-story', function(e){
                e.preventDefault();
                var target = $(this).parent().find('.preview-story .oet-sidebar-story-url');
                $.post(oet_ajax_object.ajaxurl,
                {
                    action:'oet_sidebar_story_url_callback',
                    id: $(this).val()
                }).done(function (response) {
                    target.attr('href',response);
                });
            });
        }
    }

    //OET_Dynamic_Sidebar.initializeActiveEditors();
    OET_Dynamic_Sidebar.addSidebarSection();
    OET_Dynamic_Sidebar.displayContentTypeEditor();
    OET_Dynamic_Sidebar.selectSidebarSectionImage();
    OET_Dynamic_Sidebar.addContentTypeEditor();
    OET_Dynamic_Sidebar.sidebarSectionSortable();
    OET_Dynamic_Sidebar.changeElementOrder();
    OET_Dynamic_Sidebar.deleteSidebarSection();
    OET_Dynamic_Sidebar.deleteSectionContentFields();
    OET_Dynamic_Sidebar.mediumBGColorSelection();
    OET_Dynamic_Sidebar.mediumBackgroundImage();
    OET_Dynamic_Sidebar.getStoryURL();
});