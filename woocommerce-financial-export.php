<?php
/**
 *
 * @package   Woocommerce_Financial_Export
 * @author    Niels Donninger <niels@donninger.nl>
 * @license   GPL-2.0+
 * @link      http://donninger.nl
 * @copyright 2013 Donninger Consultancy
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Financial Export
 * Plugin URI:        https://github.com/nielsdon/woocommerce-financial-export
 * Description:       A simple but functional Woocommerce Financial exporter tool. Exports orders, customers, etc.
 * Version:           0.0.1
 * Author:            Niels Donninger
 * Author URI:        http://donninger.nl
 * Text Domain:       en_US
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/nielsdon/woocommerce-financial-export
 * Depends:           WooCommerce
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-woocommerce-financial-export.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'Woocommerce_Financial_Export', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Woocommerce_Financial_Export', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Woocommerce_Financial_Export', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-woocommerce-financial-export-admin.php' );
	add_action( 'plugins_loaded', array( 'Woocommerce_Financial_Export_Admin', 'get_instance' ) );

}
