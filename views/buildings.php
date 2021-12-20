<div class='wrap'>
    <h2><?php echo esc_html(get_admin_page_title()) ?></h2>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="redirect_hook"/>
        <input type="hidden" name="redirect" value="buildings"/>
        <div class="options">
            <p>
                <label for="property">Filter By Property</label>
                <select name="property_id" id="property">
                    <option value="">Select a Property</option>
                    <?php foreach ($properties as $property) { ?>
                        <option value="<?php echo $property->id; ?>" <?php if (isset($_REQUEST['property_id']) && $_REQUEST['property_id'] == $property->id) echo "selected"; ?>><?php echo $property->name; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="button button-primary">Apply</button>
            </p>
        </div>
        <?php
        wp_nonce_field('redirect_hook_nonce', 'redirect_hook_nonce');
        ?>
    </form>
    <table class="widefat fixed" cellspacing="0">
        <thead>
        <tr>
            <th class="manage-column" scope="col">ID</th>
            <th class="manage-column column-title column-primary" scope="col">Building Name</th>
            <th class="manage-column" scope="col">Property Name</th>
            <th class="manage-column" scope="col">Address</th>
            <th class="manage-column" scope="col">Total Videos</th>
            <th class="manage-column" scope="col">Listing</th>
            <th class="manage-column" scope="col">Create At</th>
            <th class="manage-column" scope="col">Update At</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th class="manage-column" scope="col">ID</th>
            <th class="manage-column column-title column-primary" scope="col">Building Name</th>
            <th class="manage-column" scope="col">Property Name</th>
            <th class="manage-column" scope="col">Address</th>
            <th class="manage-column" scope="col">Total Videos</th>
            <th class="manage-column" scope="col">Listing</th>
            <th class="manage-column" scope="col">Create At</th>
            <th class="manage-column" scope="col">Update At</th>
        </tr>
        </tfoot>
        <tbody>
        <?php for ($i = 0; $i < count($buildings); $i++) { ?>
            <tr class="<?php if ($i % 2 != 0) echo "alternate"; ?>">
                <th scope="row"><?php echo $buildings[$i]->id; ?></th>
                <td class="title column-title has-row-actions column-primary">
                    <strong>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=videos&building_id=' . $buildings[$i]->id)); ?>"><?php echo $buildings[$i]->name; ?></a>
                    </strong>
                    <div class="row-actions">
                        <span><a href="<?php echo esc_url(admin_url('admin.php?page=edit-building&id=' . $buildings[$i]->id)); ?>">Edit</a></span>
                    </div>
                </td>
                <td><?php echo $buildings[$i]->property_name; ?></td>
                <td><?php echo $buildings[$i]->address; ?></td>
                <td><?php echo $buildings[$i]->videos; ?></td>
                <td>
                    <?php
                    if($buildings[$i]->listing_order)
                        echo 'Line video first';
                    else
                        echo 'Unique video first';
                    ?>
                </td>
                <td><?php echo (new DateTime($buildings[$i]->created_at))->format('m/d/Y h:i a'); ?> ?></td>
                <td><?php echo (new DateTime($buildings[$i]->updated_at))->format('m/d/Y h:i a'); ?> ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>