<div class='wrap'>
    <h2><?php echo esc_html(get_admin_page_title()) ?></h2>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="save_building_hook"/>
        <div class="options">
            <div class="label">
                <label for="property">Property</label>
            </div>
            <select required name="property_id" id="property">
                <option value="">Select a Property</option>
                <?php foreach ($properties as $property) { ?>
                    <option value="<?php echo $property->id; ?>"><?php echo $property->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="options">
            <div class="label">
                <label for="name">Building Name</label>
            </div>
            <input type="text" name="name" value="" required id="name"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="address">Address</label>
            </div>
            <input type="text" name="address" value="" required id="address"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="apart_type">
                    Video listing order
                </label>
            </div>
            <fieldset>
                <label>
                    <input type="radio" name="listing_order" value="true">
                    Line video first
                </label>
                <label>
                    <input type="radio" name="listing_order" value="false" checked>
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
                <option value="draft">Draft</option>
                <option value="publish">Publish</option>
                <option value="trash">Trash</option>
            </select>
        </div>
        <?php
        wp_nonce_field('building_save_nonce', 'building_save_nonce');
        submit_button('Create a building');
        ?>
    </form>
</div>