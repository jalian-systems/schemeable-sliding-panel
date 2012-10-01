<?php

global $messages ;
$messages = array() ;

class Schemeable_Sliding_Panel_v1_0_u_Sliding_Panel_Options {
  static function setup() {
    $var = new Schemeable_Sliding_Panel_v1_0_u_Sliding_Panel_Options;
        $page = add_submenu_page( 'themes.php', 'Sliding Panel Options', 'Sliding Panel Options', 'edit_theme_options',
                      'sliding-panel-options', array(&$var, 'render_menu_page') );
    add_action( 'load-' . $page, array(&$var, 'load_page') );
  }

  function load_page() {
    $this->__enqueue_css();
    $this->setup_help();
    do_action('add_menu_page_meta_boxes', 'sliding-panel-options', null);
  }

  function setup_help() {
    $screen = get_current_screen();
    $menu_slug = 'sliding-panel-options' ;
    $help_tabs = array();
    if( !is_dir( dirname( __FILE__ ) . '/help' ) )
      return ;
    $help_files = scandir( dirname( __FILE__ ) . '/help' );
    foreach( $help_files as $help_file ) {
      if( preg_match( '/[^-]*-' . get_bloginfo('language') . '-' . $menu_slug . '-' . '/', $help_file ) ) {
        $display = preg_replace( '/[^-]*-' . get_bloginfo('language') . '-' . $menu_slug . '-' . '/', '', basename( $help_file, '.md' ) );
        $display = ucwords( str_replace( '-', ' ', $display ) );
        $help_tabs[] = array( sanitize_html_class( $help_file ), $display, $help_file );
      } else if( get_bloginfo('language') . '-' . $menu_slug . '-sidebar.md' == $help_file ) {
        $sidebar = $help_file ;
      }
    }
    foreach( $help_tabs as $tab )
      $screen->add_help_tab( array(
        'id' => $tab[0],
        'title' => $tab[1],
        'content' => Markdown( file_get_contents( dirname( __FILE__ ) . '/help/' . $tab[2] ) )
      ) );

    if( isset( $sidebar ) )
      $screen->set_help_sidebar( Markdown( file_get_contents( dirname( __FILE__ ) . '/help/' . $sidebar ) ) );
  }

  function get_field_id( $id ) {
    return 'id_Schemeable_Sliding_Panel_v1_0_u_Sliding_Panel_Options_' . $id ;
  }

  function get_field_name( $id ) {
    return 'name_Schemeable_Sliding_Panel_v1_0_u_Sliding_Panel_Options_' . $id ;
  }

  function render_menu_page() {

    $action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'edit' ;
    if( isset( $_REQUEST['_wpnonce']) )
      check_admin_referer( plugin_basename( __FILE__ ) );
    if( $action == 'edit' ) {
      $instance = get_option('sliding-panel-options') ;
    }
    if( empty( $instance ) || $action != 'edit' ) {
      $odefaults = array(
                 'preview' => '',
                 'settings' => '',
                 'text_color' => '#999999',
                 'background_color' => '#272727',
                 'panel_border_color' => '#414141',
                 'h1_color' => '#FFFFFF',
                 'h2_color' => '#FFFFFF',
                 'link_color' => '#15ADFF',
                 'link_hover_color' => '#FFFFFF',
                 'field_color' => '#FFFFFF',
                 'field_bg_color' => '#414141',
                 'field_bg_focus_color' => '#545454',
                 'field_border_color' => '#1A1A1A',
                 'login_color' => '#FFFFFF',
                 'login_hover_color' => '#e0e0e0',
                 'login_bg_color' => '#21759B',
                 'login_border_color' => '#298CBA',
                 'register_color' => '#636363',
                 'register_hover_color' => '#838383',
                 'register_bg_color' => '#E7E7E7',
                 'register_border_color' => '#C7C7C7',
                 'lostpwd_color' => '#FFFFFF',
                 'lostpwd_hover_color' => '#e0e0e0',
                 'lostpwd_bg_color' => '#21759B',
                 'lostpwd_border_color' => '#29BCBA',
                 'tab_link_color' => '#15ADFF',
                 'tab_link_hover_color' => '#FFFFFF',
                 'gd_exists' => '',
                 'tab_images' => 'Tab Images',
                 'tab_background_color' => '',
                 'tab_border_color' => '',
                 'gd_exists_end' => '',
                 'panel_background' => '',
                 'panel_background_repeat' => '',
                 'content_background' => '',
                 'content_background_repeat' => '',
                 'panel_font_family' => '',
                 'panel_font_size' => '',
                 'h1_font_family' => '',
                 'h1_font_size' => '',
                 'h1_font_weight' => '',
                 'h1_font_style' => '',
                 'h2_font_family' => '',
                 'h2_font_size' => '',
                 'h2_font_weight' => '',
                 'h2_font_style' => '',
                 'btn_font_family' => '',
                 'btn_font_size' => '',
                 'btn_font_weight' => '',
                 'btn_font_style' => '',
                 'tab_font_family' => '',
                 'tab_font_size' => '',
                 'tab_font_weight' => '',
                 'tab_font_style' => '',
                 'login_panel' => '',
                 'has_social_login' => '',
                 'use_social_login' => 'Use Social Login',
                 'social_login_introduction' => '',
                 'has_social_login_end' => '',
                 'welcome_message' => '',
                 'registration_available' => '',
                 'registration_message' => '',
                 'registration_available_end' => '',
                 'heading_login' => 'Login with Local Account',
                 'heading_register' => 'Signup for a Local Account',
                 'heading_lost_password' => 'Lost Password',
                 'tab_login_link' => 'Login | Register',
                 'tab_close_panel' => 'Close Panel',
                 'do_not_show_dashboard' => '',
                 'show_dashboard' => '',
                 'dashboard_welcome_message' => '',
                 'dashboard_message' => '',
                 'tab_dashboard_open_link' => 'Show Dashboard',
                 'other_images' => '',
                 'extra_css_blurb' => '',
                 'extra_css' => '',
        );

      $odefaults = apply_filters('pde-menu-page-defaults-sliding-panel-options', $odefaults);
      $defaults = array();
      foreach( $odefaults as $k => $v )
        $defaults[$this->get_field_name($k)] = $v ;

      $post_vars = shortcode_atts( $defaults, $_POST );

      $instance = array();
      $instance['preview'] = $post_vars[$this->get_field_name('') . 'preview'] ;
      $instance['settings'] = $post_vars[$this->get_field_name('') . 'settings'] ;
      $instance['text_color'] = $post_vars[$this->get_field_name('') . 'text_color'] ;
      $instance['background_color'] = $post_vars[$this->get_field_name('') . 'background_color'] ;
      $instance['panel_border_color'] = $post_vars[$this->get_field_name('') . 'panel_border_color'] ;
      $instance['h1_color'] = $post_vars[$this->get_field_name('') . 'h1_color'] ;
      $instance['h2_color'] = $post_vars[$this->get_field_name('') . 'h2_color'] ;
      $instance['link_color'] = $post_vars[$this->get_field_name('') . 'link_color'] ;
      $instance['link_hover_color'] = $post_vars[$this->get_field_name('') . 'link_hover_color'] ;
      $instance['field_color'] = $post_vars[$this->get_field_name('') . 'field_color'] ;
      $instance['field_bg_color'] = $post_vars[$this->get_field_name('') . 'field_bg_color'] ;
      $instance['field_bg_focus_color'] = $post_vars[$this->get_field_name('') . 'field_bg_focus_color'] ;
      $instance['field_border_color'] = $post_vars[$this->get_field_name('') . 'field_border_color'] ;
      $instance['login_color'] = $post_vars[$this->get_field_name('') . 'login_color'] ;
      $instance['login_hover_color'] = $post_vars[$this->get_field_name('') . 'login_hover_color'] ;
      $instance['login_bg_color'] = $post_vars[$this->get_field_name('') . 'login_bg_color'] ;
      $instance['login_border_color'] = $post_vars[$this->get_field_name('') . 'login_border_color'] ;
      $instance['register_color'] = $post_vars[$this->get_field_name('') . 'register_color'] ;
      $instance['register_hover_color'] = $post_vars[$this->get_field_name('') . 'register_hover_color'] ;
      $instance['register_bg_color'] = $post_vars[$this->get_field_name('') . 'register_bg_color'] ;
      $instance['register_border_color'] = $post_vars[$this->get_field_name('') . 'register_border_color'] ;
      $instance['lostpwd_color'] = $post_vars[$this->get_field_name('') . 'lostpwd_color'] ;
      $instance['lostpwd_hover_color'] = $post_vars[$this->get_field_name('') . 'lostpwd_hover_color'] ;
      $instance['lostpwd_bg_color'] = $post_vars[$this->get_field_name('') . 'lostpwd_bg_color'] ;
      $instance['lostpwd_border_color'] = $post_vars[$this->get_field_name('') . 'lostpwd_border_color'] ;
      $instance['tab_link_color'] = $post_vars[$this->get_field_name('') . 'tab_link_color'] ;
      $instance['tab_link_hover_color'] = $post_vars[$this->get_field_name('') . 'tab_link_hover_color'] ;
      $instance['gd_exists'] = $post_vars[$this->get_field_name('') . 'gd_exists'] ;
      $instance['tab_images'] = $post_vars[$this->get_field_name('') . 'tab_images'] ;
      $instance['tab_background_color'] = $post_vars[$this->get_field_name('') . 'tab_background_color'] ;
      $instance['tab_border_color'] = $post_vars[$this->get_field_name('') . 'tab_border_color'] ;
      $instance['gd_exists_end'] = $post_vars[$this->get_field_name('') . 'gd_exists_end'] ;
      $instance['settings'] = $post_vars[$this->get_field_name('') . 'settings'] ;
      $instance['panel_background'] = $post_vars[$this->get_field_name('') . 'panel_background'] ;
      $instance['panel_background_repeat'] = $post_vars[$this->get_field_name('') . 'panel_background_repeat'] ;
      $instance['content_background'] = $post_vars[$this->get_field_name('') . 'content_background'] ;
      $instance['content_background_repeat'] = $post_vars[$this->get_field_name('') . 'content_background_repeat'] ;
      $instance['settings'] = $post_vars[$this->get_field_name('') . 'settings'] ;
      $instance['panel_font_family'] = strip_tags( $post_vars[$this->get_field_name('') . 'panel_font_family'] );
      $instance['panel_font_size'] = strip_tags( $post_vars[$this->get_field_name('') . 'panel_font_size'] );
      $instance['h1_font_family'] = strip_tags( $post_vars[$this->get_field_name('') . 'h1_font_family'] );
      $instance['h1_font_size'] = strip_tags( $post_vars[$this->get_field_name('') . 'h1_font_size'] );
      $instance['h1_font_weight'] = $post_vars[$this->get_field_name('') . 'h1_font_weight'] ;
      $instance['h1_font_style'] = $post_vars[$this->get_field_name('') . 'h1_font_style'] ;
      $instance['h2_font_family'] = strip_tags( $post_vars[$this->get_field_name('') . 'h2_font_family'] );
      $instance['h2_font_size'] = strip_tags( $post_vars[$this->get_field_name('') . 'h2_font_size'] );
      $instance['h2_font_weight'] = $post_vars[$this->get_field_name('') . 'h2_font_weight'] ;
      $instance['h2_font_style'] = $post_vars[$this->get_field_name('') . 'h2_font_style'] ;
      $instance['btn_font_family'] = strip_tags( $post_vars[$this->get_field_name('') . 'btn_font_family'] );
      $instance['btn_font_size'] = strip_tags( $post_vars[$this->get_field_name('') . 'btn_font_size'] );
      $instance['btn_font_weight'] = $post_vars[$this->get_field_name('') . 'btn_font_weight'] ;
      $instance['btn_font_style'] = $post_vars[$this->get_field_name('') . 'btn_font_style'] ;
      $instance['tab_font_family'] = strip_tags( $post_vars[$this->get_field_name('') . 'tab_font_family'] );
      $instance['tab_font_size'] = strip_tags( $post_vars[$this->get_field_name('') . 'tab_font_size'] );
      $instance['tab_font_weight'] = $post_vars[$this->get_field_name('') . 'tab_font_weight'] ;
      $instance['tab_font_style'] = $post_vars[$this->get_field_name('') . 'tab_font_style'] ;
      $instance['settings'] = $post_vars[$this->get_field_name('') . 'settings'] ;
      $instance['login_panel'] = $post_vars[$this->get_field_name('') . 'login_panel'] ;
      $instance['has_social_login'] = $post_vars[$this->get_field_name('') . 'has_social_login'] ;
      $instance['use_social_login'] = $post_vars[$this->get_field_name('') . 'use_social_login'] ;
      $instance['social_login_introduction'] = stripslashes ( $post_vars[$this->get_field_name('') . 'social_login_introduction'] );
      $instance['has_social_login_end'] = $post_vars[$this->get_field_name('') . 'has_social_login_end'] ;
      $instance['welcome_message'] = stripslashes ( $post_vars[$this->get_field_name('') . 'welcome_message'] );
      $instance['registration_available'] = $post_vars[$this->get_field_name('') . 'registration_available'] ;
      $instance['registration_message'] = stripslashes ( $post_vars[$this->get_field_name('') . 'registration_message'] );
      $instance['registration_available_end'] = $post_vars[$this->get_field_name('') . 'registration_available_end'] ;
      $instance['heading_login'] = strip_tags( $post_vars[$this->get_field_name('') . 'heading_login'] );
      $instance['heading_register'] = strip_tags( $post_vars[$this->get_field_name('') . 'heading_register'] );
      $instance['heading_lost_password'] = strip_tags( $post_vars[$this->get_field_name('') . 'heading_lost_password'] );
      $instance['tab_login_link'] = strip_tags( $post_vars[$this->get_field_name('') . 'tab_login_link'] );
      $instance['tab_close_panel'] = $post_vars[$this->get_field_name('') . 'tab_close_panel'];
      $instance['settings'] = $post_vars[$this->get_field_name('') . 'settings'] ;
      $instance['do_not_show_dashboard'] = $post_vars[$this->get_field_name('') . 'do_not_show_dashboard'] ;
      $instance['show_dashboard'] = $post_vars[$this->get_field_name('') . 'show_dashboard'] ;
      $instance['dashboard_welcome_message'] = stripslashes ( $post_vars[$this->get_field_name('') . 'dashboard_welcome_message'] );
      $instance['dashboard_message'] = stripslashes ( $post_vars[$this->get_field_name('') . 'dashboard_message'] );
      $instance['tab_dashboard_open_link'] = $post_vars[$this->get_field_name('') . 'tab_dashboard_open_link'];
      $instance['settings'] = $post_vars[$this->get_field_name('') . 'settings'] ;
      $instance['other_images'] = $post_vars[$this->get_field_name('') . 'other_images'] ;
      $instance['extra_css_blurb'] = $post_vars[$this->get_field_name('') . 'extra_css_blurb'] ;
      $instance['extra_css'] = stripslashes ( $post_vars[$this->get_field_name('') . 'extra_css'] );
      $instance = apply_filters('save_menu_page-sliding-panel-options', $instance);
      if( $action == 'edit' ) {
        update_option('sliding-panel-options', $instance ) ;
      }
    }

    if( $action == 'save' ) {
      update_option('sliding-panel-options', $instance ) ;
    }

    do_action('sliding-panel-options-action-' . $action, $instance ) ;

    $instance = get_option('sliding-panel-options') ;

?>
<script type="text/javascript">
(function($) {
  $(document).ready(function() {
  postboxes.add_postbox_toggles('<?php $screen = get_current_screen(); echo $screen->id; ?>');
  });
})(jQuery);
</script>
<div class="wrap" style="width:1120px;">
  <?php screen_icon(); ?>
  <h2>Sliding Panel Options</h2>
  <?php
    global $messages ;
    foreach( $messages as $message ) {
      ?><div class="<?php echo $message[0]; ?>"><?php _e( $message[1] ); ?></div><?php
    }
  ?>
  <br class="clear"/>
  <form id='<?php echo $this->get_field_id("wp-pde-form"); ?>' action="#" method="post" enctype="multipart/form-data">
  <div class="pde-menu-page pde-menu-page-default" style="float:right;">
  <?php
    if( empty( $instance ) ) {
      $instance = array(
                   'preview' => '',
                 'settings' => '',
                 'text_color' => '#999999',
                 'background_color' => '#272727',
                 'panel_border_color' => '#414141',
                 'h1_color' => '#FFFFFF',
                 'h2_color' => '#FFFFFF',
                 'link_color' => '#15ADFF',
                 'link_hover_color' => '#FFFFFF',
                 'field_color' => '#FFFFFF',
                 'field_bg_color' => '#414141',
                 'field_bg_focus_color' => '#545454',
                 'field_border_color' => '#1A1A1A',
                 'login_color' => '#FFFFFF',
                 'login_hover_color' => '#e0e0e0',
                 'login_bg_color' => '#21759B',
                 'login_border_color' => '#298CBA',
                 'register_color' => '#636363',
                 'register_hover_color' => '#838383',
                 'register_bg_color' => '#E7E7E7',
                 'register_border_color' => '#C7C7C7',
                 'lostpwd_color' => '#FFFFFF',
                 'lostpwd_hover_color' => '#e0e0e0',
                 'lostpwd_bg_color' => '#21759B',
                 'lostpwd_border_color' => '#29BCBA',
                 'tab_link_color' => '#15ADFF',
                 'tab_link_hover_color' => '#FFFFFF',
                 'gd_exists' => '',
                 'tab_images' => 'Tab Images',
                 'tab_background_color' => '',
                 'tab_border_color' => '',
                 'gd_exists_end' => '',
                 'panel_background' => '',
                 'panel_background_repeat' => '',
                 'content_background' => '',
                 'content_background_repeat' => '',
                 'panel_font_family' => '',
                 'panel_font_size' => '',
                 'h1_font_family' => '',
                 'h1_font_size' => '',
                 'h1_font_weight' => '',
                 'h1_font_style' => '',
                 'h2_font_family' => '',
                 'h2_font_size' => '',
                 'h2_font_weight' => '',
                 'h2_font_style' => '',
                 'btn_font_family' => '',
                 'btn_font_size' => '',
                 'btn_font_weight' => '',
                 'btn_font_style' => '',
                 'tab_font_family' => '',
                 'tab_font_size' => '',
                 'tab_font_weight' => '',
                 'tab_font_style' => '',
                 'login_panel' => '',
                 'has_social_login' => '',
                 'use_social_login' => 'Use Social Login',
                 'social_login_introduction' => '',
                 'has_social_login_end' => '',
                 'welcome_message' => '',
                 'registration_available' => '',
                 'registration_message' => '',
                 'registration_available_end' => '',
                 'heading_login' => 'Login with Local Account',
                 'heading_register' => 'Signup for a Local Account',
                 'heading_lost_password' => 'Lost Password',
                 'tab_login_link' => 'Login | Register',
                 'tab_close_panel' => 'Close Panel',
                 'do_not_show_dashboard' => '',
                 'show_dashboard' => '',
                 'dashboard_welcome_message' => '',
                 'dashboard_message' => '',
                 'tab_dashboard_open_link' => 'Show Dashboard',
                 'other_images' => '',
                 'extra_css_blurb' => '',
                 'extra_css' => '',
          );
      $instance = apply_filters('pde-menu-page-defaults-sliding-panel-options', $instance);
    }
    ?>


    <?php
    echo "\n\n";wp_nonce_field( plugin_basename( __FILE__ ) );echo "\n\n";
  ?>
        <?php if(!isset($instance['options']['preview']) || $instance['options']['preview'] == 'Preview'): ob_start();?>
<div class="overview-dashboard"><div class="overview">
<?php
  sliding_panel_show_dashboard(1);
?>
</div></div>
<?php if(empty($instance['login_panel'])): ?>
<div class="overview-login"><div class="overview" >
<?php
  sliding_panel_show_login(1);
?>
</div></div>
<?php endif; ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
   $('.overview-dashboard').css('height', (Math.round(parseInt($('.overview-dashboard .overview').css('height')) * 0.85) + 1).toString() + 'px');
<?php if(empty($instance['login_panel'])): ?>
   $('.overview-login').css('height', (Math.round(parseInt($('.overview-login .overview').css('height')) * 0.85) + 1).toString() + 'px');
<?php endif; ?>
});
</script>
<?php echo str_replace('</form', '</div', str_replace('<form', '<div', ob_get_clean())); endif; ?>
<br style="clear:both"/>

