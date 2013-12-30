<?php
/**
 * Woocommerce CSV Export
 *
 * @package   Woocommerce_Financial_Export_Admin
 * @author    Niels Donninger <niels@donninger.nl>
 * @license   GPL-2.0+
 * @link      http://donninger.nl
 * @copyright 2013 Donninger Consultancy
 */

class Woocommerce_Financial_Export_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	
	private $query;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin = Woocommerce_Financial_Export::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		//add_action( 'admin_menu', array( $this, 'get_order_statuses' ) );
		//add_filter( '@TODO', array( $this, 'filter_method_name' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Woocommerce_Financial_Export::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Woocommerce_Financial_Export::VERSION );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * @TODO:
		 *
		 * - Change 'Page Title' to the title of your plugin admin page
		 * - Change 'Menu Text' to the text for menu item for the plugin settings page
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Woocommerce Financial Export', $this->plugin_slug ),
			__( 'Woocommerce Financial Export', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 *           Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function get_order_statuses() {
		// @TODO: Define your action hook callback here
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		$query = "SELECT
			DISTINCT(t.slug) AS status
		FROM
			{$prefix}term_taxonomy x
				JOIN {$prefix}terms t ON x.term_id=t.term_id
		WHERE
			x.taxonomy='shop_order_status'";
		foreach($wpdb->get_results($query) AS $row) {
			$statuses[] = $row->status;
		}
		return $statuses;
	}
	
	private function get_orders_by_status($status, $date_from, $date_to) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		if(!$date_from) { $date_from = date('Y-m-d', 0); }
		if(!$date_to) { $date_to = date('Y-m-d'); }

		$query = "SELECT *, DATE_FORMAT(post_date,'%d-%m-%Y') as order_date
		FROM
			{$prefix}posts p JOIN {$prefix}postmeta m ON m.post_id=p.ID
			JOIN {$prefix}term_relationships tr ON tr.object_id=p.ID
			JOIN {$prefix}term_taxonomy tt ON tr.term_taxonomy_id=tt.term_taxonomy_id
			JOIN {$prefix}terms t ON tt.term_id=t.term_id
		WHERE
			p.post_type LIKE 'shop_order'
		AND
			t.slug='$status'
		AND
			post_date BETWEEN '$date_from' AND '$date_to'			
		ORDER BY
			post_date";
		$rows = $wpdb->get_results($query);
		$orders = array();
		$order_id = 0;
		foreach($rows as $row) {
			if($order_id != $row->ID && $order_id != 0) {
				$counter++;
			}			
			if($orders[$counter]["order_tax"] && $orders[$counter]["shipping_tax"]) {
				$orders[$counter]["tax"]=$orders[$counter]["order_tax"]+$orders[$counter]["shipping_tax"];
			
			}
			$orders[$counter]["ID"]=$row->ID;
			$orders[$counter]["order_date"]=$row->order_date;
			switch($row->meta_key) {
				case "_billing_first_name":
					$orders[$counter]["first_name"]=$row->meta_value;
					break;
				case "_billing_last_name":
					$orders[$counter]["last_name"]=$row->meta_value;
					break;
				case "_billing_address_1":
					$orders[$counter]["address"]=$row->meta_value;
					break;
				case "_billing_postcode":
					$orders[$counter]["postal_code"]=$row->meta_value;
					break;
				case "_billing_city":
					$orders[$counter]["city"]=$row->meta_value;
					break;
				case "_order_tax":
					$orders[$counter]["order_tax"]=round($row->meta_value,2);
					break;
				case "_order_shipping_tax":
					$orders[$counter]["shipping_tax"]=round($row->meta_value,2);
					break;
				case "_order_total":
					$orders[$counter]["order_total"]=round($row->meta_value,2);
					break;
			}
			$order_id = $row->ID;
		}
		return $orders;
	}
	
	public function generate_csv($orders) {
		$newline="\r\n";
		$delimiter=",";
		$quote="\"";
		$filename = "financial_export.txt";	
		$upload_dir = wp_upload_dir();		
		$file = $upload_dir["path"]."/".$filename;
		$fp = fopen($file, "w");
		fwrite($fp,"ID" . $delimiter . "Date" . $delimiter . "First_name" . $delimiter . "Last_name" . $delimiter . "Address" . $delimiter . "Postal" . $delimiter . "City" . $delimiter . "Tax" . $delimiter . "Total" . $newline);

		foreach($orders as $order) {
			fwrite($fp,$order["ID"] . $delimiter);
			fwrite($fp,$order["order_date"] . $delimiter);
			fwrite($fp,$order["first_name"] . $delimiter);
			fwrite($fp,$order["last_name"] . $delimiter);
			fwrite($fp,$order["address"] . $delimiter);
			fwrite($fp,$order["postal_code"] . $delimiter);
			fwrite($fp,$order["city"] . $delimiter);
			fwrite($fp,$order["tax"] . $delimiter);
			fwrite($fp,$order["order_total"] . $delimiter);
			fwrite($fp,$newline);
		}
		fclose($fp);
		return $upload_dir["url"] . "/" . $filename;
	}

	/**
	 * NOTE:     Filters are points of execution in which WordPress modifies data
	 *           before saving it or sending it to the browser.
	 *
	 *           Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}

}
