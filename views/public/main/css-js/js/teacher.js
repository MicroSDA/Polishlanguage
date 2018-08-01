
//Calendar init
$(document).ready(function () {


    $('#calendar').fullCalendar({
        eventLimit: true, // allow "more" link when too many events
        locale: "ru",
        editable: false,
        selectable: true,

        events: {
            url: '/get-t-time',
            error: function () {
                $('#script-warning').show();
            }
        },eventRender: function(event, element) {

            if(event.notif === 'yes'){

                $(element).css('border-color', 'red');

                var audio = new Audio();
                audio.src = '/public/notif.mp3';
                audio.autoplay = true;

                $.ajax({
                    type: 'POST',
                    url: '/notif-t-update',
                    headers: {"Ajax": "Ajax"},
                    data: {
                        Date: moment(event.start).format('YYYY-MM-DD').toString(),
                        Time: event.title,
                        Notif: 'no'
                    },
                    cache: false,
                    success: function (html) {
                       // $('#calendar').fullCalendar('updateEvent', event);
                    },
                    error: function (html) {

                    }
                });

            }

            //element.append(event.description);
        },eventAfterRender: function(event, element, view){



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

                if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {

                    //add new
                    $('#new-date').text(clickData);
                    $('#addTime').modal();

                }else {

                    $('#error-message').text('This is past day, please choose available days');
                    $('#messageModal').modal();

                }


        }, eventClick: function(calEvent, jsEvent, view) {

            if (calEvent.url) {
                //window.open(calEvent.url);
                //return false;
            }else{

               // deleteTime(moment(calEvent.start).format('YYYY-MM-DD'),calEvent.title);


                $('#delete-date').val(moment(calEvent.start).format('YYYY-MM-DD'));
                $('#delete-time').val(calEvent.title);
                $('#deleteTime').modal();
               // alert(calEvent.title);
               // alert(moment(calEvent.start).format('YYYY-MM-DD'));

                // change the border color just for fun
               // $(this).css('border-color', 'red');
            }


        }

    });

    setInterval(function() {$('#calendar').fullCalendar('refetchEvents'); }, 60000);

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
        var hours = (date.getHours()<10?'0':'')+ date.getHours();
        var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes();
        time = hours + ":" + minutes;
        return time;
    };
});

function addNewTime() {

    var date = $('#new-date').text();
    var time = $('#new-time').val();
    var offset = moment().format("Z");
    $.ajax({
        type: 'POST',
        url: '/add-t-time',
        headers: {"Ajax": "Ajax"},
        data: {
            Date: date,
            Time: time,
            Offset: offset
        },
        cache: false,
        success: function (html) {

            $('#addTime').modal('toggle');
            $('#error-message').text(html);
            $('#messageModal').modal();
            $('#calendar').fullCalendar('refetchEvents');
        },
        error: function (html) {

        }
    });
}

function deleteTime() {

    $.ajax({
        type: 'POST',
        url: '/delete-t-time',
        headers: {"Ajax": "Ajax"},
        data: {
            Date: $('#delete-date').val(),
            Time: $('#delete-time').val()
        },
        cache: false,
        success: function (html) {

            $('#deleteTime').modal('toggle');
            $('#error-message').text(html);
            $('#messageModal').modal();
            $('#calendar').fullCalendar('refetchEvents');
        },
        error: function (html) {

        }
    });
}

function completeLesson() {

    var data = $('#completeLessonForm').serializeArray();
    $.ajax({
        type: 'POST',
        url: '/complete-t-lesson',
        headers: {"Ajax": "Ajax"},
        data: {
          Data: data
        },
        cache: false,
        success: function (html) {
            $('#lesson-complete-message').empty();
            $('#lesson-complete-message').append(html);
        },
        error: function (html) {

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
        url: '/change-t-password',
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
        url: '/change-t-photo',
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