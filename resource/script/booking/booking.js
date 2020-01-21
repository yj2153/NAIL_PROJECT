$(function() {
    //ボタン押下チェック
    $(".bookingCheck").click(function(){
        $(this).children(".selDate").attr("name", "selDate");
        $(this).children(".selTime").attr("name", "selTime");
        $('form').attr('action', "index.php?page=bookingCheck");
        submit();
    });
});