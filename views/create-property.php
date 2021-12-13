<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title())?></h1>

    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="save_property_hook"/>
        <div id="universal-message-container">
            <div class="options">
                <p>
                    <label>Property Name</label>
                    <input type="text" name="name" value="" required/>
                </p>
            </div>
        </div>
        <?php
            wp_nonce_field( 'property_save_nonce', 'property_save_nonce' );
            submit_button('Create a Property');
        ?>
    </form>
</div>