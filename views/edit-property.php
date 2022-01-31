<div class="wrap">
    <h1>Edit a Property</h1>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="save_property_hook"/>
        <input type="hidden" name="property_id" value="<?php echo $property->id; ?>"/>
        <div id="universal-message-container">
            <div class="options">
                <p>
                    <label for="property">Property Name</label>
                    <input type="text" id="property" name="name" value="<?php echo $property->name; ?>" required/>
                </p>
            </div>
            <div class="options">
                <div class="label">
                    <label for="status">Status</label>
                </div>
                <select name="status" id="status" required>
                    <option value="">Select a status</option>
                    <option value="draft" <?php if ($property->status == 'draft') echo 'selected';?>>Draft</option>
                    <option value="publish" <?php if ($property->status == 'publish') echo 'selected';?>>Publish</option>
                    <option value="trash" <?php if ($property->status == 'trash') echo 'selected';?>>Trash</option>
                </select>
            </div>
        </div>
        <?php
        wp_nonce_field('property_save_nonce', 'property_save_nonce');
        submit_button('Save');
        ?>
    </form>
</div>