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

//Calendar init
$(document).ready(function () {


    $('#calendar').fullCalendar({
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
            $('#loading-calendar').toggle(bool);
        },
        dayClick: function (date, allDay, jsEvent, view) {
            var dayEvents = $('#calendar').fullCalendar('clientEvents', function(event){
                return event;
            });


            var clickData = date.format();
            var eventDay = [];
            var eventTime = '';

            dayEvents.forEach(function(item, i, dayEvents) {
                if(clickData.toString() === moment(item.start).format().toString()) {
                    //alert(moment(item.start).format());
                    eventDay.push(clickData);
                    eventTime = item.title;
                    return false;
                }
            });

            if(eventDay.length > 0 ){

                if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {

                    //Edit
                    $('#lessons-date-edit').text(clickData);
                    $('#lessons-time-edit').val(eventTime);
                    $('#lessons-date-edit-offset').val(moment().format("Z"));
                    $('#edit-lessons-day').modal();

                }else {

                    $('#error-message').text('This is past day, please choose available days');
                    $('#messageModal').modal();

                }


            }else{

                if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {

                    //add new
                    $('#lessons-date').text(clickData);
                    $('#lessons-date-offset').val(moment().format("Z"));
                    $('#myModal').modal();

                }else {

                    $('#error-message').text('This is past day, please choose available days');
                    $('#messageModal').modal();

                }

            }





            /* if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {
                 var clickData = date.format();
                 $('#lessons-date').text(clickData);
                 $('#myModal').modal()

             } else {
                 $('#error-message').text('This is past day, please choose available days');
                 $('#messageModal').modal()

             }*/
        }

    });

});

//Clock init
$(document).ready(function () {

    $('.clockpicker').clockpicker({
        default: 'now',
        placement: 'bottom',
        align: 'left',
        donetext: 'Done',
        vibrate: true
    }).find('input').val(DisplayCurrentTime())

    function DisplayCurrentTime() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes();
        time = hours + ":" + minutes;
        return time;
    };
});


function editLesson() {



    var data = $('#lessons-date-edit').text();
    var time = $('#lessons-time-edit').val();
    var offset = $('#lessons-date-edit-offset').val();
    $.ajax({
        type: 'POST',
        url: '/edit-events',
        headers: {"Ajax": "Ajax"},
        data: {
            Data: data,
            Time: time,
            Offset: offset
        },
        cache: false,
        success: function (html) {

            $('#edit-lessons-day').modal('toggle');
            $('#error-message').text(html);
            $('#messageModal').modal();
            $('#calendar').fullCalendar('refetchEvents');

        },
        error: function (html) {
            alert(html);
        }
    });

}


function addNewLesson() {

    var data = $('#lessons-date').text();
    var time = $('#lessons-time').val();
    var offset = $('#lessons-date-offset').val();
    $.ajax({
        type: 'POST',
        url: '/add-events',
        headers: {"Ajax": "Ajax"},
        data: {
            Data: data,
            Time: time,
            Offset: offset
        },
        cache: false,
        success: function (html) {

            $('#myModal').modal('toggle');
            $('#error-message').text(html);
            $('#messageModal').modal();
            $('#calendar').fullCalendar('refetchEvents');
        },
        error: function (html) {

        }
    });
}

function deleteLesson() {

    var data = $('#lessons-date-edit').text();
    var time = $('#lessons-time-edit').val();
    $.ajax({
        type: 'POST',
        url: '/delete-events',
        headers: {"Ajax": "Ajax"},
        data: {
            Data: data,
            Time: time
        },
        cache: false,
        success: function (html) {

            $('#edit-lessons-day').modal('toggle');
            $('#error-message').text(html);
            $('#messageModal').modal();
            $('#calendar').fullCalendar('refetchEvents');

        },
        error: function (html) {

        }
    });
}