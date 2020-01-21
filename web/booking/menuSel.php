<?php 
//ログインではない場合。
if(empty($userInfo)){
    header('Location: index.php?page=login');
    exit();
}

echo "<script>var errorMsg = '".$settings->booking['booking_sel_error']."';</script>";

//リストを取得する
$nails = $db->prepare('SELECT *
                        FROM (SELECT n.type, n.title, n.title_ko, FORMAT(price/10, 0) AS price, FORMAT(price, 0) AS price_ko, n.id, COUNT(*)
                                FROM nails n
                            GROUP BY  n.type,n.title WITH ROLLUP) n
                        ORDER BY n.type, n.title IS NULL DESC, n.title');
$nails->execute();

?>
<form id="bookingSel" action="index.php?page=booking" method="post">
    <div id="content">
        <div id="title">
            <h1><?php echo $settings->booking['booking_menu']; ?></h1>
        </div>
        <table id="listTbl">
            <?php while($nail = $nails->fetch()) : ?>
                <?php if(!empty($nail['type']) && empty($nail['title'])) : ?>
                    <tr class="lineTitle">    
                        <td colspan="2" style="font-weight:bold;">
                            <?php switch($nail['type']){
                                case "1":
                                    echo h($settings->booking['booking_type_hand']); 
                                break;
                                case "2":
                                    echo h($settings->booking['booking_type_foot']); 
                                break;
                                case "3":
                                    echo h($settings->booking['booking_type_off']); 
                                break;
                                default:
                                break;
                            }
                            ?>
                        </td>
                    </tr>
                <?php elseif(!empty($nail['type'])) : ?>
                    <tr class="line">    
                        <td>
                        <input type="checkbox" name="nailMenu[]" class="nailMenu" id="menu<?php echo $nail['id']; ?>" value="<?php echo $nail['id']; ?>"/>
                            <?php if(!strcmp($lang, 'ja')){
                                    echo "<label for='menu".$nail['id']."'>".h($nail['title'])."</label>";
                                }else{
                                    echo "<label for='menu".$nail['id']."'>".h($nail['title_ko'])."</label>";
                                } ?>
                        </td>
                        <td>
                        <?php if(!strcmp($lang, 'ja')){
                                    echo h($nail['price']).$settings->booking['booking_type_unit'];
                                }else{
                                    echo h($nail['price_ko']).$settings->booking['booking_type_unit'];
                                } ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
        </table>
        <div id="nextBtnDiv"><input type="button" id="nextBtn" value="<?php echo $settings->booking['booking_sel_next']; ?>"/></div>
    </div>
</form>