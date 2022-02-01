<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()) ?></h2>
    <div id="ajax-feed"></div>
    <?php wp_nonce_field('ajax_request_nonce', 'ajax_request_nonce'); ?>
    <a
        <?php if (empty($_GET['status']) || $_GET['status'] == 'publish') echo 'class="active-link"'?>
            href="<?php echo esc_url(admin_url('admin.php?page=property-manager-admin&status=publish')); ?>">
        Active (<?php echo $active[0]->counts; ?>)
    </a> |
    <a
        <?php if (!empty($_GET['status']) && $_GET['status'] == 'draft') echo 'class="active-link"'?>
            href="<?php echo esc_url(admin_url('admin.php?page=property-manager-admin&status=draft')); ?>">
        Draft (<?php echo $draft[0]->counts; ?>)
    </a> |
    <a
        <?php if (!empty($_GET['status']) && $_GET['status'] == 'trash') echo 'class="active-link"'?>
            href="<?php echo esc_url(admin_url('admin.php?page=property-manager-admin&status=trash')); ?>">
        Trashed (<?php echo $trashed[0]->counts; ?>)
    </a>
    <table class="widefat fixed" cellspacing="0">
        <thead>
        <tr>
            <th class="manage-column" scope="col">ID</th>
            <th class="manage-column column-title column-primary" scope="col">Property Name</th>
            <th class="manage-column" scope="col">Total Buildings</th>
            <th class="manage-column" scope="col">Status</th>
            <th class="manage-column" scope="col">Create At</th>
            <th class="manage-column" scope="col">Update At</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th class="manage-column" scope="col">ID</th>
            <th class="manage-column column-title column-primary" scope="col">Property Name</th>
            <th class="manage-column" scope="col">Total Buildings</th>
            <th class="manage-column" scope="col">Status</th>
            <th class="manage-column" scope="col">Create At</th>
            <th class="manage-column" scope="col">Update At</th>
        </tr>
        </tfoot>
        <tbody>
        <?php for ($i = 0; $i < count($properties); $i++) { ?>
            <tr class="<?php if ($i % 2 != 0) echo "alternate"; ?>"
                data-score="<?php echo $properties[$i]->id; ?>">
                <th scope="row"><?php echo $properties[$i]->id; ?></th>
                <td class="title column-title has-row-actions column-primary">
                    <strong>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=buildings&property_id=' . $properties[$i]->id)); ?>">
                            <?php echo $properties[$i]->name; ?>
                        </a>
                    </strong>
                    <div class="row-actions">
                        <span>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=edit-property&id=' . $properties[$i]->id)); ?>">
                                Edit</a>
                            |
                        </span>
                        <?php if ($properties[$i]->status != 'trash') { ?>
                            <span>
                                <a href="javascript:void(0);"
                                   onclick="trashProperty(<?php echo $properties[$i]->id; ?>)">
                                    Trash
                                </a>
                            </span>
                        <?php } else { ?>
                            <span>
                                <a href="javascript:void(0);"
                                   onclick="restoreProperty(<?php echo $properties[$i]->id; ?>)">
                                    Restore
                                </a>
                            </span>
                        <?php } ?>
                    </div>
                </td>
                <td><?php echo $properties[$i]->buildings; ?></td>
                <td><?php echo $properties[$i]->status ?></td>
                <td><?php echo (new DateTime($properties[$i]->created_at))->format('m/d/Y h:i a'); ?></td>
                <td><?php echo (new DateTime($properties[$i]->updated_at))->format('m/d/Y h:i a'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
