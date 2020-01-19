<?php
if(!isset($_SESSION['join'])){
    header('Location: index.php');
    exit();
}

if(!empty($_POST)){
    //登録処理をする
    $statement = $db->prepare('INSERT INTO members SET name=?, email=? , password=? , created=NOW()');
    $statement->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['email'],
        sha1($_SESSION['join']['password'])
    ));

    unset($_SESSION['join']);

    header('Location: index.php?page=signUpOk');
    exit();
}

?>

<p><?php echo $settings->check['check_info']; ?></p>
 <form action="" method="post" enctype="multipart/form-data">
 <input type="hidden" name="action" value="submit"/>
    <dl>
        <dt><?php echo $settings->check['check_input_name']; ?></dt>
        <dd>
            <?php echo h($_SESSION['join']['name']); ?>
        </dd>
        <dt><?php echo $settings->check['check_input_email']; ?></dt>
            <?php echo h($_SESSION['join']['email']); ?>
        <dd>
        </dd>
        <dt><?php echo $settings->check['check_input_password']; ?></dt>
        <dd>
        <?php echo $settings->check['check_input_password_value']; ?>
        </dd>
        <div>
            <a href="index.php?action=rewrite">&laquo;&nbsp;<?php echo $settings->check['check_rewrite']; ?></a> | 
            <input type="submit" value="<?php echo $settings->check['check_regist']; ?>"/>
        </div>
    </dl>
 </form> 
