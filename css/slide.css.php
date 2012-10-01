<?php header("Content-type: text/css; charset: UTF-8"); ?>
<?php
function sliding_panel_extract_options($pairs, $atts) { 
    $atts = (array)$atts; 
    foreach($pairs as $name => $default) { 
        if ( empty($atts[$name]) )
            $atts[$name] = $default;
    }
    return $atts;
}

    global $sliding_panel_options;
    $sliding_panel_options = get_option( 'sliding-panel-options');
    $options = isset($sliding_panel_options['options']) ? $sliding_panel_options['options'] : array();
    $content_display = isset($options['content_display']) ? $options['content_display'] : 'Overlay over Content' ;
    $overlay = ($content_display != 'Slide Down');
    $color_defaults = array(
      'text_color' => '#999999',
      'background_color' => '#272727',
      'h1_color' => 'white',
      'h2_color' => 'white',
      'link_color' => '#15ADFF',
      'link_hover_color' => '#FFFFFF',
      'field_color' => '#FFFFFF',
      'field_bg_color' => '#414141',
      'field_bg_focus_color' => '#545454', 
      'field_border_color' => '#1A1A1A',
      'panel_border_color' => '#414141',
      'login_bg_color' => '#21759B',
      'login_border_color' => '#298CBA',
      'login_color' => '#FFFFFF',
      'login_hover_color' => '#e0e0e0',
      'lostpwd_bg_color' => '#21759B',
      'lostpwd_border_color' => '#298CBA',
      'lostpwd_color' => '#FFFFFF',
      'lostpwd_hover_color' => '#e0e0e0',
      'register_bg_color' => '#E7E7E7',
      'register_border_color' => '#C7C7C7',
      'register_color' => '#636363',
      'register_hover_color' => '#838383',
      'tab_link_color' => '#15ADFF',
      'tab_link_hover_color' => '#FFFFFF',
    );
    $font_defaults = array(
      'panel_font_family' => 'Arial, Helvetica Neue, Helvetica, sans-serif',
      'panel_font_size' => '13px',
      'h1_font_family' => 'Arial, Helvetica Neue, Helvetica, sans-serif',
      'h1_font_size' => '20px',
      'h1_font_weight' => 'bold',
      'h1_font_style' => 'normal',
      'h2_font_family' => 'Arial, Helvetica Neue, Helvetica, sans-serif',
      'h2_font_size' => '16px',
      'h2_font_weight' => 'bold',
      'h2_font_style' => 'normal',
      'btn_font_family' => 'Arial, Helvetica Neue, Helvetica, sans-serif',
      'btn_font_size' => '16px',
      'btn_font_weight' => 'bold',
      'btn_font_style' => 'normal',
      'tab_font_family' => 'Arial, Helvetica Neue, Helvetica, sans-serif',
      'tab_font_size' => '12px',
      'tab_font_weight' => 'bold',
      'tab_font_style' => 'normal',
      'tab_images' => 'Tab Images',
    );
    $sliding_panel_options = sliding_panel_extract_options($color_defaults, $sliding_panel_options);
    $sliding_panel_options = sliding_panel_extract_options($font_defaults, $sliding_panel_options);
    $c = function($name) { global $sliding_panel_options; echo $sliding_panel_options[$name . '_color']; };
    $ff = function($name) { global $sliding_panel_options; echo $sliding_panel_options[$name . '_font_family']; };
    $fs = function($name) { global $sliding_panel_options; echo $sliding_panel_options[$name . '_font_size']; };
    $fw = function($name) { global $sliding_panel_options; echo $sliding_panel_options[$name . '_font_weight']; };
    $fst = function($name) { global $sliding_panel_options; echo $sliding_panel_options[$name . '_font_style']; };
    $e = function($name) { global $sliding_panel_options; return empty($sliding_panel_options[$name . '_color']); };
?>
/*
Name: Sliding Login Panel with jQuery 1.3.2
Author: Jeremie Tisseau
Author URI: http://web-kreation.com/
Date: March 26, 2009
Version: 1.0
    The CSS, XHTML and design is released under Creative Common License 3.0:
    http://creativecommons.org/licenses/by-sa/3.0/

*/ 

