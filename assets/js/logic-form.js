;(function($){
    $(document).ready(function (){

        /* Shows/hides no row notice */
        function showRowInfo(){
            if($('.team_member_add_content').not('.member_empty').length > 0){
                $( '.row_clear' ).hide();
            } else {
                $( '.row_clear' ).show();
            }
        }
        showRowInfo();

        /* Adds a member to the team. */
        $( '.add_member_button' ).on('click', function() {
            var row = $( '.member_empty' ).clone(true);
            row.removeClass( 'member_empty' ).addClass('team_member_add_content').addClass('member_content_main').show();
            row.insertBefore( $('.member_empty') );
            row.find('.member-firstname-field').focus();
            showRowInfo();
            return false;
        });

        /* Removes a row. */
        $('.remove_row').click(function(e) {
            $(this).closest('.team_member_add_content').remove();
            showRowInfo();
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

        /* Collapse the row controller */
        function collapseController(e){
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
            collapseController(e);
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

        /* Update Titlebar handling */
        function updatetitelbar(firstnameField){

            /* Makes current title. */
            var firstnameField = firstnameField,
            lastname = firstnameField.closest('.team_member_add_content').find('.member-lastname-field').val() || '';
            handleTitle = firstnameField.closest('.team_member_add_content').find('.member_add_title');  

            /* Updates handle title. */
            (firstnameField.val() != '')
              ? handleTitle.html(firstnameField.val() + ' ' + lastname)
              : handleTitle.html(uebnsobjjs.untitled);
        
        }

        /* Firstname/Lastname handles. */
        $('body').on('keyup', '.member-firstname-field', function(e) { 

            //call updatefunction
            updatetitelbar($(this)); 
        });

        $('body').on('keyup', '.member-lastname-field', function(e) {

            //search firstname obj
            firstnameField = $(this).closest('.team_member_add_content').find('.member-firstname-field');
            //call updatefunction
            updatetitelbar(firstnameField);
        });

        /* Gathers data into single input. */
        function updatedatabox(keyUpParam) {

            //trenner
            var trenner = ';;';
            var member = keyUpParam.closest('.team_member_add_content'),
            firstname = member.find('.member-firstname-field').val() || '',
            lastname = member.find('.member-lastname-field').val() || '',
            job = member.find('.member-jobrole-field').val() || '';
            description = $.trim(member.find('#uebns-description-member').val()) || '';

            var sclType1 = member.find('.member_social_media_kanal1').val() || '',
            sclTitle1 = member.find('.member-social-link-titel1-field').val() || '',
            sclUrl1 = member.find('.member-social-link-url1-field').val() || '',

            sclType2 = member.find('.member_social_media_kanal2').val() || '',
            sclTitle2 = member.find('.member-social-link-titel2-field').val() || '',
            sclUrl2 = member.find('.member-social-link-url2-field').val() || '',

            sclType3 = member.find('.member_social_media_kanal3').val() || '',
            sclTitle3 = member.find('.member-social-link-titel3-field').val() || '',
            sclUrl3 = member.find('.member-social-link-url3-field').val() || '',

            memberPhoto = member.find('.uebns_img_data_url').attr('data-img') || '',
            memberPhotoUrl = member.find('.member-image-link-field').val() || '',
            datafieldhidden = member.find('.uebns_data');

            datafieldhidden.val(
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
        }

        /* triggers for the update */
        $('body').on('keyup', '.ubns-field', function(e) { 
            updatedatabox($(this)); 
        });
        
        $('body').on('change', '.ubns-select', function(e) { 
            updatedatabox($(this)); 
        });
        
        $('body').on('change', '.uebns_img_data_url', function(e) { 
            updatedatabox($(this)); 
        });

        $('body').on('paste keyup', '.textarea-member-bio', function(e) { 
            updatedatabox($(this)); 
        });

        /* Init - Load the postpage */
        $('.team_member_add_content').not('.member_empty').each(function(i, obj){

            /* update the fields */
            updatedatabox($(this).find('.ubns-field').first());

            /* Collapse the Content*/
            collapseController($(this));

        });
    });

})(jQuery);