<?php
    
?>
<a id="content" tabindex="0"></a>
<div class="col-md-9 col-sm-12 col-xs-12">
    <h3><?php echo get_the_title($post->ID) . ": " . "Full Video Library"; ?></h3>
    <div class="gat_content">
        <?php 
            $content = get_post_meta($post->ID, "full_library_content", true);
	    echo '<p>' . $content . '</p>';
        ?>
    </div>
    <div class="video-list">
        <?php
            $domainids = get_domainid_by_assementid($post->ID);
            foreach($domainids as $domainid){
                $domain = get_post($domainid);
                ?>
                <div class="vlist">
                    <h4><?php echo $domain->post_title; ?></h4>
                </div>
                <?php
            }
        ?>
    </div>
</div>