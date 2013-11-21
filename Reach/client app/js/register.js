(function() {
    var auth = {
        registration_state: 1,
        identity: "",
        password2: "",
        err_message: "",
        first_name: "",
        last_name: "",
        new_password: "",
        new_email: "",
        new_username: ""
    };

    ///Transition animations
    function one_two() {
        auth.registration_state = 2;
        $('#login').fadeOut(function() {
            auth.err_message = "";
            $('.register_err_message').text(auth.err_message);
            $('#registration').show('slow', function() {
                $('#create').fadeOut('slow', function() {
                    $('#create').html(' back &nbsp ');
                });
                $('#create').fadeIn('slow');
            });
        });
    }

    function two_one() {
        auth.registration_state = 1;
        $('#registration').fadeOut(function() {
            $('#login').fadeIn('slow', function() {
                $('#create').fadeOut('slow', function() {
                    $('#create').html('create ');
                });
                $('#create').fadeIn('slow');
            });
        });
    }

    function two_three() {
        auth.registration_state = 3;
        $('#registration').fadeOut(function() {
            auth.err_message = "";
            $('.register_err_message').text(auth.err_message);
            $('#registration2').show(500, 'linear');
        });
    }

    function three_two() {
        auth.registration_state = 2;
        $('#registration2').fadeOut(function() {
            $('#registration').fadeIn();
        });
    }
    //End Transitions


    //Effects -- on 2nd view	
    //displays first name and last name	input after message is clicked
    $('#reg_mess_1').click(function() {
        $('#reg_mess_1').fadeOut(200, function() {
            $('#reg_mess_2').fadeIn(300);
            $('#last_name, #first_name').fadeIn(300);
        });
    });

    //shows first and last name as it's being typed
    $('#last_name, #first_name').keyup(function() {
        $("#reg_mess_2").text($('#first_name').val() + " " + $('#last_name').val());
    });

    //display error
    function error() {
        $('#logo_pusher').animate({
            width: '10%',
        }, 80, 'linear', function() {
            $('#logo_pusher_2').animate({
                width: '20%',
            }, 80, 'linear', function() {
                $('#logo_pusher_2, #logo_pusher').animate({
                    width: '1%',
                }, 100);
            });
        });
        $('.register_err_message').text(auth.err_message);
        return false;
    }

    function validate_page_1(id, pass) {
        if (!is_email(id)) {
            if (!validate_username(id)) {
                return false;
            }
        }
        if (!validate_password(pass)) {
            return false;
        }
        return true;
    }

    function validate_page_3(id, mail, pass) {
        console.log(id.length);
        if (id.length > 0) {
            if (is_email(mail) && validate_username(id) && validate_password(pass)) {
                return true;
            }
        } else if (id.length < 1 && is_email(mail) && validate_password(pass)) {
            return true;
        } else {
            return false;
        }
    }

    ///validation functions
    function validate_username(id) {
        var username_regex = /^[A-Za-z](?=[A-Za-z0-9_.]{3,20}$)[a-zA-Z0-9_]*\.?[a-zA-Z0-9_]*$/;

        if (!username_regex.test(id)) {
            if ((id.length) > 21) {
                auth.err_message = "That's a long username. Let's keep it under 20 characters.";
            } else if ((id.length) < 4) {
                auth.err_message = "That's a short username. Let's make it more than 4 characters.";
            } else {
                auth.err_message = "You can use 4-20 characters, including underscores and one dot.";
            }
            return error();
        }
        return username_regex.test(id);
    }

    function validate_password(pass) {
        var password_regex = /^.{8,20}$/;

        if (password_regex.test(pass)) {
            return true;
        } else if (pass.length < 8) {
            auth.err_message = "My grandma can hack that password. Let's shoot for 8 characters or more.";
            return error();
        } else if (pass.length > 21) {
            auth.err_message = "We know you're really important but twenty character max :)";
            return error();
        } else if (!password_regex.test(password)) {
            auth.err_message = "Passwords can be  8-20 characters";
            return error();
        }
    }

    function validate_name(first, last) {
        var name_regex = /^[a-zA-Z\-_\.]{1,20}$/;

        if (first.length === 0 || last.length === 0) {
            auth.err_message = "Surely your parents wrote something on the birth certificate.";
            return error();
        }
        if (!name_regex.test(first)) {
            auth.err_message = "That's probably not a real first name.";
            return error();
        }
        if (!name_regex.test(last)) {
            auth.err_message = "That's probably not a real last name.";
            return error();
        }
        if (name_regex.test(last) && name_regex.test(first)) {
            return true;
        } else {
            auth.err_message = "Surely your parents wrote something on the birth certificate.";
            return error();
        }
    }

    function is_email(email) {
        var email_regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (auth.registration_state === 3 && !email_regex.test(email)) {
            auth.err_message = "Hmmm, doesn't look like a valid email.";
            return error();
        }
        return email_regex.test(email);
    }

    //show submit button if text is entered	
    $('form').keyup(function() {
        "use strict";
        switch (auth.registration_state) {
            case 1:
                auth.identity = $.trim($('#identity').val());
                auth.password2 = $.trim($('#password2').val());
                if (auth.identity && auth.password2) {
                    $('#login .submit').animate({
                        opacity: 1
                    }, 3000);
                }
                break;
            case 2:
                auth.first_name = $.trim($('#first_name').val());
                auth.last_name = $.trim($('#last_name').val());
                if (auth.first_name && auth.last_name) {
                    $('#registration .submit').animate({
                        opacity: 1
                    }, 3000);
                }
                break;
            case 3:
                auth.new_username = $.trim($('#new_username').val());
                auth.new_email = $.trim($('#new_email').val());
                auth.new_password = $.trim($('#new_password').val());
                if (auth.new_email && auth.new_password) {
                    $('#registration2 .submit').animate({
                        opacity: 1
                    }, 3000);
                }
                break;
        }
    });
    //validate submited form
    $(".submit").on('click', validate);

    //validate and navigate forward
    function validate() {
        "use strict";
        switch (auth.registration_state) {
            case 1:
                if (validate_page_1(auth.identity, auth.password2)) {
                    ajax();
                }
                break;
            case 2:
                if (validate_name(auth.first_name, auth.last_name)) {
                    two_three();
                }
                break;
            case 3:
                if (validate_page_3(auth.new_username, auth.new_email, auth.new_password)) {
                    ajax();
                }
                break;
        }
    }
    //navigate back
    $('#create').on('click', function() {
        "use strict";
        switch (auth.registration_state) {
            case 1:
                one_two();
                break;
            case 2:
                two_one();
                break;
            case 3:
                three_two();
                break;
        }
    });

    function ajax() {
        $.ajax({
            url: '/controller/auth_controller.php',
            type: 'POST',
            data: auth,
            success: function(data) {
                if (data.success === 1) {
                    login_success(data);
                } else {
                    login_problem(data.msg);
                }
            },
            error: function(err) {
                auth.err_message = "Snap, something in internet land messed up. Don't worry and try 									again soon. Ok?";
                error();
            }
        });
    }

    function login_success(data) {
        linkLocation = 'home.html';
        $("body").fadeOut(3000, redirect_page);
    }

    function redirect_page() {
        window.location = linkLocation;
    }

    function login_problem(msg) {
        auth.err_message = msg;
        error();
    }
})();