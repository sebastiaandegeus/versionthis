<?php
/*
Plugin Name: Version This
Plugin URI: http://wordpress.org/plugins/versionthis/
Description: This WordPress plugin make it possible to automaticallly version a javascript or css file from your theme or plugin when that file changes content.
Author: Sebastiaan de Geus
Version: 1.1.1
*/

class Version_This {
  private static $instance;

  public static $identifiers = array();

  private function __construct() {
    Version_This::filters();
  }

  public static function get() {
    if ( is_null( self::$instance ) )
      self::$instance = new self();

    return self::$instance;
  }

  public static function filters() {
    add_filter( 'style_loader_src', array( 'Version_This', 'loader_src_filter' ) );
    add_filter( 'script_loader_src', array( 'Version_This', 'loader_src_filter' ) );
  }

  public static function loader_src_filter( $src ) {
    if ( ! Version_This::versioned( $src ) ) return $src;

    $parts = parse_url( $src );

    if ( defined( 'BEDROCK' ) ) {
      $file = untrailingslashit( str_replace('wp/', '', ABSPATH)) . $parts['path'];
    } else {
      $file = untrailingslashit( ABSPATH ) . $parts['path'];
    }

    $parts['query']  = '?ver=' . md5_file( $file );
    $parts['scheme'] = $parts['scheme'] . '://';
    $parts['port']   = ! empty( $parts['port'] ) ? ':' . $parts['port'] : '';

    return implode( $parts );
  }

  public static function add_identifier( $identifier ) {
    Version_This::$identifiers[] = $identifier;
  }

  public static function get_themes() {
    return Version_This::$versioned_themes;
  }

  public static function versioned( $src ) {
    foreach ( Version_This::$identifiers as $identifier ) {
      if ( strpos( $src, $identifier ) !== FALSE )
        return true;
    }

    return false;
  }

}

Version_This::get();

function version_this( $identifier ) {
  Version_This::add_identifier( $identifier );
}
