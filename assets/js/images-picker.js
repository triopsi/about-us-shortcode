;(function($){
    $(document).ready(function (){

        /* Choose a member image */
        $('.uebns_upload_img_btn').click(function(e) {
            e.preventDefault();
                    var button = $(this), custom_uploader = wp.media({
                        allowLocalEdits: true,
                    title: 'Insert image',
                    library : {
                        type : 'image'
                    },
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                }).on('select', function() {

                    /* Imagespicker Result Path */
                    var thumbnail_member = custom_uploader.state().get('selection').first().toJSON(); // Images Object

                    /* Remove Trashicon, Images an Button */
                    button.siblings('img, .button-trash-images-btn, .dashicons-trash').remove();

                    /* Remove curent thumbnail in the titelbar */
                    button.closest('.team_member_add_content').find('.thumbnail-titelbar').remove();

                    /* Add image */
                    $("<a class=\"button button-trash-images-btn button-large\" href=\"#\"><span class=\"dashicons dashicons-trash\"></span></a><img src=\""+thumbnail_member.url+"\" class=\"member-image\"/>").insertAfter(button);
                    
                    /* Add URL*/
                    button.closest('.team_member_add_content').find('.member-image-link-field').val(thumbnail_member.url);

                    /* Add thumbnail image to the titelbar*/
                    button.closest('.team_member_add_content').find( $('.member_add_image_thumbnail')).append("<img class=\"thumbnail-titelbar\" src=\""+thumbnail_member.url+"\"/>");
                    
                    /* Add data-img attr on the change */
                    button.siblings('.uebns_img_data_url').attr('data-img', thumbnail_member.url).trigger('change');
            }).open();
        });

        /* Click event trash thumbnail */
        $('body').on('click', '.button-trash-images-btn', function(e) {

            /* Remove thumbnail */
            $(this).parent().find('.member-image').remove();

            /* Remove titel thumbnail */
            $(this).closest('.team_member_add_content').find('.thumbnail-titelbar').remove();

            /* Atrr resetten */
            $(this).parent().find('.uebns_img_data_url').attr('data-img', '').trigger('change');

            /* Remove Trash Button*/
            $(this).remove();

            return false;

        });

        /* Init */
        $('.uebns_img_data_url').each(function(i, obj) {

            /* var */
            var imgUrl = $(this).attr("data-img");

            /* Add image and trash */
            if (imgUrl != ''){
                $("<a class='button button-trash-images-btn button-large' href='#'><span class='dashicons dashicons-trash'></span></a><img src='"+imgUrl+"' class='member-image'/>").insertAfter($(this).parent().find('.uebns_upload_img_btn'));
            }
        });
    });
})(jQuery);