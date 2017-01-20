<?php
/**
 * Plugin Name:       NS Nepali Date
 * Plugin URI:        #
 * Description:       Display Nepali Date
 * Version:           1.0.0
 * Author:            Nilambar Sharma
 * Author URI:        http://www.nilambar.net
 * Text Domain:       ns-nepali-date
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'NS_NEPALI_DATE_VERSION', '1.0.0' );
define( 'NS_NEPALI_DATE_NAME', 'NS Nepali Date' );
define( 'NS_NEPALI_DATE_SLUG', 'ns-nepali-date' );
define( 'NS_NEPALI_DATE_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'NS_NEPALI_DATE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'NS_NEPALI_DATE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

require_once( NS_NEPALI_DATE_DIR . '/inc/nepali_calendar.php' );

add_filter( 'get_the_date', 'ns_nepali_date_implement', 10, 3 );
function ns_nepali_date_implement($the_date, $d, $post){

  if ( ! is_admin() ) {
      $the_date = get_the_date_nepali( $the_date );
  }
  return $the_date;

}

/**
 * get_the_date_nepali
 */
function get_the_date_nepali($date=''){

  if (empty($date)) {
    global $post;
    $date = $post->post_date;
  }

  $cal = new Nepali_Calendar();
  $req_date_formatted = date('Y-m-d',strtotime($date));
  $date_arr = explode('-', $req_date_formatted );
  if( 3 != count($date_arr) ){
    return;
  }
  $newd = $cal->eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
  $our_date = $newd['date'].' '. $newd['month_name'].', '. $newd['year'];
  return apply_filters('get_the_date_nepali', $our_date, $newd, $date );

}

/**
 * the_date_nepali
 */
function the_date_nepali($date=''){

  echo get_the_date_nepali( $date );

}

?>
<?php echo the_date_nepali(''); ?>