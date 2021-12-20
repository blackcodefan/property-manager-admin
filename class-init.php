<?php

namespace PROPERTY_MANAGER_ADMIN;
use PROPERTY_MANAGER_ADMIN as PMA;

include 'class-loader.php';
include 'class-admin.php';
include 'class-api.php';

class Init {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_base_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_basename;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * The text domain of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $plugin_text_domain;


    // define the core functionality of the plugin.
    public function __construct() {

        $this->plugin_name = PMA\PLUGIN_NAME;
        $this->version = PMA\PLUGIN_VERSION;
        $this->plugin_basename = PMA\PLUGIN_BASENAME;
        $this->plugin_text_domain = PMA\PLUGIN_TEXT_DOMAIN;

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->register_rest_api();
    }

    /**
     * Loads the following required dependencies for this plugin.
     *
     * - Loader - Orchestrates the hooks of the plugin.
     *
     * @access    private
     */
    private function load_dependencies() {
        $this->loader = new Loader();

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * Callbacks are documented in inc/admin/class-admin.php
     *
     * @access    private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        //Add a top-level admin menu for our plugin
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

        $this->loader->add_action( 'admin_post_save_property_hook', $plugin_admin, 'save_property');

        $this->loader->add_action( 'admin_post_save_building_hook', $plugin_admin, 'save_building');

        $this->loader->add_action( 'admin_post_save_video_hook', $plugin_admin, 'save_video');

        $this->loader->add_action( 'admin_post_redirect_hook', $plugin_admin, 'redirect_hook');

        $this->loader->add_action('admin_post_set_video_setting', $plugin_admin, 'save_video_scree_option');

        //when a form is submitted to admin-ajax.php
        $this->loader->add_action( 'wp_ajax_property_request_handler', $plugin_admin, 'property_ajax_handler');

        $this->loader->add_action( 'wp_ajax_video_request_handler', $plugin_admin, 'video_ajax_handler');

        // Register admin notices
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'print_plugin_admin_notices');

        $this->loader->add_filter('screen_settings', $plugin_admin, 'print_settings_collapse');
    }

    private function register_rest_api(){
        $plugin_api = new Api();

        $this->loader->add_action('rest_api_init', $plugin_api, 'register_api');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Retrieve the text domain of the plugin.
     *
     * @since     1.0.0
     * @return    string    The text domain of the plugin.
     */
    public function get_plugin_text_domain() {
        return $this->plugin_text_domain;
    }

}