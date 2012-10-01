<?php

$uploads = wp_upload_dir();
define('SLIDING_PANEL_SCHEME_DIR',  $uploads['basedir'] . '/sliding-panel-schemes' );
define('SLIDING_PANEL_SCHEME_URL',  $uploads['baseurl'] . '/sliding-panel-schemes' );

function slidin_panel_Zip($source, $destination, $prefix='') {
    global $messages ;
    if (!extension_loaded('zip') || !file_exists($source)) {
        $messages[] = array( 'error', 'Zip extension not loaded') ;
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE)) {
        $messages[] = array( 'error', 'Unable to create zip archive ' . $destination) ;
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if( !empty( $prefix ) ) {
      $zip->addEmptyDir($prefix . '/');
    }

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            if( basename($file) == '.' || basename($file) == '..' )
              continue ;
            $file = str_replace('\\', '/', realpath($file));

            if (is_dir($file) === true) {
                $zip->addEmptyDir( $prefix . '/' . str_replace($source . '/', '', $file . '/'));
            } else if (is_file($file) === true) {
                $zip->addFromString( $prefix . '/' . str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    } else if (is_file($source) === true) {
        $zip->addFromString( $prefix . '/' . basename($source), file_get_contents($source));
    }

    if( !$zip->close() ) {
        $messages[] = array( 'error', 'Unable to create zip archive ' . $destination) ;
        return false ;
    }
    $wupl = wp_upload_dir();
    return $wupl['baseurl'] . str_replace( $wupl['basedir'], '', $destination) ;
}

function collect_images( $img_url, &$images, $dir ) {
  $upl = wp_upload_dir() ;
  if( !empty( $img_url ) && !isset( $images[$img_url] ) ) {
    if( strpos( $img_url, $upl['baseurl'] ) === 0 )
      $src = $upl['basedir'] . str_replace( $upl['baseurl'], '', $img_url );
    else
      $src = '';
    $base = basename( $img_url ) ;
    foreach( $images as $k => $v ) {
      if( $base == $v[2] ) {
        $prefix = 'a' ;
        $base = $prefix.md5(time().rand()) . '-' . $base ;
      }
    }
    $dest = $dir . '/images/' . $base ;
    $images[$img_url] = array( $src, $dest, $base );
  }
}

function scheme_rmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") scheme_rmdir($dir."/".$object); else unlink($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
}

function remove_scheme( $scheme_name ) {
  global $messages ;

  $file = strtolower(SLIDING_PANEL_SCHEME_DIR . '/' . sanitize_file_name( $scheme_name ) . '.php') ;
  if( !unlink( $file ) ) {
    $messages[] = array( 'error', 'Could not remove scheme ' . $scheme_name );
    return ;
  }
  $messages[] = array( 'updated fade', 'Removed scheme ' . $scheme_name );
  $method_name = str_replace( '-', '_', sanitize_title_with_dashes( $scheme_name ) ) ;
  remove_filter( 'sliding-panel-schemes', $method_name . '_local' );
  global $sliding_panel_schemes ;
  $sliding_panel_schemes = '';
}

function export_scheme( $scheme_name ) {
  $dir = strtolower(SLIDING_PANEL_SCHEME_DIR . '/' . sanitize_file_name( $scheme_name )) ;
  $file = $dir . '/' . strtolower(sanitize_file_name( $scheme_name )) . '.php' ;
  $scheme = get_scheme( $scheme_name ) ;
  if( empty( $scheme ) ) {
    $messages[] = array( 'error', 'Could not find scheme ' . $scheme_name );
    return ;
  }
  $method_name = str_replace( '-', '_', sanitize_title_with_dashes( $scheme_name ) ) ;
  $images = array();

  collect_images( $scheme['panel_background'], $images , $dir);
  collect_images( $scheme['content_background'], $images , $dir);
  if( !empty( $scheme['other_images'] ) ) {
    foreach( $scheme['other_images'] as $img_url ) {
      collect_images( $img_url, $images , $dir);
    }
  }
  /* Tab images if they exist */

  if( empty($scheme['tab_images']) )
    foreach( array( 'tab_b', 'tab_l', 'tab_m', 'tab_r' ) as $tab )
      collect_images( sliding_panel_get_url( $tab ), $images, $dir );

  pde_fb('exporting ' . $scheme_name );
  pde_fb('dir ' . $dir );
  pde_fb('scheme file ' . $file );
  pde_fb('method name ' . $method_name );
  pde_fb($images);

  scheme_rmdir( $dir );
  global $messages ;
  if( !@mkdir( $dir . '/images', 0777, true ) ) {
    $messages[] = array( 'error', 'Unable to create folder ' . $dir );
    return false;
  }
  if( !empty( $scheme['panel_background'] ) )
    $panel_background = "plugins_url('images/" . $images[$scheme['panel_background']][2] . "', __FILE__ )" ;
  if( !empty( $scheme['content_background'] ) )
    $content_background = "plugins_url('images/" . $images[$scheme['content_background']][2] . "', __FILE__ )" ;
  unset($scheme['panel_background']);
  unset($scheme['content_background']);
  if( !empty( $scheme['other_images'] ) ) {
    $extra_css = var_export($scheme['extra_css'], true) ;
    $other_images = array();
    for( $i = 0; $i < count($scheme['other_images']); $i++ ) {
      $img_url = $scheme['other_images'][$i] ;
      if( empty( $img_url ) )
        continue ;
      $other_images[$i] = "plugins_url('images/" . $images[$img_url][2] . "', __FILE__ )" ;
      $extra_css = str_replace( $img_url, "' . plugins_url('images/" . $images[$img_url][2] . "', __FILE__ ) . '", $extra_css );
    }
  }
  unset( $scheme['extra_css'] );
  unset( $scheme['other_images'] );

  pde_fb($scheme);
  ob_start();
  include 'templates/sliding-panel-scheme-export.php.php' ;
  if( @file_put_contents( $file, str_replace( '@>', '?>', str_replace( '<@php', '<?php', ob_get_clean() ) ) ) === false ) {
    $messages[] = array( 'error', 'Unable to save the file ' . $file );
    return false ;
  }
  foreach( $images as $img_url => $data ) {
    pde_fb('Copying from ' . $data[0] . ' to ' . $data[1] );
    if( !empty( $data[0] ) )
      file_put_contents( $data[1], file_get_contents( $data[0] ) );
    else {
      pde_fb('Using wp_remote_get');
      wp_remote_get( $img_url, array( 'timeout' => 300, 'stream' => true, 'filename' => $data[1] ) );
    }
  }
  $prefix = strtolower( sanitize_file_name( $scheme_name ) ) ;
  $zipfile = SLIDING_PANEL_SCHEME_DIR . '/' . $prefix . '.zip' ;
  return slidin_panel_Zip($dir, $zipfile, $prefix) ;
}

