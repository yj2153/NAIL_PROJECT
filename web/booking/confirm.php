<?php

//ログインではない場合。
if(empty($userInfo)){
    header('Location: index.php?page=login');
    exit();
}
//選択メニュー
$selMenus=null;
$selDate = null;
$selTime = null;
if(isset($_POST)){
    $selDate = $_POST['selDate'];
    $selTime = $_POST['selTime'];
    $selMenus = $_POST['nailMenu'];
    $nails = $db->prepare("SELECT n.type, n.title, n.title_ko, FORMAT(SUM(price)/10, 0) AS price, FORMAT(SUM(price), 0) AS price_ko, SEC_TO_TIME(sum(TIME_TO_SEC( useTime ))) AS useTime
                            FROM nails n
                           WHERE n.id IN (".implode(',',$selMenus).")
                        GROUP BY  n.type WITH ROLLUP");
    $nails->execute();
}else{
    header('Location: index.php?page=bookingSel');
    exit();
}

?>
<form action="./web/booking/insert.php" method="post">
<!-- 選択メニュー保持 -->
<?php foreach($selMenus as $selMenu) : ?>
    <input type="hidden" name="nailMenu[]" value="<?php echo $selMenu; ?>" />
<?php endforeach; ?>
<input type="hidden" name="selDate" value="<?php echo $selDate; ?>" />
<input type="hidden" name="selTime" value="<?php echo $selTime; ?>" />

<div id="title">
    <h1><?php echo $settings->booking['booking_check_title']; ?></h1>
</div>
<div id="checkTblDiv">
    <table id="checkTbl">
        <tr>
            <td colspan="2">
                <h3><?php echo h($settings->booking['booking_sel_date']); ?></h3>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <?php echo h($selDate)." ".h($selTime); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h3><?php echo h($settings->booking['booking_sel_menu']); ?></h3>
            </td>
        </tr>
        <?php while($nail = $nails->fetch()) : ?>
            <?php if(!empty($nail['type'])) : ?>
            <tr>
                <td></td>
                <td>
                    <?php if(!strcmp($lang, 'ja')){
                            echo h($nail['title']);
                        }else{
                            echo h($nail['title_ko']);
                        } ?>
                </td>
            </tr>
            <?php else : ?>
            <tr>
                <td colspan="2">
                    <h3><?php echo h($settings->booking['booking_sel_price']); ?></h3>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php if(!strcmp($lang, 'ja')){
                            echo h($nail['price']).$settings->booking['booking_type_unit'];
                        }else{
                            echo h($nail['price_ko']).$settings->booking['booking_type_unit'];
                        } ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h3><?php echo h($settings->booking['booking_sel_time']); ?></h3>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo h($nail['useTime']); ?>
                </td>
            </tr>
            <?php endif; ?>
        <?php endwhile; ?>
    </table>
</div>
<div id="btnDiv"><input type="submit" value="<?php echo $settings->booking['booking_insert']; ?>"/></div>
</form>