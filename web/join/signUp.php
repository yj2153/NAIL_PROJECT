<?php
//ログインしている場合、
if(!empty($userInfo)){
    header('Location: index.php');
    exit();
}

if(!empty($_POST)){
    //エラー項目の確認
    if($_POST['name'] == ''){
        $error['name'] = 'blank';
    }
    if($_POST['email'] == ''){
        $error['email'] = 'blank';
    }
    if(strlen($_POST['password']) < 4){
        $error['password'] = 'length';
    }
    if($_POST['password'] == ''){
        $error['password'] = 'blank';
    }

    if(empty($error)){
        //重複アカウントのチェック
        $member = $db->prepare(('SELECT COUNT(*) AS cnt FROM members WHERE email = ? '));
        $member->execute(array($_POST['email']));
        $record = $member->fetch();

        if($record['cnt'] > 0){
            $error['email'] = 'duplicate';
        }
    }

    if(empty($error)){
        $_SESSION['join'] = $_POST;
        header('Location: index.php?page=signUpCheck'); 
        exit();
    }
}

//書き直し
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite'){
    $_POST = $_SESSION['join'];
    $error['rewrite'] = true;
}
?>

 <p><?php echo $settings->join['join_info']; ?></p>
 <form action="" method="post">
    <table id="signTbl">
        <tr>
            <td><?php echo $settings->join['join_input_name']; ?><span class="required"><?php echo $settings->join['join_required']; ?></span></td>
            <td>
                <input type="text" name="name" size="35" maxlength="255" value="<?php echo isset($_POST['name']) ? h($_POST['name']) : ''; ?>" />
                <?php if(isset($error['name']) && $error['name'] == 'blank') : ?>
                    <p class="error"><?php echo $settings->joinError['join_error_name_blank']; ?></p>
                <?php endif; ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            </td>
        </tr>
        <tr>
            <td><?php echo $settings->join['join_input_email']; ?><span class="required"><?php echo $settings->join['join_required']; ?></span></td>
            <td>
                <input type="text" name="email" size="35" maxlength="255" value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>" />
                <?php if(isset($error['email']) && $error['email'] == 'blank') : ?>
                    <p class="error"><?php echo $settings->joinError['join_error_email_blank']; ?></p> 
                <?php endif; ?>
                <?php if(isset($error['email']) && $error['email'] == 'duplicate') : ?>
                    <p class="error"><?php echo $settings->joinError['join_error_email_duplicate']; ?></p> 
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $settings->join['join_input_password']; ?><span class="required"><?php echo $settings->join['join_required']; ?></span></td>
            <td>
                <input type="password" name="password" size="10" maxlength="20" value="<?php echo isset($_POST['password']) ? h($_POST['password']) : ''; ?>"/>
                <?php if(isset($error['password']) && $error['password'] == 'blank') : ?>
                    <p class="error"><?php echo $settings->joinError['join_error_password_blank']; ?></p>
                <?php endif; ?>
                <?php if(isset($error['password']) && $error['password'] == 'length') : ?>
                    <p class="error"><?php echo $settings->joinError['join_error_password_length']; ?></p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <div><input type="submit" value="<?php echo $settings->join['join_sign_up']; ?>"/></div>
</form> 
