<?php
/*
Plugin Name: Toggle Media
Plugin URI: https://www.tipsandtricks-hq.com/toggle-media-wordpress-plugin
Description: Allows you to toggle media when a text/image is clicked
Version: 1.0.1
Author: Tips and Tricks HQ, wptipsntricks
Author URI: http://www.tipsandtricks-hq.com/
*/

add_action( 'wp_enqueue_scripts', 'toggle_media_enqueue_plugin_scripts');

function toggle_media_enqueue_plugin_scripts()
{
    if (!is_admin()) 
    {
        wp_enqueue_script('jquery');
    }
}

function toggle_media_embed($html, $url, $attr) 
{
    if(isset($attr['toggle_media_anchor']))
    {
        $anchor = $attr['toggle_media_anchor'];
        if (preg_match("/http/", $anchor)){ // Use the image as the anchor
            $anchor = '<img src="'.$anchor.'" />';
        }
        $div_id = uniqid();
        $media_id = 'media_'.$div_id;
        $output = <<<EOT
        <a id="$div_id" href="javascript:;">$anchor</a>
        <div id="$media_id" style="display:none;">
            $html
        </div>
        <script type="text/javascript" charset="utf-8">
        /* <![CDATA[ */
        jQuery(document).ready(function($){
            $(function(){
                $("#$div_id").click(function() {
                    $("#$media_id").toggle("slow");
                });
            });
        });
        /* ]]> */
        </script>
EOT;
        return $output;
        
    }
    return $html;
}
add_filter('embed_oembed_html', 'toggle_media_embed', 10, 3);
