<div id="screen-options-wrap">
    <form id="pma-buildings-setting"  method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="set_video_setting"/>
        <?php wp_nonce_field('setting_hook_nonce', 'setting_hook_nonce');?>
        <fieldset class="screen-options">
            <legend>Columns</legend>
            <?php foreach ($options as $option){?>
            <label>
                <input class="hide-column-tog"
                       name="<?php echo $option['id'];?>"
                       type="checkbox"
                    <?php if(empty($this->is_hidden(str_replace("pma_v_", '', $option['id'])))) echo 'checked';?>
                >
                <?php echo $option['label'];?>
            </label>
            <?php } ?>
        </fieldset>
        <button type="submit" class="button button-primary">Apply</button>
    </form>
</div>