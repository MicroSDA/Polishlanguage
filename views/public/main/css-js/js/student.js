
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
                    eventDay.push(clickData);
                    eventTime = item.title;
                    return false;
                }
            });

            if(eventDay.length > 0 ){

                if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {

                    //Edit
                    $('#lessons-date').val(clickData);
                    $('#lessons-time').val(eventTime);
                    $('#deleteLesson').modal();

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

    var date = $('#lessons-date').val();
    var time = $('#lessons-time').val();
    $.ajax({
        type: 'POST',
        url: '/delete-s-lesson',
        headers: {"Ajax": "Ajax"},
        data: {
            Date: date,
            Time: time
        },
        cache: false,
        success: function (html) {

            $('#deleteLesson').modal('toggle');
            $('#error-message').empty();
            $('#error-message').append(html);
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


function changePassword() {

    var data = $('#change-password-form').serializeArray();

    $('#change-password-form').submit(function (e) {
        e.preventDefault();
    });

    $.ajax({
        type: 'POST',
        url: '/change-password',
        headers: {"Ajax": "Ajax"},
        data: data,
        cache: false,
        success: function (html) {

            $('#change-password-message').empty();
            $('#change-password-message').append(html);

        },
        error: function (html) {

        }
    });

}


function changePhoto() {

    var image_data = $('#upload-image').prop('files')[0];
    var form_data = new FormData();
    var name = $('#name').val();

    form_data.append('name', name);
    form_data.append('image', image_data);

    $.ajax({
        url: '/change-photo',
        headers: {"Ajax": "Ajax"},
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (html) {

            $('#change-photo-message').empty();
            $('#change-photo-message').append(html);

        }
    });
    //alert(image_data);

}

$(function () {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready(function () {
        $(':file').on('fileselect', function (event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) /*alert(log)*/;
            }

        });
    });

});