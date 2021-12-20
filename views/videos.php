<div class='wrap'>
    <h2><?php echo esc_html(get_admin_page_title()) ?></h2>
    <div id="ajax-feed"></div>
    <?php wp_nonce_field('ajax_request_nonce', 'ajax_request_nonce'); ?>

<!--    Filter form-->
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="redirect_hook"/>
        <input type="hidden" name="redirect" value="videos"/>
        <div class="options">
            <p>
                <label for="property">Filter By Building</label>
                <select name="building_id" id="property">
                    <option value="">Select a Building</option>
                    <?php foreach ($buildings as $building) { ?>
                        <option value="<?php echo $building->id; ?>" <?php if (isset($_REQUEST['building_id']) && $_REQUEST['building_id'] == $building->id) echo "selected"; ?>><?php echo $building->name; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="button button-primary">Apply</button>
            </p>
        </div>
        <?php
        wp_nonce_field('redirect_hook_nonce', 'redirect_hook_nonce');
        ?>
    </form>

<!--    Info bar-->
    <a href="<?php echo esc_url(admin_url('admin.php?page=videos&status=publish')); ?>">
        Active (<?php echo $active[0]->counts; ?>)
    </a> |
    <a href="<?php echo esc_url(admin_url('admin.php?page=videos&status=trash')); ?>">
        Trashed (<?php echo $trashed[0]->counts; ?>)
    </a>

<!--    Listing table-->
    <table class="jsmartable table wp-list-table widefat" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th data-columns="address"
                class="
                <?php
                echo $this->sortable_column_class_generator('address');
                echo $this->is_hidden('address');
                ?>">
                <a href="<?php echo $this->video_page_sort_url_generator('address');?>">
                    <span>Address</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
            <th  data-columns="description"
                 class="
                 <?php
                 echo $this->sortable_column_class_generator('description');
                 echo $this->is_hidden('description');
                 ?>">
                <a href="<?php echo $this->video_page_sort_url_generator('description');?>">
                    <span>Description</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
            <th data-columns="building"
                class="
                <?php
                echo $this->sortable_column_class_generator('building');
                echo $this->is_hidden('building');
                ?>"
                data-breakpoint="xs">
                <a href="<?php echo $this->video_page_sort_url_generator('building');?>">
                    <span>Building</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
            <th data-columns="property"
                class="
                <?php
                echo $this->sortable_column_class_generator('property');
                echo $this->is_hidden('property');
                ?>"
                data-breakpoint="xs">
                <a href="<?php echo $this->video_page_sort_url_generator('property');?>">
                    <span>Property</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
            <th data-breakpoint="lg" class="<?php echo $this->is_hidden('label'); ?>">Label</th>
            <th data-breakpoint="lg">Unit Floor</th>
            <th data-breakpoint="lg">Unit</th>
            <th data-columns="bedroom"
                class="<?php echo $this->is_hidden('bedroom'); ?>"
                data-breakpoint="lg">Bedroom</th>
            <th data-columns="bathroom"
                class="<?php echo $this->is_hidden('bathroom');?>"
                data-breakpoint="lg">Bathroom</th>
            <th data-columns="type"
                class="<?php echo $this->is_hidden('type');?>"
                data-breakpoint="lg">Type</th>
            <th data-columns="min"
                class="<?php echo $this->is_hidden('min');?>"
                data-breakpoint="lg">Line Start</th>
            <th data-columns="max"
                class="<?php echo $this->is_hidden('max');?>"
                data-breakpoint="lg">Line End</th>
            <th data-columns="youtube" class="video" data-breakpoint="xlg">Youtube</th>
            <th data-columns="vimeo" class="video" data-breakpoint="xlg">Vimeo</th>
            <th data-columns="wistia" class="video" data-breakpoint="xlg">Wistia</th>
            <th data-columns="created_at" data-breakpoint="xlg">Create At</th>
            <th data-columns="updated_at" data-breakpoint="xlg">Update At</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($videos); $i++) { ?>
            <tr class="<?php if ($i % 2 != 0) echo "alternate"; ?>"
                data-score="<?php echo $videos[$i]->id; ?>">
                <td><?php echo $videos[$i]->id; ?></td>
                <td class="<?php echo $this->is_hidden('address');?>"><?php echo $videos[$i]->address; ?></td>
                <td class="<?php echo $this->is_hidden('description');?>">
                    <?php echo $videos[$i]->description; ?>
                    <div class="row-actions">
                        <span>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=edit-video&id=' . $videos[$i]->id)); ?>">
                                Edit</a> |
                        </span>
                        <?php if ($videos[$i]->status == 'publish') { ?>
                            <span>
                                <a href="javascript:void(0);"
                                   onclick="trashVideo(<?php echo $videos[$i]->id; ?>)">
                                    Trash
                                </a>
                            </span>
                        <?php } else { ?>
                            <span>
                                <a href="javascript:void(0);"
                                   onclick="restoreVideo(<?php echo $videos[$i]->id; ?>)">
                                    Restore
                                </a>
                            </span>
                        <?php } ?>
                    </div>
                </td>
                <td class="<?php echo $this->is_hidden('building');?>"><?php echo $videos[$i]->building_name; ?></td>
                <td class="<?php echo $this->is_hidden('property');?>"><?php echo $videos[$i]->property_name; ?></td>
                <td class="<?php echo $this->is_hidden('label');?>"><?php echo $videos[$i]->label; ?></td>
                <td>
                    <?php
                    if (!empty($videos[$i]->unitf)) echo $videos[$i]->unitf;
                    if (!empty($videos[$i]->unitfn)) echo $videos[$i]->unitfn;
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($videos[$i]->unit)) echo $videos[$i]->unit;
                    if (!empty($videos[$i]->unitn)) echo $videos[$i] -> unitn;
                    ?>
                </td>
                <td class="<?php echo $this->is_hidden('bedroom');?>"><?php echo $videos[$i]->bedroom; ?></td>
                <td class="<?php echo $this->is_hidden('bathroom');?>"><?php echo $videos[$i]->bathroom; ?></td>
                <td class="<?php echo $this->is_hidden('type');?>">
                    <?php if ($videos[$i]->apartrange) echo 'Line'; else echo 'Unique'; ?>
                </td>
                <td class="<?php echo $this->is_hidden('min');?>"><?php echo $videos[$i]->apartmin; ?></td>
                <td class="<?php echo $this->is_hidden('max');?>"><?php echo $videos[$i]->apartmax; ?></td>
                <td class="video">
                    <a target="_blank" href="<?php echo $videos[$i]->youtube; ?>">
                        <?php echo $videos[$i]->youtube; ?>
                    </a>
                </td>
                <td class="video">
                    <a target="_blank" href="<?php echo $videos[$i]->vimeo; ?>">
                        <?php echo $videos[$i]->vimeo; ?>
                    </a>
                </td>
                <td class="video">
                    <a target="_blank" href="<?php echo $videos[$i]->wistia; ?>">
                        <?php echo $videos[$i]->wistia; ?>
                    </a>
                </td>
                <td><?php echo (new DateTime($videos[$i]->created_at))->format('m/d/Y h:i a'); ?></td>
                <td><?php echo (new DateTime($videos[$i]->updated_at))->format('m/d/Y h:i a'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>