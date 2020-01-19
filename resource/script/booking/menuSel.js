$(function() {
    //ボタン押下チェック
    var checked = false;
    $("#nextBtn").click(function(){
        $(".nailMenu").each(function(index){
            if($(this). is(":checked")){
                checked = true;
            }
        });

        //選択がない場合エラー
        if(!checked){
            alert(errorMsg);
        }else{
            $("#bookingSel").submit();
        }
    });
});