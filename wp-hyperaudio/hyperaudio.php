<?php
/**
* Plugin Name: Official Hyperaudio Plugin
* Plugin URI: https://hyper.audio
* Description: Hyperaudio Interactive Transcript Player
* Version: 1.0
* Author: Mark Boas
* Author URI: http://hyper.audio
**/

$globalid = 0;

// scripts to go in the header and/or footer
add_action('init', 'hyperaudio_init');
add_shortcode('hyperaudio', 'hyperaudio_shortcode_handler');

function hyperaudio_shortcode_handler($atts, $transcript, $tag)
{
  $o = '';

  // defaults
  $src = '';

  if (isset($atts['src'])) $src = esc_html__($atts['src']);
  //$transcript = esc_html__($transcript);

  $transcript = preg_replace( "/\r|\n/", "", $transcript);
  //$transcript = preg_replace( "<br />", "", $transcript);

  $transcript = str_replace("<br />", "", $transcript);

  global $globalid;
  $globalid++;
  $id = $globalid;

  $o .='<style>

  #hypertranscript .strikethrough {
    text-decoration: line-through;
  }
  
  #hypertranscript .annotation, #hypertranscript .parannotation{
    opacity: 0.7;
  }
  
  #hypertranscript .highlight {
    background-color: yellow !important;
  }
  
  #hypertranscript .highlight.active {
    background-color: lightGreen !important;
  }
  
  #hypertranscript  header {
    font-size: 200%;
  }
  
  /*#hypertranscript a {
    cursor: pointer;
    color: #000;
  }*/
  /*
  #hypertranscript .active ~ span {
    color: #999;
  }
  
  #hypertranscript p.active ~ p span {
    color: #999;
  }
  */
  
  #hypertranscript a, a.link {
    border: 0px;
  }
  
  #hypertranscript .read {
    color: #000 !important;
  }
  
  #hypertranscript .unread {
    color: #999 !important;
  }
  
  #hypertranscript .search-match {
    background-color: pink !important;
  }
  
  #hypertranscript .share-match {
    background-color: #66ffad !important;
  }
  
  #hypertranscript sub:before {
    content: "\231C";
  }
  
  #hypertranscript sub.highlight-duration:before {
    content: "\231D";
  }
  
  #hypertranscript h5 {
    font-size: 130%;
  }
  
  [data-m] {
    cursor: pointer;
  }
  
  
  body {
    font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
    line-height: 1.5;
  }
  
  .speaker {
    font-weight: bold;
  }

  a {
    text-decoration:none !important;
  }

  </style>';

  $o .='<style>.share-this-popover{max-width:8em;pointer-events:none;-webkit-filter:drop-shadow(0 1px 3px rgba(0,0,0,.35));filter:drop-shadow(0 1px 3px rgba(0,0,0,.35));-webkit-animation:a .3s;animation:a .3s}.share-this-popover:before{content:"";position:absolute;bottom:100%;left:50%;width:0;height:0;margin:.25em -.5em;border-width:.5em .5em 0;border-style:solid;border-color:#333 transparent}.share-this-popover>ul{pointer-events:auto;list-style:none;padding:0;margin:-.75em 0 0;white-space:nowrap;background:#333;color:#fff;border-radius:.25em;position:absolute;left:50%;-webkit-transform:translate(-50%,-100%);-ms-transform:translate(-50%,-100%);transform:translate(-50%,-100%)}.share-this-popover>ul>li{display:inline-block;width:2em;height:2em;line-height:2em;text-align:center}.share-this-popover>ul>li>a{display:inline-block;width:100%;height:100%;color:inherit;box-sizing:border-box;padding:.35em}.share-this-popover>ul>li>a:focus,.share-this-popover>ul>li>a:hover{background:hsla(0,0%,100%,.25)}@media (pointer:coarse){.share-this-popover{font-size:150%}.share-this-popover:before{bottom:auto;top:100%;border-width:0 .5em .5em;margin-top:0}.share-this-popover>ul{top:100%;transform:translateX(-50%);margin:.5em 0 0}}@media (max-width:575px){.share-this-popover{left:0!important;right:0!important;width:auto!important;max-width:none}.share-this-popover:before{bottom:auto;top:100%;border-width:0 .5em .5em;margin-top:0}.share-this-popover>ul{top:100%;transform:translateX(-50%);margin:.5em 0 0;left:0;width:100%;transform:none;border-radius:0;text-align:center}}@-webkit-keyframes a{0%{-webkit-transform:translateY(-3em);opacity:0}80%{-webkit-transform:translateY(.5em);opacity:1}to{-webkit-transform:translateY(0)}}@keyframes a{0%{transform:translateY(-3em);opacity:0}80%{transform:translateY(.5em);opacity:1}to{transform:translateY(0)}}</style>';

  $o .='<!--<p>
    <form id="searchForm" style="float:right">
      Playback Rate <span id="currentPbr">1</span><input id="pbr" type="range" value="1" min="0.5" max="3" step="0.1" style="width:10%">
      <input id="search" type="text" ><input type="submit" value="search">
    </form>
  </p>-->';
  
  if (strpos(strtolower($src), 'youtube.com') !== false || strpos(strtolower($src), 'youtu.be') !== false) {
    $o .= '<iframe id="hyperplayer" data-player-type="youtube" width="400" height="300" frameborder="no" allow="autoplay" src='.$src.'"?enablejsapi=1"></iframe>';
  } elseif (strpos(strtolower($src), 'soundcloud.com') !== false) {
    //$o .= '<iframe id="hyperplayer" data-player-type="soundcloud" width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="'.$src.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
    $o .= '<iframe id="hyperplayer" data-player-type="soundcloud" width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/730479133&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe><script src="https://w.soundcloud.com/player/api.js"></script>';
  } elseif (strpos(strtolower($src), '.mp3') !== false) {
    $o .= '<audio id="hyperplayer" style="position:relative; width:100%" src="'.$src.'" controls></audio>';
  } else {
    $o .= '<video id="hyperplayer" style="position:relative; width:100%" src="'.$src.'" controls></video>';
  }


 $o .='<div id="hypertranscript" style="overflow-y:scroll; height:600px; position:relative; border-style:dashed; border-width: 1px; border-color:#999; padding: 8px">'.$transcript.'</div>';


  $o .= '<script>
  ShareThis({
      sharers: [ ShareThisViaTwitter ],
      selector: "article"
  }).init();

  </script>
