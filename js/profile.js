jQuery(function(){


    jQuery('.members__avatar--identicon').each(function(index, ele) {

        var $ele = jQuery(ele);
        var user = $ele.data('username');
 
        var avatar = new Identicon(btoa(user + 'mozilla-community-portal'), { format: 'svg' }).toString();
        $ele.css({'background-image': "url('data:image/svg+xml;base64," + avatar + "')"});

    });

    if(jQuery('.profile__avatar--empty').length > 0) {
        var user = jQuery('.profile__avatar--empty').data('user');
        var avatar = new Identicon(btoa(user + 'mozilla-community-portal'), { format: 'svg' }).toString();
        jQuery('.profile__avatar--empty').css({'background-image': "url('data:image/svg+xml;base64," + avatar + "')"});
    };

    jQuery('#complete-profile-form').one('submit', function(e){
        e.preventDefault();
        var error = false;

        jQuery(':input[required]').each(function(index, element) {
            var $ele = jQuery(element);
            var $errorMsg = $ele.next('.form__error-container');

            if($ele.val() == "" || $ele.val() == "0" || ($ele.is(':checkbox') && $ele.prop("checked") === false)) {
                error = true;           
                $ele.addClass("profile__input--error");
                $errorMsg.addClass('form__error-container--visible');
            }

            // Validate email
            if($ele.attr('name') == 'email' && $ele.val()) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(re.test(String($ele.val()).toLowerCase()) === false) {
                    error = true;
                    $ele.addClass("profile__input--error");
                    $errorMsg.addClass('form__error-container--visible');
                    $ele.next('.form__error-container').children('.form__error').text('Invalid Email');
                } else {
                    $ele.next('.form__error-container').children('.form__error').text('This field is required');
                }
            }
        });

        if(error || jQuery('.profile__input--error').length > 0) {
            jQuery('#complete-profile-form').find('.profile__input--error:first').focus();
            return false;
        } else {
            jQuery(this).submit();
            return true;
        }


    });

    jQuery('#profile-visibility').change(function(e) {
        var $this = jQuery(this);
        var value = parseInt($this.val());

        switch(value) {
            case 2:
                jQuery('#firstname-visibility').val(0);
                jQuery('#lastname-visibility').val(2);
                jQuery('#email-visibility').val(2);
                jQuery('#profile-pronoun-visibility').val(2);
                jQuery('#profile-bio-visibility').val(2);
                jQuery('#profile-location-visibility').val(2);
                jQuery('#profile-phone-visibility').val(2);
                break;
            default:
                jQuery('#firstname-visibility').val(value);
                jQuery('#lastname-visibility').val(value);
                jQuery('#email-visibility').val(value);
                jQuery('#profile-pronoun-visibility').val(value);
                jQuery('#profile-bio-visibility').val(value);
                jQuery('#profile-location-visibility').val(value);
                jQuery('#profile-phone-visibility').val(value);
        }
    });

    jQuery('#social-visibility').change(function(e) {
        var $this = jQuery(this);
        var value = parseInt($this.val());

        jQuery('#profile-discourse-visibility').val(value);
        jQuery('#profile-facebook-visibility').val(value);
        jQuery('#profile-twitter-visibility').val(value);
        jQuery('#profile-linkedin-visibility').val(value);
        jQuery('#profile-github-visibility').val(value);
        jQuery('#profile-telegram-visibility').val(value);
    });

    jQuery('#communication-visibility').change(function(e) {
        var $this = jQuery(this);
        var value = parseInt($this.val());

        jQuery('#profile-languages-visibility').val(value);
        jQuery('#profile-tags-visibility').val(value);
       
    });


    jQuery('#portal-visibility').change(function(e) {
        var $this = jQuery(this);
        var value = parseInt($this.val());

        jQuery('#profile-groups-joined-visibility').val(value);
        jQuery('#profile-events-attended-visibility').val(value);
        jQuery('#profile-events-organized-visibility').val(value);
        jQuery('#profile-campaigns-visibility').val(value);
    });

    jQuery('.profile__add-language').click(function(e) {
        e.preventDefault();
        var $element = jQuery('.profile__form-field--tight:last');

        if($element.hasClass('profile__form-field--hidden')) {
            $element.removeClass('profile__form-field--hidden');
        } else {
            var $newLanguage = $element.clone(true);
            $newLanguage.addClass('profile__form-field--new');
            $newLanguage.insertBefore('.profile__add-language-container');
        }

        jQuery('.profile__form-field--new').find('.profile__select').val('');
        jQuery('.profile__form-field--new').removeClass('profile__form-field--new');
        $element.find(".profile__select--short:first").removeClass("profile__select--hide");

        return false;
    });

    jQuery('.profile__remove-language').click(function(e) {
    
        e.preventDefault();

        var $element = jQuery(this).parent().parent();
        jQuery(this).prev('.profile__select').addClass('profile__select--hide');

        if(jQuery('.profile__form-field--tight').length === 2) {
            $element.addClass('profile__form-field--hidden');
        } else {
            $element.remove();
        }

        jQuery(".profile__select--hide").val("");


        return false;
    });

    jQuery('.profile__tag').click(function(e) {
        e.preventDefault();
        var $this = jQuery(this);
        var tag = $this.data('value');
        var current = jQuery('#tags').val();

        if(!$this.hasClass('profile__tag--active'))
            jQuery('#tags').val(current + ',' + tag);
        
        if($this.hasClass('profile__tag--active'))
            jQuery('#tags').val(current.replace(',' + tag, ''));

        $this.toggleClass('profile__tag--active');

        return false;
    });


    jQuery('#username').on('change keyup', function(e) {
        var $this = jQuery(this);
        var value = $this.val();
        var get = { };
        get.u = value;

        var $errorContainer = $this.next('.form__error-container');
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php?action=check_user',
            data: get,
            method: 'GET',
            success: function(data) {
                var response = jQuery.parseJSON(data);

                // User name is no good
                if(response == false) {
                    $this.addClass('profile__input--error');
                    $errorContainer.addClass('form__error-container--visible');
                    $errorContainer.children('.form__error').text('This username is already taken');
                } else {
                    $this.removeClass('profile__input--error');
                    $errorContainer.removeClass('form__error-container--visible');
                    $errorContainer.children('.form__error').text('This field is required');
                }
            }
        })
    });


    jQuery('#email').on('change keyup', function(e) {
        var $this = jQuery(this);
        var value = $this.val();
        var get = { };
        get.u = value;

        var $errorContainer = $this.next('.form__error-container');
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php?action=validate_email',
            data: get,
            method: 'GET',
            success: function(data) {
                var response = jQuery.parseJSON(data);
                if(response == false) {
                    $this.addClass('profile__input--error');
                    $errorContainer.addClass('form__error-container--visible');
                    $errorContainer.children('.form__error').text('This email is already in use');
                } else {
                    $this.removeClass('profile__input--error');
                    $errorContainer.removeClass('form__error-container--visible');
                    $errorContainer.children('.form__error').text('This field is required');
                }
            }
        })
    });




    jQuery("#profile-photo-uploader").dropzone({
        url: '/wp-admin/admin-ajax.php?action=upload_group_image',
        acceptedFiles: 'image/*',
        createImageThumbnails: false,
        addRemoveLinks: true,
        init: function() {
            this.on("sending", function(file, xhr, formData){
                var nonce = jQuery('#my_nonce_field').val();
                formData.append('my_nonce_field', nonce);
            });
        },
        success: function (file, response) {
            
            file.previewElement.classList.add("dz-success");
            file['attachment_id'] = response; // push the id for future reference
            
            jQuery('#image-url').val(response);
            jQuery('#profile-photo-uploader').css('background-image', 'url(' +  response + ')');
            jQuery('#profile-photo-uploader').css('background-size', 'cover');
            jQuery('#profile-photo-uploader').addClass("profile__image-upload--complete");
            
        },
        error: function (file, response) {
            
            file.previewElement.classList.add("dz-error");
        },
        sending: function(file, xhr, formData) {
        },
        removedfile: function(file) {
           
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;     
        }
    });



    jQuery('.profile__input, .profile__textarea, .profile__select').on('change keyup', function(e){
        var $this = jQuery(this);
        if($this.val() != '' || $this.val() == '0') {
            $this.removeClass('profile__input--error');
            $this.next('.form__error-container').removeClass('form__error-container--visible');
        } else {
            $this.addClass('profile__input--error');
            $this.next('.form__error-container').addClass('form__error-container--visible');
        }
        e.stopPropagation();

        return false;
    });

});