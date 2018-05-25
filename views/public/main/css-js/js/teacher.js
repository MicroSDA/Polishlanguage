
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

    setInterval(function() {$('#calendar').fullCalendar('refetchEvents'); }, 5000);

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