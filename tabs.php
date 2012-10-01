<?php
function sliding_panel_imagefillroundedrect($im,$x,$y,$cx,$cy,$rad,$col, $tl = true, $tr = true, $br = true, $bl = true)
{

// Draw the middle cross shape of the rectangle

    imagefilledrectangle($im,$x,$y+$rad,$cx,$cy-$rad,$col);
    imagefilledrectangle($im,$x+$rad,$y,$cx-$rad,$cy,$col);
    $dia = $rad*2;

// Now fill in the rounded corners


    if( $tl )
        imagefilledellipse($im, $x+$rad, $y+$rad, $rad*2, $dia, $col);
    else
        imagefilledrectangle($im, $x, $y, $x + $dia, $y + $dia, $col);
    if( $tr)
        imagefilledellipse($im, $cx-$rad, $y+$rad, $rad*2, $dia, $col);
    else
        imagefilledrectangle($im, $cx-$dia, $y, $cx, $y + $dia, $col);
    if( $br )
        imagefilledellipse($im, $cx-$rad, $cy-$rad, $rad*2, $dia, $col);
    else
        imagefilledrectangle($im, $cx-$dia, $cy-$dia, $cx, $cy, $col);
    if( $bl )
        imagefilledellipse($im, $x+$rad, $cy-$rad, $rad*2, $dia, $col);
    else
        imagefilledrectangle($im, $x, $cy-$dia, $x+$dia, $cy, $col);
}

function sliding_panel_html2rgb($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

function sliding_panel_create_tab_b( $file ) {
  $width = 6 ;
  $height = 42 ;

  if( !is_dir( dirname( $file ) ) )
    mkdir( dirname( $file ), 0755, true );
  global $sliding_panel_options;
  $bg = $sliding_panel_options['tab_background_color'];
  $border = $sliding_panel_options['tab_border_color'];

  $image = imagecreatetruecolor($width, $height);
  $black = imagecolorallocate( $image, 0, 0, 0 );
  imagecolortransparent( $image, $black );
  imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $black);

  list( $r, $g, $b ) = sliding_panel_html2rgb( $border );
  $border_color = imagecolorallocate( $image, $r, $g, $b ) ;
  imagefilledrectangle( $image, 0, 0, 6, 7, $border_color );
  list( $r, $g, $b ) = sliding_panel_html2rgb( $bg ) ;
  $bg_color = imagecolorallocate( $image, $r, $g, $b ) ;
  imagefilledrectangle( $image, 0, 0, 6, 5, $bg_color );
  $wupl = wp_upload_dir();
  imagepng( $image, $file );
  imagedestroy( $image );
}

function sliding_panel_create_tab_l( $file ) {
  $o_width = 30 ;
  $o_height = 42 ;
  $o_rad = 10 ;

  $width = $o_width * 10 ;
  $height = $o_height * 10 ;
  $rad = $o_rad * 10 ;

  if( !is_dir( dirname( $file ) ) )
    mkdir( dirname( $file ), 0755, true );
  global $sliding_panel_options;
  $bg = $sliding_panel_options['tab_background_color'];
  $border = $sliding_panel_options['tab_border_color'];

  $image = imagecreatetruecolor($width, $height);
  $alpha = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
  imagealphablending( $image, false );
  imagesavealpha( $image, true );
  imagecolortransparent( $image, $alpha );
  imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $alpha);

  list( $r, $g, $b ) = sliding_panel_html2rgb( $border );
  $border_color = imagecolorallocate( $image, $r, $g, $b ) ;
  sliding_panel_imagefillroundedrect( $image, 0, 60, 300, 370, $rad, $border_color, false, false, false, true );
  list( $r, $g, $b ) = sliding_panel_html2rgb( $bg ) ;
  $bg_color = imagecolorallocate( $image, $r, $g, $b ) ;
  sliding_panel_imagefillroundedrect( $image, 20, 60, 300, 350, $rad, $bg_color, false, false, false, true );
  imagefilledrectangle($image, 0, 0, 300, 60, $bg_color);

  $r = imagecreatetruecolor($o_width, $o_height) ;
  $alpha = imagecolorallocatealpha( $r, 0, 0, 0, 127 );
  imagealphablending( $r, false );
  imagesavealpha( $r, true );
  imagecolortransparent( $r, $alpha );
  imagefilledrectangle($r, 0, 0, imagesx($r), imagesy($r), $alpha);

  imagecopyresampled( $r, $image, 0, 0, 0, 0, $o_width, $o_height, $width, $height );
  imagedestroy( $image );
  imagepng( $r, $file );
  imagedestroy( $r );
}

