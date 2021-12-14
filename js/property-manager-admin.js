jQuery(function () {

    // Line video / unique apartment checkbox
   jQuery("[name='apartment-type-radio']").click(function () {
       if (jQuery(this).val() === 'true'){
           if((jQuery(".range")).length === 0){
               jQuery("#radio-box").after(
                   "<div class=\"options range\">\n" +
                   "    <p><label for=\"min\">Enter Range:</label></p>\n" +
                   "    <input type=\"number\" name=\"min\" required id=\"min\"/>\n" +
                   "    <input type=\"number\" name=\"max\" required id=\"max\"/>\n" +
                   "</div>"
               )
           }
       }else{
           jQuery(".range").remove();
       }
   });

   // handle form submit
    jQuery("#add-video-form").on("submit", function (event) {
        let youtube = jQuery("#youtube").val();
        let vimeo = jQuery("#vimeo").val();
        let wistia = jQuery("#wistia").val();
        if (!youtube && !vimeo && !wistia) {
            event.preventDefault();
            return alert("Enter one video url.");
        }

        if (youtube && !/^https:\/\/www\.youtube\.com\/embed\/\S*$/.test(youtube)){
            event.preventDefault();
            return alert("Invalid Youtube Embed URL.");
        }
        if (vimeo && !/^https:\/\/vimeo\.com\/\S*$/.test(vimeo)) {
            event.preventDefault();
            return alert("Invalid Vimeo URL.")
        }
        if (wistia && !/^https:\/\/fast\.wistia\.net\/embed\/iframe\/\S*$/.test(wistia)){
            event.preventDefault();
            return alert("Invalid Wistia URL.");
        }
    });

    jQuery('.jsmartable').jsmartable({breakpoint: {
            xs: 480,
            sm: 768,
            md: 1024,
            lg: 1500,
            xlg: 2500,
        }});
});

function trashProperty(property_id) {
    let ajax_request_nonce = jQuery('#ajax_request_nonce').val();
    jQuery.ajax({
        url:    params.ajaxurl,
        type:   'POST',
        data:   {
            ajax_request_nonce: ajax_request_nonce,
            id: property_id,
            action: 'property_request_handler',
            status: 'trash'
        }
    })
        .done( function( response ) {
            if (JSON.parse(response)['success']){
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-success is-dismissible"><p><strong>Property has been saved successfully.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
                jQuery(`tr[data-score="${property_id}"]`).remove();
            }else{
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
            }
        })
        .fail( function() {
            jQuery('#ajax-feed').html(
                '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
            );
        });
}

function restoreProperty(property_id) {
    let ajax_request_nonce = jQuery('#ajax_request_nonce').val();
    jQuery.ajax({
        url:    params.ajaxurl,
        type:   'POST',
        data:   {
            ajax_request_nonce: ajax_request_nonce,
            id: property_id,
            action: 'property_request_handler',
            status: 'publish'
        }
    })
        .done( function( response ) {
            if (JSON.parse(response)['success']){
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-success is-dismissible"><p><strong>Property has been saved successfully.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
                jQuery(`tr[data-score="${property_id}"]`).remove();
            }else{
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
            }
        })
        .fail( function() {
            jQuery('#ajax-feed').html(
                '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
            );
        });
}

function trashVideo(video_id) {
    let ajax_request_nonce = jQuery('#ajax_request_nonce').val();
    jQuery.ajax({
        url:    params.ajaxurl,
        type:   'POST',
        data:   {
            ajax_request_nonce: ajax_request_nonce,
            id: video_id,
            action: 'video_request_handler',
            status: 'trash'
        }
    })
        .done( function( response ) {
            if (JSON.parse(response)['success']){
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-success is-dismissible"><p><strong>Video has been saved successfully.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
                jQuery(`tr[data-score="${video_id}"]`).remove();
            }else{
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
            }
        })
        .fail( function() {
            jQuery('#ajax-feed').html(
                '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
            );
        });
}

function restoreVideo(video_id) {
    let ajax_request_nonce = jQuery('#ajax_request_nonce').val();
    jQuery.ajax({
        url:    params.ajaxurl,
        type:   'POST',
        data:   {
            ajax_request_nonce: ajax_request_nonce,
            id: video_id,
            action: 'video_request_handler',
            status: 'publish'
        }
    })
        .done( function( response ) {
            if (JSON.parse(response)['success']){
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-success is-dismissible"><p><strong>Video has been saved successfully.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
                jQuery(`tr[data-score="${video_id}"]`).remove();
            }else{
                jQuery('#ajax-feed').html(
                    '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
                );
            }
        })
        .fail( function() {
            jQuery('#ajax-feed').html(
                '<div class="notice notice-error is-dismissible"><p><strong>Woops! There was an issue handling your request.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'
            );
        });
}