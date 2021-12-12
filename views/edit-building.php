<div class=\'wrap\'>
    <h2>Edit a Building</h2>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="save_building_hook"/>
        <input type="hidden" name="building_id" value="<?php echo $building->id;?>"/>
        <div class="options">
            <p><label for="property">Property</label></p>
            <select required name="property_id" id="property">
                <option value="">Select a Property</option>
                <?php foreach ($properties as $property){?>
                    <option value="<?php echo $property->id;?>" <?php if($property->id == $building->property_id) echo "selected";?>><?php echo $property->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="options">
            <p><label for="name">Building Name</label></p>
            <input type="text" name="name" value="<?php echo $building->name;?>" required id="name"/>
        </div>
        <div class="options">
            <p><label for="address">Address</label></p>
            <input type="text" name="address" value="<?php echo $building->address;?>" required id="address"/>
        </div>
        <?php
        wp_nonce_field( 'building_save_nonce', 'building_save_nonce' );
        submit_button('Save');
        ?>
    </form>
</div>