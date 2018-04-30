
function editUrlValidate(form_id){

    var this_data = $('#'+form_id).serializeArray();

    //alert(this_data);

    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/edit-url-validate/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            var obj = JSON.parse(html);

            $('#edit-url-message').empty();
            $('#edit-url-name').val(obj['name']);
            $('#edit-url-pattern').val(obj['pattern']);
            $('#edit-url-pattern-old').val(obj['pattern']);
            $('#edit-url-model').val(obj['model']);
            $('#edit-url-method').val(obj['method']);
            $('#edit-url-view').val(obj['view']);
            $('#edit-url-type').val(obj['type']);
            $('#edit-url-cache').val(obj['cache']);
            $('#edit-url-status').val(obj['status']);


            $('#edit-url-modal').modal();
        }

    });

};

function editUrl(){

    var this_data = $('#edit-url-form').serializeArray();

    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/edit-url/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#edit-url-message').empty();
            $('#edit-url-message').append(html);

        }

    });

};

function deleteUrlValidate(form_id){

    var this_data = $('#'+form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/delete-url-validate/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            var obj = JSON.parse(html);

            $('#delete-url-message').empty();
            $('#delete-url-pattern').empty();
            $('#delete-url-pattern').append(obj['pattern']);

            $('#delete-url-modal').modal();
        }

    });

};

function deleteUrl(){

    var this_data = $('#delete-url-pattern').text();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/delete-url/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#delete-url-message').empty();
            $('#delete-url-message').append(html);
        }

    });

};


function addNewUrl() {

    var this_data = $('#add-new-url-form').serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/add-url/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#add-new-url-message').empty();
            $('#add-new-url-message').append(html);
        }

    });

    //$('#add-new-url-modal').modal();

}

function addArticle() {

    var this_data = $('#add-article').serializeArray();
    var body = CKEDITOR.instances.article_body.getData();
    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/add-article/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data,
                body : body
            },
        success: function (html){

            $('#add-article-error-message').empty();
            $('#add-article-error-message').append(html);
        }

    });

}


function editArticleValidate(form_id) {

    var this_data = $('#'+form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/edit-article-validate/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            var obj = JSON.parse(html);


            $('#edit-article-message').empty();
            $('#edit-article-title').val(obj['title']);
            $('#edit-article-url').val(obj['url']);
            $('#edit-article-url-old').val(obj['url']);
            $('#edit-article-writer').val(obj['writer']);
            CKEDITOR.instances.edit_article_body.setData(obj['body']);
            $('#edit-article-modal').modal();


        }

    });
}


function editArticle() {

    var this_data = $('#edit-article-form').serializeArray();
    var body = CKEDITOR.instances.edit_article_body.getData();

    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/edit-article/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data,
                body: body
            },
        success: function (html){

            $('#edit-article-message').empty();
            $('#edit-article-message').append(html);

        }

    });
}

function deleteArticleValidate(form_id){

    var this_data = $('#'+form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/delete-article-validate/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            var obj = JSON.parse(html);

            $('#delete-article-message').empty();
            $('#delete-article-url').empty();
            $('#delete-article-url').append(obj['url']);

            $('#delete-article-modal').modal();
        }

    });

};

function deleteArticle(){

    var this_data = $('#delete-article-url').text();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/delete-article/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#delete-article-message').empty();
            $('#delete-article-message').append(html);
        }

    });

};

function addNewEmployee() {

    var this_data = $('#add-new-employee-form').serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/add-employee/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#add-new-employee-message').empty();
            $('#add-new-employee-message').append(html);
        }

    });
}

function addNewBlock(){

    var this_data = $('#add-new-block-form').serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/add-block/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#add-new-block-message').empty();
            $('#add-new-block-message').append(html);
        }

    });
}

function deleteBlockValidate(form_id){


    var this_data = $('#'+form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/delete-block-validate/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            var obj = JSON.parse(html);

            $('#delete-block-message').empty();
            $('#delete-block-ip').empty();
            $('#delete-block-ip').append(obj['ip']);

            $('#delete-block-modal').modal();
        }

    });
}

function deleteBlock() {

    var this_data = $('#delete-block-ip').text();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/delete-block/',
        headers: { "Ajax": "Ajax" },
        data:
            {
                data: this_data
            },
        success: function (html){

            $('#delete-block-message').empty();
            $('#delete-block-message').append(html);
        }

    });
}


function uploadLesson() {
        var name =  $('#lesson-name').val();
        var level=  $('#lesson-level').val();
        var file_data = $('#upload-file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('name',name);
        form_data.append('level',level);
        $.ajax({
            url: '/ajax-admin/lesson-upload',
            headers: { "Ajax": "Ajax" },
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(html){

                $('#add-new-lesson-message').empty();
                $('#add-new-lesson-message').append(html);

            }
        });

}