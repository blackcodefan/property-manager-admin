<?php
/**
 * Plugin Name: Property Manager Administrator
 * Description: Property tour video management tool
 * Author: MingRi Jin
 * Author URI: https://github.com/blackcodefan
 * Version: 1.0
 * Text Domain: property-manager-admin
 */

namespace PROPERTY_MANAGER_ADMIN;

include 'class-init.php';
include 'class-activator.php';

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Define Constants
 */

define( __NAMESPACE__ . '\PMA', __NAMESPACE__ . '\\' );

define( PMA . 'PLUGIN_NAME', 'property-manager-admin' );

define( PMA . 'PLUGIN_VERSION', '1.0.0' );

define( PMA . 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );

define( PMA . 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );

define( PMA . 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( PMA . 'PLUGIN_TEXT_DOMAIN', 'property-manager-admin' );

/**
 * Register Activation Hooks
 * This action is documented class-activator.php
 */
register_activation_hook( __FILE__, array( PMA . 'Activator', 'activate' ) );

add_action('init', PMA.'property_manager_admin_init');

/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    1.0.0
 */
class PropertyManagerAdmin {

    static $init;
    /**
     * Loads the plugin
     *
     * @access    public
     */
    public static function init() {

        if ( null == self::$init ) {
            self::$init = new Init();
            self::$init->run();
        }

        return self::$init;
    }

}

/*
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 *
 */
function property_manager_admin_init() {
    return PropertyManagerAdmin::init();
}