/***** clearfix *****/
.clear {clear: both;height: 0;line-height: 0;}
.clearfix:after {content: ".";display: block;height: 0;clear: both;visibility: hidden;}
.clearfix {display: inline-block;}
/* Hides from IE-mac */
* html .clearfix {height: 1%;}
.clearfix {display: block;}
/* End hide from IE-mac */
.clearfix {height: 1%;}
.clearfix {display: block;}

#sliding-panel * {
	text-shadow: none;
}

div.overview-dashboard {
}

div.overview-login {
}

div.overview {
  -moz-transform: scale(0.85);
  -moz-transform-origin: 0% 0%;
  -webkit-transform: scale(0.85);
  -webkit-transform-origin: 0% 0%;
  -ms-transform: scale(0.85);
  -ms-transform-origin: 0% 0%;
  -o-transform: scale(0.85);
  -o-transform-origin: 0% 0%;
}

div.overview-dashboard:after {content: ".";display: block;height: 0;clear: right;visibility: hidden;}
div.overview-login:after {content: ".";display: block;height: 0;clear: right;visibility: hidden;}

div.overview #sliding-panel {
    position: relative;
    width:980px;
}

div.overview #sliding-panel #panel {
	display: block;
	overflow: hidden ;
	height: auto;
}

/* sliding panel */
#sliding-panel {
<?php if($content_display == 'Fixed'): ?>
    position: fixed;   /*Panel will overlap  content */
<?php elseif($content_display == 'Overlay over Content'): ?>
    position: absolute;   /*Panel will overlap  content */
<?php else: ?>
    position: relative;   /*Panel will "push" the content down */
<?php endif; ?>
<?php if(is_admin_bar_showing() && $overlay): ?>
    top: 28px;
<?php else: ?>
    top: 0;
<?php endif; ?>
    left: 0;
    width: 100%;
    z-index: 10000; /* Work by default with twentyeleven theme */
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}

#sliding-panel #panel {
    width: 100%;
    /* height: 280px; */
    overflow: hidden;
    position: relative;
    z-index: 3;
    display: none;
}

#sliding-panel #panel p {
    margin: 5px 0 10px;
    padding: 0;
}

#sliding-panel #panel a {
    text-decoration: none;
}

#sliding-panel #panel ul {
    margin: 0 0 5px 0;
    padding: 0;
    line-height: 1.6em;
    list-style: none;
}

#sliding-panel #panel .content {
    width: 960px;
    margin: 0 auto;
    padding-top: 15px;
    text-align: left;
}

#sliding-panel #panel .content a {
}

#sliding-panel #panel .content .left {
    width: 280px;
    float: left;
    margin-bottom: 25px;
    padding: 0 15px;
    min-height: 220px;
    border-left: 1px solid #333;
}

#sliding-panel #panel .content .border {
    border-left: 1px solid #333;
}

#sliding-panel #panel .content .narrow {
    width:120px !important;
}

#sliding-panel #panel .content form {
    margin: 0;
}

#sliding-panel #panel .content label {
    float: left;
    padding-top: 8px;
    clear: both;
    width: 280px;
    display: block;
}

#sliding-panel #panel .content input.field {
    border: 1px #1A1A1A solid;
    margin-right: 5px;
    margin-top: 4px;
    width: 200px;
    height: 16px;
}

#sliding-panel #panel .lost-pwd {
    display: inline-block;
    text-decoration: underline;
}

/* Panel Tab/button */
#sliding-panel #register-message, #sliding-panel #login-message, #sliding-panel #lostpwd-message {
}

#sliding-panel #wp-social-login-connect-with {
  margin: 10px;
}

#sliding-panel #wp-social-login-connect-options {
  margin-top: 20px;
}

#sliding-panel a.wsl_connect_with_provider {
    padding-right: 3px;
}

#sliding-panel .content p {
}

/* Colors */

#sliding-panel #panel {
    color: <?php $c('text'); ?>;
    background-color:   <?php $c('background'); ?>;
}

#sliding-panel h1 {
    color: <?php $c('h1'); ?>;
}

#sliding-panel h2{
    color: <?php $c('h2'); ?>;
}

#sliding-panel #panel a {
    color: <?php $c('link'); ?>;
}

#sliding-panel #panel a:hover {
    color: <?php $c('link_hover'); ?>;
}

#sliding-panel #panel .content input.field {
    background-color: <?php $c('field_bg'); ?>;
    color: <?php $c('field'); ?>;
}

