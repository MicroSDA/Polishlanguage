function add(){

    $.ajax({
        type: 'POST',
        url:  '/ajax/add/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                message: 'Hello'
            },
        success: function (html){

            $('#hello').empty();
            $('#hello').append(html);
        }

    });

};