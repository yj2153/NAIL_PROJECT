$(function() {
    var jbMedia = window.matchMedia( '( max-width: 700px )' );

    if(jbMedia.matches){
        $("#menu > li").click(function(){
            if($(this).children('ul').css('display') === 'none'){
                $(this).children('ul').slideDown();
                $(this).children('ul').show();
            }else{
                $(this).children('ul').hide();
            }
        });
    }
});