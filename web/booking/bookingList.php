<?php 

//ログインではない場合。
if(empty($userInfo)){
    header('Location: index.php?page=login');
    exit();
}

//リストを取得する
$nails = $db->prepare('SELECT *
                        FROM(
                            SELECT b.reservation,n.title, n.title_ko, b.status, COUNT(*)
                            FROM bookings b, nails n
                            WHERE b.member_id=?
                            AND b.nail_id = n.id 
                            GROUP BY b.reservation, n.title WITH ROLLUP
                        ) A
                        ORDER BY A.reservation, A.title IS NULL DESC, A.title');
$nails->execute(array($userInfo->getId()));

?>

<div id="title">
    <h1><?php echo $settings->booking['booking_list_title']; ?></h1>
</div>
<table id="listTbl">
    <?php while($nail = $nails->fetch()) : ?>
        <?php if(!empty($nail['reservation']) && empty($nail['title'])) : ?>
                <tr class="lineTitle">
                    <td colspan="2" style="font-weight:bold;">
                        ・<?php echo h($nail['reservation']); ?>
                    </td>
                </tr>
            <?php elseif(!empty($nail['reservation'])) : ?>
                <tr class="line">
                    <td>
                        <?php if(!strcmp($lang, 'ja')){
                                echo h($nail['title']);
                            }else{
                                echo h($nail['title_ko']);
                            } ?>
                    </td>
                    <td>
                        <?php switch($nail['status']){
                                case "1":
                                    echo h($settings->booking['booking_status_1']); 
                                break;
                                case "2":
                                    echo h($settings->booking['booking_status_2']); 
                                break;
                                default:
                                    echo h($settings->booking['booking_status_9']); 
                                break;
                            }
                        ?>
                    </td>
                </tr>
            <?php endif; ?>

    <?php endwhile; ?>

</table>