#sliding-panel #panel .content .left {
    border-left: 1px solid <?php $c('panel_border'); ?>;
}

#sliding-panel #panel .content .border {
    border-left: 1px solid <?php $c('panel_border'); ?>;
}

#sliding-panel #panel .content input.field {
    border-color: <?php $c('field_border'); ?>;
}

#sliding-panel #panel .content input:focus.field {
    background-color: <?php $c('field_bg_focus'); ?>;
}

#sliding-panel input[type=submit].bt_login,
#sliding-panel input[type=submit].bt_lostpwd,
#sliding-panel input[type=submit].bt_register {
    clear:left;
    margin-top:8px;
    line-height: 16px;
    padding: 3px 8px 3px 8px;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);
    -moz-box-sizing: content-box;
    border-radius: 11px 11px 11px 11px;
    border-style: solid;
    border-width: 1px;
    cursor: pointer;
    text-decoration: none;
    outline: 0 none;
    height: auto;
    width: auto;
}

#sliding-panel input[type=submit].bt_login {
    background: <?php $c('login_bg'); ?>;
    border-color: <?php $c('login_border'); ?>;
    color: <?php $c('login'); ?>;
}

#sliding-panel input[type=submit].bt_login:hover {
   color: <?php $c('login_hover'); ?>
}

#sliding-panel input[type=submit].bt_lostpwd {
    background: <?php $c('lostpwd_bg'); ?>;
    border-color: <?php $c('lostpwd_border'); ?>;
    color: <?php $c('lostpwd'); ?>;
}

#sliding-panel input[type=submit].bt_lostpwd:hover {
   color: <?php $c('lostpwd_hover'); ?>
}

#sliding-panel input[type=submit].bt_register {
    background: <?php $c('register_bg'); ?>;
    border-color: <?php $c('register_border'); ?>;
    color: <?php $c('register'); ?>;
}

#sliding-panel input[type=submit].bt_register:hover {
   color: <?php $c('register_hover'); ?>
}

/* Background Images */

<?php if(!empty($sliding_panel_options['panel_background'])): ?>
#sliding-panel #panel {
<?php if(empty($sliding_panel_options['panel_background_repeat'])): ?>
  background: url(<?php echo $sliding_panel_options['panel_background']; ?>) no-repeat left top  <?php $c('background'); ?>;
<?php else: ?>
  background: url(<?php echo $sliding_panel_options['panel_background']; ?>) repeat left top  <?php $c('background'); ?>;
<?php endif; ?>
}
<?php endif; ?>

<?php if(!empty($sliding_panel_options['content_background'])): ?>
#sliding-panel #panel .content {
<?php if(empty($sliding_panel_options['content_background_repeat'])): ?>
  background: url(<?php echo $sliding_panel_options['content_background']; ?>) no-repeat left top <?php $c('background'); ?>;
<?php else: ?>
  background: url(<?php echo $sliding_panel_options['content_background']; ?>) repeat left top  <?php $c('background'); ?>;
<?php endif; ?>
}
<?php endif; ?>

/* FONTS */

#sliding-panel {
	font-family: <?php $ff('panel'); ?>;
	font-size: <?php $fs('panel'); ?>;
	line-height: 1em;
}

#sliding-panel h1 {
    text-align: left;
    display: block ;
    margin: 10px 0 10px 0;
    font-family: <?php $ff('h1'); ?>;
    font-size: <?php $fs('h1'); ?>;
    font-weight: <?php $fw('h1'); ?>;
    font-style: <?php $fst('h1'); ?>;
}

#sliding-panel h2 {
    margin: 6px 0 6px 0;
    text-align: left;
    display: block;
    font-family: <?php $ff('h2'); ?>;
    font-size: <?php $fs('h2'); ?>;
    font-weight: <?php $fw('h2'); ?>;
    font-style: <?php $fst('h2'); ?>;
}

#sliding-panel input[type=submit].bt_login,
#sliding-panel input[type=submit].bt_lostpwd,
#sliding-panel input[type=submit].bt_register {
    font-family: <?php $ff('btn'); ?>;
    font-size: <?php $fs('btn'); ?>;
    font-weight: <?php $fw('btn'); ?>;
    font-style: <?php $fst('btn'); ?>;
}

<?php include(dirname(__FILE__) . '/slide-tab.css.php'); ?>

<?php echo $sliding_panel_options['extra_css']; ?>
