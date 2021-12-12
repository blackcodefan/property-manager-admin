<?php

namespace PROPERTY_MANAGER_ADMIN;

include 'PropertyController.php';
include 'BuildingController.php';
include 'VideoController.php';
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

	public function __construct( $plugin_name, $version, $plugin_text_domain ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_text_domain = $plugin_text_domain;

		$this->property_controller = new PropertyController();
		$this->building_controller = new BuildingController();
		$this->video_controller = new VideoController();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/property-manager-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		$params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
		wp_enqueue_script( 'pma_ajax_handle', plugin_dir_url( __FILE__ ) . 'js/property-manager-admin.js', array( 'jquery' ), $this->version, false );
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
            array( $this, 'building_edit_page_content' )
        );

        add_submenu_page(
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

	}

	public function property_list_page_content() {
	    $status = 'publish';
	    if (isset($_GET['status']) && $_GET['status'] == 'trash'){
	        $status = 'trash';
        }

	    $properties = $this->property_controller->index($status);
	    $trashed = $this->property_controller->count('trash');
	    $active = $this->property_controller->count('publish');
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
	    $buildings = $this->building_controller->index();
        $properties = $this->property_controller->index();
	    include_once('views/buildings.php');
    }

    public function building_create_page_content(){
        $properties = $this->property_controller->index();
	    include_once('views/create-building.php');
    }

    public function building_edit_page_content(){
        $properties = $this->property_controller->index();
        $building = $this->building_controller->get($_GET['id']);
	    include_once('views/edit-building.php');
    }

    public function video_list_page_content(){
        $status = 'publish';
        if (isset($_GET['status']) && $_GET['status'] == 'trash'){
            $status = 'trash';
        }
        $trashed = $this->video_controller->count('trash');
        $active = $this->video_controller->count('publish');

	    $videos = $this->video_controller->index($status);
        $buildings = $this->building_controller->index();
	    include_once('views/videos.php');
    }

    public function video_create_page_content(){
	    $buildings = $this->building_controller->index();
	    include_once('views/create-video.php');
    }

    public function video_edit_page_content(){
        $buildings = $this->building_controller->index();
	    $video = $this->video_controller->get($_GET['id']);
	    include_once('views/edit-video.php');
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
            if ($this->property_controller->save($property_name, $property_id)){
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

    public function save_building(){
        if( isset( $_POST['building_save_nonce'] ) && wp_verify_nonce( $_POST['building_save_nonce'], 'building_save_nonce') ){

            $building = [];
            $building['property_id'] = sanitize_text_field($_POST['property_id']);
            $building['name'] = sanitize_text_field($_POST['name']);
            $building['address'] = sanitize_text_field($_POST['address']);
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

    public function save_video(){
        if( isset( $_POST['video_save_nonce'] ) && wp_verify_nonce( $_POST['video_save_nonce'], 'video_save_nonce') ){

            $video = [];
            $video['building_id'] = $_POST['building_id'];
            $video['youtube'] = $_POST['youtube'];
            $video['vimeo'] = $_POST['vimeo'];
            $video['wistia'] = $_POST['wistia'];
            $video['description'] = $_POST['description'];
            $video['unitf'] = $_POST['unit_floor'];
            $video['unit'] = $_POST['unit'];
            $video['bedroom'] = $_POST['bedroom'];
            $video['bathroom'] = $_POST['bathroom'];
            $video['apartrange'] = isset($_POST['apartment-type-radio']) && $_POST['apartment-type-radio'] == 'true'?1:0;
            $video['apartmin'] = $_POST['min'];
            $video['apartmax'] = $_POST['max'];
            $video['status'] = 'publish';

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


}