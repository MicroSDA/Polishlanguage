function registerNewUser() {

    var register_data = $('#register-new-user-form').serializeArray();

    $.ajax({
        type: 'POST',
        url: '/register-new-user',
        headers: {"Ajax": "Ajax"},
        data: register_data,
        cache: false,
        success: function (html) {

            $('#register-new-user-message').empty();
            $('#register-new-user-message').append(html);

        }

    });
}

function login() {

    var login_data = $('#login-user-form').serializeArray();

    $.ajax({
        type: 'POST',
        url: '/login-secure',
        headers: {"Ajax": "Ajax"},
        data: login_data,
        cache: false,
        success: function (html) {

            $('#login-user-message').empty();
            $('#login-user-message').append(html);

        }

    });
}


$(document).ready(function () {

    $('#calendar').fullCalendar({
        dayClick: function (date, jsEvent, view) {
            if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {
                var clickData = date.format();
                $('#lessons-date').text(clickData);
                $('#myModal').modal()
            } else {
                $('#error-message').text('This is past day, please choose available days');
                $('#messageModal').modal()

            }
        },
        eventLimit: true, // allow "more" link when too many events
        locale: "ru",
        editable: false,
        selectable: true,
        selectHelper: true,
        businessHours: true, // display business hours
        events: {
            url: '/get-events',
            error: function () {
                $('#script-warning').show();
            }
        },
        loading: function (bool) {
            $('#loading').toggle(bool);
        },

    });

});

function updateLessons() {



}


function addNewLesson() {

    var data = $('#lessons-date').text();
    $.ajax({
        type: 'POST',
        url: '/add-events',
        headers: {"Ajax": "Ajax"},
        data: {
            Data: data
        },
        cache: false,
        success: function (html) {
            $('#calendar').fullCalendar( 'refetchEvents' );
        },
        error: function (html) {
            alert(html);
        }
    });
}