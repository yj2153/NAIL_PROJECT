<?php 

//リストを取得する
if(isset($_REQUEST['pageNum'])){
    $pageNum = $_REQUEST['pageNum'];
}else{
    $pageNum = 1;
}
$pageNum = max($pageNum, 1);

//最終ページを取得する
$counts = $db->query('SELECT COUNT(*) AS cnt FROM gallery');
$cnt = $counts->fetch();
$maxPageNum = ceil($cnt['cnt'] / 20);
$pageNum = min($pageNum, $maxPageNum);

$start = ($pageNum - 1) * 20;
$start = max(0, $start);

$imgList = $db->prepare('SELECT g.* FROM gallery g ORDER BY g.id DESC LIMIT ?,20');
$imgList->bindParam(1, $start, PDO::PARAM_INT);
$imgList->execute();
$img = $imgList->fetchAll();

?>

<div id="content">
    <div id="title">
        <h1><?php echo $settings->gallery['gallery_list_title']; ?></h1>
    </div>
    <div id="rigistBtnDiv">
        <button onclick="location.href='index.php?page=galleryRegist'"><?php echo $settings->gallery['gallery_submit']; ?></button>
    </div>
    <div id="listTblDiv">
        <table id="listTbl">
            <?php for($trCnt=0; $trCnt<count($img); $trCnt+=4) : ?>
                <tr class="line">
                    <?php for($tdCnt=$trCnt; $tdCnt<($trCnt+4); $tdCnt++) : ?>
                        <?php if($tdCnt >= (count($img))){ 
                            echo "<td></td>";
                            continue;
                         } ?>
                    <td onclick="location.href='index.php?page=galleryView&listNum=<?php echo h($img[$tdCnt]['id']); ?>'">
                        <table id="lineTbl">
                            <tr>
                                <td class="lineTitle">
                                    <span><?php echo "No.".$tdCnt."  ".h($img[$tdCnt]['title']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="lineImg">
                                    <img src="./resource/image/<?php echo h($img[$tdCnt]['picture']); ?>" width="150" height="150" alt=""/>
                                </td>
                            </tr>
                            <tr>
                                <td class="lineDate">
                                    <?php echo h($img[$tdCnt]['created']); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <?php endfor; ?>
                </tr>
                <?php endfor; ?>
        </table>
    </div>
    <ul class="paging">
        <?php if($pageNum > 1){ ?>
            <li>
                <a href="index.php?page=gallery&pageNum=<?php print($pageNum - 1); ?>"><?php echo $settings->gallery['gallery_prev']; ?></a>
            </li>
        <?php } else { ?>
        <li><?php echo $settings->gallery['gallery_prev']; ?></li>
        <?php } ?>
        <?php if($pageNum < $maxPageNum){ ?>
        <li>
            <a href="index.php?page=gallery&pageNum=<?php print($pageNum + 1); ?>"><?php echo $settings->gallery['gallery_next']; ?></a>
        </li>
        <?php } else { ?>
            <li><?php echo $settings->gallery['gallery_next']; ?></li>
        <?php } ?>
    </ul>
</div>