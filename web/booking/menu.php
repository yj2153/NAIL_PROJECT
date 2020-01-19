<?php 

//リストを取得する
$nails = $db->prepare('SELECT *
                        FROM (SELECT n.type, n.title, n.title_ko, FORMAT(price/10, 0) AS price, FORMAT(price, 0) AS price_ko, COUNT(*)
                                FROM nails n
                            GROUP BY  n.type,n.title WITH ROLLUP) n
                        ORDER BY n.type, n.title IS NULL DESC, n.title');
$nails->execute();

?>

<div id="content">
    <table id="listTbl">
        <?php while($nail = $nails->fetch()) : ?>
            <tr class="line">
                <?php if(!empty($nail['type']) && empty($nail['title'])) : ?>
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
                <?php elseif(!empty($nail['type'])) : ?>
                    <td>
                        <?php if(!strcmp($lang, 'ja')){
                                echo h($nail['title']);
                            }else{
                                echo h($nail['title_ko']);
                            } ?>
                    </td>
                    <td>
                    <?php if(!strcmp($lang, 'ja')){
                                echo h($nail['price']).$settings->booking['booking_type_unit'];
                            }else{
                                echo h($nail['price_ko']).$settings->booking['booking_type_unit'];
                            } ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>
</div>