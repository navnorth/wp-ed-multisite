<div class="col-md-9 col-sm-12 col-xs-12">
    <h3><?php echo get_the_title($post->ID); ?></h3>

    <div class="gat_moreContent">
        <?php
            $content = get_the_content($post->ID);
            $content = apply_filters('the_content', $content);
            echo strip_tags($content);
        ?>
    </div>

    <ul class="get_domainlist">
    <?php
        $domainids = get_domainid_by_assementid($post->ID);
        if(isset($domainids) && !empty($domainids))
        {
            $i = 1;
            foreach($domainids as $domainid)
            {
                $domain = get_post($domainid);
                $total_dmnsn = get_dimensioncount($domainid);
                $total_dmnsn_rated = get_dimensioncount_domainid($domainid, htmlspecialchars($_COOKIE['GAT_token']));
				$total_rating = get_ratingcount_domainid($domainid, htmlspecialchars($_COOKIE['GAT_token']));

                echo '<li>';
                        echo '<h4 style="float:left;"><a href="'.get_permalink().'?action=token-saved&list='.$i.'">'.$domain->post_title.'</a></h4>';
                        echo '<ul class="gat_indicatorlights">';
                        if($total_rating != 0)
                        {
							$progress = ($total_rating/$total_dmnsn);
							$progress = round( $progress, 1, PHP_ROUND_HALF_UP);
							$resultpage_url = get_permalink($post->ID).'?action=analysis-result';

							if($progress > SCORE_HIGH_DOWN && $progress <= SCORE_HIGH_UPPER)
                            {
                                echo '<li><a href="'.$resultpage_url.'"><div class="get_indicator_btn red"></div></a></li>
                                      <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn yellow"></div></a></li>
                                      <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn green selected_indicatorlght"></div></a></li>';
                            }
                            elseif($progress > SCORE_LOW_UPPER && $progress <= SCORE_HIGH_DOWN)
                            {
                                echo '<li><a href="'.$resultpage_url.'"><div class="get_indicator_btn red"></div></a></li>
                                      <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn yellow selected_indicatorlght"></div></a></li>
                                      <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn green"></div></a></li>';
                            }
							elseif($progress > SCORE_LOW_DOWN && $progress <= SCORE_LOW_UPPER)
                            {
                                echo '<li><a href="'.$resultpage_url.'"><div class="get_indicator_btn red selected_indicatorlght"></div></a></li>
									  <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn yellow"></div></a></li>
									  <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn green"></div></a></li>';
                            }
                        }
                        else
                        {
                            echo '<li><a href="'.$resultpage_url.'"><div class="get_indicator_btn red selected_indicatorlght"></div></a></li>
                                  <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn yellow"></div></a></li>
                                  <li><a href="'.$resultpage_url.'"><div class="get_indicator_btn green"></div></a></li>';
                        }
                        echo '</ul>';
                  		echo '<a href="'.get_permalink().'?action=token-saved&list='.$i.'">';
                            if($total_dmnsn_rated != 0)
                            {
                                $progress = ($total_dmnsn_rated/$total_dmnsn)*100;
                                if($progress == 100)
                                {
                                    echo '<label><i class="fa fa-check"></i></label>';
                                }
                                else
                                {
                                    echo '<label class="meter"><span style="width: '.$progress.'%"></span></label>';
                                }
                            }
                            else
                            {
                                echo '<label><i class="fa fa-play"></i></label>';
                            }
                    	echo '</a>';
                echo '</li>';
                $i++;
            }
        }
    ?>
    </ul>
    <div class="get_domainlist_button">
        <a class="btn btn-default gat_buttton" href="<?php echo get_permalink()."?action=token-saved&list=1"; ?>" role="button">Continue Analysis</a>
   </div>
</div>

<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="gat_sharing_widget">
        <p class="pblctn_scl_icn_hedng"> Share the GAP analysis tool </p>
        <div class="pblctn_scl_icns">
            <?php echo do_shortcode("[ssba]"); ?>
        </div>
    </div>
    <?php progress_indicator_sidebar($post->ID, htmlspecialchars($_COOKIE['GAT_token'])); ?>
</div>
