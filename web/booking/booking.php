<?php

//ログインではない場合。
if(empty($userInfo)){
    header('Location: index.php?page=login');
    exit();
}

//選択メニュー
$selMenus=null;
if(isset($_POST['nailMenu'])){
    $selMenus = $_POST['nailMenu'];
}else{
    header('Location: index.php?page=bookingSel');
    exit();
}

//今週
$startDay = 0;
if(isset($_POST['startWeek'])){
    $startDay = $_POST['startWeek'];
    if($startDay < 0 ){
        $startDay = 0;
    }else if($startDay > 4){
        $startDay = 4;
    }
}

//基準日
$today = date("m/d");
$nowTime = date("H:i");

$bookings=$db->prepare("SELECT date_format(b.reservation, '%m/%d') AS bDate, date_format(b.reservation, '%H:%i') AS bTime
                        FROM bookings b
                       WHERE b.status <> '取消'
                         AND DATE(NOW()) < DATE(b.reservation)
                        ORDER BY b.reservation");
$bookings->execute();
$bookingList = array();
$listCnt = 0;
while($booking = $bookings->fetch()){
    $bookingList[$listCnt++] = $booking;
}


?>
<form action="" method="post" >
<?php foreach($selMenus as $selMenu) : ?>
    <!-- 選択メニュー保持 -->
    <input type="hidden" name="nailMenu[]" value="<?php echo $selMenu; ?>" />
<?php endforeach; ?>
    
    <div id="title">
        <h1><?php echo $settings->booking['booking_menu']; ?></h1>
    </div>

    <div id="weekBtnDiv">
    <div><button type="submit" name="startWeek" value="<?php echo $startDay-1; ?>"><?php echo $settings->booking['booking_prev'];?></button></div>
    <div><button type="submit" name="startWeek" value="0"><?php echo $settings->booking['booking_now'];?></button></div>
    <div><button type="submit" name="startWeek" value="<?php echo $startDay+1; ?>"><?php echo $settings->booking['booking_next'];?></button></div>
    </div>
    <table id="dateTbl">
        <tr>
            <td>
            <!-- time -->
            </td>
            <?php 
                $week = array();
                for($row=0; $row<7; $row++) {
                    $week[$row] = date("m/d", strtotime("+".($row+($startDay*7))." day"));
                    echo "<td>";
                    echo $week[$row];
                    echo "</td>";
                }
            ?>
        </tr>
        <?php 
            for($trRow=0; $trRow<13; $trRow++) {
                echo "<tr>";
                $time[$trRow] = date("H:i", strtotime("10:00 +".($trRow+($startDay*7))." hours"));
                echo "<td>";
                echo $time[$trRow]; 
                echo "</td>";
                for($tdRow=0; $tdRow<7; $tdRow++) {
                    echo "<td>";
                    //基準日　AND　前時間帯の場合。
                    if(($week[$tdRow] === $today) && ($time[$trRow] < $nowTime)){
                        echo "✖";
                    }else{
                        foreach($bookingList as $booking){
                            if(!strcmp($week[$tdRow], $booking['bDate']) && !strcmp($time[$trRow], $booking['bTime'])){
                                echo "✖";
                                goto nextDateCheck;
                            }
                        }

                        if(strcmp(date("w", strtotime("+".$tdRow." day")), "0")){
                            echo '<button class="bookingCheck">〇';
                            echo '<input type="hidden" class="selDate" value="'.$week[$tdRow].'"/>';
                            echo '<input type="hidden" class="selTime" value="'.$time[$trRow].'"/>';
                            echo '</button>';
                        }else{
                            //日曜日休み
                            echo "✖";
                        }
                        nextDateCheck:
                         continue;
                    }
                    
                    echo "</td>";
                }
                echo "</tr>";
            }
        ?>
    </table>
</form>