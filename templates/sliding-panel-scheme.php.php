<@php
/*
 * Plugin Name: Scheme <?php echo $scheme_name; ?> for Sliding Panel
 * Plugin URI: 
 * Description: A scheme to be used with Wordpress Sliding Panel plugin (http://wordpress.org/extend/plugins/wordpress-sliding-panel)
 * Version: 1.0
 * Author: 
 * Author URI: 
 * License: 
*/

function <?php echo $method_name; ?>_local($schemes) {
  $scheme_name = '<?php echo $scheme_name; ?>' ;
  $scheme = 
      <?php var_export($scheme); ?>;

  $schemes[$scheme_name] = $scheme ;
  return $schemes ;
}
add_action('sliding-panel-schemes', '<?php echo $method_name; ?>_local');
@>