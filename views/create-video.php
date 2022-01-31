<div class='wrap'>
    <h2><?php echo esc_html(get_admin_page_title()) ?></h2>
    <form method="post"
          action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
          id="add-video-form">
        <input type="hidden" name="action" value="save_video_hook"/>
        <div class="options">
            <div class="label">
                <label for="building">Building:</label>
            </div>
            <select required name="building_id" id="building">
                <option value="">Select a Building</option>
                <?php foreach ($buildings as $building) { ?>
                    <option value="<?php echo $building->id; ?>"><?php echo $building->property_name . '-' . $building->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="c-row">
            <div class="options">
                <div class="label">
                    <label for="unit_floor">Unit Floor:</label>
                </div>
                <input type="text" name="unit_floor" required id="unit_floor"/>
            </div>
            <div class="options">
                <div class="label">
                    <label for="unit">Unit # :</label>
                </div>
                <input type="text" name="unit" required id="unit"/>
            </div>
        </div>
        <div class="c-row">
            <div class="options">
                <div class="label">
                    <label for="bedroom">Bedrooms:</label>
                </div>
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
                <div class="label">
                    <label for="bathroom">Bathrooms:</label>
                </div>
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
            <div class="label">
                <label for="apart_type">Is this a line video or a unique apartment video?</label>
            </div>
            <fieldset>
                <label>
                    <input type="radio" name="apartment-type-radio" value="true"/>
                    Line video
                </label>
                <label>
                    <input type="radio" name="apartment-type-radio" value="false" checked/>
                    Unique apartment
                </label><br>
            </fieldset>
        </div>
        <div class="options">
            <div class="label">
                <label for="label">Extra Label</label>
            </div>
            <input type="text" name="label" id="label"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="description">Description</label>
            </div>
            <textarea type="text" name="description" required id="description"></textarea>
        </div>
        <div class="options">
            <div class="label">
                <label for="youtube">Youtube URL:</label>
            </div>
            <input type="text" name="youtube" id="youtube"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="vimeo">Vimeo URL:</label>
            </div>
            <input type="text" name="vimeo" id="vimeo"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="wistia">Wistia URL:</label>
            </div>
            <input type="text" name="wistia" id="wistia"/>
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
        wp_nonce_field('video_save_nonce', 'video_save_nonce');
        submit_button('Add a Video');
        ?>
    </form>
</div>