<?php
namespace PROPERTY_MANAGER_ADMIN;

class Api
{
    private $property_table;
    private $building_table;
    private $video_table;
    private $db;
    private $current_user;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->property_table = $wpdb->prefix.'properties';
        $this->building_table = $wpdb->prefix.'buildings';
        $this->video_table = $wpdb->prefix.'tour_videos';
        $this->current_user = wp_get_current_user();
    }

    public function register_api(){
        register_rest_route( 'pma/v1', '/fetch-videos', array(
            'methods' => 'POST',
            'callback' => array($this, 'fetch_videos'),
            'permission_callback' => '__return_true'
        ));

        register_rest_route( 'pma/v1', '/verify-credential', array(
            'methods' => 'POST',
            'callback' => array($this, 'verify_credential'),
            'permission_callback' => '__return_true'
        ));
    }

    public function fetch_videos($request){
        if($this->current_user->exists()) {
            $results = $this->db->get_results(
                $this->db->prepare(
                    "SELECT {$this->video_table}.*,
                                  {$this->property_table}.name as property_name,
                                  {$this->building_table}.name as building_name,
                                  {$this->building_table}.listing_order,
                                  {$this->building_table}.address as address 
                           FROM  {$this->video_table} 
                           LEFT JOIN {$this->property_table}
                           ON {$this->video_table}.property_id={$this->property_table}.id
                           LEFT JOIN {$this->building_table}
                           ON {$this->video_table}.building_id={$this->building_table}.id
                           WHERE {$this->video_table}.user_id=%d
                           AND {$this->property_table}.status='publish'
                           AND {$this->building_table}.status='publish'
                           AND {$this->video_table}.status='publish'
                           ORDER BY
                                {$this->building_table}.sort,
                                (CASE 
                                     WHEN {$this->video_table}.apartrange = 1 AND {$this->video_table}.unitn IS NULL
                                         THEN {$this->video_table}.unitn IS NULL
                                     WHEN {$this->video_table}.apartrange = 1 AND {$this->video_table}.unitn IS NOT NULL
                                         THEN {$this->video_table}.unitn
                                END),
                                (CASE 
                                     WHEN {$this->video_table}.apartrange = 1 AND {$this->video_table}.unit IS NULL
                                         THEN {$this->video_table}.unit IS NULL
                                     WHEN {$this->video_table}.apartrange = 1 AND {$this->video_table}.unit IS NOT NULL
                                         THEN {$this->video_table}.unit
                                END),
                                {$this->video_table}.unitfn IS NULL,
                                {$this->video_table}.unitfn,
                                {$this->video_table}.unitf IS NULL,
                                {$this->video_table}.unitf,
                                (CASE 
                                     WHEN {$this->video_table}.apartrange = 0 AND {$this->video_table}.unitn IS NULL
                                         THEN {$this->video_table}.unitn IS NULL
                                     WHEN {$this->video_table}.apartrange = 0 AND {$this->video_table}.unitn IS NOT NULL
                                         THEN {$this->video_table}.unitn
                                END),
                                (CASE 
                                     WHEN {$this->video_table}.apartrange = 0 AND {$this->video_table}.unit IS NULL
                                         THEN {$this->video_table}.unit IS NULL
                                     WHEN {$this->video_table}.apartrange = 0 AND {$this->video_table}.unit IS NOT NULL
                                         THEN {$this->video_table}.unit
                                END),
                                {$this->video_table}.apartmin,
                                {$this->video_table}.apartmax,
                                {$this->video_table}.apartmin2,
                                {$this->video_table}.apartmax2,
                                {$this->video_table}.label
                           ;",
                    $this->current_user->ID)
            );
            return ['success' => true, 'videos' => $results];
        }else{
            return ['success' => false];
        }
    }

    public function verify_credential($request){
        if($this->current_user->exists()) {
            return ['success' => true];
        }else{
            return ['success' => false];
        }
    }
}