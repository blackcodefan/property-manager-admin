<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()) ?></h1>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="save_property_hook"/>
        <div id="universal-message-container">
            <div class="options">
                <p>
                    <label for="property">Property Name</label>
                    <input type="text" id="property" name="name" value="" required/>
                </p>
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
        </div>
        <?php
        wp_nonce_field('property_save_nonce', 'property_save_nonce');
        submit_button('Create a Property');
        ?>
    </form>
</div>