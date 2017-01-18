/*global $*/
$(document).ready(function() {
   /**
   * Drop Down Menu
   */
    $('.hamburger').click( function(event){
        event.stopPropagation();
        $('.drop-menu').toggle();
    });

    $(document).click( function(){
        $('.drop-menu').hide();
    });
    
    /**
    * Fancybox
    */
    $(".fancybox").fancybox();
});


/**
* Window scroll effects
*/
$(window).scroll(function(){   
    /**
    * Menu show after scroll
    */
    if ($(this).scrollTop() > 200) {
        $('#menu').fadeIn(400);
    } else {
        $('#menu').fadeOut(400);
    }
    
    /**
    * Scroll slow effect to #packages
    */
    $("#to-top").click(function() {
        $('html, body').animate({
            scrollTop: $("#packages").offset().top
        }, 2000);
    });
    
    /**
    * Scroll slow effect to #booking
    */
    $(".scroll-to").click(function() {
        $('html, body').animate({
            scrollTop: $("#booking").offset().top
        }, 2000);
    });
});