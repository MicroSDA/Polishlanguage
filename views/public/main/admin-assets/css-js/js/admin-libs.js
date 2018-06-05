function editUrlValidate(form_id) {

    var this_data = $('#' + form_id).serializeArray();

    //alert(this_data);

    $.ajax({
        type: 'POST',
        url: '/ajax-admin/edit-url-validate/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

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

function editUrl() {

    var this_data = $('#edit-url-form').serializeArray();

    $.ajax({
        type: 'POST',
        url: '/ajax-admin/edit-url/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            $('#edit-url-message').empty();
            $('#edit-url-message').append(html);

        }

    });

};

function deleteUrlValidate(form_id) {

    var this_data = $('#' + form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/delete-url-validate/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            var obj = JSON.parse(html);

            $('#delete-url-message').empty();
            $('#delete-url-pattern').empty();
            $('#delete-url-pattern').append(obj['pattern']);

            $('#delete-url-modal').modal();
        }

    });

};

function deleteUrl() {

    var this_data = $('#delete-url-pattern').text();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/delete-url/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            $('#delete-url-message').empty();
            $('#delete-url-message').append(html);
        }

    });

};


function addNewUrl() {

    var this_data = $('#add-new-url-form').serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/add-url/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

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
        url: '/ajax-admin/add-article/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data,
                body: body
            },
        success: function (html) {

            $('#add-article-error-message').empty();
            $('#add-article-error-message').append(html);
        }

    });

}


function editArticleValidate(form_id) {

    var this_data = $('#' + form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/edit-article-validate/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

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
        url: '/ajax-admin/edit-article/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data,
                body: body
            },
        success: function (html) {

            $('#edit-article-message').empty();
            $('#edit-article-message').append(html);

        }

    });
}

function deleteArticleValidate(form_id) {

    var this_data = $('#' + form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/delete-article-validate/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            var obj = JSON.parse(html);

            $('#delete-article-message').empty();
            $('#delete-article-url').empty();
            $('#delete-article-url').append(obj['url']);

            $('#delete-article-modal').modal();
        }

    });

};

function deleteArticle() {

    var this_data = $('#delete-article-url').text();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/delete-article/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            $('#delete-article-message').empty();
            $('#delete-article-message').append(html);
        }

    });

};

function addNewEmployee() {

    var this_data = $('#add-new-employee-form').serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/add-employee/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            $('#add-new-employee-message').empty();
            $('#add-new-employee-message').append(html);
        }

    });
}

function addNewBlock() {

    var this_data = $('#add-new-block-form').serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/add-block/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            $('#add-new-block-message').empty();
            $('#add-new-block-message').append(html);
        }

    });
}

function deleteBlockValidate(form_id) {


    var this_data = $('#' + form_id).serializeArray();


    $.ajax({
        type: 'POST',
        url: '/ajax-admin/delete-block-validate/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

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
        url: '/ajax-admin/delete-block/',
        headers: {"Ajax": "Ajax"},
        data:
            {
                data: this_data
            },
        success: function (html) {

            $('#delete-block-message').empty();
            $('#delete-block-message').append(html);
        }

    });
}


function uploadLesson() {

    $('#add-new-lesson-form').submit(function (e) {
        e.preventDefault();
    });

    var name = $('#lesson-name').val();
    var course = $('#lesson-course').val();
    var description = $('#lesson-description').val();
    var image_data = $('#upload-image').prop('files')[0];
    var pdf_data = $('#upload-pdf').prop('files')[0];
    var audio_data = $('#upload-audio').prop('files')[0];
    var form_data = new FormData();
    form_data.append('image', image_data);
    form_data.append('pdf', pdf_data);
    form_data.append('audio', audio_data);
    form_data.append('name', name);
    form_data.append('description', description);
    form_data.append('course', course);
    $.ajax({
        url: '/ajax-admin/upload-lesson-material',
        headers: {"Ajax": "Ajax"},
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (html) {

            $('#add-new-lesson-message').empty();
            $('#add-new-lesson-message').append(html);

        }
    });

}

