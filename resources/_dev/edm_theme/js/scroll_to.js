import $ from 'jquery';

$(document).ready(function() {
    
    $('.js-totop').on('click', function(e) {
        e.preventDefault();
        // $(this).tooltip('hide');
        scrollToTarget('body', 0);
    });
    
    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y > 300) {
            $('.totop').css('opacity', 1);
        } else {
            $('.totop').removeAttr('style');
        }
        
    });
    
    function scrollToTarget(target, offset) {
        $('html').animate({
                scrollTop: $(target).offset().top - offset
            }, 800);
        // return;
    }
        
});