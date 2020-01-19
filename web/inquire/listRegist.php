<?php 
  //ログインしていない
if(empty($userInfo)){
    header('Location: index.php?page=login');  
    exit();
}

//問い合わせを記録する
if(!empty($_POST)){
    //新規
    if(isset($_POST['message']) && !empty($_POST['message']) && !isset($_REQUEST['listNum'])){
        $message = $db->prepare('INSERT INTO inquire SET member_id=?, title=?, message=?, created=NOW()');
        $message->execute(array(
            $userInfo->getId(),
            $_POST['title'],
            $_POST['message']
        ));

        header('Location: index.php?page=inquire');
        exit();
    }else if(isset($_POST['message']) && !empty($_POST['message']) && isset($_REQUEST['listNum'])){
        $message = $db->prepare('UPDATE inquire SET title=?, message=?, modifled=NOW() WHERE id=?');
        $mess = $message->execute(array(
            $_POST['title'],
            $_POST['message'],
            $_REQUEST['listNum']
        ));

        header('Location: index.php?page=inquire');
        exit();
    }

}

//問い合わせを取得
$inquireMsg = null;
if(isset($_REQUEST['listNum'])){
    $inquire = $db->prepare('SELECT i.* FROM inquire i WHERE i.id = ?');
    $inquire->execute(array($_REQUEST['listNum']));
    $inquireMsg = $inquire->fetch();
}


?>

<div id="content">
    <form action="" method="post">
        <dl>
            <dt><?php echo $settings->inquire['inquire_title']; ?></dt>
            <dd>
                <input type="text" name="title" value="<?php echo empty($inquireMsg) ? '' : h($inquireMsg['title']); ?>" />
            </dd>
            <dt><?php echo $settings->inquire['inquire_message']; ?></dt>
            <dd>
                <textarea name="message" cols="50" rows="5"><?php echo empty($inquireMsg) ? '' : h($inquireMsg['message']); ?></textarea>
            </dd>
        </dl>
        <div>
            <input type="submit" value="<?php echo $settings->inquire['inquire_submit']; ?>"/>
        </div>
    </form>
</div>