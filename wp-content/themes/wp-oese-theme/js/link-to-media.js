( function( wp ) {

    var withSelect  = wp.data.withSelect;
    var ifCondition = wp.compose.ifCondition;
    var compose     = wp.compose.compose;
    var media_url;

    /** Create Link To Media Button **/
    var OESE_LinkToMedia = function( props ) {
       return wp.element.createElement(
            wp.blockEditor.RichTextToolbarButton, {
                icon: 'admin-media', 
                title: 'Link to Media', 
                onClick: function() {
                    custom_uploader = wp.media({
                        title: 'Add Media Link',
                        button: {
                            text: 'Insert Media Link' // button label text
                        },
                        multiple: false
                    }).on('select', function() { // event that handles insert media link button click
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        media_url = attachment.url;
                        props.onChange( 
                            /** Set Format to Link to Media and set url attribute **/
                            wp.richText.applyFormat(props.value, {
                                type: 'oese/link-to-media',
                                attributes : {
                                    url: media_url
                                }
                            }, props.value.start, props.value.end)
                        );
                    }).open();
                },
                isActive: props.isActive
            }
        );
    }

    /** Only show link to media button on paragraph, heading, list, and quote block **/
    var OESE_ConditionalLinkToMedia = compose(
        withSelect( function( select ) {
            return {
                selectedBlock: select( 'core/editor' ).getSelectedBlock()
            }
        } ),
        ifCondition( function( props ) {
            return (
                props.selectedBlock &&
                (props.selectedBlock.name === 'core/paragraph' 
                 || props.selectedBlock.name === 'core/heading' 
                 || props.selectedBlock.name === 'core/list'
                 || props.selectedBlock.name === 'core/quote')
            );
        } )
    )( OESE_LinkToMedia );

    /** Set Format Type of Selected Text **/
    wp.richText.registerFormatType(
        'oese/link-to-media', {
            attributes: {
                url: 'href'
            },
            title: 'Link To Media',
            tagName: 'a',
            className: 'oese-link-to-media',
            edit: OESE_LinkToMedia,
        }
    );
} )( window.wp );