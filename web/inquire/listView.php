<?php 

//投稿を記録する
if(!empty($_POST)){
    if(isset($_POST['message']) && !empty($_POST['message'])){
        $message = $db->prepare('INSERT INTO inquire SET member_id=?, message=?, reply_id=?, created=NOW()');
        $message->execute(array(
            $userInfo->getId(),
            $_POST['message'],
            $_POST['listNum']
        ));

        header('Location: index.php?page=inquireView&listNum='.$_POST['listNum']);
        exit();
    }
}


//問い合わせを取得
$inquireMsg = null;
if(isset($_REQUEST['listNum'])){
    $inquire = $db->prepare('SELECT i.* FROM inquire i WHERE i.id = ? ');
    $inquire->execute(array($_REQUEST['listNum']));
    $inquireMsg = $inquire->fetch();

    //コメント取得
    $comments = $db->prepare('SELECT m.name, i.* FROM inquire i, members m WHERE i.reply_id = ? AND m.id = i.member_id ORDER BY i.created');
    $comments->execute(array($_REQUEST['listNum'])); 
    $comments->execute();
}


?>

<div id="content">
    <form action="" method="post">
        <div id="buttonDiv">
            <?php if(!empty($userInfo) && strcmp($userInfo->getId(), $_REQUEST['listNum'])) : ?>
                    <a href="index.php?page=inquireMsg&listNum=<?php echo h($_REQUEST['listNum']); ?>"><?php echo h($settings->inquire['inquire_change']); ?></a>
            <?php endif; ?>
        </div>
        <table id="viewTbl">
            <tr>
                <td><?php echo h($settings->inquire['inquire_title']); ?></td>
                <td colspan="2"><?php echo h($inquireMsg['title']); ?></td>
            </tr>
            <tr>
                <td>
                    <?php echo h($settings->inquire['inquire_message']); ?>
                </td>
                <td colspan="2">
                    <?php echo h($inquireMsg['message']); ?>
                </td>
            </tr>
            <?php while($comment = $comments->fetch()) : ?>
                <tr>
                    <td colspan="2">
                        <?php echo h($comment['name']); ?>
                        </br>
                        <?php echo h($comment['message']); ?>
                        </td>
                    <td>
                        <?php if(!empty($userInfo) && !strcmp($userInfo->getId(), $comment['member_id'])) : ?>
                            <a href="./inquire/commontDelete.php?listNum=<?php echo h($_REQUEST['listNum']); ?>&reply_id=<?php echo h($comment['id']); ?>"><?php echo $settings->inquire['inquire_delete']; ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php if(!empty($userInfo)) : ?>
                <tr>
                    <td>
                    <?php echo h($userInfo->getName()); ?>
                    </td>
                    <td>
                        <textarea name="message" cols="50" rows="5"><?php echo empty($message) ? '' : h($message); ?></textarea>
                        <input type="hidden" name="listNum" value="<?php echo $_REQUEST['listNum'] ?>"/>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo $settings->inquire['inquire_submit']; ?>"/>
                    </td>
                <tr>
            <?php else : ?>
                <tr>
                    <td colspan="3">
                    <?php echo h($settings->inquire['inquire_comment']); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </form>
</div>