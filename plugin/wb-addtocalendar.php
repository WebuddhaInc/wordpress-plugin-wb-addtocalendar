<?php
/**
 * Add to Calendar Button
 *
 * @package           wordpress-plugin-wb-addtocalendar
 * @author            David Hunt
 * @copyright         2019 Webuddha, Holodyn Inc.
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Add to Calendar Button
 * Plugin URI:        https://addtocalendar.apps.webuddha.com/
 * Description:       Insert Add to Calendar buttons into any post or via PHP
 * Version:           0.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            David Hunt
 * Author URI:        https://webuddha.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wb-addtocalendar
 * Domain Path:       /languages
 */

if( !function_exists('inspect') ){
  function inspect(){
    echo '<pre>' . print_r(func_get_args(), true) . '</pre>';
  }
}

class wb_addtocalendar {

  private static $instance;
  private static $version = '0.0.0';

  /**
   * [__construct description]
   */
  public function __construct(){

    // Instance
    if (empty(self::$instance))
      self::$instance = $this;

    // Actions
    add_action( 'init', array($this, 'initAssets') );
    add_action( 'init', array($this, 'initPublic') );
    add_action( 'init', array($this, 'initShortcode') );

  }

  /**
   * [getInstance description]
   * @return [type] [description]
   */
  public static function getInstance(){
    if (empty(self::$instance))
      new self();
    return self::$instance;
  }

  /**
   * [getVersion description]
   * @return [type] [description]
   */
  public function getVersion(){
    return self::$version;
  }

  /**
   * [initAssets description]
   * @return [type] [description]
   */
  public function initAssets() {

    // Add to Calendar
    wp_register_style( 'wb-addtocalendar', plugins_url( '/assets/addtocalendar/add-to-calendar.css', __FILE__ ), array(), self::getVersion() );
    wp_register_script( 'wb-addtocalendar', plugins_url( '/assets/addtocalendar/add-to-calendar.min.js', __FILE__ ), array(), self::getVersion() );

  }

  /**
   * [initPublic description]
   * @return [type] [description]
   */
  public function initPublic() {
  }

  /**
   * [initShortcode description]
   * @return [type] [description]
   */
  public function initShortcode() {
    add_shortcode('addtocalendar', array($this, 'callShortcode'));
  }

  /**
   * [shortcode_addtocalendar description]
   * @param  array  $atts    [description]
   * @param  [type] $content [description]
   * @return [type]          [description]
   */
  public function callShortcode( $atts = [], $content = null ){
    return $this->createButton($atts);
  }

  /**
   * [createAddToCalendarButton description]
   * @param  array  $atts [description]
   * @return [type]       [description]
   */
  public function createButton( $atts = [] ){

    // Stage Attributes
    extract($atts);

    // Capture Output
    ob_start();

    // Render Script
    if (empty($target)) {
      $target = 'addtocalendar_' . wp_generate_password(6,false,false);
      echo '<div id="' . $target . '" class="wb_addtocalendar"></div>';
      $target = '#' . $target;
    }
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        addToCalendar(document.querySelector('.addtocalendar'));
        document.querySelector('<?php echo $target ?>').appendChild(createCalendar({
          options: {class:'my-class',id:'my-id'},
          data: {
            title: '<?php echo str_replace('__BR__', '\\n', preg_replace('/[\r\n]/', '__BR__', esc_attr(strip_tags($title)))) ?>',
            <?php if(!empty($start)){ ?>start: new Date('<?php echo esc_attr(date('Y-m-d H:i:s', strtotime($start))) ?>'),<?php } ?>
            <?php if(!empty($end)){ ?>end: new Date('<?php echo esc_attr(date('Y-m-d H:i:s', strtotime($end))) ?>'),<?php } ?>
            <?php if(!empty($timezone)){ ?>timezone: <?php echo esc_attr($timezone) ?>,<?php } ?>
            <?php if(!empty($allday)){ ?>allday: 1,<?php } ?>
            <?php if(!empty($duration)){ ?>duration: <?php echo esc_attr($duration) ?>,<?php } ?>
            <?php if(!empty($location)){ ?>location: '<?php echo preg_replace('/[\r\n]/', ', ', esc_attr(strip_tags($location))) ?>',<?php } ?>
            <?php if(!empty($description)){ ?>description: '<?php echo str_replace('__BR__', '\\n', preg_replace('/[\r\n]/', '__BR__', esc_attr(strip_tags($description)))) ?>',<?php } ?>
          }
        }));
      });
    </script>
    <?php

    // Load Assets
    // CSS inline from JS
    // wp_enqueue_style('wb-addtocalendar');
    wp_enqueue_script('wb-addtocalendar');

    // Return Captured Output
    return ob_get_clean();

  }

}

new wb_addtocalendar();
