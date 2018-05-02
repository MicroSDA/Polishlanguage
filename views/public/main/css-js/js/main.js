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