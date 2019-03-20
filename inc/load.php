<?php
/**
 * Plugin load class.
 *
 * @author   Joshua McKendall
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_User_Badges' ) ) {
	/**
	 * Class LP_Addon_User_Badges
	 */
	class LP_Addon_User_Badges extends LP_Addon {

		/**
		 * @var string
		 */
		public $version = LP_ADDON_USER_BADGES_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_USER_BADGES_REQUIRE_VER;

		/**
		 * LP_Addon_User_Badges constructor.
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		}

		public function plugins_loaded() {
			if ( ! $this->mycred_is_active() ) {
				add_action( 'admin_notices', array( $this, 'admin_notices' ) );
			} else {
				parent::__construct();
			}
		}


		/**
		 * Check myCRED active.
		 *
		 * @return bool
		 */
		public function mycred_is_active() {
			return class_exists( 'myCRED_Core' );
		}

		public function bp_is_active() {
			return function_exists('bp_is_active');
		}

		/**
		 * Define Learnpress Stripe payment constants.
		 *
		 * @since 3.0.0
		 */
		protected function _define_constants() {
			define( 'LP_ADDON_USER_BADGES_PATH', dirname( LP_ADDON_USER_BADGES_FILE ) );
			define( 'LP_ADDON_USER_BADGES_INC', LP_ADDON_USER_BADGES_PATH . '/inc/' );
			define( 'LP_ADDON_USER_BADGES_URL', plugin_dir_url( LP_ADDON_USER_BADGES_FILE ) );
			define( 'LP_ADDON_USER_BADGES_TEMPLATE', LP_ADDON_USER_BADGES_PATH . '/templates/' );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since 3.0.0
		 */
		protected function _includes() {
			include_once LP_ADDON_USER_BADGES_INC . 'functions.php';
		}

		/**
		 * Init hooks.
		 */
		protected function _init_hooks() {

			add_action( 'bp_profile_header_meta', 'learnpress_render_user_badge' );
			add_action( 'omicslogic_student_preview', 'learnpress_render_user_badge', 10, 1 );

		}

		/**
		 * Enqueue assets.
		 *
		 * @since 3.0.0
		 */
		protected function _enqueue_assets() {

			if( ! is_admin() ) {
				$assets = learn_press_assets();
			    $assets->enqueue_style( 'learnpress-user-badge', $this->get_plugin_url( '/assets/css/learnpress-user-badges.css' ), array() );
				$assets->enqueue_script( 'learnpress-user-badge', $this->get_plugin_url( '/assets/js/loading-bar.min.js' ), array() );	
			}			
		}
	}
}