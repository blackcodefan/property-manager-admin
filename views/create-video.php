<div class=\'wrap\'>
    <h2><?php echo esc_html(get_admin_page_title())?></h2>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="add-video-form">
        <input type="hidden" name="action" value="save_video_hook"/>
        <div class="options">
            <p><label for="building">Building:</label></p>
            <select required name="building_id" id="building">
                <option value="">Select a Building</option>
                <?php foreach ($buildings as $building){?>
                    <option value="<?php echo $building->id;?>"><?php echo $building->property_name.'-'.$building->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <div class="options">
                <p><label for="unit_floor">Unit Floor:</label></p>
                <input type="text" name="unit_floor" required id="unit_floor"/>
            </div>
            <div class="options">
                <p><label for="unit">Unit # :</label></p>
                <input type="number" name="unit" required id="unit"/>
            </div>
        </div>
        <div class="row">
            <div class="options">
                <p><label for="bedroom">Bedrooms:</label></p>
                <select name="bedroom" required id="bedroom">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="options">
                <p><label for="bathroom">Bathrooms:</label></p>
                <select name="bathroom" required id="bathroom">
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                </select>
            </div>
        </div>
        <div class="options" id="radio-box">
            <p><label for="apart_type">Is this a line video or a unique apartment video?</label></p>
            <fieldset>
                <label><input type="radio" name="apartment-type-radio" value="true">
                    Yes
                </label>
                <label><input type="radio" name="apartment-type-radio" value="false" checked>
                    No
                </label><br>
            </fieldset>
        </div>
        <div class="options">
            <p><label for="description">Description</label></p>
            <textarea type="text" name="description" required id="description"></textarea>
        </div>
        <div class="options">
            <p><label for="youtube">Youtube URL:</label></p>
            <input type="text" name="youtube" id="youtube"/>
        </div>
        <div class="options">
            <p><label for="vimeo">Vimeo URL:</label></p>
            <input type="text" name="vimeo" id="vimeo"/>
        </div>
        <div class="options">
            <p><label for="wistia">Wistia URL:</label></p>
            <input type="text" name="wistia" id="wistia"/>
        </div>
        <?php
        wp_nonce_field( 'video_save_nonce', 'video_save_nonce' );
        submit_button('Add a Video');
        ?>
    </form>
</div>