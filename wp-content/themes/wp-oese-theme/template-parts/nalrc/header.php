<?php 
/** NALRC Header **/
global $post;
?>
<div class="nalrc-header">
	<div class="nalrc-wrapper">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/nalrc-logo.png" alt="Native American Language Resource Center" />
	</div>
</div>
<div class="nalrc-banner">
	<div class="nalrc-wrapper">
		<div class="col-md-3 nalrc-nav">
			<?php
				$nalrc_header_menu = get_option('wp_oese_theme_nalrc_header');
				if ($nalrc_header_menu){
					$nav_items = wp_get_nav_menu_items($nalrc_header_menu);
					if (!empty($nav_items)){
						?>
						<nav>
							<ul class="nalrc-menu">
								<?php
								foreach($nav_items as $nav_item){
									$class = "";
									if ($nav_item->object_id==(string)$post->ID){
										$class = " current-menu-item";
									}
									?>
									<li class="nav-item<?php echo $class; ?>">
										<a href="<?php echo esc_url($nav_item->url); ?>"><?php echo esc_html($nav_item->title); ?></a>
									</li>
									<?php
								}
								?>
							</ul>
						</nav>
						<?php
					}
				} else {
					_e("Please select header menu for NALRC Page in Theme Settings.",WP_OESE_THEME_SLUG);
				}
			?>
		</div>
		<div class="col-md-9 nalrc-slider">
			<?php get_template_part('template-parts/nalrc/carousel'); ?>
		</div>
	</div>
</div>