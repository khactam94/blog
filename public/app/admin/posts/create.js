$(document).ready(function() {
    $('#categorytoken').tokenfield({
        autocomplete: {
            source: function (request, response) {
                jQuery.get(categoryAjaxUrl, {
                    query: request.term
                }, function (data) {
                    data = $.parseJSON(data);
                    response(data);
                });
            },
            delay: 100
        },
        showAutocompleteOnFocus: true
    });

    $('#tagtoken').tokenfield({
        autocomplete: {
            source: function (request, response) {
                jQuery.get(tagAjaxUrl, {
                    query: request.term
                }, function (data) {
                    data = $.parseJSON(data);
                    response(data);
                });
            },
            delay: 100
        },
        showAutocompleteOnFocus: true
    });
    $('#add-tag-btn').click(function (e) {
        $('.modal').modal('toggle');
        e.preventDefault();
        $.ajax({
            url: addTagUrl,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: 'name=' + $('#add-tag-modal input[name="name"]').val(),
            success: function (data) {
            if(data['success']){
                toastr.success('Add tag '+ data['data']['name'] + ' success!', data['message']);
            }else{
                toastr.error('Add tag '+ $('#add-tag-modal input[name="name"]').val() + ' Failed!', 'Fail');
            }
        },
        error: function (data) {
            if(data['message']){
                toastr.error(data['message'], 'Error');
            }
            else{
                toastr.error('You are offline now!', 'Connection Failed');
            }
        }
    });
    })
});