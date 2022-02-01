<div class='wrap'>
    <h2>Edit a Video</h2>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="add-video-form">
        <input type="hidden" name="action" value="save_video_hook"/>
        <input type="hidden" name="video_id" value="<?php echo $video->id; ?>"/>
        <div class="options">
            <div class="label">
                <label for="building">Building:</label>
            </div>
            <select required name="building_id" id="building">
                <option value="">Select a Building</option>
                <?php foreach ($buildings as $building) { ?>
                    <option value="<?php echo $building->id; ?>" <?php if ($building->id == $video->building_id) echo "selected"; ?>><?php echo $building->property_name . '-' . $building->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="c-row">
            <div class="options">
                <div class="label">
                    <label for="unit_floor">Unit Floor:</label>
                </div>
                <input type="text" name="unit_floor" required id="unit_floor" value="<?php echo $video->unitf.$video->unitfn; ?>"/>
            </div>
            <div class="options">
                <div class="label">
                    <label for="unit">Unit # :</label>
                </div>
                <input type="text" name="unit" required id="unit" value="<?php echo $video->unit.$video->unitn; ?>"/>
            </div>
        </div>
        <div class="c-row">
            <div class="options">
                <div class="label">
                    <label for="bedroom">Bedrooms:</label>
                </div>
                <select name="bedroom" required id="bedroom">
                    <option value="0" <?php if ($video->bedroom == 0) echo "selected"; ?>>0</option>
                    <option value="1" <?php if ($video->bedroom == 1) echo "selected"; ?>>1</option>
                    <option value="2" <?php if ($video->bedroom == 2) echo "selected"; ?>>2</option>
                    <option value="3" <?php if ($video->bedroom == 3) echo "selected"; ?>>3</option>
                    <option value="4" <?php if ($video->bedroom == 4) echo "selected"; ?>>4</option>
                    <option value="5" <?php if ($video->bedroom == 5) echo "selected"; ?>>5</option>
                </select>
            </div>
            <div class="options">
                <div class="label">
                    <label for="bathroom">Bathrooms:</label>
                </div>
                <select name="bathroom" required id="bathroom">
                    <option value="1" <?php if ($video->bathroom == 1) echo "selected"; ?>>1</option>
                    <option value="1.5" <?php if ($video->bathroom == 1.5) echo "selected"; ?>>1.5</option>
                    <option value="2" <?php if ($video->bathroom == 2) echo "selected"; ?>>2</option>
                    <option value="2.5" <?php if ($video->bathroom == 2.5) echo "selected"; ?>>2.5</option>
                    <option value="3" <?php if ($video->bathroom == 3) echo "selected"; ?>>3</option>
                    <option value="3.5" <?php if ($video->bathroom == 3.5) echo "selected"; ?>>3.5</option>
                    <option value="4" <?php if ($video->bathroom == 4) echo "selected"; ?>>4</option>
                </select>
            </div>
        </div>
        <div class="options" id="radio-box">
            <div class="label">
                <label for="apart_type">Is this a line video or a unique apartment video?</label>
            </div>
            <fieldset>
                <label>
                    <input type="radio" name="apartment-type-radio"
                           value="true" <?php if ($video->apartrange) echo "checked"; ?>>
                    Line video
                </label>
                <label>
                    <input type="radio" name="apartment-type-radio"
                           value="false" <?php if (!$video->apartrange) echo "checked"; ?>>
                    Unique apartment
                </label>
                <br>
            </fieldset>
        </div>
        <?php if ($video->apartrange) { ?>
            <div class="options range">
                <div class="label">
                    <label for="min">Enter Range:</label>
                </div>
                <input type="number" name="min" required id="min" value="<?php echo $video->apartmin; ?>"/>
                <input type="number" name="max" required id="max" value="<?php echo $video->apartmax; ?>"/>
            </div>
            <?php if (!empty($video->apartmin2)) {?>
                <div class="options range">
                    <div class="label">
                        <label for="min">Enter Second Range (optional):</label>
                    </div>
                    <input type="number" name="min2" value="<?php echo $video->apartmin2; ?>"/>
                    <input type="number" name="max2" value="<?php echo $video->apartmax2; ?>"/>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="options">
            <div class="label">
                <label for="label">Extra Label</label>
            </div>
            <input type="text" name="label" id="label" value="<?php echo $video->label; ?>"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="description">Description</label>
            </div>
            <textarea type="text" name="description" required
                      id="description"><?php echo $video->description; ?></textarea>
        </div>
        <div class="options">
            <div class="label"><label for="youtube">Youtube URL:</label></div>
            <input type="text" name="youtube" id="youtube" value="<?php echo $video->youtube; ?>"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="vimeo">Vimeo URL:</label>
            </div>
            <input type="text" name="vimeo" id="vimeo" value="<?php echo $video->vimeo; ?>"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="wistia">Wistia URL:</label>
            </div>
            <input type="text" name="wistia" id="wistia" value="<?php echo $video->wistia; ?>"/>
        </div>
        <div class="options">
            <div class="label">
                <label for="status">Status</label>
            </div>
            <select name="status" id="status" required>
                <option value="">Select a status</option>
                <option value="draft" <?php if ($video->status == 'draft') echo 'selected';?>>Draft</option>
                <option value="publish" <?php if ($video->status == 'publish') echo 'selected';?>>Publish</option>
                <option value="trash" <?php if ($video->status == 'trash') echo 'selected';?>>Trash</option>
            </select>
        </div>
        <?php
        wp_nonce_field('video_save_nonce', 'video_save_nonce');
        submit_button('Save');
        ?>
    </form>
</div>