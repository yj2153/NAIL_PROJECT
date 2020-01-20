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

<div id="lead">
    <h1><?php echo $settings->join['join_title']; ?></h1>
</div> 
 <form action="" method="post">
 <div id="signDiv" > 
    <div id="signTblDiv">
        <table style="width:100%; height:100%">
            <tr>
                <td>
                    <table id="signTbl" >
                        <tr>
                            <td><?php echo $settings->join['join_input_name']; ?><span class="required"> <?php echo $settings->join['join_required']; ?></span></td>
                            <td>
                                <input type="text" name="name" size="35" maxlength="255" value="<?php echo isset($_POST['name']) ? h($_POST['name']) : ''; ?>" />
                            </td>
                        </tr>
                       
                        <tr>
                            <td colspan="2" class="error">
                                <?php if(isset($error['name']) && $error['name'] == 'blank') : ?>
                                    <?php echo $settings->joinError['join_error_name_blank']; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
                        <tr>
                            <td><?php echo $settings->join['join_input_email']; ?><span class="required"> <?php echo $settings->join['join_required']; ?></span></td>
                            <td>
                                <input type="text" name="email" size="35" maxlength="255" value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="error">
                                <?php if(isset($error['email']) && !strcmp($error['email'],'blank')) : ?>
                                    <?php echo $settings->joinError['join_error_email_blank']; ?>
                                <?php endif; ?>
                                <?php if(isset($error['email']) && !strcmp($error['email'], 'duplicate')) : ?>
                                    <?php echo $settings->joinError['join_error_email_duplicate']; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $settings->join['join_input_password']; ?><span class="required"> <?php echo $settings->join['join_required']; ?></span></td>
                            <td>
                                <input type="password" name="password" size="10" maxlength="20" value="<?php echo isset($_POST['password']) ? h($_POST['password']) : ''; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="error">
                                <?php if(isset($error['password']) && !strcmp($error['password'],'blank')) : ?>
                                    <?php echo $settings->joinError['join_error_password_blank']; ?>
                                <?php endif; ?>
                                <?php if(isset($error['password']) && !strcmp($error['password'],'length')) : ?>
                                    <?php echo $settings->joinError['join_error_password_length']; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div id="submitBtn"><input type="submit" value="<?php echo $settings->join['join_sign_up']; ?>"/></div>
</div>
</form> 
