function ajaxCall(url, data = {}, type) {
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });
    $.ajax({
        url: url,           
        type: type,         
        data: data,         
        dataType: 'json',   
        beforeSend: function() {
            $('.wrapper').addClass('blur-view');
            $('#spinner').show();
        },
        success: function(response) {
            if(response.status === 'success'){
                $('#success-alert-modal .message').text(response.message);
                $('#success-alert-modal').modal('show');
            }else{
                $('#danger-alert-modal .message').text(response.message);
                $('#danger-alert-modal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.status);
            if (xhr.status === 422) {
                let errors = JSON.parse(xhr.responseText).errors; 
                let errorMessage = "";
                $.each(errors, function(key, value) {
                    errorMessage += value + "\n"; 
                });
                $('#danger-alert-modal .message').text(errorMessage);
            } else if (xhr.status === 500) {
                $('#danger-alert-modal .message').text('Internal Server Error (500): Something went wrong on the server.');
            } else if (xhr.status === 400) {
                let errors = JSON.parse(xhr.responseText);
                $('#danger-alert-modal .message').text(errors.message);
            } else {
                $('#danger-alert-modal .message').text('Error (' + xhr.status + '): ' + xhr.statusText);
            }
            $('#danger-alert-modal').modal('show');
        },
        complete: function() {
            $('.wrapper').removeClass('blur-view');
            $('#spinner').hide();
        }
    });
}


function ajaxWithReload(url, data = {}, type) {
    $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });
    $.ajax({
        url: url,           
        type: type,         
        data: data,         
        dataType: 'json',   
        beforeSend: function() {
            $('.wrapper').addClass('blur-view');
            $('#spinner').show();
        },
        success: function(response) {
            if(response.status === 'success'){
                $('#success-alert-modal .message').text(response.message);
                $('#success-alert-modal').modal('show');
            }else{
                $('#danger-alert-modal .message').text(response.message);
                $('#danger-alert-modal').modal('show');
            }
            window.location.reload();
        },
        error: function(xhr, status, error) {
            console.log(xhr, status, error);
            if (xhr.status === 422) {
                // Validation error
                let errors = JSON.parse(xhr.responseText).errors; 
                let errorMessage = "";
                $.each(errors, function(key, value) {
                    errorMessage += value + "\n"; 
                });
                $('#danger-alert-modal .message').text(errorMessage);
            } else if (xhr.status === 500) {
                $('#danger-alert-modal .message').text('Internal Server Error (500): Something went wrong on the server.');
            } else if (xhr.status === 400) {
                $('#danger-alert-modal .message').text('Bad Request (400): Your request could not be processed.');
            } else {
                $('#danger-alert-modal .message').text('Error (' + xhr.status + '): ' + xhr.statusText);
            }
            $('#danger-alert-modal').modal('show');
        },
        complete: function() {
            $('.wrapper').removeClass('blur-view');
            $('#spinner').hide();
            $('#danger-alert-modal').modal('show');
        }
    });
}

