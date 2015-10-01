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
	<div class="modal-container">
	<?php
	    $token = htmlspecialchars($_COOKIE['GAT_token']);
	    $response_table = PLUGIN_PREFIX . "response";
	    $sql = $wpdb->prepare( "SELECT * FROM `$response_table` WHERE `token` = %s", $token );
	    $data = $wpdb->get_row($sql);
	    ?>

	    <div class="modal fade" id="gat-user-info-modal">
		<div class="modal-dialog">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title">Save Your Session</h4>
			</div>
			<div class="modal-body">
			    <p class="text-justify">
				Your access code is displayed below. If you would like to return and view your playlist or revise your answers, you will need this code. Entering your email address and district name is optional, but doing so will enable you to access additional features of the tool.
			    </p>
			    <p class="gat_genratedtoken">Your Access Code : <?php echo $token; ?></p>
			    <form id="gat-user-info-form">
				<?php wp_nonce_field("55e80bfb3ea74", "gat-user-information-nonce"); ?>

				<input type="hidden" name="token" value="<?php echo $token; ?>" />

				<div class="form-group">
				    <label class="control-label">E-mail address</label>
				    <input type="text" name="email" class="form-control" value="" />
				</div>

				<div class="row">
				    <div class="col-sm-6 col-md-6 select-group">
					<div class="form-group">
					    <label>State</label>
					    <select name="state" class="form-control" onchange="gat_districtcode(this);">
						<option value="">Select State</option>
						<?php gat_state($data->state); ?>
					    </select>
					</div>
				    </div>

				    <div class="col-sm-6 col-md-6 select-group">
					<div class="form-group">
					    <label>District</label>
					    <select name="district" class="form-control">
						<option value="">Select District</option>
					    </select>
					</div>
				    </div>
				</div>
			    </form>
			    <p class="text-right">
				Read our <a href="http://www2.ed.gov/notices/privacy/index.html?src=future-ready-gap-analysis" target="_blank">privacy policy</a>.
			    </p>
			</div>
			<div class="modal-footer">
			    <button type="button" id="submit-gat-user-info" data-loading-text="Submitting..." class="btn btn-default gat_button">Submit</button>
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
