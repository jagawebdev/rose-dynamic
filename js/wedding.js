/*global $*/
$(document).ready(function() {
   /**
    * making odd div change color
    */
    $( '#odd-div section:visible' ).each( function( i ){
        $( this )[ (1&i) ? 'addClass' : 'removeClass' ]( 'colored-div' );
    });
});