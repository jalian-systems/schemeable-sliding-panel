<?php
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

  function sliding_panel_show_dashboard($display_tab = 1) {
global $menu, $submenu;
    $sop = get_option('sliding-panel-options') ;
    $show_dashboard = empty($sop['do_not_show_dashboard']) && is_user_logged_in();
    $all_roles = $sop['show_dashboard'];
    if( !$all_roles )
      $all_roles = array();
    $roles = array();
    foreach( $all_roles as $role )
      if( get_role( $role ) )
        $roles[] = $role ;
    if($show_dashboard && count($roles) > 0) {
      $show = false ;
      foreach( $roles as $role ) {
        global $current_user ;
        if( in_array($role, $current_user->roles) ) {
          $show = true ;
          break ;
        }
      }
      $show_dashboard = $show ;
    }
    if(!empty($sop['tab_close_panel']))
      $tab_close_panel = $sop['tab_close_panel'] ;
    else
      $tab_close_panel = 'Close Panel' ;
    if(!empty($sop['tab_dashboard_open_link']))
      $tab_dashboard_open_link = $sop['tab_dashboard_open_link'] ;
    else
      $tab_dashboard_open_link = 'Show Dashboard' ;
?>
<div id="sliding-panel">
  <div id="panel">
    <div class="content clearfix">
<?php
    if($show_dashboard) {
      if(!isset($menu)) {
        $menus = get_option('sliding-panel-dashboard-menus') ;
      } else {
        $menus = collect_admin_menu($menu, $submenu, false);
        update_option('sliding-panel-dashboard-menus', $menus) ;
      }
      if(empty($menus)) {
        ?><center><h1>Dashboard is not populated. Please visit the plugin page to populate the dashboard content</h1></center><?php
      } else {
        sliding_panel_show_system_dashboard($sop, $menus);
      }
    } else {
      echo do_shortcode($sop['dashboard_message']);
    }
?>
    </div>
  </div> <!-- /login -->

<?php if($display_tab): ?>
    <!-- The tab on top -->
  <div class="tab">
    <ul class="login">
      <li class="left">&nbsp;</li>
<?php if(is_user_logged_in()): ?>
      <!-- Logout -->
      <li><a href="<?php echo wp_logout_url(get_permalink()); ?>" rel="nofollow" title="<?php _e('Log out'); ?>"><?php _e('Log out'); ?></a></li>
      <li class="sep">|</li>
<?php endif; ?>
      <li id="toggle">
        <a id="open" class="open" href="#"><?php echo do_shortcode($tab_dashboard_open_link); ?></a>
        <a id="close" style="display: none;" class="close" href="#"><?php echo do_shortcode($tab_close_panel); ?></a>
      </li>
      <li class="right">&nbsp;</li>
    </ul>
  </div> <!-- / top -->
<?php endif; ?>
</div> <!--END panel -->
<?php
  }


  function sliding_panel_show_system_dashboard($sop, $menus) {
    
    if(!empty($sop['dashboard_welcome_message']))
      $dashboard_welcome_message = $sop['dashboard_welcome_message'] ;
    else
      $dashboard_welcome_message = '<h1>Welcome back [user_identity]</h1>' ;
    $first = true ;
    $max = calculate_opt_max($menus);
    $incol = 0 ;
    $need_div_closure = false ;
    foreach( $menus as $menu ) {
      if($first) {
        $first = false ;
        ?><div class="left"><?php
        echo do_shortcode($dashboard_welcome_message);
        sliding_panel_print_menu($menu);
        ?></div><?php
        continue ;
      } else {
        $inmenu = sliding_panel_menu_count($menu);
        if($inmenu == 0)
          continue ;
        if( $incol + $inmenu > $max ) {
          ?></div><?php
          $incol = 0 ;
        }
        if( $incol == 0 ) {
          ?><div class="left narrow"><?php
          $need_div_closure = true ;
        }
        sliding_panel_print_menu($menu);
        $incol += $inmenu ;
      }
    }
        if($need_div_closure) {
          ?></div><?php
        }
  }

  function sliding_panel_menu_count($menu) {
    if( current_user_can( $menu['cap'] ) && !isset($menu['submenu'])) {
      return 1 ;
    }
    if( !isset( $menu['submenu'] ) )
      return 0 ;
    $n = 0 ;
    foreach( $menu['submenu'] as $submenu ) {
      if( !current_user_can( $submenu['cap'] ) )
        continue ;
      $n++ ;
    }
    if( $n > 0 )
      return $n + 1 ;
    return 0 ;
  }

  function sliding_panel_print_menu($menu) {
    if( current_user_can( $menu['cap'] ) && !isset($menu['submenu'])) {
      ?><h2><a href="<?php echo $menu['href']; ?>"><?php echo $menu['title']; ?></a></h2><?php
      return ;
    } else if ( isset( $menu['submenu'] ) ) {
      ?><h2><?php echo $menu['title']; ?></h2><?php
      ?><ul><?php
      foreach( $menu['submenu'] as $submenu ) {
        if( !current_user_can( $submenu['cap'] ) )
          continue ;
        ?><li><a href="<?php echo $submenu['href']; ?>"><?php echo $submenu['title']; ?></a></li><?php
      }
      ?></ul><?php
    }
  }

  function calculate_opt_max($menus) {
    $min = 0 ;
    foreach($menus as $menu) {
      $min = max( $min, sliding_panel_menu_count($menu) );
    }
    for(; true ; $min++) {
      $col = 1 ;
      $incol = 0 ;
      $first = true ;
      foreach( $menus as $menu ) {
        if($first) {
          $first = false ;
          continue ;
        }
        $inmenu = sliding_panel_menu_count($menu);
        if($incol + $inmenu > $min) {
          $col++ ;
          $incol = 0 ;
        }
        $incol += $inmenu ;
      }
      if($col <= 4)
        return $min;
    }
  }


  function sliding_panel_show_login($display_tab = 1) {
    $sop = get_option('sliding-panel-options') ;
    if( !empty( $sop['login_panel'] ) ) {
      sliding_panel_show_dashboard( $display_tab );
      return ;
    }
    if(!empty($sop['welcome_message']))
      $welcome_message = $sop['welcome_message'] ;
    else
      $welcome_message = '<h1>Welcome to ' . get_bloginfo('name') . '</h1>' ;
    
    if(!empty($sop['social_login_introduction']))
      $social_login_introduction = $sop['social_login_introduction'] ;
    else
      $social_login_introduction = '<h1>Login with OpenID</h1><p>OpenID allows you to use an existing account to sign in to multiple websites, without needing to create new passwords. <a href="http://openid.net/what">Learn more</a>.</p>' ;

    if( !get_option('users_can_register') ) {
      if( empty( $sop['registration_message'] ) )
        $registration_message = '<h1>Registration is closed</h1><p>Sorry, you are not allowed to register by yourself on this site!</p><p>You must either be invited by one of our team member or request an invitation by emailing the site administrator at <a href="mailto:' . get_option('admin_email') . '">' . esc_html(get_option('admin_email')) . '</a>.</p>' ;
      else
        $registration_message = $sop['registration_message'] ;
    }

    if(!empty($sop['heading_login']))
      $heading_login = $sop['heading_login'] ;
    else
      $heading_login = 'Login with Local Account' ;

    if(!empty($sop['heading_register']))
      $heading_register = $sop['heading_register'] ;
    else
      $heading_register = 'Register for a Local Account' ;

    if(!empty($sop['heading_lostpwd']))
      $heading_lostpwd = $sop['heading_lostpwd'] ;
    else
      $heading_lostpwd = 'Lost Password' ;

    if(!empty($sop['tab_login_link']))
      $tab_login_link = $sop['tab_login_link'] ;
    else
      $tab_login_link = 'Login | Register' ;

    if(!empty($sop['tab_close_panel']))
      $tab_close_panel = $sop['tab_close_panel'] ;
    else
      $tab_close_panel = 'Close Panel' ;
?>
<div id="sliding-panel">
  <div id="panel">
    <div class="content clearfix">
      <div class="left">
<?php if(has_action('wordpress_social_login') && (!isset($sop['use_social_login']) || !empty($sop['use_social_login']))): ?>
        <?php echo do_shortcode($social_login_introduction); ?>
        <?php do_action( 'wordpress_social_login' ); ?>
<?php else: ?>
        <?php echo do_shortcode($welcome_message); ?>
<?php endif; ?>
      </div>
      <div class="left" id="login-form">
        <!-- Login Form -->
        <form class="clearfix" action="<?php echo esc_url( site_url( 'wp-login.php?sliding-panel=true', 'login_post' ) ); ?>" method="post" id="loginform">
          <h1><?php echo do_shortcode($heading_login); ?></h1>
          <label for="log">Username:</label>
          <input class="field" type="text" name="log" id="log" value="" size="23" />
          <label for="pwd">Password:</label>
          <input class="field" type="password" name="pwd" id="pwd" size="23" /><br/>
                <label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> Remember me</label>
          <input id="submit" type="submit" name="submit" value="Login" class="bt_login"/>
          <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
          <a class="lost-pwd" id="lost-pwd" href="#">Lost your password?</a>
        </form>
                <br class="clear"/>
                <div id="login-message">&nbsp;</div>
      </div>
        <div class="left" id="lostpassword-form" style="display:none;">
        <!-- Login Form -->
        <form class="clearfix" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword&sliding-panel=true', 'login_post' ) ); ?>" method="post" id="lostpasswordform">
          <h1><?php echo do_shortcode($heading_lostpwd); ?></h1>
                    <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
                    <label for="log">Username or E-mail:</label>
          <input class="field" type="text" name="name_email" id="name_email" value="" size="23" />
              <div class="clear"></div>
          <input id="lost-submit" type="submit" name="lost-submit" value="Submit" class="bt_lostpwd" />
          <a class="lost-pwd" id="login-again" href="#">Login</a>
        </form>
                <div id="lostpwd-message">&nbsp;</div>
      </div>
      <div class="left right" id="register-form">
      <?php if (get_option('users_can_register')) : ?>
        <!-- Register Form -->
        <form class="clearfix" name="registerform" id="registerform" action="<?php echo esc_url( site_url('wp-login.php?action=register&sliding-panel=true', 'login_post') ); ?>" method="post">
          <h1><?php echo do_shortcode($heading_register); ?></h1>
          <label for="user_login"><?php _e('Username:') ?></label>
          <input class="field" type="text" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10" />
          <label for="user_email"><?php _e('E-mail:') ?></label>
          <input class="field" type="text" name="user_email" id="user_email" class="input" value="" size="25" tabindex="20" />
                  <label>A password will be mailed to you.</label>
          <input type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Register'); ?>" class="bt_register" />
        </form>
                <br class="clear"/>
                <div id="register-message">&nbsp;</div>
      <?php else : 
        echo do_shortcode( $registration_message ); ?>
      <?php endif ?>
      </div>
    </div>
  </div> <!-- /login -->

<?php if($display_tab): ?>
    <!-- The tab on top -->
  <div class="tab">
    <ul class="login">
        <li class="left">&nbsp;</li>
        <!-- Login / Register -->
      <li id="toggle">
        <a id="open" class="open" href="#"><?php echo do_shortcode($tab_login_link); ?></a>
        <a id="close" style="display: none;" class="close" href="#"><?php echo do_shortcode($tab_close_panel); ?></a>
      </li>
        <li class="right">&nbsp;</li>
    </ul>
  </div> <!-- / top -->
<?php endif; ?>
</div> <!--END panel -->
<?php
  }

  function show_sliding_panel() {
    global $user_identity, $user_ID;
    // If user is logged in or registered, show dashboard links in panel
    $force_login = false ;
    if( isset( $_GET['instrument'] ) && $_GET['instrument'] == 'login' )
      $force_login = true ;
    if (is_user_logged_in() && !$force_login ) {
      sliding_panel_show_dashboard();
    } else {
      sliding_panel_show_login();
    }
  }

  function sliding_panel_user_identity($atts, $content = '') {
    global $user_identity;
    return $user_identity ;
  }
  add_shortcode('user_identity', 'sliding_panel_user_identity');

  function collect_admin_menu( $menu, $submenu, $submenu_as_parent = true ) {
    global $self, $parent_file, $submenu_file, $plugin_page, $pagenow, $typenow;

    $menu_items = array() ;
    $first = true;
    // 0 = name, 1 = capability, 2 = file, 3 = class, 4 = id, 5 = icon src
    foreach ( $menu as $key => $item ) {
      $menu_item = array() ;
      $admin_is_parent = false;
      $class = array();
      $aria_attributes = 'tabindex="1"';

      if ( $first ) {
        $class[] = 'wp-first-item';
        $first = false;
      }

      $submenu_items = false;
      if ( ! empty( $submenu[$item[2]] ) ) {
        $class[] = 'wp-has-submenu';
        $submenu_items = $submenu[$item[2]];
      }

      if ( ( $parent_file && $item[2] == $parent_file ) || ( empty($typenow) && $self == $item[2] ) ) {
        $class[] = ! empty( $submenu_items ) ? 'wp-has-current-submenu wp-menu-open' : 'current';
      } else {
        $class[] = 'wp-not-current-submenu';
        if ( ! empty( $submenu_items ) )
          $aria_attributes .= ' aria-haspopup="true"';
      }

      if ( ! empty( $item[4] ) )
        $class[] = $item[4];

      $class = $class ? ' class="' . join( ' ', $class ) . '"' : '';
      $id = ! empty( $item[5] ) ? ' id="' . preg_replace( '|[^a-zA-Z0-9_:.]|', '-', $item[5] ) . '"' : '';
      $img = '';
      if ( ! empty( $item[6] ) )
        $img = ( 'div' === $item[6] ) ? '<br />' : '<img src="' . $item[6] . '" alt="" />';
      $arrow = '<div class="wp-menu-arrow"><div></div></div>';

      $title = wptexturize( $item[0] );
      $aria_label = esc_attr( strip_tags( $item[0] ) ); // strip the comment/plugins/updates bubbles spans but keep the pending number if any

      if ( false !== strpos( $class, 'wp-menu-separator' ) ) {
        continue ;
      } elseif ( $submenu_as_parent && ! empty( $submenu_items ) ) {
        $submenu_items = array_values( $submenu_items );  // Re-index.
        $menu_hook = get_plugin_page_hook( $submenu_items[0][2], $item[2] );
        $menu_file = $submenu_items[0][2];
        if ( false !== ( $pos = strpos( $menu_file, '?' ) ) )
          $menu_file = substr( $menu_file, 0, $pos );
        if ( ! empty( $menu_hook ) || ( ('index.php' != $submenu_items[0][2]) && file_exists( WP_PLUGIN_DIR . "/$menu_file" ) ) ) {
          $admin_is_parent = true;
          $menu_item['title'] = $title ;
          $menu_item['href'] = admin_url("admin.php?page={$submenu_items[0][2]}") ;
          $menu_item['cap'] = $submenu_items[0][1] ;
        } else {
          $menu_item['title'] = $title ;
          $menu_item['href'] = admin_url($submenu_items[0][2]) ;
          $menu_item['cap'] = $submenu_items[0][1] ;
        }
      } elseif ( ! empty( $item[2] ) ) {
        $menu_hook = get_plugin_page_hook( $item[2], 'admin.php' );
        $menu_file = $item[2];
        if ( false !== ( $pos = strpos( $menu_file, '?' ) ) )
          $menu_file = substr( $menu_file, 0, $pos );
        if ( ! empty( $menu_hook ) || ( ('index.php' != $item[2]) && file_exists( WP_PLUGIN_DIR . "/$menu_file" ) ) ) {
          $admin_is_parent = true;

          $menu_item['title'] = $item[0] ;
          $menu_item['href'] = admin_url("admin.php?page={$item[2]}") ;
          $menu_item['cap'] = $item[1];
        } else {
          $menu_item['title'] = $item[0] ;
          $menu_item['href'] = admin_url($item[2]);
          $menu_item['cap'] = $item[1];
        }
      }

      if ( ! empty( $submenu_items ) ) {
        $mysubmenu_items = array() ;
        $first = true;
        foreach ( $submenu_items as $sub_key => $sub_item ) {
          $submenu_item = array() ;

          $aria_attributes = 'tabindex="1"';
          $class = array();
          if ( $first ) {
            $class[] = 'wp-first-item';
            $first = false;
          }

          $menu_file = $item[2];

          if ( false !== ( $pos = strpos( $menu_file, '?' ) ) )
            $menu_file = substr( $menu_file, 0, $pos );

          // Handle current for post_type=post|page|foo pages, which won't match $self.
          $self_type = ! empty( $typenow ) ? $self . '?post_type=' . $typenow : 'nothing';

          if ( isset( $submenu_file ) ) {
            if ( $submenu_file == $sub_item[2] )
              $class[] = 'current';
          // If plugin_page is set the parent must either match the current page or not physically exist.
          // This allows plugin pages with the same hook to exist under different parents.
          } else if (
            ( ! isset( $plugin_page ) && $self == $sub_item[2] ) ||
            ( isset( $plugin_page ) && $plugin_page == $sub_item[2] && ( $item[2] == $self_type || $item[2] == $self || file_exists($menu_file) === false ) )
          ) {
            $class[] = 'current';
          }

          $class = $class ? ' class="' . join( ' ', $class ) . '"' : '';

          $menu_hook = get_plugin_page_hook($sub_item[2], $item[2]);
          $sub_file = $sub_item[2];
          if ( false !== ( $pos = strpos( $sub_file, '?' ) ) )
            $sub_file = substr($sub_file, 0, $pos);

          $title = wptexturize($sub_item[0]);

          if ( ! empty( $menu_hook ) || ( ('index.php' != $sub_item[2]) && file_exists( WP_PLUGIN_DIR . "/$sub_file" ) ) ) {
            // If admin.php is the current page or if the parent exists as a file in the plugins or admin dir
            if ( (!$admin_is_parent && file_exists(WP_PLUGIN_DIR . "/$menu_file") && !is_dir(WP_PLUGIN_DIR . "/{$item[2]}")) || file_exists($menu_file) )
              $sub_item_url = add_query_arg( array('page' => $sub_item[2]), $item[2] );
            else
              $sub_item_url = add_query_arg( array('page' => $sub_item[2]), 'admin.php' );

            $sub_item_url = esc_url( $sub_item_url );
            $submenu_item['title'] = $title ;
            $submenu_item['href'] = admin_url($sub_item_url) ;
            $submenu_item['cap'] = $sub_item[1];
          } else {
            $submenu_item['title'] = $title ;
            $submenu_item['href'] = admin_url($sub_item[2]) ;
            $submenu_item['cap'] = $sub_item[1];
          }
          $mysubmenu_items[] = $submenu_item;
        }
        $menu_item['submenu'] = $mysubmenu_items;
      }
      $menu_items[] = $menu_item ;
    }

    return $menu_items ;
  }

  $sop = get_option('sliding-panel-options');
  if(!empty($sop['options']['admin_bar'])) {
    show_admin_bar(false);
  }


function thickbox_fields($form_fields, $post){
    unset(
       $form_fields['post_title'], //disables "Title" field and so forth...
       $form_fields['url'],
       $form_fields['image_alt'], 
       $form_fields['post_excerpt'], 
       $form_fields['post_content'], 
       $form_fields['align'], 
       $form_fields['image-size']
    );

    pde_fb('Filter called');
    pde_fb($form_fields);
    return $form_fields;
}

function thickbox_upload_init(){
    pde_fb('Adding filter');
    add_filter('attachment_fields_to_edit', 'thickbox_fields', 10, 2);
}
  
  ?>
