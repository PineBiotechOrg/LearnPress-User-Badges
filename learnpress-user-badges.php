<?php
/*
Plugin Name: LearnPress - User Badges
Plugin URI: http://thimpress.com/learnpress
Description: User badges that are rewarded for a user's progress
Author: Joshua McKendall
Version: 3.0.0
Author URI: http://thimpress.com
Tags: learnpress, lms, add-on, badges
Text Domain: learnpress-user-badges
Domain Path: /languages/
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'LP_ADDON_USER_BADGES_FILE', __FILE__ );
define( 'LP_ADDON_USER_BADGES_VER', '3.0.0' );
define( 'LP_ADDON_USER_BADGES_REQUIRE_VER', '3.0.0' );

/**
 * Class LP_Addon_User_Badges_Preload
 */
class LP_Addon_User_Badges_Preload {

    /**
     * LP_Addon_User_Badges_Preload constructor.
     */
    public function __construct() {

        add_action( 'learn-press/ready', array( $this, 'load' ) );
        add_action( 'admin_notices', array( $this, 'admin_notices' ) );        
    }

    /**
     * Load addon
     */
    public function load() {
        LP_Addon::load( 'LP_Addon_User_Badges', 'inc/load.php', __FILE__ );
        remove_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }

    /**
     * Admin notice
     */
    public function admin_notices() {
        ?>
        <div class="error">
            <p><?php echo wp_kses(
                    sprintf(
                        __( '<strong>%s</strong> addon version %s requires %s version %s or higher is <strong>installed</strong> and <strong>activated</strong>.', 'learnpress-user-badges' ),
                        __( 'LearnPress Stripe Payment', 'learnpress-user-badges' ),
                        LP_ADDON_STRIPE_ADVANCED_PAYMENT_VER,
                        sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), __( 'LearnPress', 'learnpress-user-badges' ) ),
                        LP_ADDON_STRIPE_ADVANCED_PAYMENT_REQUIRE_VER
                    ),
                    array(
                        'a'      => array(
                            'href'  => array(),
                            'blank' => array()
                        ),
                        'strong' => array()
                    )
                ); ?>
            </p>
        </div>
        <?php
    }
}

new LP_Addon_User_Badges_Preload();