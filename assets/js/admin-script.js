jQuery(document).ready(function ($) {
    if (jQuery(".ppws-color-field").length > 0) {
        jQuery(".ppws-color-field").wpColorPicker();
    }

    if (jQuery("#ppws_form_above_content").length > 0) {
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
    }

    if (jQuery("#ppws_form_below_content").length > 0) {
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
    }

    if (typeof ppwsObj != undefined) {
        var $seacrh_category = jQuery(".ppws_product_categories");

        if ($seacrh_category.length > 0) {

            $seacrh_category.select2({
                ajax: {
                    type: 'POST',
                    url: ppwsObj.ajaxurl,
                    dataType: 'json',
                    delay: 250,
                    data: (params) => {
                        return {
                            'search': params.term,
                            'action': 'ppws_search_product_categories',
                        }
                    },
                    processResults: (data, params) => {
                        const results = data.map(item => {
                            return {
                                id: item.id,
                                text: item.title,
                            };
                        });
                        return {
                            results: results,
                        }
                    },
                },
                minimumInputLength: 2,
                escapeMarkup: function (markup) { return markup; },
                placeholder: "Please select any categories"
            });
        }

        var $seacrh_page = jQuery(".ppws_product_pages");

        if ($seacrh_page.length > 0) {

            $seacrh_page.select2({
                ajax: {
                    type: 'POST',
                    url: ppwsObj.ajaxurl,
                    dataType: 'json',
                    delay: 250,
                    data: (params) => {
                        return {
                            'search': params.term,
                            'action': 'ppws_search_pages',
                        }
                    },
                    processResults: (data, params) => {
                        const results = data.map(item => {
                            return {
                                id: item.id,
                                text: item.title,
                            };
                        });
                        return {
                            results: results,
                        }
                    },
                },
                minimumInputLength: 2,
                escapeMarkup: function (markup) { return markup; },
                placeholder: "Please select pages"
            });
        }
    }

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


    jQuery("input[name='ppws_form_desgin_settings[ppws_form_page_background_field_image_selecter]']").click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
            .on('select', function (e) {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                jQuery('#ppws_form_page_background_field_image_selecter').val(image_url);
            });
    });



    jQuery("input[name='ppws_form_desgin_settings[ppws_form_background_field_image_selecter]']").click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
            .on('select', function (e) {
                var uploaded_image = image.state().get('selection').first();
                console.log(uploaded_image.toJSON());
                var image_url = uploaded_image.toJSON().url;
                jQuery('#ppws_form_background_field_image_selecter').val(image_url);
            });
    });

    /** Pages JS */
    jQuery("body").on("change", "#enable_user_role", function () {
        if (jQuery(this).is(":checked")) {
            //$("body .ppws-userrole-error").addClass('ppws-hide-section');
            jQuery(".ppws-section-user").removeClass("none-redio-click");
            if (jQuery(".ppws_user_logged_in_user").is(":checked")) {
                jQuery(".ppws-page-logged-in-user-section").removeClass("ppws-hide-section");
            }
        } else {
            jQuery(".ppws-section-user").addClass("none-redio-click");
           // jQuery("body .ppws-userrole-error").removeClass('ppws-hide-section');
            jQuery(".ppws-page-logged-in-user-section").addClass("ppws-hide-section");
        }
        // $(".ppws-page-logged-in-user-section").removeClass("ppws-hide-section");
    });

   jQuery("body").on("click", ".ppws_user_logged_in_user, input[class='ppws_user_non_logged_in_user']", function () {

        if (jQuery("#enable_user_role").is(":checked")) {
            jQuery("body .ppws-userrole-error").addClass('ppws-hide-section');
            jQuery(".ppws-page-logged-in-user-section").removeClass("ppws-hide-section");
        } else {
            jQuery("body .ppws-userrole-error").removeClass('ppws-hide-section');
        }

    });

    if (jQuery("input[class='ppws_user_non_logged_in_user']").is(":checked")) {
        jQuery(".ppws-page-logged-in-user-section").addClass("ppws-hide-section");
    }
    jQuery("body").on("click", ".ppws_user_non_logged_in_user", function () {
        jQuery(".ppws-page-logged-in-user-section").addClass("ppws-hide-section");
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

    jQuery("body").on("change", "input[name='ppws_form_desgin_settings[ppws_form_background_field_radio]']", function () {
        var this_val = jQuery(this).val();
        if (this_val == "none") {
            jQuery(".ppws-form-background-image-selecter").addClass("ppws-hide-section");
            jQuery(".ppws-form-background-color-selecter").addClass("ppws-hide-section");
        } else if (this_val == "image") {
            jQuery(".ppws-form-background-color-selecter").addClass("ppws-hide-section");
            jQuery(".ppws-form-background-image-selecter").removeClass("ppws-hide-section");
        } else if (this_val == "solid-color") {
            jQuery(".ppws-form-background-image-selecter").addClass("ppws-hide-section");
            jQuery(".ppws-form-background-color-selecter").removeClass("ppws-hide-section");
        }
    });

    /* Page Background */
    jQuery("body").on("change", "input[name='ppws_form_desgin_settings[ppws_form_page_background_field_radio]']", function () {
        var this_val = jQuery(this).val();
        if (this_val == "none") {
            jQuery(".ppws-form-page-background-image-selecter").addClass("ppws-hide-section");
            jQuery(".ppws-form-page-background-color-selecter").addClass("ppws-hide-section");
        } else if (this_val == "image") {
            jQuery(".ppws-form-page-background-color-selecter").addClass("ppws-hide-section");
            jQuery(".ppws-form-page-background-image-selecter").removeClass("ppws-hide-section");
        } else if (this_val == "solid-color") {
            jQuery(".ppws-form-page-background-image-selecter").addClass("ppws-hide-section");
            jQuery(".ppws-form-page-background-color-selecter").removeClass("ppws-hide-section");
        }
    });


    jQuery('input[name="ppws_general_settings[ppws_enable_password_field_checkbox]"]').click(function () {
        if (jQuery(this).prop("checked") == true) {
            jQuery(".ppws-whole-site-password-section").removeClass("ppws-hide-section");
            jQuery(".ppws-note-info,.ppws-section-user").removeClass("ppws-hide-section");
        } else if (jQuery(this).prop("checked") == false) {
            jQuery(".ppws-whole-site-password-section").addClass("ppws-hide-section");
            jQuery(".ppws-note-info,.ppws-section-user").addClass("ppws-hide-section");
        }
    });

    jQuery('input[id="ppws_page_enable_password_field_checkbox"]').click(function () {
        if (jQuery(this).prop("checked") == true) {
            jQuery(".ppws-page-enable-password-section,.ppws-section-user,.ppws-note-info").removeClass("ppws-hide-section");
        } else if (jQuery(this).prop("checked") == false) {
            jQuery(".ppws-page-enable-password-section,.ppws-section-user,.ppws-note-info").addClass("ppws-hide-section");
        }
    });

    jQuery('input[id="ppws_product_categories_enable_password_field_checkbox"]').click(function () {
        if (jQuery(this).prop("checked") == true) {
            jQuery(".ppws-product-categories-enable-password-section,.ppws-section-user,.ppws-note-info").removeClass("ppws-hide-section");
        } else if (jQuery(this).prop("checked") == false) {
            jQuery(".ppws-product-categories-enable-password-section,.ppws-section-user,.ppws-note-info").addClass("ppws-hide-section");
        }
    });    
    
    setInterval(function () {
        var isAllChecked = 0;
        jQuery(".editable_roles_single").each(function(){
        if(!this.checked)
            isAllChecked = 1;
        })              
        if(isAllChecked == 0){ jQuery(".editable_roles_all").prop("checked", true); }  
    }, 500);

    jQuery(".editable_roles_all").change(function(){
        if(this.checked){
          jQuery(".editable_roles_single").each(function(){
            this.checked=true;
          })              
        }else{
          jQuery(".editable_roles_single").each(function(){
            this.checked=false;
          })              
        }
      });

    jQuery(".editable_roles_single").click(function () {
        if (jQuery(this).is(":checked")){
          var isAllChecked = 0;
          jQuery(".editable_roles_single").each(function(){
            if(!this.checked)
               isAllChecked = 1;
          })          
        if(isAllChecked == 0){ jQuery(".editable_roles_all").prop("checked", true); }
        }else {
          jQuery(".editable_roles_all").prop("checked", false);
        }
      });

});