(function() {
    $('#sign_in_button').on('click', sign_in);
    $('#create_new_account').on('click', create);
    $('#create_signup_form').on('click', modal);

    function modal() {
        $('#error_box2').text('').hide();
    }

    function login_success(data) {
        console.log(data);
        console.log(data.response);
        //linkLocation = 'home.html';
        //$("body").fadeOut(3000, redirect_page);	
    }

    function redirect_page() {
        window.location = linkLocation;
    }

    function login_error() {
        var msg = 'Error logging in';
        error(msg);
    }


    function get_form_input(id, validator) {
        var check = '',
            type = $(id).attr('type');

        if (type != 'checkbox') {
            check = $(id).val();
        } else if (type == 'checkbox') {
            check = $(id).attr('checked');
        }

        if (validator(check)) {
            return check;
        } else {
            return false;
        }
        return false;
    }

    ///validation functions

    function validate_username(id) {
        var username_regex = /^[A-Za-z](?=[A-Za-z0-9_.]{3,20}$)[a-zA-Z0-9_]*\.?[a-zA-Z0-9_]*$/;
        var msg;
        if (!username_regex.test(id)) {
            if ((id.length) > 21) {
                msg = "That's a long username. Let's keep it under 20 characters.";
            } else if ((id.length) < 4) {
                msg = "That's a short username. Let's make it more than 4 characters.";
            } else {
                msg = "You can use 4-20 characters, including underscores and one dot.";
            }
            return error(msg);
        }
        return username_regex.test(id);
    }

    function validate_password(pass) {
        var msg;
        var password_regex = /^.{8,20}$/;

        if (password_regex.test(pass)) {
            return true;
        } else if (pass.length < 8) {
            msg = "Passwords should be 8 characters or more.";
            return error(msg);
        } else if (pass.length > 21) {
            msg = "We know you're really important but twenty character max :)";
            return error(msg);
        } else if (!password_regex.test(password)) {
            msg = "Passwords can be  8-20 characters";
            return error(msg);
        }
    }

    function validate_email(email) {
        var email_regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var msg;
        if (!email_regex.test(email)) {
            msg = "Hmmm, doesn't look like a valid email.";
            return error(msg);
        }
        return email;
    }

    function validate_awesomeness(awesome) {
        if (awesome !== 'checked') {
            msg = "Can you confirm that you are indeed awesome?";
            return error(msg);
        } else {
            return true;
        }

    }

    function error(msg) {
        //this is lazy and should be fixed at some point
        $('#error_box1').slideDown();
        $('#error_box2').slideDown();
        $('#error_box1').text(msg);
        $('#error_box2').text(msg);

        return false;
    }

    function create_success() {
        login_success();
    }

    function create_error() {
        var msg = 'Error logging in';
        error(msg);
    }


    function sign_in() {
        var send = {
            'password': get_form_input('#password', validate_password),
        },
            url = "http://api.tallyapp.bananastand.co/auth/login",
            identity = $('#identity').val();

        if (identity.indexOf('@') !== -1) {
            send.identity = get_form_input('#identity', validate_email);
        } else {
            send.identity = get_form_input('#identity', validate_username);
        }


        if (send.identity && send.password) {
            console.log(send);
            $.when($.post(url, send, 0, 'json')).then(login_success, login_error);
        } else {
            return;
        }
    }

    function create() {
        var send = {
            'password': get_form_input('#new_password', validate_password),
            'username': get_form_input('#new_username', validate_username),
            'email': get_form_input('#new_email', validate_email),
            'awesome': get_form_input('#awesome', validate_awesomeness),
        };


        var url = "http://api.tallyapp.bananastand.co/auth/register";

        if (send.username && send.password && send.email && send.awesome) {
            console.log(send);
            $.when($.post(url, send, 0, 'json')).then(create_success, create_error);
        } else {
            //return error('Error logging in. Try again soon.');
        }
    }
})();