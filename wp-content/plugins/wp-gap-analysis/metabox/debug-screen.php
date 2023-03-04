<?php
// Get Assessment
$post_type = "assessment";
$assessments = get_posts(array(
    "numberposts" => -1,
    "post_type" => $post_type
));

?>
<div class="wrap">
    <h2>Admin Debug Screen</h2>
    <?php
    if (!empty($assessments)) {
        foreach($assessments as $assessment){
            ?>
            <h3><?php echo $assessment->post_title; ?></h3>
            <?php
            $assessment_id = $assessment->ID;
            $domains = get_domains($assessment_id);
            if ($domains->have_posts()){
                ?>
                <div class="gat_wrpr">
                <table cellspacing="5" width="100%" class="wp-list-table widefat fixed">
                    <thead>
                        <tr>
                            <td width="80%" colspan="2"><strong>Domain</strong></td>
                            <td width="20%" colspan="2"><strong>Order</strong></td>
                        </tr>
                    </thead>
                    <tbody id="the-list">
                    <?php
                    
                    while($domains->have_posts()){
                         $domains->the_post();
                         ?>
                         <tr>
                            <td colspan="2"><strong><em><?php the_title(); ?></em></strong></td>
                         <?php
                         $domainId = get_the_ID();
                         $menu_order  = get_domain_order($domainId);
                         ?>
                         <td colspan="2"><input type="hidden" name="domainId" value="<?php echo $domainId; ?>"><input type="hidden" name="domain_order" value="<?php echo $menu_order; ?>"><strong><em><?php echo $menu_order; ?></em></strong></td>
                         </tr>
                         <?php
                         $dimensions = get_alldimension_domainid($domainId);
                         if(!empty($dimensions)){
                            ?>
                            <tr>
                                <td width="90%" colspan="4">
                                 <table cellspacing="5" width="100%" class="wp-list-table wp-list-dimension widefat fixed" style="border:none;">
                                    <tbody id="the-list">
                                        <?php foreach($dimensions as $dimension) {
                                            ?>
                                            <tr>
                                                <td width="10%">&nbsp;</td>
                                                <td width="60%"><?php echo $dimension->title; ?></td>
                                                <td width="20%"><?php echo $dimension->dimension_order; ?></td>
                                                <td width="10%">&nbsp;</td>
                                            </tr>
                                            <?php
                                        } ?>
                                    </tbody>
                                 </table>
                            </td></tr>
                            <?php
                         }
                    }
                    ?>
                    </tbody>
               </table>
                </div>
                <?php
            }
        }
    }
    ?>
</div>