<?php 
  ?>
	<div id="tab-<?php echo $this->get_field_id('settings'); ?>">
		<ul></ul>
		<input type="hidden" name="<?php echo $this->get_field_name('settings'); ?>" id="<?php echo $this->get_field_id('settings'); ?>" value="<?php esc_attr_e($instance['settings']); ?>" />
	</div>
  <script type="text/javascript">
    jQuery(document).ready(function() {
				jQuery("#<?php echo $this->get_field_id( 'Colors' ); ?>").detach().appendTo("#tab-<?php echo $this->get_field_id('settings'); ?>");
				jQuery("#<?php echo $this->get_field_id( 'BackgroundImages' ); ?>").detach().appendTo("#tab-<?php echo $this->get_field_id('settings'); ?>");
				jQuery("#<?php echo $this->get_field_id( 'Fonts' ); ?>").detach().appendTo("#tab-<?php echo $this->get_field_id('settings'); ?>");
				jQuery("#<?php echo $this->get_field_id( 'LoginRegisterPanel' ); ?>").detach().appendTo("#tab-<?php echo $this->get_field_id('settings'); ?>");
				jQuery("#<?php echo $this->get_field_id( 'DashboardPanel' ); ?>").detach().appendTo("#tab-<?php echo $this->get_field_id('settings'); ?>");
				jQuery("#<?php echo $this->get_field_id( 'CSS' ); ?>").detach().appendTo("#tab-<?php echo $this->get_field_id('settings'); ?>");
				$tabs = jQuery("#tab-<?php echo $this->get_field_id('settings'); ?>").tabs();
					$tabs.tabs('add', "#<?php echo $this->get_field_id( 'Colors' ); ?>", "<?php _e('Colors'); ?>");
					$tabs.tabs('add', "#<?php echo $this->get_field_id( 'BackgroundImages' ); ?>", "<?php _e('Background Images'); ?>");
					$tabs.tabs('add', "#<?php echo $this->get_field_id( 'Fonts' ); ?>", "<?php _e('Fonts'); ?>");
					$tabs.tabs('add', "#<?php echo $this->get_field_id( 'LoginRegisterPanel' ); ?>", "<?php _e('Login/Register Panel'); ?>");
					$tabs.tabs('add', "#<?php echo $this->get_field_id( 'DashboardPanel' ); ?>", "<?php _e('Dashboard Panel'); ?>");
					$tabs.tabs('add', "#<?php echo $this->get_field_id( 'CSS' ); ?>", "<?php _e('CSS'); ?>");
				jQuery("#tab-<?php echo $this->get_field_id('settings'); ?>").bind('tabsselect', function(e,ui) {
			jQuery("#<?php echo $this->get_field_id('settings'); ?>").val(ui.index);
		});
<?php if(!empty($instance['settings'])): ?>
    $tabs.tabs('select', <?php esc_attr_e($instance['settings']); ?>);
<?php endif; ?>
		return true ;
    });
  </script>
  <?php 
  ?>
   <div id='<?php echo $this->get_field_id( "Colors"); ?>'>
<?php
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Sliding Panel' ); ?></h3>      </div>
<?php 
    $text_color = esc_attr( $instance['text_color'] );
