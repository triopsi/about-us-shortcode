;(function($){
    $(document).ready(function (){

        /* Shows/hides no row notice. */
        function refreshRowCountRelatedUI(){

            /* Shows notice when team has no member. */
            /* team_member_add_content member_empty */
            if($('.team_member_add_content').not('.member_empty').length > 0){

                /* Hide the default text */
                $( '.row_clear' ).hide();

            } else {
                $( '.row_clear' ).show();
            }
        }
        refreshRowCountRelatedUI();

        /* Adds a member to the team. */
        $( '.add_member_button' ).on('click', function() {
            
            /* Clones/cleans/displays the empty row. */
            var row = $( '.member_empty' ).clone(true);
            // var id_editor = Math.floor((Math.random() * 100) + 1);
            row.removeClass( 'member_empty' ).addClass('team_member_add_content').addClass('member_content_main').show();
            // row.find('#wp-uebns-editor-des-wrap').addClass('wp-uebns-editor-des-wrap-'+id_editor).remove('#uebns-editor-des');
            row.insertBefore( $('.member_empty') );

            row.find('.member-firstname-field').focus();

            /* Inits color picker. */
            // row.find('.dmb_color_picker_ready').removeClass('.dmb_color_picker_ready').addClass('.dmb_color_picker').wpColorPicker().css({'padding':'3px'});
            
            /* Defaults handle title. */
            // row.find('.member_add_title').html(objectL10n.untitled);
            
            /* Hides empty member description. */
            // row.find('.dmb_description_of_member').hide();

            refreshRowCountRelatedUI();
            return false;

        });

        /* Removes a row. */
        $('.remove_row').click(function(e) {
            $(this).closest('.team_member_add_content').remove();
            refreshRowCountRelatedUI();
            return false;

        });
          
        /* Expands/collapses handle. */
        $('.member_toolbar').click(function(e) {
            
            $(this).siblings('.member_add_content_row').slideToggle(50);
            
            ($(this).hasClass('closed')) 
            ? $(this).removeClass('closed') 
            : $(this).addClass('closed');

            return false;

        });

        function collapse_AbortController(e){

            $('.member_toolbar').each(function(i, obj){
                if(!$(this).closest('.member_empty').length){ // Makes sure not to collapse empty row.
                    if($(this).hasClass('closed')){
                    
                    } else {
                    
                        $(this).siblings('.member_add_content_row').slideToggle(50);
                        $(this).addClass('closed');
    
                    }
                }
            });
        }

        /* Collapses all rows. */
        $('.collapse_all').click(function(e) {

            collapse_AbortController(e);

            return false;

        });


        /* Expands all rows. */
        $('.expand_all').click(function(e) {

            $('.member_toolbar').each(function(i, obj){
            if($(this).hasClass('closed')){
                
                $(this).siblings('.member_add_content_row').slideToggle(50);
                $(this).removeClass('closed');

            }
            });

            return false;

        });

        /* Shifts a row down (clones and deletes). */
        $('.move_row_down').click(function(e) {
            if($(this).closest('.team_member_add_content').next().hasClass('team_member_add_content')){ // If there's a next row.
                /* Clones the row. */
                var movingRow = $(this).closest('.team_member_add_content').clone(true);
                /* Inserts it after next row. */
                movingRow.insertAfter($(this).closest('.team_member_add_content').next());
                /* Removes original row. */
                $(this).closest('.team_member_add_content').remove();
            }
            return false;
        });

        /* Shifts a row up (clones and deletes). */
        $('.move_row_up').click(function(e) {
            if($(this).closest('.team_member_add_content').prev().hasClass('team_member_add_content')){ // If there's a previous row.
                /* Clones the row. */
                var movingRow = $(this).closest('.team_member_add_content').clone(true);
                /* Inserts it before previous row. */
                movingRow.insertBefore($(this).closest('.team_member_add_content').prev());
                /* Removes original row. */
                $(this).closest('.team_member_add_content').remove();
            }
            return false;
        });

        /* Adds row title to handle. */
        $('.team_member_add_content').not('.member_empty').each(function(i, obj){
            if($(this).find('.member-firstname-field').val() != ''){
            var handleTitle = $(this).find('.member_add_title'),
            firstname = $(this).find('.member-firstname-field').val(),
            lastname = $(this).find('.member-lastname-field').val();
            handleTitle.html(firstname + ' ' + lastname);
            }

        });

        function updatetitelbar(firstnameField){
            
            /* Makes current title. */
            var firstnameField = firstnameField,
            lastname = firstnameField.closest('.team_member_add_content').find('.member-lastname-field').val() || '';
            handleTitle = firstnameField.closest('.team_member_add_content').find('.member_add_title');  
            /* Updates handle title. */
            (firstnameField.val() != '')
              ? handleTitle.html(firstnameField.val() + ' ' + lastname)
              : handleTitle.html(objectL10n.untitled);
        
        }

        /* Watches member firstname/lastname and updates handle. */
        $('body').on('keyup', '.member-firstname-field', function(e) { updatetitelbar($(this)); });
        $('body').on('keyup', '.member-lastname-field', function(e) {
            firstnameField = $(this).closest('.team_member_add_content').find('.member-firstname-field');
            updatetitelbar(firstnameField);
        });

        /* Gathers data into single input. */
        function dmbGatherData(keyUpParam) {
            var trenner = ';;';
            var member = keyUpParam.closest('.team_member_add_content'),
            firstname = member.find('.member-firstname-field').val() || '',
            lastname = member.find('.member-lastname-field').val() || '',
            job = member.find('.member-jobrole-field').val() || '';

            // if ($('#acf-fallback-bio').length ) {
            description = $.trim(member.find('#uebns-description-member').val()) || '';
            // } else {
            // description = $.trim(member.find('.dmb_description_of_member').html()) || '';
            // }
            var sclType1 = member.find('.member_social_media_kanal1').val() || '',
            sclTitle1 = member.find('.member-social-link-titel1-field').val() || '',
            sclUrl1 = member.find('.member-social-link-url1-field').val() || '',

            sclType2 = member.find('.member_social_media_kanal2').val() || '',
            sclTitle2 = member.find('.member-social-link-titel2-field').val() || '',
            sclUrl2 = member.find('.member-social-link-url2-field').val() || '',

            sclType3 = member.find('.member_social_media_kanal3').val() || '',
            sclTitle3 = member.find('.member-social-link-titel3-field').val() || '',
            sclUrl3 = member.find('.member-social-link-url3-field').val() || '',

            /* Image URL. */
            memberPhoto = member.find('.uebns_img_data_url').attr('data-img') || '',

            /* Image link URL. */
            memberPhotoUrl = member.find('.member-image-link-field').val() || '',

            /* Finds single input. */
            dataDump = member.find('.uebns_data');

            /* Fills single input. */
            dataDump.val(
            firstname + trenner + 
            lastname + trenner + 
            job + trenner +
            description + trenner +
            sclType1 + trenner +
            sclTitle1 + trenner +
            sclUrl1 + trenner +
            sclType2 + trenner +
            sclTitle2 + trenner +
            sclUrl2 + trenner +
            sclType3 + trenner +
            sclTitle3 + trenner +
            sclUrl3 + trenner +
            memberPhoto + trenner +
            memberPhotoUrl
            );
            // alert(
            //     firstname + trenner + 
            //     lastname + trenner + 
            //     job + trenner +
            //     // description + trenner +
            //     sclType1 + trenner +
            //     sclTitle1 + trenner +
            //     sclUrl1 + trenner +
            //     sclType2 + trenner +
            //     sclTitle2 + trenner +
            //     sclUrl2 + trenner +
            //     sclType3 + trenner +
            //     sclTitle3 + trenner +
            //     sclUrl3 + trenner +
            //     memberPhoto + trenner +
            //     memberPhotoUrl);

        }

        /* Defines trigger for single input update. */
        $('body').on('keyup', '.ubns-field', function(e) { dmbGatherData($(this)); });
        
        $('body').on('change', '.ubns-select', function(e) { dmbGatherData($(this)); });
        
        $('body').on('change', '.uebns_img_data_url', function(e) { dmbGatherData($(this)); });

        $('body').on('paste keyup', '.textarea-member-bio', function(e) { dmbGatherData($(this)); });

        /* Processes member's description fields. */
        /* Initial single input update. */
        $('.team_member_add_content').not('.member_empty').each(function(i, obj){

            /* Triggers single input update. */
            dmbGatherData($(this).find('.ubns-field').first());

            /* Collapse the Content*/
            collapse_AbortController($(this));

        });
    });

})(jQuery);