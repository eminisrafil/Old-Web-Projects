(function() {
    $(document).ready(function() {
        initializemap();
        geo();
    });

    //user variables
    var user = {
        lat: '',
        lng: '',
        cause_action: 0,
        page: 0,
    }
    //put lat/lng into an object it is given

    function geocode(obj, loc) {
        var dfd = $.Deferred();
        var geocoder = new google.maps.Geocoder();
        var results = geocoder.geocode({
            address: loc
        }, function callback(data) {
            obj.lat = data[0].geometry.location.lat();
            obj.lng = data[0].geometry.location.lng();
            if (obj.hasOwnProperty('state')) {
                var i = data[0].address_components.length;
                for (var ix = 0; ix < i; ix++) {
                    if (data[0].address_components[ix].types[0] == "administrative_area_level_1") {
                        obj.state = data[0].address_components[ix].short_name;
                    }
                }
            }
            dfd.resolve();
        });
        return dfd.promise();
    }

    function ajax(send, where) {
        //console.log(send);
        $.ajax({
            url: '/controller/' + where + '_controller.php',
            type: 'POST',
            dataType: 'json',
            data: send,
            success: function(a) {
                //console.log(a);
                if (a.success === 1) {
                    direct_success(a);

                } else {
                    create_cause_problem(a.msg);
                }
                if (a.msg.length > 1) {
                    msg_disp(a.msg);
                }

            },
            error: function(err) {
                msg_disp('Error with Ajax Call');
            }
        });
    }

    function load_cause(el) {
        $('#bottom_field').load('cause_page.html', function() {
            user.cause_action = 1;
            ajax(user, 'cause');
            user.cause_action = 3;
            ajax(user, 'cause');
        });
    }

    function load_profile(userData) {
        var $userData = $(userData);
        var send = {
            user_id: $userData.data('user_id'),
            action: 1,
        }
        ajax(send, 'user');
    }

    //Anitmations
    function msg_disp(msg) {
        //create message queue---at the end of an event, fire the queue
        //console.log($('#btm_msg').queue().length);
        $('#btm_msg').text(msg);
        $('#btm_msg').fadeIn(2000).fadeOut(3000);
    }

    var notifications = 0;
    var toggler = 0;

    function menu(load) {
        notifications++;
        toggler = (toggler + 1) % 3;
        $('#notifications').html('(' + notifications + ')');

        if (toggler == 0) {
            $('#footer').animate({
                top: '91%'
            });
            $('#wrapper').animate({
                height: '40%'
            });


        } else if (toggler == 1) {
            $('#footer').animate({
                top: '50%'
            });
            $('#wrapper').animate({
                height: '40%'
            }, function() {
                //setInterval(function(){
                scroll.refresh();
                //	},2000);
            });
        } else if (toggler == 2) {

            $('#footer').animate({
                top: '10%'
            });
            $('#wrapper').animate({
                height: '80%'
            }, scroll.refresh());
        }
        //put this as a call back after animation is complete along with a scroll refresh
        load;

        ///check msg_disp queue, if something is in there play it
    }

    function show_map() {
        var view = $('#profile_view').css('display');
        console.log(view);
        if (view === 'block') {
            $('#profile_view').hide(2000, (function() {
                $('#map_view').show(2000, (function() {
                    google.maps.event.trigger(map, 'resize');
                    print_geo();
                    console.log('ifing');
                }));
            }));
        } else if (view === 'none') {
            $('#map_view').hide(2000, function() {
                $('#profile_view').show(2000, function() {
                    console.log('elsing');
                });
            });
        }

    }

    /*
	//seems to be a lot slower than above method
	function show_map() {
		var view= $('#profile_view').css('display');
		if(view==='block'){
			$.when(hide_profile()).then((function(){reveal_map()}));
		} else if(view ==='none') {
			$.when(hide_map()).then(reveal_profile);
		}
	}

	function reveal_map() {
		var dfd = $.Deferred();
		$('#map_view').show(2000, function (){
			//console.log(user.lat, user.lng);
			google.maps.event.trigger(map, 'resize');
			map.setCenter(new google.maps.LatLng(user.lat, user.lng));
			dfd.resolve();
		})
		//dfd.done(function(){map.setCenter(new google.maps.LatLng(user.lat, user.lng))});
		return dfd.promise();
	}

	function hide_map() {
		var dfd = $.Deferred();
		$('#map_view').hide(2000, function () {
			//console.log(2);
			dfd.resolve();
		});
		dfd.done(function(){console.log('hid map')});
		return dfd.promise();
	}


	function reveal_profile() {
		var dfd = $.Deferred();
		$('#profile_view').show(2000, function (){
			//console.log(3);
			dfd.resolve();
		});
		dfd.done(function(){console.log('revealed_profile')});
		return dfd.promise()
	}

	function hide_profile() {
		var dfd = $.Deferred();
		$('#profile_view').hide(2000, function (){
			//console.log(4);
			dfd.resolve();
		});
		dfd.done(function(){console.log('hid profile')});
		return dfd.promise();
	}
	*/
})();