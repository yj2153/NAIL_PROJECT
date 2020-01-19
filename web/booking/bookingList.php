<?php 

//ログインではない場合。
if(empty($userInfo)){
    header('Location: index.php?page=login');
    exit();
}

//リストを取得する
$nails = $db->prepare('SELECT n.title, n.title_ko, b.reservation
                        FROM bookings b, nails n
                        WHERE b.member_id=?
                         AND b.nail_id = n.id 
                        ORDER BY reservation');
$nails->execute(array($userInfo->getId()));

?>

<div id="content">
    <table id="listTbl">
        <?php while($nail = $nails->fetch()) : ?>
            <tr class="line">
                <td>
                    <?php if(!strcmp($lang, 'ja')){
                            echo h($nail['title']);
                        }else{
                            echo h($nail['title_ko']);
                        } ?>
                </td>
                <td>
                <td>
                    <?php echo h($nail['reservation']); ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>