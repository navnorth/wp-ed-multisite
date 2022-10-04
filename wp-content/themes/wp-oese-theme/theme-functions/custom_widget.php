<?php
class FeaturedContentWidgetDetails extends WP_Widget
{
     function __construct()
    {
         $widget_options = array('classname'=>'FeaturedContentWidgetDetails', 'description'=> 'Widget that will show Featured Content.');
         parent::__construct('FeaturedContentWidgetDetails','Featured Content', $widget_options);
    }
    function update($newinstance,$oldinstance)
    {
        $instance =  $oldinstance;
        $instance['heading'] = $newinstance['heading'];
	    $instance['title'] = $newinstance['title'];
		$instance['image'] = $newinstance['image'];
		$instance['htmltext'] = $newinstance['htmltext'];
	return $instance;
    }
    function form($instance)
    {
		if(isset($instance['heading']))
		{
			$heading = $instance['heading'];
		}
		if(isset($instance['title']))
		{
			$title = $instance['title'];
		}
		if(isset($instance['image']))
		{
			$image = $instance['image'];
		}
		if(isset($instance['htmltext']))
		{
			$htmltext = $instance['htmltext'];
		}
        ?>  
        <p>
            <label for="<?php echo $this->get_field_id("heading");?>">Heading:</label> 
            <input type="text"  <?php if(isset($heading)){?> value="<?php echo esc_attr($heading); ?>" <?php }else{ echo 'value=""';}?> name="<?php echo $this->get_field_name("heading"); ?>" id="<?php echo $this->get_field_id("heading");?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("title");?>">Title:</label> 
            <input type="text"  <?php if(isset($title)){?> value="<?php echo esc_attr($title); ?>" <?php }else{ echo 'value=""';}?> name="<?php echo $this->get_field_name("title"); ?>" id="<?php echo $this->get_field_id("title");?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("image");?>">Image:</label> 
            <select name="<?php echo $this->get_field_name("image"); ?>" id="<?php  echo $this->get_field_id("image");?>" class="widefat">
				<option value="img1" <?php if(isset($image)){if($image == 'img1'){echo 'selected';}}?>>Star Icon</option>
                <option value="img2" <?php if(isset($image)){if($image == 'img2'){echo 'selected';}}?>>Compress Icon</option>
                    
                <option value="img3" <?php if(isset($image)){if($image == 'img3'){echo 'selected';}}?>>Cogs Icon</option>
                <option value="img4" <?php if(isset($image)){if($image == 'img4'){echo 'selected';}}?>>Cog Icon</option>
                <option value="img5" <?php if(isset($image)){if($image == 'img5'){echo 'selected';}}?>>Globe Icon</option>
                <option value="img6" <?php if(isset($image)){if($image == 'img6'){echo 'selected';}}?>>Poweroff Icon</option>
                <option value="img7" <?php if(isset($image)){if($image == 'img7'){echo 'selected';}}?>>File-o Icon</option>
                <option value="img8" <?php if(isset($image)){if($image == 'img8'){echo 'selected';}}?>>Wifi Icon</option>
                <option value="img9" <?php if(isset($image)){if($image == 'img9'){echo 'selected';}}?>>Check Icon</option>
                <option value="img10" <?php if(isset($image)){if($image == 'img10'){echo 'selected';}}?>>Comment-o Icon</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("htmltext");?>">Html Text:</label> 
            <textarea name="<?php echo $this->get_field_name("htmltext"); ?>" id="<?php echo $this->get_field_id("htmltext");?>" class="widefat"><?php if(isset($htmltext)){ echo esc_attr($htmltext); }else{ echo '';}?> </textarea>
        </p>   
       <?php       
    }
    function widget($args, $instance)
    {
		//here define your html for showing at front side
		//echo $instance['heading'];
		//echo $instance['image'];
		//echo $instance['htmltext'];
		
		$return = '';
		$return .= '<div class="col-md-12 col-sm-6 col-xs-6">';
        $return .= '<div class="pblctn_box">';
			if($instance['image'] == 'img1')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-star "></i></span>';
			}
			elseif($instance['image'] == 'img2')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-compress "></i></span>';
			}
			elseif($instance['image'] == 'img3')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-cogs "></i></span>';
			}
			elseif($instance['image'] == 'img4')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-cog "></i></span>';
			}
			elseif($instance['image'] == 'img5')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-globe "></i></span>';
			}
			elseif($instance['image'] == 'img6')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-power-off "></i></span>';
			}
			elseif($instance['image'] == 'img7')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="far fa-file "></i></span>';
			}
			elseif($instance['image'] == 'img8')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-wifi "></i></span>';
			}
			elseif($instance['image'] == 'img9')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-check "></i></span>';
			}
			elseif($instance['image'] == 'img10')
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-comment-o "></i></span>';
			}
			else
			{
				$return .= '<span class="socl_icns fa-stack"><i class="fas fa-star "></i></span>';
			}
             	
        $return .= '</div>';
        $return .= '<p class="rght_sid_wdgt_hedng">'. $instance['title'] .'</p>';
        $return .= $instance['htmltext'];
        $return .= '</div>';
		
		echo $return;
	}
} 
function register_featurecontent_widget() {
	register_widget( 'FeaturedContentWidgetDetails' );
}
add_action( 'widgets_init', 'register_featurecontent_widget' );