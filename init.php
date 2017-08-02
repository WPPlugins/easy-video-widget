<?php
/*
Plugin Name: Easy video Widget
Plugin URI: http://www.pluginswp.com/easy-video-widget/
Description: This widget lets you create multiple galleries of videos more easily.
Version: 1.2
Author: PluginsWP.com
Author URI: http://www.pluginswp.com

Copyright 2011  PluginsWP

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
*/


function easy_videowg_head() {
	
	//wp_register_script('myScript', WP_PLUGIN_URL . '/myScript/myScript.bundle.js', array('jquery') );
			//wp_register_script('myscript', '/wp-content/plugins/body-mass-index-calculator/js/bmi_calculator.js');
			$site_url = get_option( 'siteurl' );
			echo '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/easy-video-widget/js/swfobject.js"></script>';
}

	function getYTidyou($ytURL) {
#
 
#
$ytvIDlen = 11; // This is the length of YouTube's video IDs
#
 
#
// The ID string starts after "v=", which is usually right after
#
// "youtube.com/watch?" in the URL
#
$idStarts = strpos($ytURL, "?v=");
#
 
#
// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
#
// bases covered), it will be after an "&":
#
if($idStarts === FALSE)
#
$idStarts = strpos($ytURL, "&v=");
#
// If still FALSE, URL doesn't have a vid ID
#
if($idStarts === FALSE)
#
die("YouTube video ID not found. Please double-check your URL.");
#
 
#
// Offset the start location to match the beginning of the ID string
#
$idStarts +=3;
#
 
#
// Get the ID string and return it
#
$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
#
 
#
return $ytvID;
#
 
#
}
class wp_easy_videowg extends WP_Widget {
	
	
	

	
	
	
	function wp_easy_videowg() {
		$widget_ops = array('classname' => 'wp_easy_videowg', 'description' => 'This widget lets you create multiple galleries of videos more easily. Write the url of the videos (flv files on your server or videos on youtube) you can add titles, change the number of thumbnails and enable or disable the autoplay.' );
		$this->WP_Widget('wp_easy_videowg', 'Easy video widget', $widget_ops);
	}
	
	
	function widget($args, $instance) {
		$site_url = get_option( 'siteurl' );
			
			echo $before_widget;
			$widget_title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
			$widget_titles = empty($instance['titles']) ? '&nbsp;' : apply_filters('widget_titles', $instance['titles']);
			$widget_videos = empty($instance['videos']) ? '&nbsp;' : apply_filters('widget_videos', $instance['videos']);
			$widget_autoplay = empty($instance['autoplay']) ? '&nbsp;' : apply_filters('widget_autoplay', $instance['autoplay']);
			$widget_thumbnails = empty($instance['thumbnails']) ? '&nbsp;' : apply_filters('widget_thumbnails', $instance['thumbnails']);
			
			$widget_width = empty($instance['width']) ? '&nbsp;' : apply_filters('widget_width', $instance['width']);
			
			$widget_height = empty($instance['height']) ? '&nbsp;' : apply_filters('widget_height', $instance['height']);
			
			
			/// vars
			
			$texto='';
	
	

$texto='title='.$titles.'&controls='.$controls.'&color1=222222&color2=cccccc&autoplay='.$widget_autoplay.'&skin=1&youtube='.$youtube.'&columns='.$widget_thumbnails.'&rows=1&tumb=33&round=8';

$links = array();
$titlesa = array();
if($widget_videos!="") $links=preg_split ("/\n/", $widget_videos);
if($widget_titles!="") $titlesa=preg_split ("/\n/", $widget_titles);
$cont1=0;

while($cont1<count($links)) {
	$auxititle="";
	$auxivideo="";
	$auxtipo=0;
	if(isset($titlesa[$cont1])) $auxititle=$titlesa[$cont1];
	if(isset($links[$cont1])) $auxivideo=$links[$cont1];
	if($auxivideo!="") {
		$auxtipo=1;
		if(strstr($auxivideo, "http")) {
			if(strpos($auxivideo, "youtube")>0) {
				$auxivideo=getYTidyou($auxivideo);
				$auxtipo=2;
			}
			else $auxtipo=1;
		}
		else $auxtipo=2;
		

	}
	$texto.='&video'.$cont1.'='.$auxivideo.'&title'.$cont1.'='.$auxititle.'&tipo'.$cont1.'='.$auxtipo;
	$cont1++;
}
$texto.='&cantidad='.$cont1;
			
			
			/////////////////
			
		
			
			echo $before_title . $widget_title . $after_title;
			
			if($widget_title!="") echo '<br/><br/>';
			
			echo '
			
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$widget_width.'" height="'.$widget_height.'" id="easyvideo'.$id.'-'.$contador.'" title="'.$widget_title.'">
  <param name="movie" value="'.$site_url.'/wp-content/plugins/easy-video-widget/easy_video_widget.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="transparent" />
  	<param name="flashvars" value="'.$texto.'" />
	   <param name="allowFullScreen" value="true" />
 
  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
 
  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="'.$site_url.'/wp-content/plugins/easy-video-widget/easy_video_widget.swf" width="'.$widget_width.'" height="'.$widget_height.'">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="transparent" />
    	<param name="flashvars" value="'.$texto.'" />
		   <param name="allowFullScreen" value="true" />
    
    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
    <div>
      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object>


';
			
			
			
			echo $after_widget;
		
	}
	
	

	
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['videos'] = strip_tags($new_instance['videos']);
		$instance['titles'] = strip_tags($new_instance['titles']);
		$instance['thumbnails'] = strip_tags($new_instance['thumbnails']);
		$instance['autoplay'] = strip_tags($new_instance['autoplay']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Easy video widget pluginswp.com', 'videos' => 'http://www.youtube.com/watch?v=KQ6zr6kCPj8', 'titles' => 'LMFAO PARTY ROCK ANTHEM', 'thumbnails' => '1', 'autoplay' => '0', 'width'=>'100%', 'height'=>'300px') );
		$title = strip_tags($instance['title']);
		$videos = strip_tags($instance['videos']);
		$titles = strip_tags($instance['titles']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$thumbnails = strip_tags($instance['thumbnails']);
		$autoplay = strip_tags($instance['autoplay']);
		
		$autoplay_checked[$autoplay] = 'checked';
		
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
            
            <p><label for="<?php echo $this->get_field_id('videos'); ?>">Video URLs youtube of flv files(one url x line):</label> 
            <textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('videos'); ?>" name="<?php echo $this->get_field_name('videos'); ?>" ><?php echo attribute_escape($videos); ?></textarea></p>
            
             <p><label for="<?php echo $this->get_field_id('titles'); ?>">Video titles(one title x line):</label> 
            <textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('titles'); ?>" name="<?php echo $this->get_field_name('titles'); ?>" ><?php echo attribute_escape($titles); ?></textarea></p>
            
            <p><label for="<?php echo $this->get_field_id('width'); ?>">Width, number with px or %: </label><input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" /></p>
            
                        <p><label for="<?php echo $this->get_field_id('height'); ?>">Height, number with px or %: </label><input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo attribute_escape($height); ?>" /></p>
        	
            <p><label for="<?php echo $this->get_field_id('thumbnails'); ?>">Number of thumbnails: </label><input class="widefat" id="<?php echo $this->get_field_id('thumbnails'); ?>" name="<?php echo $this->get_field_name('thumbnails'); ?>" type="text" value="<?php echo attribute_escape($thumbnails); ?>" /></p>
				
               <p><input name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="1" <?php echo $autoplay_checked['1']; ?> /> Autoplay?</p>
               <p><a href="http://www.pluginswp.com">Download more plugins PLUGINSWP.com</a> <br/><br/>
              
              <a href="http://www.pluginswp.com/sliderpro/">DOWNLOAD SLIDER PRO, images and videos</a> <br/><br/>
              <a href="http://www.pluginswp.com/ultimate-full-video-gallery/">Download ultimate video gallery, widget and plugin</a></p>
                
                
<?php
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("wp_easy_videowg");') );
add_action('wp_head', 'easy_videowg_head');

?>
