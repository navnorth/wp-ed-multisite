<?php
global $wp;
$current_url = home_url( $wp->request );
?>
<div id="ssba-share-buttons" class="collapse">

    <!-- Facebook -->
    <a href="http://www.facebook.com/sharer.php?u=<?php echo $current_url; ?>" onclick="oese_trackEvent('Publication','click','Share via Facebook','<?php echo $post->post_title; ?>')" target="_blank" title="Share this via Facebook">
        <img src="<?php echo get_template_directory_uri(); ?>/buttons/facebook.png" alt="Facebook" />
    </a>

    <!-- Twitter -->
    <a href="https://twitter.com/share?url=<?php echo $current_url; ?>&amp;text=<?php echo $post->post_title; ?>&amp;hashtags=<?php echo sanitize_title($post->post_title); ?>" onclick="oese_trackEvent('Publication','click','Share via Twitter','<?php echo $post->post_title; ?>')" target="_blank" title="Share this via Twitter">
        <img src="<?php echo get_template_directory_uri(); ?>/buttons/twitter.png" alt="Twitter" />
    </a>

      <!-- Email -->
    <a href="mailto:?Subject=<?php echo $post->post_title; ?>&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 <?php echo $current_url; ?>" onclick="oese_trackEvent('Publication','click','Share via Email','<?php echo $post->post_title; ?>')" title="Share this via Email">
        <img src="<?php echo get_template_directory_uri(); ?>/buttons/email.png" alt="Email" />
    </a>

</div>
