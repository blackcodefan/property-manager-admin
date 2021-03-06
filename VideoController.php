<?php

namespace PROPERTY_MANAGER_ADMIN;

class VideoController
{
    private $table;
    private $db;
    private $current_user;
    private $building_table;
    private $property_table;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->current_user = wp_get_current_user();
        $this->table = $wpdb->prefix.'tour_videos';
        $this->building_table = $wpdb->prefix.'buildings';
        $this->property_table = $wpdb->prefix.'properties';
    }

    /**=======================
     * @param mixed ...$args
     * @return array|null|object
     */
    public function index(...$args){

        $where_clause = " WHERE {$this->table}.user_id=%d";
        if ($args[0] != 'all') {
            $where_clause .= " AND {$this->table}.status='{$args[0]}'";
        }
        if (isset($_GET['building_id']) && $_GET['building_id'] != ''){
            $where_clause .= " AND {$this->table}.building_id={$_GET['building_id']}";
        }

        $order_clause = "ORDER BY ";

        if ($args[1] == 'description'){
            $order_clause .= "{$this->table}.description {$args[2]}";
        }else if($args[1] == 'building'){
            $order_clause .= "{$this->building_table}.name {$args[2]}";
        }else if($args[1] == 'property'){
            $order_clause .= "{$this->property_table}.name {$args[2]}";
        }
        else{
            $order_clause .= "{$this->building_table}.address {$args[2]}";
        }

        $results = $this->db->get_results(
            $this->db->prepare(
                "SELECT {$this->table}.*,
                              {$this->property_table}.name as property_name,
                              {$this->building_table}.name as building_name,
                              {$this->building_table}.address as address
                        FROM  {$this->table}
                        LEFT JOIN {$this->property_table}
                        ON {$this->table}.property_id={$this->property_table}.id
                        LEFT JOIN {$this->building_table}
                        ON {$this->table}.building_id={$this->building_table}.id
                        {$where_clause}
                        {$order_clause}
                        ;",
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

    public function trash($id, $status){
        return $this->db->update($this->table, ['status' => $status, 'updated_at' => date('Y-m-d h-i-s')], ['id' => $id]);
    }

    public function count($status = 'all'){
        $where_clause = " WHERE user_id=%d AND status='{$status}'";

        return $this->db->get_results(
            $this->db->prepare(
                "SELECT COUNT('id') as counts
                      FROM  {$this->table}
                      {$where_clause};",
                $this->current_user->ID)
        );
    }

    public function save($video, $video_id = null){

        if ($video_id == null){
            $video['user_id'] = $this->current_user->ID;

            return $this->db->insert($this->table, $video);
        }else{
            $video['updated_at'] = date('Y-m-d h-i-s');
            return $this->db->update($this->table, $video, ['id' => $video_id]);
        }
    }
}