<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/19/2021
 * Time: 5:32 AM
 */

namespace PROPERTY_MANAGER_ADMIN;


class SettingController
{
    private $db;
    private $current_user;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->current_user = wp_get_current_user();
    }

    public function getVideosSetting(){
        return get_user_meta($this->current_user->ID);
    }

    public function setVideosSetting($settings){

        update_user_meta($this->current_user->ID, 'pma_v_address', !empty($settings['pma_v_address']));
        update_user_meta($this->current_user->ID, 'pma_v_description', !empty($settings['pma_v_description']));
        update_user_meta($this->current_user->ID, 'pma_v_building', !empty($settings['pma_v_building']));
        update_user_meta($this->current_user->ID, 'pma_v_property', !empty($settings['pma_v_property']));
        update_user_meta($this->current_user->ID, 'pma_v_label', !empty($settings['pma_v_label']));
        update_user_meta($this->current_user->ID, 'pma_v_bedroom', !empty($settings['pma_v_bedroom']));
        update_user_meta($this->current_user->ID, 'pma_v_bathroom', !empty($settings['pma_v_bathroom']));
        update_user_meta($this->current_user->ID, 'pma_v_type', !empty($settings['pma_v_type']));
        update_user_meta($this->current_user->ID, 'pma_v_min', !empty($settings['pma_v_min']));
        update_user_meta($this->current_user->ID, 'pma_v_max', !empty($settings['pma_v_max']));

        return true;
    }
}