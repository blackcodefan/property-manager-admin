<?php

namespace PROPERTY_MANAGER_ADMIN;

class PropertyController
{
    private $table;
    private $building_table;
    private $db;
    private $current_user;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->current_user = wp_get_current_user();
        $this->table = $wpdb->prefix.'properties';
        $this->building_table = $wpdb->prefix.'buildings';
    }

    public function index($status = 'all'){
        $where_clause = " WHERE {$this->table}.user_id=%d";
        if ($status != 'all')
            $where_clause .= " AND {$this->table}.status='{$status}'";
        $results = $this->db->get_results(
            $this->db->prepare(
                "SELECT {$this->table}.*,
                              COUNT({$this->building_table}.id) as buildings
                       FROM  {$this->table}
                       LEFT JOIN {$this->building_table}
                       ON {$this->table}.id={$this->building_table}.property_id{$where_clause}
                       GROUP BY {$this->table}.id;",
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

    public function save($property_name, $status, $property_id = null){
        if ($property_id == null)
            return $this->db->insert($this->table,
                [
                    'name' => $property_name,
                    'user_id' => $this->current_user->ID,
                    'status' => $status
                ]
            );
        else{
            return $this->db->update($this->table, 
                [
                    'name' => $property_name,
                    'status' => $status,
                    'updated_at' => date('Y-m-d h-i-s')
                ], 
                [
                    'id' => $property_id
                ]);
        }
    }
}