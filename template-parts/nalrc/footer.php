<?php
/** NALRC Footer **/
?>
<div class="nalrc-footer">
	<div class="nalrc-wrapper">
		<div class="col-md-9 col-sm-12 nalrc-nav">
			<?php
				$nalrc_footer_menu = get_option('wp_oese_theme_nalrc_footer');
				if ($nalrc_footer_menu){
					$fnav_items = wp_get_nav_menu_items($nalrc_footer_menu);
					if (!empty($fnav_items)){
						$fnav_parent = 0;
						$fnav_child_count = 0;
						$fnav_parents = [];
						$fnav_children = [];
						foreach($fnav_items as $key=>$fnav_item){
							if ($fnav_item->menu_item_parent!=="0"){
								array_push($fnav_children, $fnav_item);
								unset($fnav_items[$key]);
							}
						}
						?>
						<nav>
							<ul class="row nalrc-menu">
								<?php
								foreach($fnav_items as $fnav_item){
									?>
									<li class="col-md-2 nav-item">
										<a href="<?php echo esc_url($fnav_item->url); ?>"><?php echo esc_html($fnav_item->title); ?></a>
										<?php 
										foreach($fnav_children as $fnav_child){
											if ($fnav_child->menu_item_parent==$fnav_item->ID){
												$fnav_child_count++;
												if ($fnav_child_count==1){
													?>
													<ul class="row nalrc-submenu">
													<?php
												}
												?>
												<li class="col-md-12 nav-item">
													<a href="<?php echo esc_url($fnav_child->url); ?>"><?php echo esc_html($fnav_child->title); ?></a>
												</li>
												<?php	
											}
										}
										if ($fnav_child_count>0){
											?>
											</ul>
											<?php
										}
										$fnav_child_count = 0;
										?>
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
		<div class="col-md-3 col-sm-12 nalrc-social">
			<nav>
				<ul class="row nalrc-menu">
					<li class="col-md-6 col-sm-12 nav-item">
						<a>Social</a>
						<ul class="row nalrc-submenu">
							<?php if (get_option('wp_oese_theme_nalrc_facebook')): ?>
							<li class="col-md-12 nav-item">
								<a href="<?php echo esc_url(get_option('wp_oese_theme_nalrc_facebook')); ?>" target="_blank">Facebook</a>
							</li>
							<?php endif; 
							if (get_option('wp_oese_theme_nalrc_twitter')): ?>
							<li class="col-md-12 nav-item">
								<a href="<?php echo esc_url(get_option('wp_oese_theme_nalrc_twitter')); ?>" target="_blank">Twitter</a>
							</li>
							<?php endif; 
							if (get_option('wp_oese_theme_nalrc_youtube')): ?>
							<li class="col-md-12 nav-item">
								<a href="<?php echo esc_url(get_option('wp_oese_theme_nalrc_youtube')); ?>" target="_blank">YouTube</a>
							</li>
							<?php endif; 
							if (get_option('wp_oese_theme_nalrc_instagram')): ?>
							<li class="col-md-12 nav-item">
								<a href="<?php echo esc_url(get_option('wp_oese_theme_nalrc_instagram')); ?>" target="_blank">Instagram</a>
							</li>
							<?php endif; ?>
						</ul>
					</li>
					<li class="col-md-6 col-sm-12 nav-item">
						<a>Newsletter</a>
						<ul class="row nalrc-submenu">
							<li class="col-md-12 nav-item">
								<a href="javascript:void(0)" role="button" class="button-subscribe">Subscribe</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</div>