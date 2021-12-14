<?php
namespace PROPERTY_MANAGER_ADMIN;

class BuildingController
{
    private $table;
    private $db;
    private $current_user;
    private $video_table;
    private $property_table;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->current_user = wp_get_current_user();
        $this->table = $wpdb->prefix.'buildings';
        $this->video_table = $wpdb->prefix.'tour_videos';
        $this->property_table = $wpdb->prefix.'properties';
    }

    public function index(){
        $where_clause = " WHERE {$this->table}.user_id=%d";
        if (isset($_GET['property_id']) && $_GET['property_id'] != ''){
            $where_clause .= " AND {$this->table}.property_id={$_GET['property_id']}";
        }
        $results = $this->db->get_results(
            $this->db->prepare(
                "SELECT {$this->table}.*, {$this->property_table}.name as property_name, COUNT({$this->video_table}.id) as videos FROM  {$this->table} LEFT JOIN {$this->video_table} ON {$this->table}.id={$this->video_table}.building_id LEFT JOIN {$this->property_table} ON {$this->table}.property_id={$this->property_table}.id{$where_clause} GROUP BY {$this->table}.id;", $this->current_user->ID)
        );

        return $results;
    }

    public function get($id){
        $result = $this->db->get_results($this->db->prepare(
            "SELECT * from {$this->table} WHERE id=%d", $id
        ));

        return $result[0];
    }

    public function save($building, $building_id){
        if ($building_id == null){
            $building['user_id'] = $this->current_user->ID;
            return $this->db->insert($this->table, $building);
        }else{
            $building['updated_at'] = date('Y-m-d h-i-s');
            return $this->db->update($this->table, $building, ['id' => $building_id]);
        }

    }
}