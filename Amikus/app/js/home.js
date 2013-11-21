(function() {
    console.log('app started');
    $('#edit_account').on('click', update_profile);

    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    function update_profile() {
        var $new_password = $('#new_password').val();
        var $fieldset = $('#update_profile_fieldset');
        var $fieldsetserial = $('#update_profile_fieldset').serializeArray();
        var send = {
            'password': $new_password || "",
            //'username' : get_form_input('#new_username', validate_username),
            //'email'    : get_form_input('#new_email', validate_email),
            //'awesome'  : get_form_input('#awesome', validate_awesomeness)
        };

        console.log(send);
        console.log($new_password);
        console.log($fieldsetserial);

        console.log($fieldset);
        if (send.username && send.password && send.email && send.awesome) {
            console.log(send);
            $.when($.post(url, send)).then(create_success, create_error);
        } else {
            //return error('Error logging in. Try again soon.');
        }
    }

    //get_form_input('#new_password', validate_password)

})();