function save_scheme($scheme_name, $sop) {
  global $messages ;
  $schemes = get_schemes() ;
  if( isset( $schemes[$scheme_name] ) ) {
      $s = $schemes[$scheme_name] ;
      if( !empty( $s['default'] ) ) {
        $messages[] = array( 'error', 'Scheme name <b>' . $scheme_name . '</b> already taken by a default scheme. Choose another' );
        return false ;
      }
      if( !empty( $s['external'] ) ) {
        $messages[] = array( 'error', 'Scheme name <b>' . $scheme_name . '</b> already taken by a plugin scheme. Choose another' );
        return false ;
      }
  }
  if( !is_dir( SLIDING_PANEL_SCHEME_DIR ) )
    if( !@mkdir( SLIDING_PANEL_SCHEME_DIR ) ) {
      $messages[] = array( 'error', 'Unable to create folder ' . SLIDING_PANEL_SCHEME_DIR );
      return false ;
    }
    else
      $messages[] = array( 'updated fade', 'Created new folder ' . SLIDING_PANEL_SCHEME_DIR );
  $file = strtolower(SLIDING_PANEL_SCHEME_DIR . '/' . sanitize_file_name( $scheme_name ) . '.php') ;
  $update = file_exists( $file );
  $scheme = array() ;
  $keys = get_sliding_panel_scheme_keys();
  foreach( $keys as $key )
    $scheme[$key] = $sop[$key] ;
  $method_name = str_replace( '-', '_', sanitize_title_with_dashes( $scheme_name ) ) ;
  ob_start();
  include 'templates/sliding-panel-scheme.php.php' ;
  if( @file_put_contents( $file, str_replace( '@>', '?>', str_replace( '<@php', '<?php', ob_get_clean() ) ) ) === false ) {
    $messages[] = array( 'error', 'Unable to save the file ' . $file );
    return false ;
  }
  if( !$update ) {
    pde_fb('Including file ' . $file );
    include_once $file ;
    global $sliding_panel_schemes ;
    $sliding_panel_schemes = '';
  }
  $messages[] = array( 'updated fade', 'Scheme saved to ' . $file );
  return true ;
}

function &get_schemes() {
  global $sliding_panel_schemes ;
  if(empty($sliding_panel_schemes)) {
    $sliding_panel_schemes = apply_filters( 'sliding-panel-schemes', array() ) ;
    $plugin_schemes = apply_filters( 'sliding-panel-plugin-schemes', array() ) ;
    $pschemes = array() ;
    pde_fb('Loaded plugin schemes');
    pde_fb($plugin_schemes);
    foreach( $plugin_schemes as $pk => $ps ) {
      if( array_key_exists( $pk, $sliding_panel_schemes ) )
        $pschemes[$pk . ' (Plugin)'] = $ps ;
      else
        $pschemes[$pk] = $ps ;
    }
    pde_fb($pschemes);
    $sliding_panel_schemes = array_merge( $sliding_panel_schemes, $pschemes ) ;
  }
  return $sliding_panel_schemes ;
}

function sliding_panel_dropdown_schemes( $selected, $custom = false ) {
  $sliding_panel_schemes = get_schemes();

	$p = '';
	$r = '';

	foreach ( $sliding_panel_schemes as $name => $data ) {
    if( $custom && ( !empty( $data['default'] ) || !empty( $data['external'] ) ) )
      continue ;
		if ( $selected == $name ) // preselect specified role
			$p = "\n\t<option selected='selected' value='" . esc_attr($name) . "'>$name</option>";
		else
			$r .= "\n\t<option value='" . esc_attr($name) . "'>$name</option>";
	}
	echo $p . $r;
}

function load_scheme_files() {
  $files = @scandir( SLIDING_PANEL_SCHEME_DIR );

  if( empty( $files ) )
    return ;
  foreach( $files as $file ) {
    $ext = pathinfo( $file, PATHINFO_EXTENSION );
    if( $ext == 'php' )
      include SLIDING_PANEL_SCHEME_DIR . '/' . $file ;
  }
}

function get_scheme( $name ) {
  $schemes = get_schemes() ;
  return $schemes[$name] ;
}

load_scheme_files();
?>