?>
    <div class="pde-form-field pde-form-text text_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('text_color'); ?>">
          <span><?php esc_html_e( __('Text Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $text_color; ?>" name="<?php echo $this->get_field_name('text_color'); ?>" id="<?php echo $this->get_field_id('text_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('text_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('text_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('text_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('text_color'); ?>">
          <span><?php _e( 'Color used for displaying text.' ); ?></span>
        </label>
      </div>
    </div> <!-- text_color -->
<script type="text/javascript">
(function($){
  var text_color_farbtastic = undefined;
	var text_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('text_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('text_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('text_color'); ?>-button, #<?php echo $this->get_field_id('text_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( text_color_farbtastic == undefined ) {
      text_color_pickColor = function(a) {
        text_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  text_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', text_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('text_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('text_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('text_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      text_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		text_color_pickColor( $('#<?php echo $this->get_field_id('text_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('text_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $background_color = esc_attr( $instance['background_color'] );
?>
    <div class="pde-form-field pde-form-text background_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('background_color'); ?>">
          <span><?php esc_html_e( __('Background Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $background_color; ?>" name="<?php echo $this->get_field_name('background_color'); ?>" id="<?php echo $this->get_field_id('background_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('background_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('background_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('background_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('background_color'); ?>">
          <span><?php _e( 'Color used for displaying background.' ); ?></span>
        </label>
      </div>
    </div> <!-- background_color -->
<script type="text/javascript">
(function($){
  var background_color_farbtastic = undefined;
	var background_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('background_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('background_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('background_color'); ?>-button, #<?php echo $this->get_field_id('background_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( background_color_farbtastic == undefined ) {
      background_color_pickColor = function(a) {
        background_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  background_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', background_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('background_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('background_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('background_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      background_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		background_color_pickColor( $('#<?php echo $this->get_field_id('background_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('background_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $panel_border_color = esc_attr( $instance['panel_border_color'] );
?>
    <div class="pde-form-field pde-form-text panel_border_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('panel_border_color'); ?>">
          <span><?php esc_html_e( __('Panel Border Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $panel_border_color; ?>" name="<?php echo $this->get_field_name('panel_border_color'); ?>" id="<?php echo $this->get_field_id('panel_border_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('panel_border_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('panel_border_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('panel_border_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('panel_border_color'); ?>">
          <span><?php _e( 'Color used for separating panels.' ); ?></span>
        </label>
      </div>
    </div> <!-- panel_border_color -->
<script type="text/javascript">
(function($){
  var panel_border_color_farbtastic = undefined;
	var panel_border_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('panel_border_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('panel_border_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('panel_border_color'); ?>-button, #<?php echo $this->get_field_id('panel_border_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( panel_border_color_farbtastic == undefined ) {
      panel_border_color_pickColor = function(a) {
        panel_border_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  panel_border_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', panel_border_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('panel_border_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('panel_border_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('panel_border_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      panel_border_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		panel_border_color_pickColor( $('#<?php echo $this->get_field_id('panel_border_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('panel_border_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Heading' ); ?></h3>      </div>
<?php 
    $h1_color = esc_attr( $instance['h1_color'] );
?>
    <div class="pde-form-field pde-form-text h1_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h1_color'); ?>">
          <span><?php esc_html_e( __('H1 Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $h1_color; ?>" name="<?php echo $this->get_field_name('h1_color'); ?>" id="<?php echo $this->get_field_id('h1_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('h1_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('h1_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('h1_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h1_color'); ?>">
          <span><?php _e( 'Color used for H1 tag.' ); ?></span>
        </label>
      </div>
    </div> <!-- h1_color -->
<script type="text/javascript">
(function($){
  var h1_color_farbtastic = undefined;
	var h1_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('h1_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('h1_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('h1_color'); ?>-button, #<?php echo $this->get_field_id('h1_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( h1_color_farbtastic == undefined ) {
      h1_color_pickColor = function(a) {
        h1_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  h1_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', h1_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('h1_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('h1_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('h1_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      h1_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		h1_color_pickColor( $('#<?php echo $this->get_field_id('h1_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('h1_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $h2_color = esc_attr( $instance['h2_color'] );
?>
    <div class="pde-form-field pde-form-text h2_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h2_color'); ?>">
          <span><?php esc_html_e( __('H2 Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $h2_color; ?>" name="<?php echo $this->get_field_name('h2_color'); ?>" id="<?php echo $this->get_field_id('h2_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('h2_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('h2_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('h2_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h2_color'); ?>">
          <span><?php _e( 'Color used for H2 tag.' ); ?></span>
        </label>
      </div>
    </div> <!-- h2_color -->
<script type="text/javascript">
(function($){
  var h2_color_farbtastic = undefined;
	var h2_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('h2_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('h2_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('h2_color'); ?>-button, #<?php echo $this->get_field_id('h2_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( h2_color_farbtastic == undefined ) {
      h2_color_pickColor = function(a) {
        h2_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  h2_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', h2_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('h2_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('h2_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('h2_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      h2_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		h2_color_pickColor( $('#<?php echo $this->get_field_id('h2_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('h2_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Links' ); ?></h3>      </div>
<?php 
    $link_color = esc_attr( $instance['link_color'] );
?>
    <div class="pde-form-field pde-form-text link_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('link_color'); ?>">
          <span><?php esc_html_e( __('Link Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $link_color; ?>" name="<?php echo $this->get_field_name('link_color'); ?>" id="<?php echo $this->get_field_id('link_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('link_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('link_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('link_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('link_color'); ?>">
          <span><?php _e( 'Color used for links.' ); ?></span>
        </label>
      </div>
    </div> <!-- link_color -->
<script type="text/javascript">
(function($){
  var link_color_farbtastic = undefined;
	var link_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('link_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('link_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('link_color'); ?>-button, #<?php echo $this->get_field_id('link_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( link_color_farbtastic == undefined ) {
      link_color_pickColor = function(a) {
        link_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  link_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', link_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('link_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('link_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('link_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      link_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		link_color_pickColor( $('#<?php echo $this->get_field_id('link_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('link_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $link_hover_color = esc_attr( $instance['link_hover_color'] );
?>
    <div class="pde-form-field pde-form-text link_hover_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('link_hover_color'); ?>">
          <span><?php esc_html_e( __('Link Hover Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $link_hover_color; ?>" name="<?php echo $this->get_field_name('link_hover_color'); ?>" id="<?php echo $this->get_field_id('link_hover_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('link_hover_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('link_hover_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('link_hover_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('link_hover_color'); ?>">
          <span><?php _e( 'Color used for links when hovered upon.' ); ?></span>
        </label>
      </div>
    </div> <!-- link_hover_color -->
<script type="text/javascript">
(function($){
  var link_hover_color_farbtastic = undefined;
	var link_hover_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('link_hover_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('link_hover_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('link_hover_color'); ?>-button, #<?php echo $this->get_field_id('link_hover_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( link_hover_color_farbtastic == undefined ) {
      link_hover_color_pickColor = function(a) {
        link_hover_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  link_hover_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', link_hover_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('link_hover_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('link_hover_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('link_hover_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      link_hover_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		link_hover_color_pickColor( $('#<?php echo $this->get_field_id('link_hover_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('link_hover_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Input Fields' ); ?></h3>      </div>
<?php 
    $field_color = esc_attr( $instance['field_color'] );
?>
    <div class="pde-form-field pde-form-text field_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('field_color'); ?>">
          <span><?php esc_html_e( __('Field Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $field_color; ?>" name="<?php echo $this->get_field_name('field_color'); ?>" id="<?php echo $this->get_field_id('field_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('field_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('field_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('field_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('field_color'); ?>">
          <span><?php _e( 'Color used for input fields (not used?)' ); ?></span>
        </label>
      </div>
    </div> <!-- field_color -->
<script type="text/javascript">
(function($){
  var field_color_farbtastic = undefined;
	var field_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('field_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('field_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('field_color'); ?>-button, #<?php echo $this->get_field_id('field_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( field_color_farbtastic == undefined ) {
      field_color_pickColor = function(a) {
        field_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  field_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', field_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('field_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('field_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('field_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      field_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		field_color_pickColor( $('#<?php echo $this->get_field_id('field_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('field_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $field_bg_color = esc_attr( $instance['field_bg_color'] );
?>
    <div class="pde-form-field pde-form-text field_bg_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('field_bg_color'); ?>">
          <span><?php esc_html_e( __('Field Background Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $field_bg_color; ?>" name="<?php echo $this->get_field_name('field_bg_color'); ?>" id="<?php echo $this->get_field_id('field_bg_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('field_bg_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('field_bg_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('field_bg_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('field_bg_color'); ?>">
          <span><?php _e( 'Background color for the fields.' ); ?></span>
        </label>
      </div>
    </div> <!-- field_bg_color -->
<script type="text/javascript">
(function($){
  var field_bg_color_farbtastic = undefined;
	var field_bg_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('field_bg_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('field_bg_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('field_bg_color'); ?>-button, #<?php echo $this->get_field_id('field_bg_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( field_bg_color_farbtastic == undefined ) {
      field_bg_color_pickColor = function(a) {
        field_bg_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  field_bg_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', field_bg_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('field_bg_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('field_bg_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('field_bg_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      field_bg_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		field_bg_color_pickColor( $('#<?php echo $this->get_field_id('field_bg_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('field_bg_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $field_bg_focus_color = esc_attr( $instance['field_bg_focus_color'] );
?>
    <div class="pde-form-field pde-form-text field_bg_focus_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('field_bg_focus_color'); ?>">
          <span><?php esc_html_e( __('Field Background Focus Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $field_bg_focus_color; ?>" name="<?php echo $this->get_field_name('field_bg_focus_color'); ?>" id="<?php echo $this->get_field_id('field_bg_focus_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('field_bg_focus_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('field_bg_focus_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('field_bg_focus_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('field_bg_focus_color'); ?>">
          <span><?php _e( 'Color used field background when focused.' ); ?></span>
        </label>
      </div>
    </div> <!-- field_bg_focus_color -->
<script type="text/javascript">
(function($){
  var field_bg_focus_color_farbtastic = undefined;
	var field_bg_focus_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('field_bg_focus_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('field_bg_focus_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('field_bg_focus_color'); ?>-button, #<?php echo $this->get_field_id('field_bg_focus_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( field_bg_focus_color_farbtastic == undefined ) {
      field_bg_focus_color_pickColor = function(a) {
        field_bg_focus_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  field_bg_focus_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', field_bg_focus_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('field_bg_focus_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('field_bg_focus_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('field_bg_focus_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      field_bg_focus_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		field_bg_focus_color_pickColor( $('#<?php echo $this->get_field_id('field_bg_focus_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('field_bg_focus_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $field_border_color = esc_attr( $instance['field_border_color'] );
?>
    <div class="pde-form-field pde-form-text field_border_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('field_border_color'); ?>">
          <span><?php esc_html_e( __('Field Border Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $field_border_color; ?>" name="<?php echo $this->get_field_name('field_border_color'); ?>" id="<?php echo $this->get_field_id('field_border_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('field_border_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('field_border_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('field_border_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('field_border_color'); ?>">
          <span><?php _e( 'Color used for drawing field borders.' ); ?></span>
        </label>
      </div>
    </div> <!-- field_border_color -->
<script type="text/javascript">
(function($){
  var field_border_color_farbtastic = undefined;
	var field_border_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('field_border_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('field_border_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('field_border_color'); ?>-button, #<?php echo $this->get_field_id('field_border_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( field_border_color_farbtastic == undefined ) {
      field_border_color_pickColor = function(a) {
        field_border_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  field_border_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', field_border_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('field_border_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('field_border_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('field_border_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      field_border_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		field_border_color_pickColor( $('#<?php echo $this->get_field_id('field_border_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('field_border_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Login Button' ); ?></h3>      </div>
<?php 
    $login_color = esc_attr( $instance['login_color'] );
?>
    <div class="pde-form-field pde-form-text login_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('login_color'); ?>">
          <span><?php esc_html_e( __('Login Text Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $login_color; ?>" name="<?php echo $this->get_field_name('login_color'); ?>" id="<?php echo $this->get_field_id('login_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('login_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('login_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('login_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('login_color'); ?>">
          <span><?php _e( 'Color of text on login button.' ); ?></span>
        </label>
      </div>
    </div> <!-- login_color -->
<script type="text/javascript">
(function($){
  var login_color_farbtastic = undefined;
	var login_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('login_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('login_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('login_color'); ?>-button, #<?php echo $this->get_field_id('login_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( login_color_farbtastic == undefined ) {
      login_color_pickColor = function(a) {
        login_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  login_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', login_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('login_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('login_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('login_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      login_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		login_color_pickColor( $('#<?php echo $this->get_field_id('login_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('login_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $login_hover_color = esc_attr( $instance['login_hover_color'] );
?>
    <div class="pde-form-field pde-form-text login_hover_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('login_hover_color'); ?>">
          <span><?php esc_html_e( __('Login Text Hover Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $login_hover_color; ?>" name="<?php echo $this->get_field_name('login_hover_color'); ?>" id="<?php echo $this->get_field_id('login_hover_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('login_hover_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('login_hover_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('login_hover_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('login_hover_color'); ?>">
          <span><?php _e( 'Text color on Login button when hovered upon' ); ?></span>
        </label>
      </div>
    </div> <!-- login_hover_color -->
<script type="text/javascript">
(function($){
  var login_hover_color_farbtastic = undefined;
	var login_hover_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('login_hover_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('login_hover_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('login_hover_color'); ?>-button, #<?php echo $this->get_field_id('login_hover_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( login_hover_color_farbtastic == undefined ) {
      login_hover_color_pickColor = function(a) {
        login_hover_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  login_hover_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', login_hover_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('login_hover_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('login_hover_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('login_hover_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      login_hover_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		login_hover_color_pickColor( $('#<?php echo $this->get_field_id('login_hover_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('login_hover_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $login_bg_color = esc_attr( $instance['login_bg_color'] );
?>
    <div class="pde-form-field pde-form-text login_bg_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('login_bg_color'); ?>">
          <span><?php esc_html_e( __('Login Button Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $login_bg_color; ?>" name="<?php echo $this->get_field_name('login_bg_color'); ?>" id="<?php echo $this->get_field_id('login_bg_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('login_bg_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('login_bg_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('login_bg_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('login_bg_color'); ?>">
          <span><?php _e( 'Color of the login button.' ); ?></span>
        </label>
      </div>
    </div> <!-- login_bg_color -->
<script type="text/javascript">
(function($){
  var login_bg_color_farbtastic = undefined;
	var login_bg_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('login_bg_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('login_bg_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('login_bg_color'); ?>-button, #<?php echo $this->get_field_id('login_bg_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( login_bg_color_farbtastic == undefined ) {
      login_bg_color_pickColor = function(a) {
        login_bg_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  login_bg_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', login_bg_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('login_bg_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('login_bg_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('login_bg_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      login_bg_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		login_bg_color_pickColor( $('#<?php echo $this->get_field_id('login_bg_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('login_bg_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $login_border_color = esc_attr( $instance['login_border_color'] );
?>
    <div class="pde-form-field pde-form-text login_border_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('login_border_color'); ?>">
          <span><?php esc_html_e( __('Login Border Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $login_border_color; ?>" name="<?php echo $this->get_field_name('login_border_color'); ?>" id="<?php echo $this->get_field_id('login_border_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('login_border_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('login_border_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('login_border_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('login_border_color'); ?>">
          <span><?php _e( 'Color of login button border.' ); ?></span>
        </label>
      </div>
    </div> <!-- login_border_color -->
<script type="text/javascript">
(function($){
  var login_border_color_farbtastic = undefined;
	var login_border_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('login_border_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('login_border_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('login_border_color'); ?>-button, #<?php echo $this->get_field_id('login_border_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( login_border_color_farbtastic == undefined ) {
      login_border_color_pickColor = function(a) {
        login_border_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  login_border_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', login_border_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('login_border_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('login_border_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('login_border_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      login_border_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		login_border_color_pickColor( $('#<?php echo $this->get_field_id('login_border_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('login_border_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Register Button' ); ?></h3>      </div>
<?php 
    $register_color = esc_attr( $instance['register_color'] );
?>
    <div class="pde-form-field pde-form-text register_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('register_color'); ?>">
          <span><?php esc_html_e( __('Register Text Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $register_color; ?>" name="<?php echo $this->get_field_name('register_color'); ?>" id="<?php echo $this->get_field_id('register_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('register_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('register_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('register_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('register_color'); ?>">
          <span><?php _e( 'Color of text on register button.' ); ?></span>
        </label>
      </div>
    </div> <!-- register_color -->
<script type="text/javascript">
(function($){
  var register_color_farbtastic = undefined;
	var register_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('register_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('register_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('register_color'); ?>-button, #<?php echo $this->get_field_id('register_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( register_color_farbtastic == undefined ) {
      register_color_pickColor = function(a) {
        register_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  register_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', register_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('register_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('register_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('register_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      register_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		register_color_pickColor( $('#<?php echo $this->get_field_id('register_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('register_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $register_hover_color = esc_attr( $instance['register_hover_color'] );
?>
    <div class="pde-form-field pde-form-text register_hover_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('register_hover_color'); ?>">
          <span><?php esc_html_e( __('Register Text Hover Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $register_hover_color; ?>" name="<?php echo $this->get_field_name('register_hover_color'); ?>" id="<?php echo $this->get_field_id('register_hover_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('register_hover_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('register_hover_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('register_hover_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('register_hover_color'); ?>">
          <span><?php _e( 'Color of text on register button when hovered upon.' ); ?></span>
        </label>
      </div>
    </div> <!-- register_hover_color -->
<script type="text/javascript">
(function($){
  var register_hover_color_farbtastic = undefined;
	var register_hover_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('register_hover_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('register_hover_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('register_hover_color'); ?>-button, #<?php echo $this->get_field_id('register_hover_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( register_hover_color_farbtastic == undefined ) {
      register_hover_color_pickColor = function(a) {
        register_hover_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  register_hover_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', register_hover_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('register_hover_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('register_hover_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('register_hover_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      register_hover_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		register_hover_color_pickColor( $('#<?php echo $this->get_field_id('register_hover_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('register_hover_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $register_bg_color = esc_attr( $instance['register_bg_color'] );
?>
    <div class="pde-form-field pde-form-text register_bg_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('register_bg_color'); ?>">
          <span><?php esc_html_e( __('Register Button Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $register_bg_color; ?>" name="<?php echo $this->get_field_name('register_bg_color'); ?>" id="<?php echo $this->get_field_id('register_bg_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('register_bg_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('register_bg_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('register_bg_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('register_bg_color'); ?>">
          <span><?php _e( 'Color of the register button.' ); ?></span>
        </label>
      </div>
    </div> <!-- register_bg_color -->
<script type="text/javascript">
(function($){
  var register_bg_color_farbtastic = undefined;
	var register_bg_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('register_bg_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('register_bg_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('register_bg_color'); ?>-button, #<?php echo $this->get_field_id('register_bg_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( register_bg_color_farbtastic == undefined ) {
      register_bg_color_pickColor = function(a) {
        register_bg_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  register_bg_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', register_bg_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('register_bg_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('register_bg_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('register_bg_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      register_bg_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		register_bg_color_pickColor( $('#<?php echo $this->get_field_id('register_bg_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('register_bg_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $register_border_color = esc_attr( $instance['register_border_color'] );
?>
    <div class="pde-form-field pde-form-text register_border_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('register_border_color'); ?>">
          <span><?php esc_html_e( __('Register Border Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $register_border_color; ?>" name="<?php echo $this->get_field_name('register_border_color'); ?>" id="<?php echo $this->get_field_id('register_border_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('register_border_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('register_border_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('register_border_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('register_border_color'); ?>">
          <span><?php _e( 'Color of register button border.' ); ?></span>
        </label>
      </div>
    </div> <!-- register_border_color -->
<script type="text/javascript">
(function($){
  var register_border_color_farbtastic = undefined;
	var register_border_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('register_border_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('register_border_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('register_border_color'); ?>-button, #<?php echo $this->get_field_id('register_border_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( register_border_color_farbtastic == undefined ) {
      register_border_color_pickColor = function(a) {
        register_border_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  register_border_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', register_border_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('register_border_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('register_border_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('register_border_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      register_border_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		register_border_color_pickColor( $('#<?php echo $this->get_field_id('register_border_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('register_border_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Lost Password Button' ); ?></h3>      </div>
<?php 
    $lostpwd_color = esc_attr( $instance['lostpwd_color'] );
?>
    <div class="pde-form-field pde-form-text lostpwd_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('lostpwd_color'); ?>">
          <span><?php esc_html_e( __('Lost Password Text Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $lostpwd_color; ?>" name="<?php echo $this->get_field_name('lostpwd_color'); ?>" id="<?php echo $this->get_field_id('lostpwd_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('lostpwd_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('lostpwd_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('lostpwd_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('lostpwd_color'); ?>">
          <span><?php _e( 'Color of text on lost password button.' ); ?></span>
        </label>
      </div>
    </div> <!-- lostpwd_color -->
<script type="text/javascript">
(function($){
  var lostpwd_color_farbtastic = undefined;
	var lostpwd_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('lostpwd_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('lostpwd_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('lostpwd_color'); ?>-button, #<?php echo $this->get_field_id('lostpwd_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( lostpwd_color_farbtastic == undefined ) {
      lostpwd_color_pickColor = function(a) {
        lostpwd_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  lostpwd_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', lostpwd_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('lostpwd_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('lostpwd_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('lostpwd_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      lostpwd_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		lostpwd_color_pickColor( $('#<?php echo $this->get_field_id('lostpwd_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('lostpwd_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $lostpwd_hover_color = esc_attr( $instance['lostpwd_hover_color'] );
?>
    <div class="pde-form-field pde-form-text lostpwd_hover_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('lostpwd_hover_color'); ?>">
          <span><?php esc_html_e( __('Lost Password Text Hover Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $lostpwd_hover_color; ?>" name="<?php echo $this->get_field_name('lostpwd_hover_color'); ?>" id="<?php echo $this->get_field_id('lostpwd_hover_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('lostpwd_hover_color'); ?>">
          <span><?php _e( 'Color of text on lostpassword button when hovered upon.' ); ?></span>
        </label>
      </div>
    </div> <!-- lostpwd_hover_color -->
<script type="text/javascript">
(function($){
  var lostpwd_hover_color_farbtastic = undefined;
	var lostpwd_hover_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-button, #<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( lostpwd_hover_color_farbtastic == undefined ) {
      lostpwd_hover_color_pickColor = function(a) {
        lostpwd_hover_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  lostpwd_hover_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', lostpwd_hover_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      lostpwd_hover_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		lostpwd_hover_color_pickColor( $('#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('lostpwd_hover_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $lostpwd_bg_color = esc_attr( $instance['lostpwd_bg_color'] );
?>
    <div class="pde-form-field pde-form-text lostpwd_bg_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('lostpwd_bg_color'); ?>">
          <span><?php esc_html_e( __('Lost Password Button Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $lostpwd_bg_color; ?>" name="<?php echo $this->get_field_name('lostpwd_bg_color'); ?>" id="<?php echo $this->get_field_id('lostpwd_bg_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('lostpwd_bg_color'); ?>">
          <span><?php _e( 'Color of lost password button.' ); ?></span>
        </label>
      </div>
    </div> <!-- lostpwd_bg_color -->
<script type="text/javascript">
(function($){
  var lostpwd_bg_color_farbtastic = undefined;
	var lostpwd_bg_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-button, #<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( lostpwd_bg_color_farbtastic == undefined ) {
      lostpwd_bg_color_pickColor = function(a) {
        lostpwd_bg_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  lostpwd_bg_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', lostpwd_bg_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      lostpwd_bg_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		lostpwd_bg_color_pickColor( $('#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('lostpwd_bg_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $lostpwd_border_color = esc_attr( $instance['lostpwd_border_color'] );
?>
    <div class="pde-form-field pde-form-text lostpwd_border_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('lostpwd_border_color'); ?>">
          <span><?php esc_html_e( __('Lost Password Button Border') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $lostpwd_border_color; ?>" name="<?php echo $this->get_field_name('lostpwd_border_color'); ?>" id="<?php echo $this->get_field_id('lostpwd_border_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('lostpwd_border_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('lostpwd_border_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('lostpwd_border_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('lostpwd_border_color'); ?>">
          <span><?php _e( 'Border color for lost password button.' ); ?></span>
        </label>
      </div>
    </div> <!-- lostpwd_border_color -->
<script type="text/javascript">
(function($){
  var lostpwd_border_color_farbtastic = undefined;
	var lostpwd_border_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('lostpwd_border_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('lostpwd_border_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('lostpwd_border_color'); ?>-button, #<?php echo $this->get_field_id('lostpwd_border_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( lostpwd_border_color_farbtastic == undefined ) {
      lostpwd_border_color_pickColor = function(a) {
        lostpwd_border_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  lostpwd_border_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', lostpwd_border_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('lostpwd_border_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('lostpwd_border_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('lostpwd_border_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      lostpwd_border_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		lostpwd_border_color_pickColor( $('#<?php echo $this->get_field_id('lostpwd_border_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('lostpwd_border_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Colors - Tab' ); ?></h3>      </div>
<?php 
    $tab_link_color = esc_attr( $instance['tab_link_color'] );
?>
    <div class="pde-form-field pde-form-text tab_link_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_link_color'); ?>">
          <span><?php esc_html_e( __('Tab Link Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_link_color; ?>" name="<?php echo $this->get_field_name('tab_link_color'); ?>" id="<?php echo $this->get_field_id('tab_link_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('tab_link_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('tab_link_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('tab_link_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_link_color'); ?>">
          <span><?php _e( 'Color used for links on the tab.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_link_color -->
<script type="text/javascript">
(function($){
  var tab_link_color_farbtastic = undefined;
	var tab_link_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('tab_link_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('tab_link_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('tab_link_color'); ?>-button, #<?php echo $this->get_field_id('tab_link_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( tab_link_color_farbtastic == undefined ) {
      tab_link_color_pickColor = function(a) {
        tab_link_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  tab_link_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', tab_link_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('tab_link_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('tab_link_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('tab_link_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      tab_link_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		tab_link_color_pickColor( $('#<?php echo $this->get_field_id('tab_link_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('tab_link_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $tab_link_hover_color = esc_attr( $instance['tab_link_hover_color'] );
?>
    <div class="pde-form-field pde-form-text tab_link_hover_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_link_hover_color'); ?>">
          <span><?php esc_html_e( __('Tab Link Hover Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_link_hover_color; ?>" name="<?php echo $this->get_field_name('tab_link_hover_color'); ?>" id="<?php echo $this->get_field_id('tab_link_hover_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('tab_link_hover_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('tab_link_hover_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('tab_link_hover_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_link_hover_color'); ?>">
          <span><?php _e( 'Color used for links on tab when hovered.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_link_hover_color -->
<script type="text/javascript">
(function($){
  var tab_link_hover_color_farbtastic = undefined;
	var tab_link_hover_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('tab_link_hover_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('tab_link_hover_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('tab_link_hover_color'); ?>-button, #<?php echo $this->get_field_id('tab_link_hover_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( tab_link_hover_color_farbtastic == undefined ) {
      tab_link_hover_color_pickColor = function(a) {
        tab_link_hover_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  tab_link_hover_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', tab_link_hover_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('tab_link_hover_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('tab_link_hover_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('tab_link_hover_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      tab_link_hover_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		tab_link_hover_color_pickColor( $('#<?php echo $this->get_field_id('tab_link_hover_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('tab_link_hover_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <?php if( !extension_loaded('gd') ) : ?>
<p>
You can change the tab background and border colors if the <b>GD</b> extension is installed.
</p>
<?php else: ?> 
      </div>

<?php 
?>
    <div class="pde-form-field pde-form-checkbox tab_images">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('tab_images'); ?>">
            <span><?php esc_html_e( __('Tab Images') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('tab_images'); ?>"
            value="Tab Images"
            name="cb-<?php echo $this->get_field_name('tab_images'); ?>"
            type="checkbox"<?php checked(isset($instance['tab_images']) ? $instance['tab_images'] : '', 'Tab Images'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('tab_images'); ?>"
            value="Tab Images"
            name="<?php echo $this->get_field_name('tab_images'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('tab_images'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('tab_images'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('tab_images'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('tab_images'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Use default tab images') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('tab_images'); ?>">
            <span><?php _e( 'The sliding panel uses the default tab images - hand drawn for the original sliding panel. These look better - but only black and white.' ); ?></span>
          </label>
        </div>
    </div> <!-- tab_images -->

<?php 
?>
    <div class="display_when_unselected group-for-checkbox group-tab_images" id="group-<?php echo $this->get_field_id("tab_images") ?>">
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id("wp-pde-form"); ?>').on('change', '.wp-pde-checkbox', function (e) {
    item = $(e.target);
    group = '#group-' + $(item).attr('id');
    if($(group).size() > 0 && !$(group).hasClass('display_always')) {
      if( ( $(item).attr('checked') != 'checked' && $(group).hasClass('display_when_unselected') )
            || ( $(item).attr('checked') == 'checked' && $(group).hasClass('display_when_selected') ) )
        d = 'block' ;
      else
        d = 'none';
      $(group).css('display', d);
		};
  });
})(jQuery);
</script>
<script type="text/javascript">
(function($) {
  $(document).ready(function(e) {
    $('.wp-pde-checkbox').trigger('change');
  });
})(jQuery);
</script>
<?php
    $tab_background_color = esc_attr( $instance['tab_background_color'] );
?>
    <div class="pde-form-field pde-form-text tab_background_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_background_color'); ?>">
          <span><?php esc_html_e( __('Tab Background Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_background_color; ?>" name="<?php echo $this->get_field_name('tab_background_color'); ?>" id="<?php echo $this->get_field_id('tab_background_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('tab_background_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('tab_background_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('tab_background_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
    </div> <!-- tab_background_color -->
<script type="text/javascript">
(function($){
  var tab_background_color_farbtastic = undefined;
	var tab_background_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('tab_background_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('tab_background_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('tab_background_color'); ?>-button, #<?php echo $this->get_field_id('tab_background_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( tab_background_color_farbtastic == undefined ) {
      tab_background_color_pickColor = function(a) {
        tab_background_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  tab_background_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', tab_background_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('tab_background_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('tab_background_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('tab_background_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      tab_background_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		tab_background_color_pickColor( $('#<?php echo $this->get_field_id('tab_background_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('tab_background_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
    $tab_border_color = esc_attr( $instance['tab_border_color'] );
?>
    <div class="pde-form-field pde-form-text tab_border_color">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_border_color'); ?>">
          <span><?php esc_html_e( __('Tab Border Color') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_border_color; ?>" name="<?php echo $this->get_field_name('tab_border_color'); ?>" id="<?php echo $this->get_field_id('tab_border_color'); ?>" class="pde-plugin-pickcolor-text"/>
        <a style="-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #dfdfdf;margin: 0 7px 0 3px;padding: 4px 14px;display: inline;" href="#" class="pde-plugin-pickcolor-example hide-if-no-js" id="<?php echo $this->get_field_id('tab_border_color'); ?>-example"></a>
        <input id="<?php echo $this->get_field_id('tab_border_color'); ?>-button" type="button" class="pde-plugin-pickcolor button hide-if-no-js" value="Select" />
        <div id="<?php echo $this->get_field_id('tab_border_color'); ?>-colorPickerDiv" class="pde-plugin-pickcolor-popup"></div>
      </div>
    </div> <!-- tab_border_color -->
<script type="text/javascript">
(function($){
  var tab_border_color_farbtastic = undefined;
	var tab_border_color_pickColor = function(a) {
		$('#<?php echo $this->get_field_id('tab_border_color'); ?>').val(a);
		$('#<?php echo $this->get_field_id('tab_border_color'); ?>-example').css('background-color', a);
	};

  $('#wpbody-content').on( 'click', "#<?php echo $this->get_field_id('tab_border_color'); ?>-button, #<?php echo $this->get_field_id('tab_border_color'); ?>-example", function(e) {
    e.preventDefault();
    id = $(e.target).attr('id').replace(/-button$|-example$/, '')
		if ( tab_border_color_farbtastic == undefined ) {
      tab_border_color_pickColor = function(a) {
        tab_border_color_farbtastic.setColor(a);
        $('#' + id).val(a);
        $('#' + id + '-example').css('background-color', a);
      };
		  tab_border_color_farbtastic = $.farbtastic('#' + id + '-colorPickerDiv', tab_border_color_pickColor);
      $(document).mousedown( function() {
        $('#' + id + '-colorPickerDiv').hide();
      });
    }

    $('#' + id + '-colorPickerDiv').show();
  });

  $('#wpbody-content').on( 'keyup', '#<?php echo $this->get_field_id('tab_border_color'); ?>',  function() {
    var a = $('#<?php echo $this->get_field_id('tab_border_color'); ?>').val(),
      b = a;

    a = a.replace(/[^a-fA-F0-9]/, '');
    if ( '#' + a !== b )
      $('#<?php echo $this->get_field_id('tab_border_color'); ?>').val(a);
    if ( a.length === 3 || a.length === 6 )
      tab_border_color_pickColor( '#' + a );
  });

	$(document).ready( function() {

		tab_border_color_pickColor( $('#<?php echo $this->get_field_id('tab_border_color'); ?>').val() );

		$(document).mousedown( function() {
			$('#<?php echo $this->get_field_id('tab_border_color'); ?>-colorPickerDiv').hide();
		});

	});
})(jQuery);
</script>
<?php 
?>
   </div>
<?php
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <?php endif; ?> 
      </div>

<?php 
?>
   </div>
<?php
?>
   <div id='<?php echo $this->get_field_id( "BackgroundImages"); ?>'>
<?php
    $panel_background = $instance['panel_background'] ;
?>
    <div class="pde-form-field pde-form-images panel_background">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('panel_background'); ?>">
          <span><?php esc_html_e( __('Panel Background') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
          <div class="pde-form-images-text">
          <input id="<?php echo $this->get_field_id('panel_background'); ?>" name="<?php echo $this->get_field_name('panel_background'); ?>" type="text"
                      value="<?php echo esc_attr($panel_background); ?>" />
          </div>
          <?php if( !empty( $panel_background ) ) : ?>
            <div class="pde-form-images-img">
              <img src='<?php echo esc_attr($panel_background); ?>' />
            </div>
          <?php endif; ?>
          <div class="pde-form-images-buttons">
            <input id="<?php echo $this->get_field_id('panel_background'); ?>_remove_button" value="Remove" type="button" class="pde-form-image-upload-remove-button button-secondary"/>
            <input id="<?php echo $this->get_field_id('panel_background'); ?>_button" value="Upload" type="button" class="pde-form-image-upload-button button-secondary"/>
          </div>

        </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('panel_background'); ?>">
          <span><?php _e( 'The background image used for the full panel.' ); ?></span>
        </label>
      </div>
    </div> <!-- panel_background -->
<script type="text/javascript">
(function($) {
  $('#wpbody-content').off( 'click', '.pde-form-image-upload-button' );
  $('#wpbody-content').on( 'click', '.pde-form-image-upload-button', function(e) {
    id_text = $(e.target).attr('id').replace(/_button$/, '');
    window.send_to_editor = function(html) {
      imgurl = jQuery('img',html).attr('src');
      if( imgurl == undefined ) {
        imgurl = jQuery(html).attr('href');
      }
      jQuery('#' + id_text).val(imgurl);
      tb_remove();
      jQuery('#' + id_text).change();
    }

    <?php $url = add_query_arg( array( 'post_id' => '0', 'type' => 'image', 'tab' => 'library', 'TB_iframe' => 'true'),
                    admin_url('media-upload.php') ); ?>
    formfield = jQuery('#' + id_text).attr('name');
    tb_show('', '<?php echo $url; ?>');
    return false;
  });
  $('#wpbody-content').off( 'click', '.pde-form-image-upload-remove-button' );
  $('#wpbody-content').on( 'click', '.pde-form-image-upload-remove-button', function(e) {
    id_text = $(e.target).attr('id').replace(/_remove_button$/, '');
    jQuery('#' + id_text).val('');
  });
})(jQuery);
</script>

<?php 
?>
    <div class="pde-form-field pde-form-checkbox panel_background_repeat">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('panel_background_repeat'); ?>">
            <span><?php esc_html_e( __('Repeat') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('panel_background_repeat'); ?>"
            value="Repeat"
            name="cb-<?php echo $this->get_field_name('panel_background_repeat'); ?>"
            type="checkbox"<?php checked(isset($instance['panel_background_repeat']) ? $instance['panel_background_repeat'] : '', 'Repeat'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('panel_background_repeat'); ?>"
            value="Repeat"
            name="<?php echo $this->get_field_name('panel_background_repeat'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('panel_background_repeat'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('panel_background_repeat'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('panel_background_repeat'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('panel_background_repeat'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Tile the background') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('panel_background_repeat'); ?>">
            <span><?php _e( 'Select this to tile the panel background with the image.' ); ?></span>
          </label>
        </div>
    </div> <!-- panel_background_repeat -->

<?php 
    $content_background = $instance['content_background'] ;
?>
    <div class="pde-form-field pde-form-images content_background">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('content_background'); ?>">
          <span><?php esc_html_e( __('Content Background') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
          <div class="pde-form-images-text">
          <input id="<?php echo $this->get_field_id('content_background'); ?>" name="<?php echo $this->get_field_name('content_background'); ?>" type="text"
                      value="<?php echo esc_attr($content_background); ?>" />
          </div>
          <?php if( !empty( $content_background ) ) : ?>
            <div class="pde-form-images-img">
              <img src='<?php echo esc_attr($content_background); ?>' />
            </div>
          <?php endif; ?>
          <div class="pde-form-images-buttons">
            <input id="<?php echo $this->get_field_id('content_background'); ?>_remove_button" value="Remove" type="button" class="pde-form-image-upload-remove-button button-secondary"/>
            <input id="<?php echo $this->get_field_id('content_background'); ?>_button" value="Upload" type="button" class="pde-form-image-upload-button button-secondary"/>
          </div>

        </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('content_background'); ?>">
          <span><?php _e( 'The background image used for the content part. (Width: 960px)' ); ?></span>
        </label>
      </div>
    </div> <!-- content_background -->
<script type="text/javascript">
(function($) {
  $('#wpbody-content').off( 'click', '.pde-form-image-upload-button' );
  $('#wpbody-content').on( 'click', '.pde-form-image-upload-button', function(e) {
    id_text = $(e.target).attr('id').replace(/_button$/, '');
    window.send_to_editor = function(html) {
      imgurl = jQuery('img',html).attr('src');
      if( imgurl == undefined ) {
        imgurl = jQuery(html).attr('href');
      }
      jQuery('#' + id_text).val(imgurl);
      tb_remove();
      jQuery('#' + id_text).change();
    }

    <?php $url = add_query_arg( array( 'post_id' => '0', 'type' => 'image', 'tab' => 'library', 'TB_iframe' => 'true'),
                    admin_url('media-upload.php') ); ?>
    formfield = jQuery('#' + id_text).attr('name');
    tb_show('', '<?php echo $url; ?>');
    return false;
  });
  $('#wpbody-content').off( 'click', '.pde-form-image-upload-remove-button' );
  $('#wpbody-content').on( 'click', '.pde-form-image-upload-remove-button', function(e) {
    id_text = $(e.target).attr('id').replace(/_remove_button$/, '');
    jQuery('#' + id_text).val('');
  });
})(jQuery);
</script>

<?php 
?>
    <div class="pde-form-field pde-form-checkbox content_background_repeat">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('content_background_repeat'); ?>">
            <span><?php esc_html_e( __('Repeat') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('content_background_repeat'); ?>"
            value="Repeat"
            name="cb-<?php echo $this->get_field_name('content_background_repeat'); ?>"
            type="checkbox"<?php checked(isset($instance['content_background_repeat']) ? $instance['content_background_repeat'] : '', 'Repeat'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('content_background_repeat'); ?>"
            value="Repeat"
            name="<?php echo $this->get_field_name('content_background_repeat'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('content_background_repeat'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('content_background_repeat'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('content_background_repeat'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('content_background_repeat'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Tile the background') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('content_background_repeat'); ?>">
            <span><?php _e( 'Select this to tile the content background with the image.' ); ?></span>
          </label>
        </div>
    </div> <!-- content_background_repeat -->

<?php 
?>
   </div>
<?php
?>
   <div id='<?php echo $this->get_field_id( "Fonts"); ?>'>
<?php
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Fonts - Sliding Panel' ); ?></h3>      </div>
<?php 
    $panel_font_family = esc_attr( $instance['panel_font_family'] );
?>
    <div class="pde-form-field pde-form-text panel_font_family">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('panel_font_family'); ?>">
          <span><?php esc_html_e( __('Font Family') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $panel_font_family; ?>" name="<?php echo $this->get_field_name('panel_font_family'); ?>" id="<?php echo $this->get_field_id('panel_font_family'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('panel_font_family'); ?>">
          <span><?php _e( 'Font family for regular text.' ); ?></span>
        </label>
      </div>
    </div> <!-- panel_font_family -->

<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Fonts - Heading' ); ?></h3>      </div>
<?php 
    $panel_font_size = esc_attr( $instance['panel_font_size'] );
?>
    <div class="pde-form-field pde-form-text panel_font_size">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('panel_font_size'); ?>">
          <span><?php esc_html_e( __('Font Size') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $panel_font_size; ?>" name="<?php echo $this->get_field_name('panel_font_size'); ?>" id="<?php echo $this->get_field_id('panel_font_size'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('panel_font_size'); ?>">
          <span><?php _e( 'Font size for regular text.' ); ?></span>
        </label>
      </div>
    </div> <!-- panel_font_size -->

<?php 
    $h1_font_family = esc_attr( $instance['h1_font_family'] );
?>
    <div class="pde-form-field pde-form-text h1_font_family">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h1_font_family'); ?>">
          <span><?php esc_html_e( __('H1 Font Family') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $h1_font_family; ?>" name="<?php echo $this->get_field_name('h1_font_family'); ?>" id="<?php echo $this->get_field_id('h1_font_family'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h1_font_family'); ?>">
          <span><?php _e( 'Font family for heading level 1.' ); ?></span>
        </label>
      </div>
    </div> <!-- h1_font_family -->

<?php 
    $h1_font_size = esc_attr( $instance['h1_font_size'] );
?>
    <div class="pde-form-field pde-form-text h1_font_size">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h1_font_size'); ?>">
          <span><?php esc_html_e( __('H1 Font Size') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $h1_font_size; ?>" name="<?php echo $this->get_field_name('h1_font_size'); ?>" id="<?php echo $this->get_field_id('h1_font_size'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h1_font_size'); ?>">
          <span><?php _e( 'Font size for heading level 1.' ); ?></span>
        </label>
      </div>
    </div> <!-- h1_font_size -->

<?php 
    $h1_font_weight = $instance['h1_font_weight'] ;
?>
    <div class="pde-form-field pde-form-dropdown h1_font_weight">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h1_font_weight'); ?>">
          <span><?php esc_html_e( __('H1 Font Weight') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('h1_font_weight'); ?>" id="<?php echo $this->get_field_id('h1_font_weight'); ?>">
            <option value="normal"<?php selected( $instance['h1_font_weight'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="bold"<?php selected( $instance['h1_font_weight'], 'bold' ); ?>><?php _e('bold'); ?></option>
              <option value="inherit"<?php selected( $instance['h1_font_weight'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
              <option value="100"<?php selected( $instance['h1_font_weight'], '100' ); ?>><?php _e('100'); ?></option>
              <option value="200"<?php selected( $instance['h1_font_weight'], '200' ); ?>><?php _e('200'); ?></option>
              <option value="300"<?php selected( $instance['h1_font_weight'], '300' ); ?>><?php _e('300'); ?></option>
              <option value="400"<?php selected( $instance['h1_font_weight'], '400' ); ?>><?php _e('400'); ?></option>
              <option value="500"<?php selected( $instance['h1_font_weight'], '500' ); ?>><?php _e('500'); ?></option>
              <option value="600"<?php selected( $instance['h1_font_weight'], '600' ); ?>><?php _e('600'); ?></option>
              <option value="700"<?php selected( $instance['h1_font_weight'], '700' ); ?>><?php _e('700'); ?></option>
              <option value="800"<?php selected( $instance['h1_font_weight'], '800' ); ?>><?php _e('800'); ?></option>
              <option value="900"<?php selected( $instance['h1_font_weight'], '900' ); ?>><?php _e('900'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h1_font_weight'); ?>">
          <span><?php _e( 'Font weight for heading level 1.' ); ?></span>
        </label>
      </div>
    </div> <!-- h1_font_weight -->
<?php 
    $h1_font_style = $instance['h1_font_style'] ;
?>
    <div class="pde-form-field pde-form-dropdown h1_font_style">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h1_font_style'); ?>">
          <span><?php esc_html_e( __('H1 Font Style') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('h1_font_style'); ?>" id="<?php echo $this->get_field_id('h1_font_style'); ?>">
            <option value="normal"<?php selected( $instance['h1_font_style'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="italic"<?php selected( $instance['h1_font_style'], 'italic' ); ?>><?php _e('italic'); ?></option>
              <option value="oblique"<?php selected( $instance['h1_font_style'], 'oblique' ); ?>><?php _e('oblique'); ?></option>
              <option value="inherit"<?php selected( $instance['h1_font_style'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h1_font_style'); ?>">
          <span><?php _e( 'Font style for heading level 1.' ); ?></span>
        </label>
      </div>
    </div> <!-- h1_font_style -->
<?php 
    $h2_font_family = esc_attr( $instance['h2_font_family'] );
?>
    <div class="pde-form-field pde-form-text h2_font_family">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h2_font_family'); ?>">
          <span><?php esc_html_e( __('H2 Font Family') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $h2_font_family; ?>" name="<?php echo $this->get_field_name('h2_font_family'); ?>" id="<?php echo $this->get_field_id('h2_font_family'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h2_font_family'); ?>">
          <span><?php _e( 'Font family for heading level 2.' ); ?></span>
        </label>
      </div>
    </div> <!-- h2_font_family -->

<?php 
    $h2_font_size = esc_attr( $instance['h2_font_size'] );
?>
    <div class="pde-form-field pde-form-text h2_font_size">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h2_font_size'); ?>">
          <span><?php esc_html_e( __('H2 Font Size') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $h2_font_size; ?>" name="<?php echo $this->get_field_name('h2_font_size'); ?>" id="<?php echo $this->get_field_id('h2_font_size'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h2_font_size'); ?>">
          <span><?php _e( 'Font size for heading level 2.' ); ?></span>
        </label>
      </div>
    </div> <!-- h2_font_size -->

<?php 
    $h2_font_weight = $instance['h2_font_weight'] ;
?>
    <div class="pde-form-field pde-form-dropdown h2_font_weight">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h2_font_weight'); ?>">
          <span><?php esc_html_e( __('H2 Font Weight') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('h2_font_weight'); ?>" id="<?php echo $this->get_field_id('h2_font_weight'); ?>">
            <option value="normal"<?php selected( $instance['h2_font_weight'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="bold"<?php selected( $instance['h2_font_weight'], 'bold' ); ?>><?php _e('bold'); ?></option>
              <option value="inherit"<?php selected( $instance['h2_font_weight'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
              <option value="100"<?php selected( $instance['h2_font_weight'], '100' ); ?>><?php _e('100'); ?></option>
              <option value="200"<?php selected( $instance['h2_font_weight'], '200' ); ?>><?php _e('200'); ?></option>
              <option value="300"<?php selected( $instance['h2_font_weight'], '300' ); ?>><?php _e('300'); ?></option>
              <option value="400"<?php selected( $instance['h2_font_weight'], '400' ); ?>><?php _e('400'); ?></option>
              <option value="500"<?php selected( $instance['h2_font_weight'], '500' ); ?>><?php _e('500'); ?></option>
              <option value="600"<?php selected( $instance['h2_font_weight'], '600' ); ?>><?php _e('600'); ?></option>
              <option value="700"<?php selected( $instance['h2_font_weight'], '700' ); ?>><?php _e('700'); ?></option>
              <option value="800"<?php selected( $instance['h2_font_weight'], '800' ); ?>><?php _e('800'); ?></option>
              <option value="900"<?php selected( $instance['h2_font_weight'], '900' ); ?>><?php _e('900'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h2_font_weight'); ?>">
          <span><?php _e( 'Font weight for heading level 2.' ); ?></span>
        </label>
      </div>
    </div> <!-- h2_font_weight -->
<?php 
    $h2_font_style = $instance['h2_font_style'] ;
?>
    <div class="pde-form-field pde-form-dropdown h2_font_style">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('h2_font_style'); ?>">
          <span><?php esc_html_e( __('H2 Font Style') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('h2_font_style'); ?>" id="<?php echo $this->get_field_id('h2_font_style'); ?>">
            <option value="normal"<?php selected( $instance['h2_font_style'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="italic"<?php selected( $instance['h2_font_style'], 'italic' ); ?>><?php _e('italic'); ?></option>
              <option value="oblique"<?php selected( $instance['h2_font_style'], 'oblique' ); ?>><?php _e('oblique'); ?></option>
              <option value="inherit"<?php selected( $instance['h2_font_style'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('h2_font_style'); ?>">
          <span><?php _e( 'Font style for heading level 2.' ); ?></span>
        </label>
      </div>
    </div> <!-- h2_font_style -->
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Fonts - Buttons' ); ?></h3>      </div>
<?php 
    $btn_font_family = esc_attr( $instance['btn_font_family'] );
?>
    <div class="pde-form-field pde-form-text btn_font_family">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('btn_font_family'); ?>">
          <span><?php esc_html_e( __('Button Font Family') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $btn_font_family; ?>" name="<?php echo $this->get_field_name('btn_font_family'); ?>" id="<?php echo $this->get_field_id('btn_font_family'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('btn_font_family'); ?>">
          <span><?php _e( 'Font family for buttons.' ); ?></span>
        </label>
      </div>
    </div> <!-- btn_font_family -->

<?php 
    $btn_font_size = esc_attr( $instance['btn_font_size'] );
?>
    <div class="pde-form-field pde-form-text btn_font_size">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('btn_font_size'); ?>">
          <span><?php esc_html_e( __('Button Font Size') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $btn_font_size; ?>" name="<?php echo $this->get_field_name('btn_font_size'); ?>" id="<?php echo $this->get_field_id('btn_font_size'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('btn_font_size'); ?>">
          <span><?php _e( 'Font size for buttons.' ); ?></span>
        </label>
      </div>
    </div> <!-- btn_font_size -->

<?php 
    $btn_font_weight = $instance['btn_font_weight'] ;
?>
    <div class="pde-form-field pde-form-dropdown btn_font_weight">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('btn_font_weight'); ?>">
          <span><?php esc_html_e( __('Button Font Weight') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('btn_font_weight'); ?>" id="<?php echo $this->get_field_id('btn_font_weight'); ?>">
            <option value="normal"<?php selected( $instance['btn_font_weight'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="bold"<?php selected( $instance['btn_font_weight'], 'bold' ); ?>><?php _e('bold'); ?></option>
              <option value="inherit"<?php selected( $instance['btn_font_weight'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
              <option value="100"<?php selected( $instance['btn_font_weight'], '100' ); ?>><?php _e('100'); ?></option>
              <option value="200"<?php selected( $instance['btn_font_weight'], '200' ); ?>><?php _e('200'); ?></option>
              <option value="300"<?php selected( $instance['btn_font_weight'], '300' ); ?>><?php _e('300'); ?></option>
              <option value="400"<?php selected( $instance['btn_font_weight'], '400' ); ?>><?php _e('400'); ?></option>
              <option value="500"<?php selected( $instance['btn_font_weight'], '500' ); ?>><?php _e('500'); ?></option>
              <option value="600"<?php selected( $instance['btn_font_weight'], '600' ); ?>><?php _e('600'); ?></option>
              <option value="700"<?php selected( $instance['btn_font_weight'], '700' ); ?>><?php _e('700'); ?></option>
              <option value="800"<?php selected( $instance['btn_font_weight'], '800' ); ?>><?php _e('800'); ?></option>
              <option value="900"<?php selected( $instance['btn_font_weight'], '900' ); ?>><?php _e('900'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('btn_font_weight'); ?>">
          <span><?php _e( 'Font weight for buttons.' ); ?></span>
        </label>
      </div>
    </div> <!-- btn_font_weight -->
<?php 
    $btn_font_style = $instance['btn_font_style'] ;
?>
    <div class="pde-form-field pde-form-dropdown btn_font_style">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('btn_font_style'); ?>">
          <span><?php esc_html_e( __('Button Font Style') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('btn_font_style'); ?>" id="<?php echo $this->get_field_id('btn_font_style'); ?>">
            <option value="normal"<?php selected( $instance['btn_font_style'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="italic"<?php selected( $instance['btn_font_style'], 'italic' ); ?>><?php _e('italic'); ?></option>
              <option value="oblique"<?php selected( $instance['btn_font_style'], 'oblique' ); ?>><?php _e('oblique'); ?></option>
              <option value="inherit"<?php selected( $instance['btn_font_style'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('btn_font_style'); ?>">
          <span><?php _e( 'Font style for buttons.' ); ?></span>
        </label>
      </div>
    </div> <!-- btn_font_style -->
<?php 
?>
      <div class="pde-form-field pde-form-label label-style-h3">
        <h3><?php _e( 'Fonts - Tab' ); ?></h3>      </div>
<?php 
    $tab_font_family = esc_attr( $instance['tab_font_family'] );
?>
    <div class="pde-form-field pde-form-text tab_font_family">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_font_family'); ?>">
          <span><?php esc_html_e( __('Tab Font Family') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_font_family; ?>" name="<?php echo $this->get_field_name('tab_font_family'); ?>" id="<?php echo $this->get_field_id('tab_font_family'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_font_family'); ?>">
          <span><?php _e( 'Font family for tab links.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_font_family -->

<?php 
    $tab_font_size = esc_attr( $instance['tab_font_size'] );
?>
    <div class="pde-form-field pde-form-text tab_font_size">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_font_size'); ?>">
          <span><?php esc_html_e( __('Tab Font Size') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_font_size; ?>" name="<?php echo $this->get_field_name('tab_font_size'); ?>" id="<?php echo $this->get_field_id('tab_font_size'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_font_size'); ?>">
          <span><?php _e( 'Font size for tab text.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_font_size -->

<?php 
    $tab_font_weight = $instance['tab_font_weight'] ;
?>
    <div class="pde-form-field pde-form-dropdown tab_font_weight">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_font_weight'); ?>">
          <span><?php esc_html_e( __('Tab Font Weight') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('tab_font_weight'); ?>" id="<?php echo $this->get_field_id('tab_font_weight'); ?>">
            <option value="normal"<?php selected( $instance['tab_font_weight'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="bold"<?php selected( $instance['tab_font_weight'], 'bold' ); ?>><?php _e('bold'); ?></option>
              <option value="inherit"<?php selected( $instance['tab_font_weight'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
              <option value="100"<?php selected( $instance['tab_font_weight'], '100' ); ?>><?php _e('100'); ?></option>
              <option value="200"<?php selected( $instance['tab_font_weight'], '200' ); ?>><?php _e('200'); ?></option>
              <option value="300"<?php selected( $instance['tab_font_weight'], '300' ); ?>><?php _e('300'); ?></option>
              <option value="400"<?php selected( $instance['tab_font_weight'], '400' ); ?>><?php _e('400'); ?></option>
              <option value="500"<?php selected( $instance['tab_font_weight'], '500' ); ?>><?php _e('500'); ?></option>
              <option value="600"<?php selected( $instance['tab_font_weight'], '600' ); ?>><?php _e('600'); ?></option>
              <option value="700"<?php selected( $instance['tab_font_weight'], '700' ); ?>><?php _e('700'); ?></option>
              <option value="800"<?php selected( $instance['tab_font_weight'], '800' ); ?>><?php _e('800'); ?></option>
              <option value="900"<?php selected( $instance['tab_font_weight'], '900' ); ?>><?php _e('900'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_font_weight'); ?>">
          <span><?php _e( 'Font weight for tab text.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_font_weight -->
<?php 
    $tab_font_style = $instance['tab_font_style'] ;
?>
    <div class="pde-form-field pde-form-dropdown tab_font_style">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_font_style'); ?>">
          <span><?php esc_html_e( __('Tab Font Style') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('tab_font_style'); ?>" id="<?php echo $this->get_field_id('tab_font_style'); ?>">
            <option value="normal"<?php selected( $instance['tab_font_style'], 'normal' ); ?>><?php _e('normal'); ?></option>
              <option value="italic"<?php selected( $instance['tab_font_style'], 'italic' ); ?>><?php _e('italic'); ?></option>
              <option value="oblique"<?php selected( $instance['tab_font_style'], 'oblique' ); ?>><?php _e('oblique'); ?></option>
              <option value="inherit"<?php selected( $instance['tab_font_style'], 'inherit' ); ?>><?php _e('inherit'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_font_style'); ?>">
          <span><?php _e( 'Font style for tab text.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_font_style -->
<?php 
?>
   </div>
<?php
?>
   <div id='<?php echo $this->get_field_id( "LoginRegisterPanel"); ?>'>
<?php
?>
    <div class="pde-form-field pde-form-checkbox login_panel">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('login_panel'); ?>">
            <span><?php esc_html_e( __('Login Panel') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('login_panel'); ?>"
            value="Login Panel"
            name="cb-<?php echo $this->get_field_name('login_panel'); ?>"
            type="checkbox"<?php checked(isset($instance['login_panel']) ? $instance['login_panel'] : '', 'Login Panel'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('login_panel'); ?>"
            value="Login Panel"
            name="<?php echo $this->get_field_name('login_panel'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('login_panel'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('login_panel'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('login_panel'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('login_panel'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Do not show login Panel') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('login_panel'); ?>">
            <span><?php _e( 'Disables the login option. For logged users the dashboard is shown, for others the static dashboard message is shown.' ); ?></span>
          </label>
        </div>
    </div> <!-- login_panel -->

<?php 
?>
    <div class="display_when_unselected group-for-checkbox group-login_panel" id="group-<?php echo $this->get_field_id("login_panel") ?>">
<script type="text/javascript">
(function($) {
  $(document).ready(function(e) {
    $('.wp-pde-checkbox').trigger('change');
  });
})(jQuery);
</script>
<?php
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <?php if(has_action('wordpress_social_login')): ?>
 
      </div>

<?php 
?>
    <div class="pde-form-field pde-form-checkbox use_social_login">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('use_social_login'); ?>">
            <span><?php esc_html_e( __('Use Social Login') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('use_social_login'); ?>"
            value="Use Social Login"
            name="cb-<?php echo $this->get_field_name('use_social_login'); ?>"
            type="checkbox"<?php checked(isset($instance['use_social_login']) ? $instance['use_social_login'] : '', 'Use Social Login'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('use_social_login'); ?>"
            value="Use Social Login"
            name="<?php echo $this->get_field_name('use_social_login'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('use_social_login'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('use_social_login'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('use_social_login'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('use_social_login'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('use_social_login'); ?>">
            <span><?php _e( 'Check this box if you want to use Social Login. The first panel in the login panel will display Social Login icons.' ); ?></span>
          </label>
        </div>
    </div> <!-- use_social_login -->

<?php 
?>
    <div class="display_when_selected group-for-checkbox group-use_social_login" id="group-<?php echo $this->get_field_id("use_social_login") ?>">
<script type="text/javascript">
(function($) {
  $(document).ready(function(e) {
    $('.wp-pde-checkbox').trigger('change');
  });
})(jQuery);
</script>
<?php
    $social_login_introduction = esc_textarea( $instance['social_login_introduction'] );
?>
    <div class="pde-form-field pde-form-textarea social_login_introduction">
      <div class="pde-form-title" style="width:100%">
        <label for="<?php echo $this->get_field_id('social_login_introduction'); ?>">
          <span><?php esc_html_e( __('Social Login Introduction') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input" style="width: 100%">
        <textarea rows = '15'  id="<?php echo $this->get_field_id('social_login_introduction'); ?>" name="<?php echo $this->get_field_name('social_login_introduction'); ?>"><?php echo $social_login_introduction; ?></textarea> 
      </div>
      <div class="pde-form-description" style="width:100%" >
        <label for="<?php echo $this->get_field_id('social_login_introduction'); ?>">
          <span><?php _e( 'Message displayed before Social Login options.
' ); ?></span>
        </label>
      </div>
    </div> <!-- social_login_introduction -->

<?php 
?>
   </div>
<?php
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <?php else: ?>
<p>You could use openID to let users register/login into the site, if <b>Wordpress Social Login</b> plugin is installed.</p>
<?php endif; ?>
 
      </div>

<?php 
    $welcome_message = esc_textarea( $instance['welcome_message'] );
?>
    <div class="pde-form-field pde-form-textarea welcome_message">
      <div class="pde-form-title" style="width:100%">
        <label for="<?php echo $this->get_field_id('welcome_message'); ?>">
          <span><?php esc_html_e( __('Welcome Message') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input" style="width: 100%">
        <textarea rows = '15'  id="<?php echo $this->get_field_id('welcome_message'); ?>" name="<?php echo $this->get_field_name('welcome_message'); ?>"><?php echo $welcome_message; ?></textarea> 
      </div>
      <div class="pde-form-description" style="width:100%" >
        <label for="<?php echo $this->get_field_id('welcome_message'); ?>">
          <span><?php _e( 'Welcome message to be displayed in the login panel. Used when WP Social Login is not used. You can use shortcodes here.' ); ?></span>
        </label>
      </div>
    </div> <!-- welcome_message -->

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <?php if ( !get_option('users_can_register')): ?>
<p>Registrations are closed on this site. You can allow users to register by selecting 'Anyone can register' option from <b>Settings > General</b>.</p>  
      </div>

<?php 
    $registration_message = esc_textarea( $instance['registration_message'] );
?>
    <div class="pde-form-field pde-form-textarea registration_message">
      <div class="pde-form-title" style="width:100%">
        <label for="<?php echo $this->get_field_id('registration_message'); ?>">
          <span><?php esc_html_e( __('Registration Message') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input" style="width: 100%">
        <textarea rows = '15'  id="<?php echo $this->get_field_id('registration_message'); ?>" name="<?php echo $this->get_field_name('registration_message'); ?>"><?php echo $registration_message; ?></textarea> 
      </div>
      <div class="pde-form-description" style="width:100%" >
        <label for="<?php echo $this->get_field_id('registration_message'); ?>">
          <span><?php _e( 'Message displayed in the registration panel' ); ?></span>
        </label>
      </div>
    </div> <!-- registration_message -->

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <?php endif; ?> 
      </div>

<?php 
    $heading_login = esc_attr( $instance['heading_login'] );
?>
    <div class="pde-form-field pde-form-text heading_login">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('heading_login'); ?>">
          <span><?php esc_html_e( __('Heading - Login') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $heading_login; ?>" name="<?php echo $this->get_field_name('heading_login'); ?>" id="<?php echo $this->get_field_id('heading_login'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('heading_login'); ?>">
          <span><?php _e( 'Heading for login form.' ); ?></span>
        </label>
      </div>
    </div> <!-- heading_login -->

<?php 
    $heading_register = esc_attr( $instance['heading_register'] );
?>
    <div class="pde-form-field pde-form-text heading_register">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('heading_register'); ?>">
          <span><?php esc_html_e( __('Heading - Register') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $heading_register; ?>" name="<?php echo $this->get_field_name('heading_register'); ?>" id="<?php echo $this->get_field_id('heading_register'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('heading_register'); ?>">
          <span><?php _e( 'Heading for register form.' ); ?></span>
        </label>
      </div>
    </div> <!-- heading_register -->

<?php 
    $heading_lost_password = esc_attr( $instance['heading_lost_password'] );
?>
    <div class="pde-form-field pde-form-text heading_lost_password">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('heading_lost_password'); ?>">
          <span><?php esc_html_e( __('Heading - Lost Password') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $heading_lost_password; ?>" name="<?php echo $this->get_field_name('heading_lost_password'); ?>" id="<?php echo $this->get_field_id('heading_lost_password'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('heading_lost_password'); ?>">
          <span><?php _e( 'Heading for lost password form.' ); ?></span>
        </label>
      </div>
    </div> <!-- heading_lost_password -->

<?php 
    $tab_login_link = esc_attr( $instance['tab_login_link'] );
?>
    <div class="pde-form-field pde-form-text tab_login_link">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_login_link'); ?>">
          <span><?php esc_html_e( __('Tab Login Link') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_login_link; ?>" name="<?php echo $this->get_field_name('tab_login_link'); ?>" id="<?php echo $this->get_field_id('tab_login_link'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_login_link'); ?>">
          <span><?php _e( 'Text shown on the tab for login.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_login_link -->

<?php 
    $tab_close_panel = esc_attr( $instance['tab_close_panel'] );
?>
    <div class="pde-form-field pde-form-text tab_close_panel">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_close_panel'); ?>">
          <span><?php esc_html_e( __('Tab Close Panel Link') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_close_panel; ?>" name="<?php echo $this->get_field_name('tab_close_panel'); ?>" id="<?php echo $this->get_field_id('tab_close_panel'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_close_panel'); ?>">
          <span><?php _e( 'Text shown on the tab for closing the panel.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_close_panel -->

<?php 
?>
   </div>
<?php
?>
   </div>
<?php
?>
   <div id='<?php echo $this->get_field_id( "DashboardPanel"); ?>'>
<?php
?>
    <div class="pde-form-field pde-form-checkbox do_not_show_dashboard">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('do_not_show_dashboard'); ?>">
            <span><?php esc_html_e( __('Do not show dashboard') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('do_not_show_dashboard'); ?>"
            value="Do not show dashboard"
            name="cb-<?php echo $this->get_field_name('do_not_show_dashboard'); ?>"
            type="checkbox"<?php checked(isset($instance['do_not_show_dashboard']) ? $instance['do_not_show_dashboard'] : '', 'Do not show dashboard'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('do_not_show_dashboard'); ?>"
            value="Do not show dashboard"
            name="<?php echo $this->get_field_name('do_not_show_dashboard'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('do_not_show_dashboard'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('do_not_show_dashboard'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('do_not_show_dashboard'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('do_not_show_dashboard'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('do_not_show_dashboard'); ?>">
            <span><?php _e( 'Does not show dashboard to any users. Instead the dashboard panel given below will be shown for everyone.' ); ?></span>
          </label>
        </div>
    </div> <!-- do_not_show_dashboard -->

<?php 
?>
    <div class="display_when_unselected group-for-checkbox group-do_not_show_dashboard" id="group-<?php echo $this->get_field_id("do_not_show_dashboard") ?>">
<script type="text/javascript">
(function($) {
  $(document).ready(function(e) {
    $('.wp-pde-checkbox').trigger('change');
  });
})(jQuery);
</script>
<?php
    $show_dashboard = $instance['show_dashboard'] ;
?>
    <div class="pde-form-field pde-form-dropdown-multiple show_dashboard">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('show_dashboard'); ?>">
          <span><?php esc_html_e( __('Show Dashboard') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
      <?php
        $key = 0 ;
        if( !empty( $show_dashboard ) )
          foreach( $show_dashboard as $show_dashboard_single ) {
            if ( $show_dashboard_single != 'select-a-role' ) {
              ?><select name="<?php echo $this->get_field_name('show_dashboard') . '[' . $key . ']'; ?>" id="<?php echo $this->get_field_id('show_dashboard') . '_' . $key; ?>">
              <option value="select-a-role">Select a role</option>
      <?php wp_dropdown_roles( $show_dashboard_single); ?>              </select><?php

              $key++ ;
              echo "<br/>";
            }
          }
        $show_dashboard_single = 'select-a-role';
        echo '<div class="pde-form-item-dropdown-new-item">';
        ?><select name="<?php echo $this->get_field_name('show_dashboard') . '[' . $key . ']'; ?>" id="<?php echo $this->get_field_id('show_dashboard') . '_' . $key; ?>">
              <option value="select-a-role">Select a role</option>
<?php wp_dropdown_roles( $show_dashboard_single); ?>        </select><?php
        echo '</div>';
        $key++ ;
?>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('show_dashboard'); ?>">
          <span><?php _e( 'Select the roles for which the dashboard should be shown. Not selecting any enables dashboard display for all users.' ); ?></span>
        </label>
      </div>
    </div> <!-- show_dashboard -->
<script type="text/javascript">
(function($){
  $('#wpbody-content').off( 'change', '.pde-form-item-dropdown-new-item select:last-child');
  $('#wpbody-content').on( 'change', '.pde-form-item-dropdown-new-item select:last-child', function(e) {
    key = parseInt($(e.target).attr('name').match(/([0-9]+).$/)[1]);
    key = key + 1;
    newName = $(e.target).attr('name').replace(/([0-9]+).$/, '' + key + ']');
    key = parseInt($(e.target).attr('id').match(/_([0-9]+)$/)[1]);
    key = key + 1;
    newid = $(e.target).attr('id').replace(/_([0-9]+)$/, '_' + key);
    clone = $(e.target).clone();
    $(clone).attr('id', newid);
    $(clone).attr('name', newName);
    $(clone).val(0);
    $("<br/>").appendTo($(e.target).parent());
    $(clone).appendTo($(e.target).parent());
  });
})(jQuery);
</script>
<?php 
    $dashboard_welcome_message = esc_textarea( $instance['dashboard_welcome_message'] );
?>
    <div class="pde-form-field pde-form-textarea dashboard_welcome_message">
      <div class="pde-form-title" style="width:100%">
        <label for="<?php echo $this->get_field_id('dashboard_welcome_message'); ?>">
          <span><?php esc_html_e( __('Welcome Message') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input" style="width: 100%">
        <textarea rows = '15'  id="<?php echo $this->get_field_id('dashboard_welcome_message'); ?>" name="<?php echo $this->get_field_name('dashboard_welcome_message'); ?>"><?php echo $dashboard_welcome_message; ?></textarea> 
      </div>
      <div class="pde-form-description" style="width:100%" >
        <label for="<?php echo $this->get_field_id('dashboard_welcome_message'); ?>">
          <span><?php _e( 'Message shown in the first panel of the dashboard.' ); ?></span>
        </label>
      </div>
    </div> <!-- dashboard_welcome_message -->

<?php 
?>
   </div>
<?php
    $dashboard_message = esc_textarea( $instance['dashboard_message'] );
?>
    <div class="pde-form-field pde-form-textarea dashboard_message">
      <div class="pde-form-title" style="width:100%">
        <label for="<?php echo $this->get_field_id('dashboard_message'); ?>">
          <span><?php esc_html_e( __('Dashboard Message') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input" style="width: 100%">
        <textarea rows = '15'  id="<?php echo $this->get_field_id('dashboard_message'); ?>" name="<?php echo $this->get_field_name('dashboard_message'); ?>"><?php echo $dashboard_message; ?></textarea> 
      </div>
      <div class="pde-form-description" style="width:100%" >
        <label for="<?php echo $this->get_field_id('dashboard_message'); ?>">
          <span><?php _e( 'The message shown to users without permissions for viewing the dashboard.' ); ?></span>
        </label>
      </div>
    </div> <!-- dashboard_message -->

<?php 
    $tab_dashboard_open_link = esc_attr( $instance['tab_dashboard_open_link'] );
?>
    <div class="pde-form-field pde-form-text tab_dashboard_open_link">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('tab_dashboard_open_link'); ?>">
          <span><?php esc_html_e( __('Tab Dashboard Open Link') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" value="<?php echo $tab_dashboard_open_link; ?>" name="<?php echo $this->get_field_name('tab_dashboard_open_link'); ?>" id="<?php echo $this->get_field_id('tab_dashboard_open_link'); ?>" />
      </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('tab_dashboard_open_link'); ?>">
          <span><?php _e( 'Text link for open dashboard.' ); ?></span>
        </label>
      </div>
    </div> <!-- tab_dashboard_open_link -->

<?php 
?>
   </div>
<?php
?>
   <div id='<?php echo $this->get_field_id( "CSS"); ?>'>
<?php
    $other_images = $instance['other_images'] ;
?>
    <div class="pde-form-field pde-form-images-multiple other_images">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('other_images'); ?>">
          <span><?php esc_html_e( __('Other Images') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
      <?php
        $key = 0 ;
        if( !empty( $other_images ) )
          foreach( $other_images as $other_images_single ) {
            if ( !empty( $other_images_single ) ) {
?>
          <div class="pde-form-images-text">
              <input id="<?php echo $this->get_field_id('other_images'); ?>_<?php echo $key; ?>" name="<?php echo $this->get_field_name('other_images'); ?>[<?php echo $key; ?>]" type="text" class="pde-form-image-upload-text"
                 value="<?php echo esc_attr($other_images_single); ?>" />
          </div>
          <div class="pde-form-images-img">
              <img src='<?php echo esc_attr($other_images_single); ?>' />
          </div>
              <div class="pde-form-images-buttons">
                <input id="<?php echo $this->get_field_id('other_images'); ?>_<?php echo $key; ?>_remove_button" value="Remove" type="button" class="pde-form-image-upload-remove-button button-secondary"/>
                <input id="<?php echo $this->get_field_id('other_images'); ?>_<?php echo $key; ?>_button" value="Upload" type="button" class="pde-form-image-upload-button button-secondary"/>
              </div>
<?php
              $key++ ;
            }
          }
        $other_images_single = '';
        echo '<div class="pde-form-item-images-new-item">';
?>
          <div class="pde-form-images-text">
              <input id="<?php echo $this->get_field_id('other_images'); ?>_<?php echo $key; ?>" name="<?php echo $this->get_field_name('other_images'); ?>[<?php echo $key; ?>]" type="text" class="pde-form-image-upload-text-last"
                 value="<?php echo esc_attr($other_images_single); ?>" />
          </div>
              <div class="pde-form-images-buttons">
                <input id="<?php echo $this->get_field_id('other_images'); ?>_<?php echo $key; ?>_button" value="Upload" type="button" class="pde-form-image-upload-button button-secondary"/>
              </div>
<?php
        echo '</div>';
        $key++ ;
?>

        </div>
      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('other_images'); ?>">
          <span><?php _e( 'Upload any images used in the CSS below. When the scheme is exported as a plugin, all these images will be packed.' ); ?></span>
        </label>
      </div>
    </div> <!-- other_images -->
<script type="text/javascript">
(function($){
  $('#wpbody-content').off( 'change', '.pde-form-item-images-new-item .pde-form-image-upload-text-last');
  $('#wpbody-content').on( 'change', '.pde-form-item-images-new-item .pde-form-image-upload-text-last', function(e) {
    key = parseInt($(e.target).attr('name').match(/([0-9]+).$/)[1]);
    key = key + 1;
    id_prefix = $(e.target).attr('id').replace(/_([0-9]+)$/, '') ;
    name_prefix = $(e.target).attr('name').replace(/.([0-9]+).$/, '') ;
    cloneText = $(e.target).clone();
    $(cloneText).val('');
    $(cloneText).attr('id', id_prefix + '_' + key );
    $(cloneText).attr('name', name_prefix + '[' + key + ']' );
    cloneButton = $('#' + $(e.target).attr('id') + '_button').clone();
    cloneButton.attr('id', id_prefix + '_' + key + '_button');
    $(e.target).removeClass('pde-form-image-upload-text-last');
    $(cloneText).appendTo($(e.target).parent().parent());
    $(cloneButton).appendTo($(e.target).parent().parent());
    return false ;
  });
})(jQuery);
</script>
<script type="text/javascript">
(function($) {
  $('#wpbody-content').off( 'click', '.pde-form-image-upload-button' );
  $('#wpbody-content').on( 'click', '.pde-form-image-upload-button', function(e) {
    id_text = $(e.target).attr('id').replace(/_button$/, '');
    window.send_to_editor = function(html) {
      imgurl = jQuery('img',html).attr('src');
      if( imgurl == undefined ) {
        imgurl = jQuery(html).attr('href');
      }
      jQuery('#' + id_text).val(imgurl);
      tb_remove();
      jQuery('#' + id_text).change();
    }

    <?php $url = add_query_arg( array( 'post_id' => '0', 'type' => 'image', 'tab' => 'library', 'TB_iframe' => 'true'),
                    admin_url('media-upload.php') ); ?>
    formfield = jQuery('#' + id_text).attr('name');
    tb_show('', '<?php echo $url; ?>');
    return false;
  });
  $('#wpbody-content').off( 'click', '.pde-form-image-upload-remove-button' );
  $('#wpbody-content').on( 'click', '.pde-form-image-upload-remove-button', function(e) {
    id_text = $(e.target).attr('id').replace(/_remove_button$/, '');
    jQuery('#' + id_text).val('');
  });
})(jQuery);
</script>

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <h3>The CSS Entered in this field will be included in the sliding panel CSS. This provides fine grained control for your panel's look and feel.</h3>
 
      </div>

<?php 
    $extra_css = esc_textarea( $instance['extra_css'] );
?>
    <div class="pde-form-field pde-form-textarea extra_css">
      <div class="pde-form-title" style="width:100%">
        <label for="<?php echo $this->get_field_id('extra_css'); ?>">
          <span><?php esc_html_e( __('Extra CSS') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input" style="width: 100%">
        <textarea rows = '30'  id="<?php echo $this->get_field_id('extra_css'); ?>" name="<?php echo $this->get_field_name('extra_css'); ?>"><?php echo $extra_css; ?></textarea> 
      </div>
    </div> <!-- extra_css -->

<?php 
?>
   </div>
<?php
    ?>
    <div class="metabox-holder ui-widget" style="min-height:10px;">
      <?php do_meta_boxes( null, 'normal', 'sliding-panel-options' ); ?>
      &nbsp;
    </div>
      <div class="button-controls"><?php submit_button( __( 'Save Changes' ) , 'button-primary plugin-save', 'save_menu', false, array() ); ?></div>
      <input type="hidden" name="action" id="action" value="save" />
  </div> <!-- pde-menu-page -->
  <div class="metabox-holder ui-widget" style="width:280px;margin-right:840px;">
    <?php do_meta_boxes( null, 'side', 'sliding-panel-options' ); ?>
  </div>
    </form>
</div> <!-- wrap -->
    <?php
  }

  function __enqueue_css() {
    // jQuery
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
    wp_enqueue_script( 'jquery-ui-sortable' );

    // Metaboxes
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );

     $file = 'pde-menu-page-default.css';
     $script_id = 'pde-menu-page-default' ;
     wp_enqueue_style( $script_id, plugins_url( $file, __FILE__ ) );
	   wp_enqueue_script( 'jquery-ui-tabs' );
       wp_enqueue_style( 'jquery-style', plugins_url( 'styles/smoothness/jquery-ui-1.8.23.custom.css', dirname( __FILE__ ) ) );
	   wp_enqueue_script( 'farbtastic' );
	   wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
   do_action('enqueue_css_sliding-panel-options', null);
  }
}
add_action('admin_menu', array('Schemeable_Sliding_Panel_v1_0_u_Sliding_Panel_Options', 'setup'));

?>
