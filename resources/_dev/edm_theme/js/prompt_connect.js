import $ from 'jquery';

$(document).ready(function() {

    $('#js-connect').on('click', function(e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        checkConnect();
    });


    function checkConnect(){
        $.ajaxSetup({
            headers: {    
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    
            }    
        });
       
        $.ajax({
            url: '/user/profile/connect', //submit to SELF
            dataType: 'json',
            type: 'post',
            success: function(data){
                $('#js-connect').removeAttr('disabled');
                console.log(data);
                if (data.success){
                    $('#js-connect').remove();
                    $('#js-notification').text(data.success_msg);
                    setTimeout(function(){
                        window.location.href = data.redirect;
                        }, 7000
                    ); 
                } else {
                    UIkit.notification({message: data.error_msg, status: 'danger'});
                }

            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });           
        
    }
});

