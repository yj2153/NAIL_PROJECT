<?php 
  require_once('../../class/autoLoad.php');
  require_once('../../class/dbconnect.php');
  session_start();

//予約登録
if(isset($_POST)){
    $selDate = $_POST['selDate'];
    $selTime = $_POST['selTime'];
    $selMenus = $_POST['nailMenu'];
    $userInfo = $_SESSION['userInfo'];
    //登録処理をする
    foreach($selMenus as $selMenu) {
        $statement = $db->prepare('INSERT INTO bookings 
                                    SET member_id=?
                                        , nail_id=? 
                                        , created=NOW()
                                        , reservation=?
                                        ,status="処理中"');
            $ret = $statement->execute(array(
                $userInfo->getId(),
                $selMenu,
                date("Y")."/".$selDate." ".$selTime.":00")
            );
    }

    header("Location: ../../index.php?page=bookingOK");
    exit;
}
?>

