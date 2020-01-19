<?php 

//リストを取得する
if(isset($_REQUEST['pageNum'])){
    $pageNum = $_REQUEST['pageNum'];
}else{
    $pageNum = 1;
}
$pageNum = max($pageNum, 1);

//最終ページを取得する
$counts = $db->query('SELECT COUNT(*) AS cnt FROM inquire');
$cnt = $counts->fetch();
$maxPageNum = ceil($cnt['cnt'] / 5);
$pageNum = min($pageNum, $maxPageNum);

$start = ($pageNum - 1) * 5;
$start = max(0, $start);

$inquireList = $db->prepare('SELECT i.* FROM inquire i WHERE reply_id=\'\' ORDER BY i.id DESC LIMIT ?,5');
$inquireList->bindParam(1, $start, PDO::PARAM_INT);
$inquireList->execute();

?>

<div id="content">
    <div>
        <a href="index.php?page=inquireMsg"><?php echo $settings->inquire['inquire_submit']; ?></a>
    </div>
    <table id="listTbl">
        <?php while($inquire = $inquireList->fetch()) : ?>
            <tr class="line" onclick="location.href='index.php?page=inquireView&listNum=<?php echo h($inquire['id']); ?>'">
                <td>
                    <table id="lineTbl" >
                        <tr>
                            <td class="lineNum">
                                <span><?php echo h($inquire['id']); ?></span>
                            </td>
                            <td class="lineTitle">
                                <?php echo h($inquire['title']); ?>
                            </td>
                            <td class="lineDate">
                                <?php echo h($inquire['created']); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <ul class="paging">
        <?php if($pageNum > 1){ ?>
            <li>
                <a href="index.php?page=inquire&pageNum=<?php print($pageNum - 1); ?>"><?php echo $settings->inquire['inquire_prev']; ?></a>
            </li>
        <?php } else { ?>
        <li><?php echo $settings->inquire['inquire_prev']; ?></li>
        <?php } ?>
        <?php if($pageNum < $maxPageNum){ ?>
        <li>
            <a href="index.php?page=inquire&pageNum=<?php print($pageNum + 1); ?>"><?php echo $settings->inquire['inquire_next']; ?></a>
        </li>
        <?php } else { ?>
            <li><?php echo $settings->inquire['inquire_next']; ?></li>
        <?php } ?>
    </ul>
</div>