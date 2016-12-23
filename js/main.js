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
    * Menu show after scroll
    */
    $(window).scroll(function(){                          
        if ($(this).scrollTop() > 200) {
            $('#menu').fadeIn(500);
        } else {
            $('#menu').fadeOut(500);
        }
    });
});