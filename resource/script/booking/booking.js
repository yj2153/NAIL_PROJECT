$(function() {
    //ボタン押下チェック
    $(".bookingCheck").click(function(){
        $('form').attr('action', "index.php?page=bookingCheck");
        submit();
    });
});