<?php

class Schemeable_Sliding_Panel_v1_0_m_Options {
  static function setup() {
    $var = new Schemeable_Sliding_Panel_v1_0_m_Options;
    add_action( 'add_meta_boxes', array( &$var, 'add_meta_box' ) );
    add_action( 'add_menu_page_meta_boxes', array( &$var, 'add_menu_page_meta_box' ) );
    add_action( 'save_post', array( &$var, 'save_post' ) );
    add_filter( 'save_menu_page-sliding-panel-options', array( &$var, 'save_menu_page' ) );
  }

  function add_meta_box( $meta_post_type ) {
  }

  function add_menu_page_meta_box( $meta_menu_page ) {
      if( $meta_menu_page == 'sliding-panel-options' ) {
        $this->__enqueue_css();
        add_meta_box( 
            'Schemeable_Sliding_Panel_v1_0_m_Options',
            __( 'Options', 'Schemeable Sliding Panel_textdomain' ),
            array( &$this, 'render_menu_page_meta_box' ),
            get_current_screen(),
            'side',
            'default'
        );
        add_filter( 'admin_title', array( &$this, 'setup_help' ) );
      }
  }

  function setup_help($title) {
    $screen = get_current_screen();
    $meta_key = 'options' ;
    $help_tabs = array();
    if( !is_dir( dirname( __FILE__ ) . '/help' ) )
      return ;
    $help_files = scandir( dirname( __FILE__ ) . '/help' );
    foreach( $help_files as $help_file ) {
      if( preg_match( '/[^-]*-' . get_bloginfo('language') . '-' . $meta_key . '-' . '/', $help_file ) ) {
        $display = preg_replace( '/[^-]*-' . get_bloginfo('language') . '-' . $meta_key . '-' . '/', '', basename( $help_file, '.md' ) );
        $display = ucwords( str_replace( '-', ' ', $display ) );
        $help_tabs[] = array( sanitize_html_class( $help_file ), $display, $help_file );
      } else if( get_bloginfo('language') . '-' . $meta_key . '-sidebar.md' == $help_file ) {
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
    return $title;
  }

  function get_field_id( $id ) {
    return 'id_Schemeable_Sliding_Panel_v1_0_m_Options_' . $id ;
  }

  function get_field_name( $id ) {
    return 'name_Schemeable_Sliding_Panel_v1_0_m_Options_' . $id ;
  }

  function render_meta_box( $post ) {

    wp_nonce_field( plugin_basename( __FILE__ ), 'Schemeable_Sliding_Panel_v1_0_m_Options_noncename' );

    $instance = get_post_meta( $post->ID, 'options', true );
    if( empty( $instance ) ) {
      $instance = array(
                 'content_display' => 'Overlay over Content',
                 'scheme' => 'Default (Black & White)',
                 'current_scheme' => '',
                 'hr_1' => '',
                 'preview' => 'Preview',
                 'admin_bar' => '',
                 'standard_pages' => '',
                 'save_changes_metabox' => '',
                 'hr_2' => '',
                 'scheme_name' => '',
                 'save_scheme' => '',
                 'remove_scheme_name' => '',
                 'remove_scheme' => '',
                );
      $instance = apply_filters('pde-meta-box-defaults-options', $instance);
    }
    ?>
    <div id='<?php echo $this->get_field_id("wp-pde-form"); ?>' class="pde-meta-box pde-meta-box-default">
    <?php
    $content_display = $instance['content_display'] ;
?>
    <div class="pde-form-field pde-form-dropdown content_display">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('content_display'); ?>">
          <span><?php esc_html_e( __('Content Display') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('content_display'); ?>" id="<?php echo $this->get_field_id('content_display'); ?>">
            <option value="Overlay over Content"<?php selected( $instance['content_display'], 'Overlay over Content' ); ?>><?php _e('Overlay over Content'); ?></option>
              <option value="Slide Down"<?php selected( $instance['content_display'], 'Slide Down' ); ?>><?php _e('Slide Down'); ?></option>
              <option value="Fixed"<?php selected( $instance['content_display'], 'Fixed' ); ?>><?php _e('Fixed'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('content_display'); ?>">
          <span><b>Overlay over Content</b> allows the panel to be displayed over the existing content. <b>Slide Down</b> pushes the existing content downwards when the panel is displayed. <b>Fixed</b> is similar to overlay except the panel does not scroll with the content.</span>
        </label>
      </div>
    </div> <!-- content_display -->
<?php 
    $scheme = $instance['scheme'] ;
?>
    <div class="pde-form-field pde-form-dropdown scheme">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('scheme'); ?>">
          <span><?php esc_html_e( __('Scheme') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('scheme'); ?>" id="<?php echo $this->get_field_id('scheme'); ?>">
<?php sliding_panel_dropdown_schemes( $instance['scheme'] ); ?>        </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('scheme'); ?>">
          <span><?php _e( 'Select a scheme.' ); ?></span>
        </label>
      </div>
    </div> <!-- scheme -->
<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <input type='hidden' value="<?php echo $instance['scheme'] ; ?>" id="current_scheme" name="current_scheme" />
 
      </div>

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <hr/> 
      </div>

<?php 
?>
    <div class="pde-form-field pde-form-checkbox preview">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('preview'); ?>">
            <span><?php esc_html_e( __('Preview') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('preview'); ?>"
            value="Preview"
            name="cb-<?php echo $this->get_field_name('preview'); ?>"
            type="checkbox"<?php checked(isset($instance['preview']) ? $instance['preview'] : '', 'Preview'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('preview'); ?>"
            value="Preview"
            name="<?php echo $this->get_field_name('preview'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('preview'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('preview'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('preview'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('preview'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Show Preview') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('preview'); ?>">
            <span><?php _e( 'Displays the preview of dashboard and login widgets' ); ?></span>
          </label>
        </div>
    </div> <!-- preview -->

<?php 
?>
    <div class="pde-form-field pde-form-checkbox admin_bar">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('admin_bar'); ?>">
            <span><?php esc_html_e( __('Admin Bar') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('admin_bar'); ?>"
            value="Admin Bar"
            name="cb-<?php echo $this->get_field_name('admin_bar'); ?>"
            type="checkbox"<?php checked(isset($instance['admin_bar']) ? $instance['admin_bar'] : '', 'Admin Bar'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('admin_bar'); ?>"
            value="Admin Bar"
            name="<?php echo $this->get_field_name('admin_bar'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('admin_bar'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('admin_bar'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('admin_bar'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('admin_bar'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Disable admin bar') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('admin_bar'); ?>">
            <span><?php _e( 'Disable the admin bar for the front end. This is useful if you enabled dashboard display.' ); ?></span>
          </label>
        </div>
    </div> <!-- admin_bar -->

<?php 
?>
    <div class="pde-form-field pde-form-checkbox standard_pages">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('standard_pages'); ?>">
            <span><?php esc_html_e( __('WP Login/Register Page') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('standard_pages'); ?>"
            value="WP Login/Register Page"
            name="cb-<?php echo $this->get_field_name('standard_pages'); ?>"
            type="checkbox"<?php checked(isset($instance['standard_pages']) ? $instance['standard_pages'] : '', 'WP Login/Register Page'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('standard_pages'); ?>"
            value="WP Login/Register Page"
            name="<?php echo $this->get_field_name('standard_pages'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('standard_pages'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('standard_pages'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('standard_pages'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('standard_pages'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Disable standard pages') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('standard_pages'); ?>">
            <span><?php _e( 'Disable wordpress login, register and lost password pages.' ); ?></span>
          </label>
        </div>
    </div> <!-- standard_pages -->

<?php 
    ?><div class="pde-form-field pde-form-markup markup-style-html"><?php
    submit_button( '', 'primary', 'submit', false, array( 'id' => 'id-submit' ) );
    ?></div><?php
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <hr/> 
      </div>

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <div class="pde-form-field pde-form-text scheme_name">
      <div class="pde-form-title">
        <label for="id_Yet_another_sliding_panel_v0_1_m_Options_scheme_name">
          <span>Scheme Name</span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" id="id_Yet_another_sliding_panel_v0_1_m_Options_scheme_name" name="scheme_name" value="">
      </div>
      <div class="pde-form-description">
        <label for="id_Yet_another_sliding_panel_v0_1_m_Options_scheme_name">
          <span>Enter a scheme name and press 'Save Scheme' button to save your scheme.</span>
        </label>
      </div>
    </div> 
      </div>

<?php 
    ?><div class="pde-form-field pde-form-markup markup-style-html"><?php
    submit_button( 'Save Scheme', 'secondary', 'save_scheme', false, array( 'id' => 'id-save_scheme' ) );
    ?></div><?php
    ?>
    <script type="text/javascript">
    (function($) {
      $(document).ready(function(e) {
        $('#id-save_scheme').bind('click', function(e) {
          $('#action').val('save_scheme');
          return true ;
        });
      });
    })(jQuery);
    </script>
    <?php
    $remove_scheme_name = $instance['remove_scheme_name'] ;
?>
    <div class="pde-form-field pde-form-dropdown remove_scheme_name">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('remove_scheme_name'); ?>">
          <span><?php esc_html_e( __('Scheme') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('remove_scheme_name'); ?>" id="<?php echo $this->get_field_id('remove_scheme_name'); ?>">
<?php sliding_panel_dropdown_schemes( $instance['remove_scheme'], true ); ?>        </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('remove_scheme_name'); ?>">
          <span><?php _e( 'Select a scheme and click on Remove to delete it.' ); ?></span>
        </label>
      </div>
    </div> <!-- remove_scheme_name -->
<?php 
    ?><div class="pde-form-field pde-form-markup markup-style-html"><?php
    submit_button( 'Remove Scheme', 'delete', 'remove_scheme', false, array( 'id' => 'id-remove_scheme' ) );
    ?></div><?php
    ?>
    <script type="text/javascript">
    (function($) {
      $(document).ready(function(e) {
        $('#id-remove_scheme').bind('click', function(e) {
          $('#action').val('remove_scheme');
          return true ;
        });
      });
    })(jQuery);
    </script>
    <?php
    ?>
    </div>
    <?php
  }

  function render_menu_page_meta_box( $menu_page_slug ) {

    wp_nonce_field( plugin_basename( __FILE__ ), 'Schemeable_Sliding_Panel_v1_0_m_Options_noncename' );

	$option = get_option($menu_page_slug);
    $instance = $option['options'];
    if( empty( $instance ) ) {
      $instance = array(
                 'content_display' => 'Overlay over Content',
                 'scheme' => 'Default (Black & White)',
                 'current_scheme' => '',
                 'hr_1' => '',
                 'preview' => 'Preview',
                 'admin_bar' => '',
                 'standard_pages' => '',
                 'save_changes_metabox' => '',
                 'hr_2' => '',
                 'scheme_name' => '',
                 'save_scheme' => '',
                 'remove_scheme_name' => '',
                 'remove_scheme' => '',
                );
    $instance = apply_filters('pde-meta-box-defaults-options', $instance);
    }
    ?>
    <div id='<?php echo $this->get_field_id("wp-pde-form"); ?>' class="pde-meta-box pde-meta-box-default">
    <?php
    $content_display = $instance['content_display'] ;
?>
    <div class="pde-form-field pde-form-dropdown content_display">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('content_display'); ?>">
          <span><?php esc_html_e( __('Content Display') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('content_display'); ?>" id="<?php echo $this->get_field_id('content_display'); ?>">
            <option value="Overlay over Content"<?php selected( $instance['content_display'], 'Overlay over Content' ); ?>><?php _e('Overlay over Content'); ?></option>
              <option value="Slide Down"<?php selected( $instance['content_display'], 'Slide Down' ); ?>><?php _e('Slide Down'); ?></option>
              <option value="Fixed"<?php selected( $instance['content_display'], 'Fixed' ); ?>><?php _e('Fixed'); ?></option>
          </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('content_display'); ?>">
          <span><b>Overlay over Content</b> allows the panel to be displayed over the existing content. <b>Slide Down</b> pushes the existing content downwards when the panel is displayed. <b>Fixed</b> is similar to overlay except the panel does not scroll with the content.</span>
        </label>
      </div>
    </div> <!-- content_display -->
<?php 
    $scheme = $instance['scheme'] ;
?>
    <div class="pde-form-field pde-form-dropdown scheme">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('scheme'); ?>">
          <span><?php esc_html_e( __('Scheme') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('scheme'); ?>" id="<?php echo $this->get_field_id('scheme'); ?>">
<?php sliding_panel_dropdown_schemes( $instance['scheme'] ); ?>        </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('scheme'); ?>">
          <span><?php _e( 'Select a scheme.' ); ?></span>
        </label>
      </div>
    </div> <!-- scheme -->
<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <input type='hidden' value="<?php echo $instance['scheme'] ; ?>" id="current_scheme" name="current_scheme" />
 
      </div>

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <hr/> 
      </div>

<?php 
?>
    <div class="pde-form-field pde-form-checkbox preview">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('preview'); ?>">
            <span><?php esc_html_e( __('Preview') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('preview'); ?>"
            value="Preview"
            name="cb-<?php echo $this->get_field_name('preview'); ?>"
            type="checkbox"<?php checked(isset($instance['preview']) ? $instance['preview'] : '', 'Preview'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('preview'); ?>"
            value="Preview"
            name="<?php echo $this->get_field_name('preview'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('preview'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('preview'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('preview'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('preview'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Show Preview') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('preview'); ?>">
            <span><?php _e( 'Displays the preview of dashboard and login widgets' ); ?></span>
          </label>
        </div>
    </div> <!-- preview -->

<?php 
?>
    <div class="pde-form-field pde-form-checkbox admin_bar">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('admin_bar'); ?>">
            <span><?php esc_html_e( __('Admin Bar') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('admin_bar'); ?>"
            value="Admin Bar"
            name="cb-<?php echo $this->get_field_name('admin_bar'); ?>"
            type="checkbox"<?php checked(isset($instance['admin_bar']) ? $instance['admin_bar'] : '', 'Admin Bar'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('admin_bar'); ?>"
            value="Admin Bar"
            name="<?php echo $this->get_field_name('admin_bar'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('admin_bar'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('admin_bar'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('admin_bar'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('admin_bar'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Disable admin bar') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('admin_bar'); ?>">
            <span><?php _e( 'Disable the admin bar for the front end. This is useful if you enabled dashboard display.' ); ?></span>
          </label>
        </div>
    </div> <!-- admin_bar -->

<?php 
?>
    <div class="pde-form-field pde-form-checkbox standard_pages">
        <div class="pde-form-title">
          <label for="<?php echo $this->get_field_id('standard_pages'); ?>">
            <span><?php esc_html_e( __('WP Login/Register Page') ); ?></span>
          </label>
        </div>
        <div class="pde-form-input">
          <input class="wp-pde-checkbox" id="<?php echo $this->get_field_id('standard_pages'); ?>"
            value="WP Login/Register Page"
            name="cb-<?php echo $this->get_field_name('standard_pages'); ?>"
            type="checkbox"<?php checked(isset($instance['standard_pages']) ? $instance['standard_pages'] : '', 'WP Login/Register Page'); ?> />
          <input id="txtcb-<?php echo $this->get_field_id('standard_pages'); ?>"
            value="WP Login/Register Page"
            name="<?php echo $this->get_field_name('standard_pages'); ?>"
            type="hidden" />
<script type="text/javascript">
(function($) {
  $('#<?php echo $this->get_field_id('standard_pages'); ?>').change(function(e) {
    if($(this).attr('checked'))
      $('#txtcb-<?php echo $this->get_field_id('standard_pages'); ?>').val($(this).val());
    else
      $('#txtcb-<?php echo $this->get_field_id('standard_pages'); ?>').val('');
  });
})(jQuery);
</script>
          <label for="<?php echo $this->get_field_id('standard_pages'); ?>">
          	<span class="pde-form-cb-label"><?php esc_html_e( __('Disable standard pages') ); ?></span>
          </label>
        </div>
        <div class="pde-form-description">
          <label for="<?php echo $this->get_field_id('standard_pages'); ?>">
            <span><?php _e( 'Disable wordpress login, register and lost password pages.' ); ?></span>
          </label>
        </div>
    </div> <!-- standard_pages -->

<?php 
    ?><div class="pde-form-field pde-form-markup markup-style-html"><?php
    submit_button( '', 'primary', 'submit', false, array( 'id' => 'id-submit' ) );
    ?></div><?php
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <hr/> 
      </div>

<?php 
?>
 
      <div class="pde-form-field pde-form-markup markup-style-html">
        <div class="pde-form-field pde-form-text scheme_name">
      <div class="pde-form-title">
        <label for="id_Yet_another_sliding_panel_v0_1_m_Options_scheme_name">
          <span>Scheme Name</span>
        </label>
      </div>
      <div class="pde-form-input">
        <input type="text" id="id_Yet_another_sliding_panel_v0_1_m_Options_scheme_name" name="scheme_name" value="">
      </div>
      <div class="pde-form-description">
        <label for="id_Yet_another_sliding_panel_v0_1_m_Options_scheme_name">
          <span>Enter a scheme name and press 'Save Scheme' button to save your scheme.</span>
        </label>
      </div>
    </div> 
      </div>

<?php 
    ?><div class="pde-form-field pde-form-markup markup-style-html"><?php
    submit_button( 'Save Scheme', 'secondary', 'save_scheme', false, array( 'id' => 'id-save_scheme' ) );
    ?></div><?php
    ?>
    <script type="text/javascript">
    (function($) {
      $(document).ready(function(e) {
        $('#id-save_scheme').bind('click', function(e) {
          $('#action').val('save_scheme');
          return true ;
        });
      });
    })(jQuery);
    </script>
    <?php
    $remove_scheme_name = $instance['remove_scheme_name'] ;
?>
    <div class="pde-form-field pde-form-dropdown remove_scheme_name">
      <div class="pde-form-title">
        <label for="<?php echo $this->get_field_id('remove_scheme_name'); ?>">
          <span><?php esc_html_e( __('Scheme') ); ?></span>
        </label>
      </div>
      <div class="pde-form-input">
        <select name="<?php echo $this->get_field_name('remove_scheme_name'); ?>" id="<?php echo $this->get_field_id('remove_scheme_name'); ?>">
<?php sliding_panel_dropdown_schemes( $instance['remove_scheme'], true ); ?>        </select>

      </div>

      <div class="pde-form-description">
        <label for="<?php echo $this->get_field_id('remove_scheme_name'); ?>">
          <span><?php _e( 'Select a scheme and click on Remove to delete it.' ); ?></span>
        </label>
      </div>
    </div> <!-- remove_scheme_name -->
<?php 
    ?><div class="pde-form-field pde-form-markup markup-style-html"><?php
    submit_button( 'Remove Scheme', 'delete', 'remove_scheme', false, array( 'id' => 'id-remove_scheme' ) );
    ?></div><?php
    ?>
    <script type="text/javascript">
    (function($) {
      $(document).ready(function(e) {
        $('#id-remove_scheme').bind('click', function(e) {
          $('#action').val('remove_scheme');
          return true ;
        });
      });
    })(jQuery);
    </script>
    <?php
    ?>
    </div>
    <?php
  }

  function save_post( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    if ( !isset( $_POST['Schemeable_Sliding_Panel_v1_0_m_Options_noncename']) || !wp_verify_nonce( $_POST['Schemeable_Sliding_Panel_v1_0_m_Options_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    $supported_post_types = array(
                          );
    if( !in_array( $_POST['post_type'], $supported_post_types ) )
      return ;

    // Check permissions
    if ( 'page' == $_POST['post_type'] ) 
    {
      if ( !current_user_can( 'edit_page', $post_id ) )
          return;
    }
    else
    {
      if ( !current_user_can( 'edit_post', $post_id ) )
          return;
    }

    $odefaults = array(
                 'content_display' => 'Overlay over Content',
                 'scheme' => 'Default (Black & White)',
                 'current_scheme' => '',
                 'hr_1' => '',
                 'preview' => 'Preview',
                 'admin_bar' => '',
                 'standard_pages' => '',
                 'save_changes_metabox' => '',
                 'hr_2' => '',
                 'scheme_name' => '',
                 'save_scheme' => '',
                 'remove_scheme_name' => '',
                 'remove_scheme' => '',
                );

    $odefaults = apply_filters('pde-meta-box-defaults-options', $odefaults);
    $defaults = array();
    foreach( $odefaults as $k => $v )
      $defaults[$this->get_field_name($k)] = $v ;

    $post_vars = shortcode_atts( $defaults, $_POST );

    $instance = array();
      $instance['content_display'] = $post_vars[$this->get_field_name('') . 'content_display'] ;
      $instance['scheme'] = $post_vars[$this->get_field_name('') . 'scheme'] ;
      $instance['current_scheme'] = $post_vars[$this->get_field_name('') . 'current_scheme'] ;
      $instance['hr_1'] = $post_vars[$this->get_field_name('') . 'hr_1'] ;
      $instance['preview'] = $post_vars[$this->get_field_name('') . 'preview'] ;
      $instance['admin_bar'] = $post_vars[$this->get_field_name('') . 'admin_bar'] ;
      $instance['standard_pages'] = $post_vars[$this->get_field_name('') . 'standard_pages'] ;
      $instance['save_changes_metabox'] = $post_vars[$this->get_field_name('') . 'save_changes_metabox'] ;
      $instance['hr_2'] = $post_vars[$this->get_field_name('') . 'hr_2'] ;
      $instance['scheme_name'] = $post_vars[$this->get_field_name('') . 'scheme_name'] ;
      $instance['save_scheme'] = $post_vars[$this->get_field_name('') . 'save_scheme'] ;
      $instance['remove_scheme_name'] = $post_vars[$this->get_field_name('') . 'remove_scheme_name'] ;
      $instance['remove_scheme'] = $post_vars[$this->get_field_name('') . 'remove_scheme'] ;
    update_post_meta( $post_id, 'options', $instance );
  }

  function save_menu_page( $data ) {

    $odefaults = array(
                 'content_display' => 'Overlay over Content',
                 'scheme' => 'Default (Black & White)',
                 'current_scheme' => '',
                 'hr_1' => '',
                 'preview' => 'Preview',
                 'admin_bar' => '',
                 'standard_pages' => '',
                 'save_changes_metabox' => '',
                 'hr_2' => '',
                 'scheme_name' => '',
                 'save_scheme' => '',
                 'remove_scheme_name' => '',
                 'remove_scheme' => '',
                );

    $odefaults = apply_filters('pde-meta-box-defaults-options', $odefaults);
    $defaults = array();
    foreach( $odefaults as $k => $v )
      $defaults[$this->get_field_name($k)] = $v ;

    $post_vars = shortcode_atts( $defaults, $_POST );

    $instance = array();
      $instance['content_display'] = $post_vars[$this->get_field_name('') . 'content_display'] ;
      $instance['scheme'] = $post_vars[$this->get_field_name('') . 'scheme'] ;
      $instance['current_scheme'] = $post_vars[$this->get_field_name('') . 'current_scheme'] ;
      $instance['hr_1'] = $post_vars[$this->get_field_name('') . 'hr_1'] ;
      $instance['preview'] = $post_vars[$this->get_field_name('') . 'preview'] ;
      $instance['admin_bar'] = $post_vars[$this->get_field_name('') . 'admin_bar'] ;
      $instance['standard_pages'] = $post_vars[$this->get_field_name('') . 'standard_pages'] ;
      $instance['save_changes_metabox'] = $post_vars[$this->get_field_name('') . 'save_changes_metabox'] ;
      $instance['hr_2'] = $post_vars[$this->get_field_name('') . 'hr_2'] ;
      $instance['scheme_name'] = $post_vars[$this->get_field_name('') . 'scheme_name'] ;
      $instance['save_scheme'] = $post_vars[$this->get_field_name('') . 'save_scheme'] ;
      $instance['remove_scheme_name'] = $post_vars[$this->get_field_name('') . 'remove_scheme_name'] ;
      $instance['remove_scheme'] = $post_vars[$this->get_field_name('') . 'remove_scheme'] ;
	  $data['options'] = $instance ;
    return $data ;
  }


  function __enqueue_css() {
     $file = 'pde-meta-box-default.css';
     $script_id = 'pde-meta-box-default' ;
     wp_enqueue_style( $script_id, plugins_url( $file, __FILE__ ) );
  }

}
if( is_admin( ) )
  add_action( 'admin_init', array( 'Schemeable_Sliding_Panel_v1_0_m_Options', 'setup' ) );
?>
