<?php 
 
//投稿を記録する
if(!empty($_POST)){
    if(isset($_POST['message']) && !empty($_POST['message'])){
        $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_posts_id=?, created=NOW()');
        $message->execute(array(
            $userInfo->getId(),
            $_POST['message'],
            $_POST['reply_post_id']
        ));

        header('Location: index.php?page=review');
        exit();
    }
}

//投稿を取得する
if(isset($_REQUEST['pageNum'])){
    $pageNum = $_REQUEST['pageNum'];
}else{
    $pageNum = 1;
}
$pageNum = max($pageNum, 1);

//最終ページを取得する
$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxPageNum = ceil($cnt['cnt'] / 5);
$pageNum = min($pageNum, $maxPageNum);

$start = ($pageNum - 1) * 5;
$start = max(0, $start);

$posts = $db->prepare('SELECT m.name, p.* FROM members m, posts p WHERE m.id = p.member_id ORDER BY p.created DESC LIMIT ?,5');
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();

//返信の場合
if(isset($_REQUEST['res'])){
    $response = $db->prepare('SELECT m.name, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
    $response->execute(array($_REQUEST['res']));

    $table = $response->fetch();
    $message = '@'.$table['name'].' '.$table['message'];
}

?>

<div id="content">
    <?php if(!empty($userInfo)) : ?>
    <form action="" method="post">
        <dl>
            <dt><?php echo h($userInfo->getName()); ?><?php echo $settings->review['review_info']; ?></dt>
            <dd>
                <textarea name="message" cols="50" rows="5"><?php echo empty($message) ? '' : h($message); ?></textarea>
                <input type="hidden" name="reply_post_id" value="<?php echo isset($_REQUEST['res']) ? h($_REQUEST['res']) : ''; ?>"/>
            </dd>
        </dl>
        <div>
            <input type="submit" value="<?php echo $settings->review['review_submit']; ?>"/>
        </div>
    </form>
    <?php else : ?>
        <div>
            <?php echo h($settings->review['review_comment']) ?>
        </div>
    <?php endif; ?>

    <?php while($post = $posts->fetch()) : ?>
    <div class="msg">
        <p>
            <?php echo makeLink(h($post['message'])); ?>
            <span class="name">(<?php echo h($post['name']); ?>)</span>
            <?php if(!empty($userInfo)) : ?>
                [<a href="index.php?page=review&res=<?php echo h($post['id']); ?>">re</a>]
            <?php endif; ?>
        </p>
        <p class="day">
            <?php echo h($post['created']); ?>
            <?php if(!empty($userInfo) && $userInfo->getId() == $post['member_id']) : ?>
                [<a href="./review/delete.php?id=<?php echo h($post['id']); ?>" style="color:#F33;"><?php echo $settings->review['review_delete']; ?></a>]
            <?php endif; ?>
        </p>
    </div>
    <?php endwhile; ?>

    <ul class="paging">
        <?php if($pageNum > 1){ ?>
            <li>
                <a href="index.php?page=review&pageNum=<?php print($pageNum - 1); ?>"><?php echo $settings->review['review_prev']; ?></a>
            </li>
        <?php } else { ?>
        <li><?php echo $settings->review['review_prev']; ?></li>
        <?php } ?>
        <?php if($pageNum < $maxPageNum){ ?>
        <li>
            <a href="index.php?page=review&pageNum=<?php print($pageNum + 1); ?>"><?php echo $settings->review['review_next']; ?></a>
        </li>
        <?php } else { ?>
            <li><?php echo $settings->review['review_next']; ?></li>
        <?php } ?>
    </ul>
</div>