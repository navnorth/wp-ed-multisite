<?php
global $post;
$contact_content = get_post_meta($post->ID,'_contact_box',true);
$contact_heading = get_post_meta($post->ID,'_contact_box_heading',true);
$contact_icon = get_post_meta($post->ID,'_contact_box_icon',true);
if (strlen($contact_content)>0){
?>
<div class="right_sid_mtr program_toc_box" id="contact">
	<div class="col-md-12 col-sm-12 col-xs-12" style="border: 3px solid #294179;margin-bottom:10px;">
		<div class="pblctn_box">
			<span class="socl_icns fa-stack"><i class="fa <?php echo $contact_icon; ?>"></i></span>
		</div>
		<div class="cntnbx_cntnr">
			<p><span class="program_toc_header"><?php echo $contact_heading; ?></span></p>
			<?php echo $contact_content; ?>
		</div>
	</div>
</div>
<?php }?>