
//Calendar init
$(document).ready(function () {


    $('#calendar').fullCalendar({
        eventLimit: true, // allow "more" link when too many events
        locale: "ru",
        editable: false,
        selectable: true,

        events: {
            url: '/get-s-calendar',
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
                    getAllTeachers(clickData);

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
        url: '/edit-s-lesson',
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

function getAllTeachers(date) {

    var this_date = date;

    $.ajax({
        type: 'POST',
        url: '/get-s-all-teachers',
        headers: {"Ajax": "Ajax"},
        data: {
            Date: this_date
        },
        cache: false,
        success: function (html) {

            $('#allTeachers').empty();
            $('#allTeachers').append(html);
            $('#getAllTeachersModal').modal();
            //$('#calendar').fullCalendar('refetchEvents');
        },
        error: function (html) {

        }
    });
}

function addNewLesson(id) {

  var data = $('#'+id).serializeArray();

    $.ajax({
        type: 'POST',
        url: '/add-s-lesson',
        headers: {"Ajax": "Ajax"},
        data: {
            Data: data
        },
        cache: false,
        success: function (html) {

            $('#getAllTeachersModal').modal('toggle');
            $('#error-message').empty();
            $('#error-message').append(html);
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
        url: '/delete-s-lesson',
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

function addFeedback() {

    var feedback_data = $('#feedback-form').serializeArray();

    $.ajax({
        type: 'POST',
        url: '/add-feedback',
        headers: {"Ajax": "Ajax"},
        data: feedback_data,
        cache: false,
        success: function (html) {
            $('#feedback-message').empty();
            $('#feedback-message').append(html);

        }

    });
}

