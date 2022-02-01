<?php

namespace PROPERTY_MANAGER_ADMIN;

class Activator
{
    public static function activate() {
        global $wpdb;

        if (!function_exists('dbDelta')){
            require_once ABSPATH.'wp-admin/includes/upgrade.php';
        }

        $collate = '';

        if ($wpdb->has_cap('collation')){
            $collate = $wpdb->get_charset_collate();
        }

        $property_schema = "CREATE TABLE {$wpdb->prefix}properties (
                          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,PRIMARY KEY  (id),
                          name varchar(255),
                          user_id int ,
                          status varchar (255) default 'draft',
                          created_at TIMESTAMP default current_timestamp,
                          updated_at TIMESTAMP default current_timestamp
                          ) $collate;";

        maybe_create_table($wpdb->prefix.'properties', $property_schema);

        $building_schema = "CREATE TABLE {$wpdb->prefix}buildings (
                          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,PRIMARY KEY  (id),
                          property_id int,
                          user_id int,
                          name varchar (255),
                          address varchar (255),
                          listing_order BOOL default 0,
                          sort int default 0,
                          status varchar (255) default 'draft',
                          created_at TIMESTAMP default current_timestamp,
                          updated_at TIMESTAMP default current_timestamp
                          ) $collate;";

        maybe_create_table($wpdb->prefix.'buildings', $building_schema);

        $tour_video_schema = "CREATE TABLE {$wpdb->prefix}tour_videos (
                          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,PRIMARY KEY  (id),
                          property_id int,
                          building_id int,
                          user_id int,
                          label varchar (255),
                          youtube varchar (255),
                          vimeo varchar (255),
                          wistia varchar (255),
                          description varchar (255),
                          unitf varchar (255),
                          unitfn int,
                          unit varchar (255),
                          unitn int,
                          bedroom int,
                          bathroom decimal,
                          apartrange BOOL default 0,
                          apartmin int,
                          apartmax int,
                          apartmin2 int,
                          apartmax2 int,
                          status varchar (255) default 'publish',
                          created_at TIMESTAMP default current_timestamp,
                          updated_at TIMESTAMP default current_timestamp
                          ) $collate;";

        maybe_create_table($wpdb->prefix.'tour_videos', $tour_video_schema);
    }
}