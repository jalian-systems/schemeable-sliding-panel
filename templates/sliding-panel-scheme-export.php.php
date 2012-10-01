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

function <?php echo $method_name; ?>_plugin($schemes) {
  $scheme_name = '<?php echo $scheme_name; ?>' ;
  $scheme = 
      <?php var_export($scheme); ?>;

  <?php if( isset( $panel_background ) ): ?>
    $scheme['panel_background'] = <?php echo $panel_background; ?>;
  <?php endif; ?>
  <?php if( isset( $content_background ) ): ?>
    $scheme['content_background'] = <?php echo $content_background; ?>;
  <?php endif; ?>
  <?php if( isset( $extra_css ) ): ?>
    $scheme['extra_css'] = <?php echo $extra_css; ?>;
  <?php endif; ?>
  <?php if( isset( $other_images ) ): ?>
    $scheme['other_images'] = array(
  <?php
    foreach( $other_images as $img ) {
      echo $img . ",\n" ;
    }
  ?>
      );
  <?php endif; ?>
  $scheme['external'] = true ;
  $schemes[$scheme_name] = $scheme ;
  return $schemes ;
}
add_action('sliding-panel-plugin-schemes', '<?php echo $method_name; ?>_plugin');
@>