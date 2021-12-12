<div class='wrap'>
    <h2><?php echo esc_html(get_admin_page_title())?></h2>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="save_building_hook"/>
        <div class="options">
            <p><label for="property">Property</label></p>
            <select required name="property_id" id="property">
                <option value="">Select a Property</option>
                <?php foreach ($properties as $property){?>
                    <option value="<?php echo $property->id;?>"><?php echo $property->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="options">
            <p><label for="name">Building Name</label></p>
            <input type="text" name="name" value="" required id="name"/>
        </div>
        <div class="options">
            <p><label for="address">Address</label></p>
            <input type="text" name="address" value="" required id="address"/>
        </div>
        <?php
        wp_nonce_field( 'building_save_nonce', 'building_save_nonce' );
        submit_button('Create a building');
        ?>
    </form>
</div>