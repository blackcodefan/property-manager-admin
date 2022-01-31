<div class="wrap">
    <h1>Sort buildings for this property</h1>
    <br />
    <?php if (count($buildings) > 0) {?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="building-order-form">
            <input type="hidden" name="action" value="save_building_order_hook"/>
            <input type="hidden" name="sort-data" id="sort-data"/>
            <ul class="sortable">
                <?php foreach ($buildings as $building){ ?>
                    <li class="ui-state-default" data-score="<?php echo $building->id; ?>">
                        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        <?php echo $building->name; ?>
                        <span class="property-name">(<?php echo $building->property_name; ?>)</span>
                    </li>
                <?php } ?>
            </ul>
            <?php
            wp_nonce_field('property_save_nonce', 'property_save_nonce');
            submit_button('Save');
            ?>
        </form>
    <?php } else {?>
        <h1>No published buildings</h1>
    <?php } ?>
</div>