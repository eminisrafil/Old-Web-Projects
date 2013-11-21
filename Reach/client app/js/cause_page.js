(function() {
    scroll = null;
    scroll = new TWIS('#wrapper');
    my_scroll();

    function my_scroll() {
        function loaded() {
            window.removeEventListener('load', loaded, false);
        }
        window.addEventListener('load', loaded, false);
    }

    function direct_success(el) {
        switch (el.action) {
            case 0:
                scroll.scrollToPage(1, 3000);
                setTimeout(function() {
                    list_stuff(el.results, el.data_type, '#thelist2', 'prepend');
                }, 3000);

                break;
            case 1:
                list_stuff(el.results, el.data_type, '#thelist', 'append');
                break;
            case 2:
                join_cause_success(el.results);
                break;
            case 3:
                list_stuff(el.results, el.data_type, '#thelist2', 'append');
                break;
            case 4:
                leave_cause_success(el.results);
                break;
            case 5:
                display_cause_success(el.results[0]);
                break;
        }

    }

    function create_cause() {
        //var for ajax
        var new_cause = {
            cause_action: 0,
            cause_name: "",
            location: "",
            description: "",
            lat: "",
            lng: "",
            state: "",
            privacy: 0,
            err_message: "",
            password: ""
        };

        //set user values 
        new_cause.cause_name = $('#cause_name').val();
        new_cause.description = $('#cause_description').val();
        new_cause.location = $('#cause_location').val();

        if ($('#cause_privacy').prop('selectedIndex') === 1) {
            new_cause.privacy = 1;
            new_cause.password = $('#cause_password').val();
            if (new_cause.password.length < 1) {
                alert('Enter password if you want a private event.');
                return;
            }
        } else {
            new_cause.privacy = 0;
            new_cause.password = '';
        }
        var new_cause_loc = $("#cause_location").val();

        //send cause info after the geolocation is completed
        $.when(geocode(new_cause, new_cause_loc)).then(function() {
            ajax(new_cause, 'cause')
        });
    }

    function create_cause_success() {

    }

    function create_cause_problem() {

    }

    function list_stuff(data, type, where, order) {
        var items = [];
        $.each(data, function(i, item) {
            items.push(
                //using jquery $data might make this look more readable
                '<li data-lat="' + item.lat + '" data-lng="' + item.lng + '" data-type="' + type + '" data-id="' + item.cause_id + '" data-privacy="' + item.privacy + '" type = "li"> ' +
                '<div class ="li_title">' + item.cause_name + '</div>' +
                '<div class ="li_description">' + item.description + '</div>' +
                '<div class ="li_footer">' + 'Miles: ' + item.distance + '  People: ' + item.peeps);

            if (item.privacy != 0) {
                items.push('  (Private Cause) ');
            }
            if (where == '#thelist') {
                items.push(
                    '</div>' +
                    '<button data-action ="2" type ="button" class ="join_button" onclick="join_cause(this)">Join</div></li>'
                );
            } else if (where == '#thelist2') {
                items.push(
                    '</div>' +
                    '<button data-action= "4" type ="button" class ="join_button" onclick="join_cause(this)">Leave</div></li>'
                );
            }
        });

        if (order === 'append') {
            $(where).append(items.join(''));
        } else {
            $(where).prepend(items.join(''));
        }

        scroll.refresh();
    }

    function join_cause(el) {
        var $el = $(el);
        var pass = 0;
        var c_id = $el.closest("li").data("id");
        var p = $el.closest("li").data("privacy");
        var action = $el.data("action");

        if (p !== 0 && action == 3) {
            pass = prompt("This cause requires a password to join.");
            if (pass === null || pass === '') {
                return false;
            }
        }

        var send = {
            cause_id: c_id,
            cause_action: action,
            privacy: p,
            password: pass,
        };

        ajax(send, 'cause');
        return false;
    }

    function join_cause_success(id) {
        var $li = $('#thelist li[data-id="' + id + '"]'),
            $li2 = $li.clone().prependTo('#thelist2').children('button').text('Leave').data("action", 4);
        $li.children('button').fadeOut('slow');
    }

    function leave_cause_success(id) {
        var $li = $('#thelist2 li[data-id="' + id + '"]'),
            $li_exists = $('#thelist li[data-id="' + id + '"]');

        $li.slideUp('slow');
        if ($li_exists.length === 0) {
            var $li2 = $li.clone().appendTo('#thelist').children('button').text('Join').data("action", 2);
        } else {
            $li_exists.children('button').fadeIn();
        }
        $li = $li_exists = $li2 = null;
    }

    function cause_display(el) {
        var $li = $(el.target).closest("li"),
            id = $li.data('id');

        if (id) {
            var send = {
                cause_id: id,
                cause_action: 5,
                privacy: $li.data('privacy')
            };
            ajax(send, 'cause');
        }
    }

    function display_cause_success(el) {
        ///part 1
        var items = [];
        $.each(el.peeps, function(i, item) {
            items.push(
                '<li onclick="load_profile(this)" data-user_id="' + item.user_id + '">' +
                item.first_name + ' ' + item.last_name +
                '</li>'
            );
        });

        $list = $('#profile_list');
        $list.fadeOut('slow', function() {
            $list.empty().prepend(items.join(''));
        }).fadeIn();
        //part 2
        $('#profile_pic').show();
        $('#profile_banner').text(el.cause_name);
        $('#description').text(el.description);
        $('#profile_sub1').text('goal: :)');
        $('#profile_sub2').text('Followers: ' + el.total_peeps);
    }

    $('#wrapper').on('click', this, cause_display);

    ///Animations
    function password_reveal(el) {
        if (el) {
            if (el.selectedIndex === 0) {
                $('#password_li').delay(450).slideUp('slow');
            } else if (el.selectedIndex === 1) {
                $('#password_li').delay(450).slideDown('slow');
            }
        }
    }

    function create_cause_transition() {
        $('#create_cause_button').fadeOut(2000, function() {
            $('#create_cause_form').fadeIn(2000);
        });
    }

    ///functions for testing
    //$('#wrapper').click(function(){
    //var id = event.srcElement;
    //console.log(id);
    //var id2 = $(id).closest("li").data("id");
    //console.log(id2);
    //});
})();