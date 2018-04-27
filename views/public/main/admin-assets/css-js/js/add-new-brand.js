function addNewBrand(){


    var this_brand_name = $('#brand_name').val();
    var this_brand_url = $('#brand_url').val();
    var this_brand_description = $('#brand_description').val();


    $.ajax({
        type: 'POST',
        url:  '/ajax-admin/add-new-brand',
        headers: { "Ajax": "Ajax" },
        data:
            {
                brand_name: this_brand_name,
                brand_url: this_brand_url,
                brand_description: this_brand_description
            },
        success: function (html){

            if(html == 'Added'){



                $('#brand_add_message').empty();
                $('#brand_add_message').append('<span class="btn btn-success">Was added</span>');

                document.getElementById("brand_name").value = "";
                document.getElementById("brand_url").value = "";
                document.getElementById("brand_description").value ="";

            }else{
                //$('#brand_name').empty();
                $('#brand_add_message').empty();
                $('#brand_add_message').append(html);
            }


        }

    });

}