function sliding_panel_create_tab_r( $file ) {
  $o_width = 30 ;
  $o_height = 42 ;
  $o_rad = 10 ;

  $width = $o_width * 10 ;
  $height = $o_height * 10 ;
  $rad = $o_rad * 10 ;

  if( !is_dir( dirname( $file ) ) )
    mkdir( dirname( $file ), 0755, true );
  global $sliding_panel_options;
  $bg = $sliding_panel_options['tab_background_color'];
  $border = $sliding_panel_options['tab_border_color'];

  $image = imagecreatetruecolor($width, $height);
  $alpha = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
  imagealphablending( $image, false );
  imagesavealpha( $image, true );
  imagecolortransparent( $image, $alpha );
  imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $alpha);

  list( $r, $g, $b ) = sliding_panel_html2rgb( $border );
  $border_color = imagecolorallocate( $image, $r, $g, $b ) ;
  sliding_panel_imagefillroundedrect( $image, 0, 60, 300, 370, $rad, $border_color, false, false, true, false );
  list( $r, $g, $b ) = sliding_panel_html2rgb( $bg ) ;
  $bg_color = imagecolorallocate( $image, $r, $g, $b ) ;
  sliding_panel_imagefillroundedrect( $image, 0, 60, 280, 350, $rad, $bg_color, false, false, true, false );
  imagefilledrectangle($image, 0, 0, 300, 60, $bg_color);

  $r = imagecreatetruecolor($o_width, $o_height) ;
  $alpha = imagecolorallocatealpha( $r, 0, 0, 0, 127 );
  imagealphablending( $r, false );
  imagesavealpha( $r, true );
  imagecolortransparent( $r, $alpha );
  imagefilledrectangle($r, 0, 0, imagesx($r), imagesy($r), $alpha);

  imagecopyresampled( $r, $image, 0, 0, 0, 0, $o_width, $o_height, $width, $height );
  imagedestroy( $image );
  imagepng( $r, $file );
  imagedestroy( $r );
}

function sliding_panel_create_tab_m( $file ) {
  $width = 6 ;
  $height = 42 ;

  if( !is_dir( dirname( $file ) ) )
    mkdir( dirname( $file ), 0755, true );
  global $sliding_panel_options;
  $bg = $sliding_panel_options['tab_background_color'];
  $border = $sliding_panel_options['tab_border_color'];

  $image = imagecreatetruecolor($width, $height);
  $black = imagecolorallocate( $image, 0, 0, 0 );
  imagecolortransparent( $image, $black );
  imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), $black);

  list( $r, $g, $b ) = sliding_panel_html2rgb( $border );
  $border_color = imagecolorallocate( $image, $r, $g, $b ) ;
  imagefilledrectangle( $image, 0, 0, 6, 36, $border_color );
  list( $r, $g, $b ) = sliding_panel_html2rgb( $bg ) ;
  $bg_color = imagecolorallocate( $image, $r, $g, $b ) ;
  imagefilledrectangle( $image, 0, 0, 6, 34, $bg_color );
  imagepng( $image, $file );
  imagedestroy( $image );
}

function sliding_panel_get_file_name( $prefix ) {
  global $sliding_panel_options;
  pde_fb('sliding_panel_get_file_name');
  pde_fb($sliding_panel_options);
  $bg = substr( $sliding_panel_options['tab_background_color'], 1);
  $border = substr( $sliding_panel_options['tab_border_color'], 1);
  return SLIDING_PANEL_SCHEME_DIR . '/images/' . $prefix . '-' . $bg . '-' . $border . '.png' ;
}

function sliding_panel_get_url( $prefix ) {
  global $sliding_panel_options;
  $bg = substr( $sliding_panel_options['tab_background_color'], 1);
  $border = substr( $sliding_panel_options['tab_border_color'], 1);
  return SLIDING_PANEL_SCHEME_URL . '/images/' . $prefix . '-' . $bg . '-' . $border . '.png' ;
}

function sliding_panel_tab_b() {
  global $sliding_panel_options;
  $load_default = !extension_loaded('gd') || !empty( $sliding_panel_options['tab_images'] );
  if( $load_default )
    echo plugins_url('css/images/tab_b.png', __FILE__);
  else {
    $file = sliding_panel_get_file_name( 'tab_b' );
    if( !file_exists( $file ) )
      sliding_panel_create_tab_b( $file );
    echo sliding_panel_get_url( 'tab_b' ) ;
  }
}

function sliding_panel_tab_l() {
  global $sliding_panel_options;
  $load_default = !extension_loaded('gd') || !empty( $sliding_panel_options['tab_images'] );
  if( $load_default )
    echo plugins_url('css/images/tab_l.png', __FILE__);
  else {
    $file = sliding_panel_get_file_name( 'tab_l' );
    if( !file_exists( $file ) )
      sliding_panel_create_tab_l( $file );
    echo sliding_panel_get_url( 'tab_l' ) ;
  }
}

function sliding_panel_tab_r() {
  global $sliding_panel_options;
  $load_default = !extension_loaded('gd') || !empty( $sliding_panel_options['tab_images'] );
  if( $load_default )
    echo plugins_url('css/images/tab_r.png', __FILE__);
  else {
    $file = sliding_panel_get_file_name( 'tab_r' );
    if( !file_exists( $file ) )
      sliding_panel_create_tab_r( $file );
    echo sliding_panel_get_url( 'tab_r' ) ;
  }
}

function sliding_panel_tab_m() {
  global $sliding_panel_options;
  $load_default = !extension_loaded('gd') || !empty( $sliding_panel_options['tab_images'] );
  if( $load_default )
    echo plugins_url('css/images/tab_m.png', __FILE__);
  else {
    $file = sliding_panel_get_file_name( 'tab_m' );
    if( !file_exists( $file ) )
      sliding_panel_create_tab_m( $file );
    echo sliding_panel_get_url( 'tab_m' ) ;
  }
}
?>
