<?php
/**
 * The Template for displaying all single story
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); ?>

    <div class="row">
    <?php while ( have_posts() ) : the_post(); ?>

	<?php get_assessment_template_part( 'content', 'assessment' ); ?>

    <?php endwhile; // end of the loop. ?>
	<script type="text/javascript">
	    jQuery(document).ready(function() {
		jQuery('#gat-user-info-modal #submit-gat-user-info').click(function() {
		    jQuery('#gat-user-info-modal input[name="email"]').parents('.form-group').removeClass('has-error')
		    
		    var email = jQuery('#gat-user-info-modal input[name="email"]')
		    var state = jQuery('#gat-user-info-modal input[name="state"]')
		    var district = jQuery('#gat-user-info-modal input[name="district"]')
		    
		    if (email.val() || state.val() || district.val()) {
			var proceed = true
			
			if (email.val()) {
			    var regex = /^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
			
			    if (regex.exec(email.val()) === null) {
				proceed = false
				jQuery('#gat-user-info-modal input[name="email"]').parents('.form-group').addClass('has-error')
			    }
			    
			    if (proceed) {
				var data = jQuery('#gat-user-info-modal form').serializeArray()
				    data.push({
					name: 'action',
					value: 'register_user_info'
				    })
				    
				jQuery.ajax({
				    url: ajaxurl,
				    type: 'post',
				    data: data
				})
			    }
			}
		    }
		    else
		    {
			jQuery('#gat-user-info-modal').modal('hide')
		    }
		})
	    })
	</script>
	<style>
	    .modal-container .modal .modal-content {
		border-radius: 0;
	    }
	</style>
	<div class="modal-container">
	<?php
	    $token = htmlspecialchars($_COOKIE['GAT_token']);
	    $response_table = PLUGIN_PREFIX . "response";
	    
	    $sql = $wpdb->prepare( "SELECT * FROM `" . $response_table . "` WHERE `token` = %s", $token );
	    $response = $wpdb->get_row($sql); ?>
	    
	    <div class="modal fade" id="gat-user-info-modal">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title">Set Your E-mail</h4>
			</div>
			<div class="modal-body">
			    <p class="text-justify">
				Your access code is displayed below. If you would like to continue this analysis or retrieve your results later, you will need this code. If you provide your email address, we will be able to assist you with retrieving it if necessary.
				Location information is optional and helps us better report on analysis results
			    </p>
			    <p class="gat_genratedtoken">Your Access Code : <?php echo $token; ?></p>
			    <form id="gat-user-info-form">
				<?php wp_nonce_field("55e80bfb3ea74", "gat-user-information-nonce"); ?>
				
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="form-group">
				    <label class="control-label">E-mail address</label>
				    <input type="text" name="email" class="form-control" />
				</div>
				
				<div class="row">
				    <div class="col-sm-6 col-md-6">
					<div class="form-group">
					    <label>State</label>
					    <select name="state" class="form-control">
						<option value="">Select State</option>
					    </select>
					</div>
				    </div>
				    
				    <div class="col-sm-6 col-md-6">
					<div class="form-group">
					    <label>District</label>
					    <select name="district" class="form-control">
						<option value="">Select District</option>
					    </select>
					</div>
				    </div>
				</div>
			    </form>
			</div>
			<div class="modal-footer">
			    <button type="button" id="submit-gat-user-info" class="btn btn-default gat_buttton">Submit</button>
			</div>
		    </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	    </div><!-- /.modal -->
	</div>
    </div><!-- /.row -->
    <!--
    <nav class="nav-single">
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
        <span class="nav-previous">
			<?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?>
        </span>
        <span class="nav-next">
			<?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?>
        </span>
    </nav>
    .nav-single -->

<?php get_footer(); ?>
