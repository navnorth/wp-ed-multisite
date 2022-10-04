<?php
/**
 * Template Name: Contact Slider
 */
global $post;

while ( have_posts() ) : the_post();
    get_template_part( 'content' , 'page' );
endwhile;
    