';

  return $o;
}

function hyperaudio_init()
{
    //global $miniAudioPlayer_version;
    //load_plugin_textdomain('mbMiniAudioPlayer', false, basename(dirname(__FILE__)) . '/languages/');
    //if (!is_admin()) {
        //wp_enqueue_script('jquery');
        wp_enqueue_script('velocity', plugins_url('/js/velocity.js', __FILE__), false, '1.0.0', false);
        wp_enqueue_script('hyperaudio-lite', plugins_url('/js/hyperaudio-lite.js', __FILE__), false, '1.0.0', false);
        wp_enqueue_script('hyperaudio-lite-wrapper', plugins_url('/js/hyperaudio-lite-wrapper.js', __FILE__), false, '1.0.0', false);
        wp_enqueue_script('share-this', plugins_url('/js/share-this.js', __FILE__), false, '1.0.0', false);
        wp_enqueue_script('share-this-twitter', plugins_url('/js/share-this-twitter.js', __FILE__), false, '1.0.0', false);
        wp_enqueue_script('twitter-widget', plugins_url('https://platform.twitter.com/widgets.js', __FILE__), false, '1.0.0', false);
        
    //}
}

add_filter('plugin_action_links', 'hyperaudio_action_links', 10, 2);
function hyperaudio_action_links($links, $file)
{
    static $this_plugin;
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
        // the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=wp-hyperaudio/hyperaudio-admin.php">Settings</a>';
        // add the link to the list
        array_unshift($links, $settings_link);
    }
    return $links;
}

if (is_admin()) {
  require('hyperaudio-admin.php');
}
