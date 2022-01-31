<div class='wrap'>
    <h2>Edit a Building</h2>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="save_building_hook"/>
        <input type="hidden" name="building_id" value="<?php echo $building->id;?>"/>
        <div class="options">
            <div class="label"><label for="property">Property</label></div>
            <select required name="property_id" id="property">
                <option value="">Select a Property</option>
                <?php foreach ($properties as $property){?>
                    <option value="<?php echo $property->id;?>" <?php if($property->id == $building->property_id) echo "selected";?>><?php echo $property->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="options">
            <div class="label">
                <label for="name">Building Name</label>
            </div>
            <input type="text" name="name" value="<?php echo $building->name;?>" required id="name"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="address">Address</label>
            </div>
            <input type="text" name="address"
                   value="<?php echo $building->address;?>" required id="address"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="apart_type">
                    Video listing order
                </label>
            </div>
            <fieldset>
                <label>
                    <input type="radio"
                           name="listing_order"
                           value="true" <?php if($building->listing_order) echo 'checked';?>>
                    Line video first
                </label>
                <label>
                    <input type="radio"
                           name="listing_order"
                           value="false" <?php if(!$building->listing_order) echo 'checked';?>>
                    Unique apartment first
                </label>
            </fieldset>
        </div>
        <div class="options">
            <div class="label">
                <label for="status">Status</label>
            </div>
            <select name="status" id="status" required>
                <option value="">Select a status</option>
                <option value="draft" <?php if ($building->status == 'draft') echo 'selected';?>>Draft</option>
                <option value="publish" <?php if ($building->status == 'publish') echo 'selected';?>>Publish</option>
                <option value="trash" <?php if ($building->status == 'trash') echo 'selected';?>>Trash</option>
            </select>
        </div>
        <?php
        wp_nonce_field( 'building_save_nonce', 'building_save_nonce' );
        submit_button('Save');
        ?>
    </form>
</div>