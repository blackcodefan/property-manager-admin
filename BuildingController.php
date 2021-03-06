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

    public function index($status = 'all'){
        $where_clause = " WHERE {$this->table}.user_id=%d";
        if (isset($_GET['property_id']) && $_GET['property_id'] != ''){
            $where_clause .= " AND {$this->table}.property_id={$_GET['property_id']}";
        }
        if ($status != 'all'){
            $where_clause .= " AND {$this->table}.status='{$status}'";
        }
        $results = $this->db->get_results(
            $this->db->prepare(
                "SELECT {$this->table}.*, 
                              {$this->property_table}.name as property_name, 
                              COUNT({$this->video_table}.id) as videos 
                       FROM  {$this->table} 
                       LEFT JOIN {$this->video_table} 
                       ON {$this->table}.id={$this->video_table}.building_id 
                       LEFT JOIN {$this->property_table} 
                       ON {$this->table}.property_id={$this->property_table}.id
                       {$where_clause}
                       GROUP BY {$this->table}.id
                       ORDER BY {$this->table}.sort;",
                $this->current_user->ID)
        );

        return $results;
    }

    public function getOrderedBuildings(){

        $results = $this->db->get_results(
            $this->db->prepare(
                "SELECT {$this->table}.*, 
                              {$this->property_table}.name as property_name
                       FROM  {$this->table} 
                       LEFT JOIN {$this->video_table} 
                       ON {$this->table}.id={$this->video_table}.building_id 
                       LEFT JOIN {$this->property_table} 
                       ON {$this->table}.property_id={$this->property_table}.id
                       WHERE {$this->table}.user_id=%d
                       AND {$this->property_table}.status='publish'
                       AND {$this->table}.status='publish'
                       GROUP BY {$this->table}.id
                       ORDER BY {$this->table}.sort;",
                $this->current_user->ID)
        );

        return $results;
    }

    public function get($id){
        $result = $this->db->get_results($this->db->prepare(
            "SELECT * from {$this->table} WHERE id=%d", $id
        ));

        return $result[0];
    }

    public function destroy($id){
        $this->db->get_results($this->db->prepare(
            "DELETE FROM {$this->table} WHERE id=%d;", $id
        ));

        $this->db->get_results($this->db->prepare(
            "UPDATE {$this->video_table}
                  SET property_id=NULL, building_id=NULL, status='draft'
                  WHERE building_id=%d
                   ;",
            $id
        ));

        return true;
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

    public function setOrder($data) {
        $VALUE = "";

        for ($i =0; $i < count($data); $i++) {
            $row = $data[$i];
            if ($i == count($data) - 1){
                $VALUE .= "({$row->id}, {$row->order})";
            }else {
                $VALUE .= "({$row->id}, {$row->order}), ";
            }
        }

        $query = "INSERT INTO {$this->table} (id, sort) VALUES {$VALUE} ON DUPLICATE KEY UPDATE sort = VALUES(sort);";
        return $this->db->get_results($this->db->prepare($query));

    }

    public function count($status){
        $where_clause = " WHERE user_id=%d AND status='{$status}'";

        return $this->db->get_results(
            $this->db->prepare(
                "SELECT COUNT('id') as counts 
                      FROM  {$this->table}
                      {$where_clause}
                ;",
                $this->current_user->ID)
        );
    }
}