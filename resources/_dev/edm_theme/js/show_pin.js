import $ from 'jquery';

$(document).ready(function() {

    var $aid = $('#js-aid');
    if ($($aid).length) {
        var aid = $($aid).text();

        //give user some time to react and look at the phone
        setTimeout(function(){
            console.log('starting transaction check after 3 seconds');
            startTxCheck(aid);
            }, 3000
        );            
    }

    function startTxCheck(aid){

        console.log('startTxCheck started with aid:', aid);
        var $spinner = $('.spinner');
        $.ajaxSetup({
            headers: {    
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')    
            }    
        });
        //check signin status every 5 seconds
        var timer = setInterval(doCheck, 5000);
        var attempt = 0;
        $spinner.show();
        $spinner.find('.spinner-text').text('Checking transaction status ...');
        
        // var i = 60;
        // var countdown = setInterval(function(){
        //     $spinner.find('.spinner-countdown').text(i);

        //     if (i < 40) {
        //         $spinner.find('.spinner-countdown').css("color", "gold");
        //     }

        //     if (i < 20) {
        //         $spinner.find('.spinner-countdown').css("color", "red");
        //     }

        //     if (i == 0) {
        //         clearInterval(countdown);
        //     }
        //     i--;
        // }, 1080);

        var progress = 0;

        function doCheck() {
            $.ajax({
                // url: '/pin', //submit to SELF
                dataType: 'json',
                type: 'post',
                data: {aid:aid},
                success: function(data){
                    if (data.status == 'AUTHORIZED'){
                        $spinner.find('.spinner-text').text('AUTHORIZED! You should be able to reach your profile now, autoredirect in 5 sec');
                        setTimeout(function(){
                            window.location.href = data.redirect;
                            }, 5000
                        );                        
                    }
                    if (data.error_msg){
                        console.log(data.error_msg);
                        // clearInterval(timer);
                        // $spinner.find('.spinner-text').text(data.error_msg);
                        // $spinner.find('#js-progressbar').remove();
                        // $spinner.find('.lds-roller').hide();

                        // setTimeout(function(){
                        //     window.location.href = window.location.origin;
                        //     }, 10000
                        // );
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

            //give user max 11 attempts or 60 seconds to signin
            // console.log( 'attempt', attempt );
            if (attempt > 11) {
                clearInterval(timer);  //stop checking and redirect to profile page
                UIkit.notification({message: 'We have not received a response from you.<br>Try again later', status: 'danger'});
                $spinner.hide();
                $spinner.find('.spinner-text').empty();
                $('.js-pin-wrapper').html('<div class="uk-alert uk-alert-warning">Unable to log you. Please, try again.<br>Redirecting to home page in 10 seconds...</div>');
                setTimeout(function(){
                    window.location.href = window.location.origin;
                    }, 10000
                );

            }
            progress = 100/12 * (attempt+1);
            $spinner.find('.spinner-text').text('Still waiting, attempt '+ (attempt+1));
            $spinner.find('#js-progressbar').attr('value', progress);
            attempt++;
        }
    }
});

