jQuery(document).ready(function ($) {
    wp.editor.initialize("ppws_form_above_content", {
        mediaButtons: true,
        tinymce: {

            theme: 'modern',
            skin: 'lightgray',
            language: 'en',
            formats: {
                alignleft: [
                    { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'left' } },
                    { selector: 'img, table, dl.wp-caption', classes: 'alignleft' }
                ],
                aligncenter: [
                    { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'center' } },
                    { selector: 'img, table, dl.wp-caption', classes: 'aligncenter' }
                ],
                alignright: [
                    { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'right' } },
                    { selector: 'img, table, dl.wp-caption', classes: 'alignright' }
                ],
                strikethrough: { inline: 'del' }
            },
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,

            entities: '38, amp, 60, lt, 62, gt ',
            entity_encoding: 'raw',
            keep_styles: false,
            paste_webkit_styles: 'font-weight font-style color',
            preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
            tabfocus_elements: ': prev ,: next',
            plugins: 'charmap,colorpicker,hr,lists,paste,tabfocus,textcolor,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wptextpattern',
            resize: 'vertical',
            menubar: false,
            indent: false,
            toolbar1: 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, wp_adv',
            toolbar2: 'formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
            toolbar3: '',
            toolbar4: '',
            body_class: 'id post-type-post-status-publish post-format-standard',
            wpeditimage_disable_captions: false,
            wpeditimage_html5_captions: true

        },
        quicktags: true
    });
    wp.editor.initialize("ppws_form_below_content", {
        mediaButtons: true,
        tinymce: {

            theme: 'modern',
            skin: 'lightgray',
            language: 'en',
            formats: {
                alignleft: [
                    { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'left' } },
                    { selector: 'img, table, dl.wp-caption', classes: 'alignleft' }
                ],
                aligncenter: [
                    { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'center' } },
                    { selector: 'img, table, dl.wp-caption', classes: 'aligncenter' }
                ],
                alignright: [
                    { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'right' } },
                    { selector: 'img, table, dl.wp-caption', classes: 'alignright' }
                ],
                strikethrough: { inline: 'del' }
            },
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,

            entities: '38, amp, 60, lt, 62, gt ',
            entity_encoding: 'raw',
            keep_styles: false,
            paste_webkit_styles: 'font-weight font-style color',
            preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
            tabfocus_elements: ': prev ,: next',
            plugins: 'charmap,colorpicker,hr,lists,paste,tabfocus,textcolor,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wptextpattern',
            resize: 'vertical',
            menubar: false,
            indent: false,
            toolbar1: 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, wp_adv',
            toolbar2: 'formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
            toolbar3: '',
            toolbar4: '',
            body_class: 'id post-type-post-status-publish post-format-standard',
            wpeditimage_disable_captions: false,
            wpeditimage_html5_captions: true

        },
        quicktags: true
    });




    jQuery("body").on('submit', '.ppws-procat-setting-form,.ppws-general-setting-form,.ppws-page-setting-form', function () {
        if (jQuery("body .ppws_password_checkbox_validation").prop("checked") == true) {
            
            var wp_number = jQuery(".ppws-pwd-input").val();

            if (wp_number == '') {
                jQuery(".ppws-pwd-input").addClass('ppws-error-border');
                return false;
            } else {
                jQuery(".ppws-pwd-input").removeClass('ppws-error-border');
                return true;
            }
        }

    });


    $("input[name='ppws_form_desgin_settings[ppws_form_page_background_field_image_selecter]']").click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
            .on('select', function (e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#ppws_form_page_background_field_image_selecter').val(image_url);
            });
    });



    $("input[name='ppws_form_desgin_settings[ppws_form_background_field_image_selecter]']").click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
            .on('select', function (e) {
                var uploaded_image = image.state().get('selection').first();
                console.log(uploaded_image.toJSON());
                var image_url = uploaded_image.toJSON().url;
                $('#ppws_form_background_field_image_selecter').val(image_url);
            });
    });


    $(".ppws-color-field").wpColorPicker();

    /** Pages JS */

    $("body").on("change", "#enable_user_role", function () {
        if (jQuery(this).is(":checked")) {
            //$("body .ppws-userrole-error").addClass('ppws-hide-section');
            $(".ppws-section-user").removeClass("none-redio-click");
            if (jQuery(".ppws_user_logged_in_user").is(":checked")) {
                $(".ppws-page-logged-in-user-section").removeClass("ppws-hide-section");
            }
        } else {
            $(".ppws-section-user").addClass("none-redio-click");
           // $("body .ppws-userrole-error").removeClass('ppws-hide-section');
            $(".ppws-page-logged-in-user-section").addClass("ppws-hide-section");
        }
        // $(".ppws-page-logged-in-user-section").removeClass("ppws-hide-section");
    });

    $("body").on("click", ".ppws_user_logged_in_user, input[class='ppws_user_non_logged_in_user']", function () {

        if (jQuery("#enable_user_role").is(":checked")) {
            $("body .ppws-userrole-error").addClass('ppws-hide-section');
            $(".ppws-page-logged-in-user-section").removeClass("ppws-hide-section");
        } else {
            $("body .ppws-userrole-error").removeClass('ppws-hide-section');
        }

    });

    if ($("input[class='ppws_user_non_logged_in_user']").is(":checked")) {
        $(".ppws-page-logged-in-user-section").addClass("ppws-hide-section");
    }
    $("body").on("click", ".ppws_user_non_logged_in_user", function () {
        $(".ppws-page-logged-in-user-section").addClass("ppws-hide-section");
    });

    /** Pages JS END */

    // if ($("input[id='ppws_select_user_role_field_radio_non_logged_in_user']").is(":checked")) {
    //     $(".ppws-logged-in-user-section").addClass("ppws-hide-section");
    // }

    // $("body").on("click", "input[id='ppws_select_user_role_field_radio_logged_in_user']", function () {
    //     $(".ppws-logged-in-user-section").removeClass("ppws-hide-section");
    // });

    // $("body").on("click", "input[id='ppws_select_user_role_field_radio_non_logged_in_user']", function () {
    //     $(".ppws-logged-in-user-section").addClass("ppws-hide-section");
    // });

    /* Form Background */

    $("body").on("change", "input[name='ppws_form_desgin_settings[ppws_form_background_field_radio]']", function () {
        var this_val = jQuery(this).val();
        if (this_val == "none") {
            $(".ppws-form-background-image-selecter").addClass("ppws-hide-section");
            $(".ppws-form-background-color-selecter").addClass("ppws-hide-section");
        } else if (this_val == "image") {
            $(".ppws-form-background-color-selecter").addClass("ppws-hide-section");
            $(".ppws-form-background-image-selecter").removeClass("ppws-hide-section");
        } else if (this_val == "solid-color") {
            $(".ppws-form-background-image-selecter").addClass("ppws-hide-section");
            $(".ppws-form-background-color-selecter").removeClass("ppws-hide-section");
        }
    });

    /* Page Background */
    $("body").on("change", "input[name='ppws_form_desgin_settings[ppws_form_page_background_field_radio]']", function () {
        var this_val = jQuery(this).val();
        if (this_val == "none") {
            $(".ppws-form-page-background-image-selecter").addClass("ppws-hide-section");
            $(".ppws-form-page-background-color-selecter").addClass("ppws-hide-section");
        } else if (this_val == "image") {
            $(".ppws-form-page-background-color-selecter").addClass("ppws-hide-section");
            $(".ppws-form-page-background-image-selecter").removeClass("ppws-hide-section");
        } else if (this_val == "solid-color") {
            $(".ppws-form-page-background-image-selecter").addClass("ppws-hide-section");
            $(".ppws-form-page-background-color-selecter").removeClass("ppws-hide-section");
        }
    });


    $('input[name="ppws_general_settings[ppws_enable_password_field_checkbox]"]').click(function () {
        if ($(this).prop("checked") == true) {
            $(".ppws-whole-site-password-section").removeClass("ppws-hide-section");
            $(".ppws-note-info,.ppws-section-user").removeClass("ppws-hide-section");
        } else if ($(this).prop("checked") == false) {
            $(".ppws-whole-site-password-section").addClass("ppws-hide-section");
            $(".ppws-note-info,.ppws-section-user").addClass("ppws-hide-section");
        }
    });

    $('input[id="ppws_page_enable_password_field_checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            $(".ppws-page-enable-password-section,.ppws-section-user,.ppws-note-info").removeClass("ppws-hide-section");
        } else if ($(this).prop("checked") == false) {
            $(".ppws-page-enable-password-section,.ppws-section-user,.ppws-note-info").addClass("ppws-hide-section");
        }
    });

    $('input[id="ppws_product_categories_enable_password_field_checkbox"]').click(function () {
        if ($(this).prop("checked") == true) {
            $(".ppws-product-categories-enable-password-section,.ppws-section-user,.ppws-note-info").removeClass("ppws-hide-section");
        } else if ($(this).prop("checked") == false) {
            $(".ppws-product-categories-enable-password-section,.ppws-section-user,.ppws-note-info").addClass("ppws-hide-section");
        }
    });    
    
    setInterval(function () {
        var isAllChecked = 0;
        $(".editable_roles_single").each(function(){
        if(!this.checked)
            isAllChecked = 1;
        })              
        if(isAllChecked == 0){ $(".editable_roles_all").prop("checked", true); }  
    }, 500);

    $(".editable_roles_all").change(function(){
        if(this.checked){
          $(".editable_roles_single").each(function(){
            this.checked=true;
          })              
        }else{
          $(".editable_roles_single").each(function(){
            this.checked=false;
          })              
        }
      });

      $(".editable_roles_single").click(function () {
        if ($(this).is(":checked")){
          var isAllChecked = 0;
          $(".editable_roles_single").each(function(){
            if(!this.checked)
               isAllChecked = 1;
          })              
          if(isAllChecked == 0){ $(".editable_roles_all").prop("checked", true); }     
        }else {
          $(".editable_roles_all").prop("checked", false);
        }
      });

});