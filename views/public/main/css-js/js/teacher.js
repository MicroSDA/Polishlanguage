
//Calendar init
$(document).ready(function () {


    $('#calendar').fullCalendar({
        eventLimit: true, // allow "more" link when too many events
        locale: "ru",
        editable: false,
        selectable: true,

        events: {
            url: '/get-t-calendar',
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


                if (moment().format('YYYY-MM-DD') === date.format('YYYY-MM-DD') || date.isAfter(moment())) {

                    //add new
                    $('#lessons-date').text(clickData);
                    $('#lessons-date-offset').val(moment().format("Z"));
                    $('#addTime').modal();

                }else {

                    $('#error-message').text('This is past day, please choose available days');
                    $('#messageModal').modal();

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
