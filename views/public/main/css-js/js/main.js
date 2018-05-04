function registerNewUser() {

    var register_data = $('#register-new-user-form').serializeArray();

    $.ajax({
        type: 'POST',
        url:  '/register-new-user',
        headers: { "Ajax": "Ajax" },
        data: register_data,
        cache: false,
        success: function (html){

            $('#register-new-user-message').empty();
            $('#register-new-user-message').append(html);

        }

    });
}

function login() {

    var login_data = $('#login-user-form').serializeArray();

    $.ajax({
        type: 'POST',
        url:  '/login-secure',
        headers: { "Ajax": "Ajax" },
        data: login_data,
        cache: false,
        success: function (html){

            $('#login-user-message').empty();
            $('#login-user-message').append(html);

        }

    });
}


$(document).ready(function() {

    $('#calendar').fullCalendar({
        dayClick: function (date, jsEvent, view) {
            var clickData = date.format();
            $('#lessons-date').text(clickData);
            $('#myModal').modal()
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        lang: 'ru',
        editable: false,
        events: [
            {
                title: 'Hi',
                start: '2018-05-01'
            },
            {
                title: 'Long Event',
                start: '2018-03-07',
                end: '2018-03-10'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2018-03-09T16:00:00'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2018-03-16T16:00:00'
            },
            {
                title: 'Conference',
                start: '2018-03-11',
                end: '2018-03-13'
            },
            {
                title: 'Meeting',
                start: '2018-03-12T10:30:00',
                end: '2018-03-12T12:30:00'
            },
            {
                title: 'Lunch',
                start: '2018-03-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2018-03-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2018-03-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2018-03-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2018-03-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2018-03-28'
            }
        ]
    });

});
