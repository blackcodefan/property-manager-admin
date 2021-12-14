<div class='wrap'>
    <h2><?php echo esc_html(get_admin_page_title())?></h2>
    <div id="ajax-feed"></div>
    <?php wp_nonce_field( 'ajax_request_nonce', 'ajax_request_nonce' );?>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="redirect_hook"/>
        <input type="hidden" name="redirect" value="videos"/>
        <div class="options">
            <p>
                <label for="property">Filter By Building</label>
                <select name="building_id" id="property">
                    <option value="">Select a Building</option>
                    <?php foreach ($buildings as $building){?>
                        <option value="<?php echo $building->id;?>" <?php if(isset($_REQUEST['building_id']) && $_REQUEST['building_id'] == $building->id) echo "selected";?>><?php echo $building->name; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="button button-primary">Apply</button>
            </p>
        </div>
        <?php
        wp_nonce_field( 'redirect_hook_nonce', 'redirect_hook_nonce' );
        ?>
    </form>
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=videos&status=publish' ) ); ?>">Active (<?php echo $active[0]->counts;?>)</a> |
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=videos&status=trash' ) ); ?>">Trashed (<?php echo $trashed[0]->counts;?>)</a>
    <table class="jsmartable table wp-list-table widefat" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Address</th>
            <th>Description</th>
            <th data-breakpoint="xs">Building</th>
            <th data-breakpoint="xs">Property</th>
            <th data-breakpoint="lg">Unit Floor</th>
            <th data-breakpoint="lg">Unit</th>
            <th data-breakpoint="lg">Bedroom</th>
            <th data-breakpoint="lg">Bathroom</th>
            <th data-breakpoint="lg">Type</th>
            <th data-breakpoint="lg">Line Start</th>
            <th data-breakpoint="lg">Line End</th>
            <th class="video" data-breakpoint="xlg">Youtube</th>
            <th class="video" data-breakpoint="xlg">Vimeo</th>
            <th class="video" data-breakpoint="xlg">Wistia</th>
            <th data-breakpoint="xlg">Create At</th>
            <th data-breakpoint="xlg">Update At</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($videos); $i++){?>
            <tr class="<?php if($i%2 != 0) echo "alternate";?>" data-score="<?php echo $videos[$i]->id; ?>">
                <td><?php echo $videos[$i]->id; ?></td>
                <td><?php echo $videos[$i]-> address;?></td>
                <td>
                    <?php echo $videos[$i]-> description;?>
                    <div class="row-actions">
                        <span><a href="<?php echo esc_url( admin_url( 'admin.php?page=edit-video&id='.$videos[$i]->id ) ); ?>">Edit</a> |</span>
                        <?php if($videos[$i]->status == 'publish'){?>
                            <span><a href="javascript:void(0);" onclick="trashVideo(<?php echo $videos[$i]->id;?>)">Trash</a></span>
                        <?php }else{ ?>
                            <span><a href="javascript:void(0);" onclick="restoreVideo(<?php echo $videos[$i]->id;?>)">Restore</a></span>
                        <?php } ?>
                    </div>
                </td>
                <td><?php echo $videos[$i]-> building_name;?></td>
                <td><?php echo $videos[$i]-> property_name;?></td>
                <td><?php echo $videos[$i]-> unitf;?></td>
                <td><?php echo $videos[$i]-> unit;?></td>
                <td><?php echo $videos[$i]-> bedroom;?></td>
                <td><?php echo $videos[$i]-> bathroom;?></td>
                <td><?php if($videos[$i]-> apartrange) echo 'Line'; else echo 'Unique';?></td>
                <td><?php echo $videos[$i]-> apartmin;?></td>
                <td><?php echo $videos[$i]-> apartmax;?></td>
                <td class="video"><a target="_blank" href="<?php echo $videos[$i]-> youtube;?>"><?php echo $videos[$i]-> youtube;?></a></td>
                <td class="video"><a target="_blank" href="<?php echo $videos[$i]-> vimeo;?>"><?php echo $videos[$i]-> vimeo;?></a></td>
                <td class="video"><a target="_blank" href="<?php echo $videos[$i]-> wistia;?>"><?php echo $videos[$i]-> wistia;?></a></td>
                <td><?php echo $videos[$i]-> created_at;?></td>
                <td><?php echo $videos[$i]-> updated_at;?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>