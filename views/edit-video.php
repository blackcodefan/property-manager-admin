<div class=\'wrap\'>
    <h2>Edit a Video</h2>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="add-video-form">
        <input type="hidden" name="action" value="save_video_hook"/>
        <input type="hidden" name="video_id" value="<?php echo $video->id;?>"/>
        <div class="options">
            <p><label for="building">Building:</label></p>
            <select required name="building_id" id="building">
                <option value="">Select a Building</option>
                <?php foreach ($buildings as $building){?>
                    <option value="<?php echo $building->id;?>" <?php if ($building-> id == $video->building_id) echo "selected";?>><?php echo $building->property_name.'-'.$building->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row">
            <div class="options">
                <p><label for="unit_floor">Unit Floor:</label></p>
                <input type="text" name="unit_floor" required id="unit_floor" value="<?php echo $video->unitf;?>"/>
            </div>
            <div class="options">
                <p><label for="unit">Unit # :</label></p>
                <input type="number" name="unit" required id="unit" value="<?php echo $video->unit;?>"/>
            </div>
        </div>
        <div class="row">
            <div class="options">
                <p><label for="bedroom">Bedrooms:</label></p>
                <select name="bedroom" required id="bedroom">
                    <option value="0" <?php if ($video->bedroom == 0) echo "selected";?>>0</option>
                    <option value="1" <?php if ($video->bedroom == 1) echo "selected";?>>1</option>
                    <option value="2" <?php if ($video->bedroom == 2) echo "selected";?>>2</option>
                    <option value="3" <?php if ($video->bedroom == 3) echo "selected";?>>3</option>
                    <option value="4" <?php if ($video->bedroom == 4) echo "selected";?>>4</option>
                    <option value="5" <?php if ($video->bedroom == 5) echo "selected";?>>5</option>
                </select>
            </div>
            <div class="options">
                <p><label for="bathroom">Bathrooms:</label></p>
                <select name="bathroom" required id="bathroom">
                    <option value="1" <?php if($video->bathroom == 1) echo "selected";?>>1</option>
                    <option value="1.5" <?php if($video->bathroom == 1.5) echo "selected";?>>1.5</option>
                    <option value="2" <?php if($video->bathroom == 2) echo "selected";?>>2</option>
                    <option value="2.5" <?php if($video->bathroom == 2.5) echo "selected";?>>2.5</option>
                    <option value="3" <?php if($video->bathroom == 3) echo "selected";?>>3</option>
                    <option value="3.5" <?php if($video->bathroom == 3.5) echo "selected";?>>3.5</option>
                    <option value="4" <?php if($video->bathroom == 4) echo "selected";?>>4</option>
                </select>
            </div>
        </div>
        <div class="options" id="radio-box">
            <p><label for="apart_type">Is this a line video or a unique apartment video?</label></p>
            <fieldset>
                <label><input type="radio" name="apartment-type-radio" value="true" <?php if($video->apartrange) echo "checked";?>>
                    Yes
                </label>
                <label><input type="radio" name="apartment-type-radio" value="false" <?php if(!$video->apartrange) echo "checked";?>>
                    No
                </label><br>
            </fieldset>
        </div>
        <?php if ($video->apartrange){?>
            <div class="options range">
                <p><label for="min">Enter Range:</label></p>
                <input type="number" name="min" required id="min" value="<?php echo $video->apartmin;?>"/>
                <input type="number" name="max" required id="max" value="<?php echo $video->apartmax;?>"/>
            </div>
        <?php }?>
        <div class="options">
            <p><label for="description">Description</label></p>
            <textarea type="text" name="description" required id="description"><?php echo $video->description;?></textarea>
        </div>
        <div class="options">
            <p><label for="youtube">Youtube URL:</label></p>
            <input type="text" name="youtube" id="youtube" value="<?php echo $video->youtube;?>"/>
        </div>
        <div class="options">
            <p><label for="vimeo">Vimeo URL:</label></p>
            <input type="text" name="vimeo" id="vimeo" value="<?php echo $video->vimeo;?>"/>
        </div>
        <div class="options">
            <p><label for="wistia">Wistia URL:</label></p>
            <input type="text" name="wistia" id="wistia"value="<?php echo $video->wistia;?>"/>
        </div>
        <?php
        wp_nonce_field( 'video_save_nonce', 'video_save_nonce' );
        submit_button('Save');
        ?>
    </form>
</div>