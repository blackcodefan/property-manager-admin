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
        </div>
        <?php
        wp_nonce_field('property_save_nonce', 'property_save_nonce');
        submit_button('Save');
        ?>
    </form>
</div>