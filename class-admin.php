<?php

namespace PROPERTY_MANAGER_ADMIN;

include 'PropertyController.php';
include 'BuildingController.php';
include 'VideoController.php';
include 'SettingController.php';
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.

 * @since      1.0.0

 */
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	private $plugin_text_domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name	The name of this plugin.
	 * @param    string $version	The version of this plugin.
	 * @param	 string $plugin_text_domain	The text domain of this plugin
	 */

	/** PropertyController */

	private $property_controller;

	/** BuildingController */

	private $building_controller;

	/** VideoController */

	private $video_controller;

	/** SettingController */

	private $setting_controller;

	private $videos_page_id;

	private $videos_setting;

	public function __construct( $plugin_name, $version, $plugin_text_domain ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;

		$this->property_controller = new PropertyController();
		$this->building_controller = new BuildingController();
		$this->video_controller = new VideoController();
		$this->setting_controller = new SettingController();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

        wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui-structure-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.structure.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-ui-theme-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/property-manager-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		$params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
		wp_enqueue_script( 'popover', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'jsmartable', plugin_dir_url( __FILE__ ) . 'js/jsmartable.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'jquery_ui', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'pma_js', plugin_dir_url( __FILE__ ) . 'js/property-manager-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'pma_ajax_handle', 'params', $params );

	}
	
	/**
	 * Callback for the admin menu
	 * 
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
				
		add_menu_page(__( 'Properties', $this->plugin_text_domain ),
            __( 'Property Manager Admin', $this->plugin_text_domain ),
            'read',
            $this->plugin_name
        );

        add_submenu_page(
            $this->plugin_name,
            __( 'Properties', $this->plugin_text_domain ),
            __( 'Properties', $this->plugin_text_domain ),
            'read',
            $this->plugin_name,
            array( $this, 'property_list_page_content' )
        );
		
		add_submenu_page(
		    $this->plugin_name,
            __( 'Create Property', $this->plugin_text_domain ),
            __( 'Create Property', $this->plugin_text_domain ),
            'read',
            'create-property',
            array( $this, 'property_create_page_content' )
        );
		
		add_submenu_page(
		    null,
            __( 'Edit Property', $this->plugin_text_domain ),
            __( 'Edit Property', $this->plugin_text_domain ),
            'read',
            'edit-property',
            array( $this, 'property_edit_page_content' )
        );

        add_submenu_page(
            $this->plugin_name,
            __( 'Buildings', $this->plugin_text_domain ),
            __( 'Buildings', $this->plugin_text_domain ),
            'read',
            'buildings',
            array( $this, 'building_list_page_content' )
        );

        add_submenu_page(
            $this->plugin_name,
            __( 'Order Buildings', $this->plugin_text_domain ),
            __( 'Order Buildings', $this->plugin_text_domain ),
            'read',
            'order-buildings',
            array( $this, 'building_order_page_content' )
        );

        add_submenu_page(
            $this->plugin_name,
            __( 'Create Building', $this->plugin_text_domain ),
            __( 'Create Building', $this->plugin_text_domain ),
            'read',
            'create-building',
            array( $this, 'building_create_page_content' )
        );

        add_submenu_page(
            null,
            __( 'Edit Building', $this->plugin_text_domain ),
            __( 'Edit Building', $this->plugin_text_domain ),
            'read',
            'edit-building',
            array( $this, 'building_edit_page_content')
        );

        $this->videos_page_id = add_submenu_page(
            $this->plugin_name,
            __( 'Videos', $this->plugin_text_domain ),
            __( 'Videos', $this->plugin_text_domain ),
            'read',
            'videos',
            array( $this, 'video_list_page_content' )
        );

        add_submenu_page(
            $this->plugin_name,
            __( 'Add Video Tour', $this->plugin_text_domain ),
            __( 'Add Video Tour', $this->plugin_text_domain ),
            'read',
            'add-video',
            array( $this, 'video_create_page_content' )
        );

        add_submenu_page(
            null,
            __( 'Edit Video Tour', $this->plugin_text_domain ),
            __( 'Edit Video Tour', $this->plugin_text_domain ),
            'read',
            'edit-video',
            array( $this, 'video_edit_page_content' )
        );

        // Add video list page load callback to add column options
        add_action('load-'.$this->videos_page_id, [$this, 'add_video_screen_options']);

	}

	public function property_list_page_content() {
	    $status = 'publish';
	    if (isset($_GET['status'])){
	        $status = $_GET['status'];
        }

	    $properties = $this->property_controller->index($status);
	    $all = $this->property_controller->count();
	    $trashed = $this->property_controller->count('trash');
	    $active = $this->property_controller->count('publish');
	    $draft = $this->property_controller->count('draft');
		include_once( 'views/properties.php' );
	}

	public function property_create_page_content() {
		include_once( 'views/create-property.php' );
	}

	public function property_edit_page_content() {
	    $property = $this->property_controller->get($_GET['id']);
	    include_once( 'views/edit-property.php');
    }

    public function building_list_page_content(){
        $status = 'publish';
        if (isset($_GET['status'])){
            $status = $_GET['status'];
        }
        $all = $this->building_controller->count();
        $trashed = $this->building_controller->count('trash');
        $active = $this->building_controller->count('publish');
        $draft = $this->building_controller->count('draft');

	    $buildings = $this->building_controller->index($status);
        $properties = $this->property_controller->index('publish');
	    include_once('views/buildings.php');
    }

    public function building_order_page_content() {
        $buildings = $this->building_controller->getOrderedBuildings();
	    include_once('views/order-buildings.php');
    }

    public function building_create_page_content(){
        $properties = $this->property_controller->index('publish');
	    include_once('views/create-building.php');
    }

    public function building_edit_page_content(){
        $properties = $this->property_controller->index('publish');
        $building = $this->building_controller->get($_GET['id']);
	    include_once('views/edit-building.php');
    }

    public function video_list_page_content(){
        $status = 'publish';
        if (isset($_GET['status'])){
            $status = $_GET['status'];
        }

        $orderBy = 'description';
        $order = !empty($_GET['order']) ? 'asc' : 'desc';
        if (!empty($_GET['orderby'])) $orderBy = $_GET['orderby'];

        $all = $this->video_controller->count();
        $trashed = $this->video_controller->count('trash');
        $active = $this->video_controller->count('publish');
        $draft = $this->video_controller->count('draft');

	    $videos = $this->video_controller->index($status, $orderBy, $order);
        $buildings = $this->building_controller->index('publish');

	    include_once('views/videos.php');
    }

    public function video_create_page_content(){
	    $buildings = $this->building_controller->index('publish');
	    include_once('views/create-video.php');
    }

    public function video_edit_page_content(){
        $buildings = $this->building_controller->index('publish');
	    $video = $this->video_controller->get($_GET['id']);
	    include_once('views/edit-video.php');
    }

    // Add column options to video list page
    public function add_video_screen_options(){
        add_screen_option('pma_v_address', ['id' => 'pma_v_address', 'label' => 'Address', 'value' => true]);
        add_screen_option('pma_v_description', ['id' => 'pma_v_description', 'label' => 'Description', 'value' => true]);
        add_screen_option('pma_v_building', ['id' => 'pma_v_building', 'label' => 'Building', 'value' => true]);
        add_screen_option('pma_v_property', ['id' =>'pma_v_property', 'label' => 'Property', 'value' => true]);
        add_screen_option('pma_v_label', ['id' =>'pma_v_label', 'label' => 'Label', 'value' => true]);
        add_screen_option('pma_v_bedroom', ['id' =>'pma_v_bedroom', 'label' => 'Bedroom', 'value' => true]);
        add_screen_option('pma_v_bathroom', ['id' =>'pma_v_bathroom', 'label' => 'Bathroom', 'value' => true]);
        add_screen_option('pma_v_type', ['id' =>'pma_v_type', 'label' => 'Type', 'value' => false]);
        add_screen_option('pma_v_min', ['id' =>'pma_v_min', 'label' => 'Line Start', 'value' => false]);
        add_screen_option('pma_v_max', ['id' =>'pma_v_max', 'label' => 'Line End', 'value' => false]);
    }

    // Include screen option
    public function print_settings_collapse(){
        $screen = get_current_screen();
        if ($screen->id == $this->videos_page_id)
            $this->show_videos_page_settings();
    }

    private function show_videos_page_settings(){
	    $screen = get_current_screen();
	    $options = $screen->get_options();
	    $this->videos_setting = $this->setting_controller->getVideosSetting();
        include_once( 'views/videos-setting.php' );
    }

    public function redirect_hook(){
        if( isset( $_POST['redirect_hook_nonce'] ) && wp_verify_nonce( $_POST['redirect_hook_nonce'], 'redirect_hook_nonce') ){
            $params = $_REQUEST;
            unset($params['redirect']);
            unset($params['action']);
            unset($params['page']);
            unset($params['redirect_hook_nonce']);
            unset($params['_wp_http_referer']);

            wp_redirect( esc_url_raw( add_query_arg( $params,
                admin_url('admin.php?page='. $_REQUEST['redirect'] )
            ) ) );
        }else{
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,

            ) );
        }
    }
	
	/**
	 * 
	 * @since    1.0.0
	 */
	public function property_ajax_handler() {
		
		if( isset( $_POST['ajax_request_nonce'] ) && wp_verify_nonce( $_POST['ajax_request_nonce'], 'ajax_request_nonce') ) {
		    $id = sanitize_text_field($_POST['id']);
		    $status = sanitize_text_field($_POST['status']);
		    if ($this->property_controller->trash($id, $status)){
		        echo json_encode(['success' => true]);
            }else{
		        echo json_encode(['success' => false]);
            }
		    wp_die();
		}
		else {
			wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
						'response' 	=> 403,
						'back_link' => 'admin.php?page=' . $this->plugin_name,

				) );
		}
	}

	public function video_ajax_handler() {
		if( isset( $_POST['ajax_request_nonce'] ) && wp_verify_nonce( $_POST['ajax_request_nonce'], 'ajax_request_nonce') ) {
		    $id = sanitize_text_field($_POST['id']);
		    $status = sanitize_text_field($_POST['status']);
		    if ($this->video_controller->trash($id, $status)){
		        echo json_encode(['success' => true]);
            }else{
		        echo json_encode(['success' => false]);
            }
		    wp_die();
		}
		else {
			wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
						'response' 	=> 403,
						'back_link' => 'admin.php?page=' . $this->plugin_name,

				) );
		}
	}

	public function save_property(){

        if( isset( $_POST['property_save_nonce'] ) && wp_verify_nonce( $_POST['property_save_nonce'], 'property_save_nonce') ){
            $property_name = sanitize_text_field($_POST['name']);
            $property_id = sanitize_text_field($_POST['property_id']);
            $status = sanitize_text_field($_POST['status']);
            if ($this->property_controller->save($property_name, $status, $property_id)){
                $admin_notice = "success";
                $response = "Property has been saved successfully.";
                $redirect = $this->plugin_name;
            }else{
                $admin_notice = "error";
                $response = "Woops! There was an issue handling your request";
                $redirect = 'create-property';
            }

            $this->custom_redirect($admin_notice, $response, $redirect);
            exit;
        }else{
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,

            ) );
        }
    }

    public function save_buildings_order() {
        if( isset( $_POST['property_save_nonce'] ) && wp_verify_nonce( $_POST['property_save_nonce'], 'property_save_nonce') ){

            $data = json_decode(stripslashes($_POST['sort-data']));

            $this->building_controller->setOrder($data);
            $admin_notice = "success";
            $response = "Property has been saved successfully.";
            $redirect = "order-buildings";

            $this->custom_redirect($admin_notice, $response, $redirect);
            exit;
        }else{
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,
            ) );
        }
    }

    public function save_building(){
        if( isset( $_POST['building_save_nonce'] ) && wp_verify_nonce( $_POST['building_save_nonce'], 'building_save_nonce') ){

            $building = [];
            $building['property_id'] = sanitize_text_field($_POST['property_id']);
            $building['name'] = sanitize_text_field($_POST['name']);
            $building['address'] = sanitize_text_field($_POST['address']);
            $building['listing_order'] = $_POST['listing_order'] == 'true' ? 1 : 0; // true if line video first
            $building['status'] = sanitize_text_field($_POST['status']);
            $building_id = sanitize_text_field($_POST['building_id']);

            if ($this->building_controller->save($building, $building_id)){
                $admin_notice = "success";
                $response = "Building has been saved successfully.";
                $redirect = "buildings";
            }else{
                $admin_notice = "error";
                $response = "Woops! There was an issue handling your request";
                $redirect = "create-building";
            }

            $this->custom_redirect($admin_notice, $response, $redirect);
            exit;
        }else{
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,

            ) );
        }
    }

    public function delete_building(){
        if( isset( $_POST['ajax_request_nonce'] ) && wp_verify_nonce( $_POST['ajax_request_nonce'], 'ajax_request_nonce') ) {
            $id = sanitize_text_field($_POST['id']);
            if ($this->building_controller->destroy($id)){
                echo json_encode(['success' => true]);
            }else{
                echo json_encode(['success' => false]);
            }
            wp_die();
        }
        else {
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,

            ) );
        }
    }

    public function save_video(){
        if( isset( $_POST['video_save_nonce'] ) && wp_verify_nonce( $_POST['video_save_nonce'], 'video_save_nonce') ){

            $video = [];
            $video['building_id'] = $_POST['building_id'];
            $video['youtube'] = $_POST['youtube'];
            $video['vimeo'] = $_POST['vimeo'];
            $video['wistia'] = $_POST['wistia'];
            $video['description'] = $_POST['description'];
            $video['bedroom'] = $_POST['bedroom'];
            $video['bathroom'] = $_POST['bathroom'];
            $video['apartrange'] = $_POST['apartment-type-radio'] == 'true'?1:0;
            $video['apartmin'] = $_POST['min'];
            $video['apartmax'] = $_POST['max'];
            $video['status'] = 'draft';
            $video['label'] = $_POST['label'];

            if (isset($_POST['status'])){
                $video['status'] = $_POST['status'];
            }

            if (is_numeric($_POST['unit_floor'])){
                $video['unitfn'] = $_POST['unit_floor'];
                $video['unitf'] = null;
            }else{
                $video['unitfn'] = null;
                $video['unitf'] = $_POST['unit_floor'];
            }

            if (is_numeric($_POST['unit'])){
                $video['unitn'] = (int) $_POST['unit'];
                $video['unit'] = null;
            }else{
                $video['unit'] = $_POST['unit'];
                $video['unitn'] = null;
            }

            $video_id = sanitize_text_field($_POST['video_id']);

            $building = $this->building_controller->get($_POST['building_id']);
            $video['property_id'] = $building->property_id;

            if ($this->video_controller->save($video, $video_id)){
                $admin_notice = "success";
                $response = "Video tour has been saved successfully.";
                $redirect = "videos";
            }else{
                $admin_notice = "error";
                $response = "Woops! There was an issue handling your request";
                $redirect = "add-video";
            }

            $this->custom_redirect($admin_notice, $response, $redirect);
            exit;
        }else{
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,

            ) );
        }
    }

    public function save_video_scree_option(){
        if( isset( $_POST['setting_hook_nonce'] ) && wp_verify_nonce( $_POST['setting_hook_nonce'], 'setting_hook_nonce') ){

            $this->setting_controller->setVideosSetting($_POST);

            wp_redirect(admin_url('admin.php?page=videos'));
            exit;
        }else{
            wp_die( __( 'Invalid nonce specified', $this->plugin_name ), __( 'Error', $this->plugin_name ), array(
                'response' 	=> 403,
                'back_link' => 'admin.php?page=' . $this->plugin_name,

            ) );
        }
    }

	/**
	 * Redirect
	 * 
	 * @since    1.0.0
	 */
	public function custom_redirect( $admin_notice, $response, $redirect_url ) {
		wp_redirect( esc_url_raw( add_query_arg( array(
									'pma_notice' => $admin_notice,
									'pma_response' => $response,
									),
							admin_url('admin.php?page='. $redirect_url )
					) ) );

	}

	/**
	 * Print Admin Notices
	 * 
	 * @since    1.0.0
	 */
	public function print_plugin_admin_notices() {
		  if ( isset( $_REQUEST['pma_notice'] ) ) {
				$html =	"<div class='notice notice-".$_REQUEST['pma_notice']." is-dismissible'><p><strong>{$_REQUEST['pma_response']}</strong></p></div>";
				echo $html;
		  }
		  else {
			  return;
		  }

	}

	public function sortable_column_class_generator($field){
        $orderBy = 'address';
        $order = !empty($_GET['order']);
        if (!empty($_GET['orderby'])) $orderBy = $_GET['orderby'];

        $class_name = '';
        $orderBy == $field ? $class_name.='sorted' : $class_name.='sortable';
        $orderBy == 'address' && $order ?$class_name.=' asc' : $class_name.=' desc';

        return $class_name;
    }

    public function video_page_sort_url_generator($field){
        $orderBy = 'address';
        $order = !empty($_GET['order']);
        if (!empty($_GET['orderby'])) $orderBy = $_GET['orderby'];

        $status_clause = "";
        if (!empty($_GET['status'])){
            $status_clause .= "&status={$_GET['status']}";
        }

        return esc_url(
            admin_url("admin.php?page=videos{$status_clause}&orderby={$field}&order="
                .($orderBy != $field || !$order)
            ));
    }

    public function get_option_value($field){
        $screen = get_current_screen();
        $options = $screen->get_options();
        return $options[$field]['value'];
    }

    public function is_hidden($field){
	    if(isset($this->videos_setting["pma_v_{$field}"])) {
	        if (empty($this->videos_setting["pma_v_{$field}"][0])){
	            return ' hidden';
            }
            return '';
        }
	    return '';
    }
}