function fillNewsStudent(form_id, type) {


    if (type === 'get') {
        var data = $('#' + form_id).serializeArray();
        $('#activate-student-message').empty();
        $('#activateStudentForm [name=first-name]').val(data[0]['value']);
        $('#activateStudentForm [name=email]').val(data[1]['value']);
        $('#activateStudentForm [name=phone]').val(data[2]['value']);
        $('#activate-students-modal').modal();

    } else if (type === 'save') {

        $('#activateStudentForm').submit(function (e) {
            e.preventDefault();
        });
        var this_data = $('#activateStudentForm').serializeArray();
        console.log(this_data);
        $.ajax({
            url: '/ajax-admin/activate-student',
            headers: {"Ajax": "Ajax"},
            data: this_data,
            type: 'POST',
            success: function (html) {

                $('#activate-student-message').empty();
                $('#activate-student-message').append(html);
            }
        });

    } else if (type === 'delete-ask') {

        var data = $('#' + form_id).serializeArray();
        $('#deleteStudentForm [name=email]').val(data[1]['value']);
        $('#delete-students-modal').modal();

    } else if (type === 'delete') {

        var delete_data = $('#deleteStudentForm').serializeArray();

        $.ajax({
            url: '/ajax-admin/delete-student',
            headers: {"Ajax": "Ajax"},
            data: delete_data,
            type: 'POST',
            success: function (html) {

                $('#delete-student-message').empty();
                $('#delete-student-message').append(html);

            }, error: function () {

                $('#delete-student-message').empty();
                $('#delete-student-message').append('<div style="text-align: center"><span class="btn btn-warning"><h5>Error during connection to server</h5></span></div>');
            }
        });

    }

}

function editStudent(form_id, type) {

    if (type === 'get') {

        var data = $('#form-edit-' + form_id).serializeArray();

        console.log(data);
        $('#edit-student-message').empty();

        $('#editStudentForm [name=first-name]').val(data[0]['value']);
        $('#editStudentForm [name=surname]').val(data[1]['value']);
        $('#editStudentForm [name=email]').val(data[2]['value']);
        $('#editStudentForm [name=phone]').val(data[3]['value'])
        $('#editStudentForm [name=skype]').val(data[4]['value']);
        $('#editStudentForm [name=additionalInfo]').val(data[5]['value']);
        $('#editStudentForm [name=level]').val(data[6]['value']);
        $('#editStudentForm [name=gender][value=' + data[7]['value'] + ']').prop('checked', true);
        $('#editStudentForm [name=age]').val(data[8]['value']);
        $('#editStudentForm [name=activeCourse]').val(data[9]['value']);

        $('#courses-for-clone').html('');
        var d = $('#courses-block-'+form_id).html();
        $('#courses-for-clone').append(d);
        $('#courses-for-clone').css('display', 'block');
        $('#edit-students-modal').modal();


        $('#change-student-message').empty();
    } else if (type === 'save') {

        $('#editStudentForm').submit(function (e) {
            e.preventDefault();
        });
        var data = $('#editStudentForm').serializeArray();

        console.log(data);
        $.ajax({
            url: '/ajax-admin/edit-student',
            headers: {"Ajax": "Ajax"},
            data: {'Data': data},
            type: 'POST',
            success: function (html) {

                $('#change-student-message').empty();
                $('#change-student-message').append(html);

            }, error: function () {

                $('#change-student-message').empty();
                $('#change-student-message').append('<div style="text-align: center"><span class="btn btn-warning"><h5>Error during connection to server</h5></span></div>');
            }
        });

    }else if (type === 'delete-ask') {

        var data = $('#form-edit-' + form_id).serializeArray();
        $('#deleteStudentForm [name=email]').val(data[2]['value']);
        $('#delete-students-modal').modal();

    }
}

$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });

});