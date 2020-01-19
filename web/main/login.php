<?php
if(!empty($_COOKIE['email']) && $_COOKIE['email'] != ''){
    $_POST['email'] = $_COOKIE['email'];
    $_POST['password'] = $_COOKIE['password'];
    $_POST['save'] = 'on';
}

if(!empty($_POST)){
    //ログインの処理
    if($_POST['email'] != '' && $_POST['password'] != ''){
        $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
        $login->execute(array(
            $_POST['email'],
            sha1($_POST['password'])
        ));

        $member = $login->fetch();
        
        if($member){
            //ログイン成功
            $userInfo = new userInfo();
            $userInfo->setId($member['id']);
            $userInfo->setName($member['name']);
            $_SESSION['userInfo'] = $userInfo;
            $_SESSION['time'] = time();

            //ログイン情報を記録する
            if(isset($_POST['save']) && $_POST['save'] == 'on'){
                setcookie('email', $_POST['email'], time() + 60*60*24*14);
                setcookie('password' , $_POST['password'], time() + 60*60*24*14);
            }

            header('Location: index.php');
        }else{
            $error['login'] = 'failed';
        }
    }else {
        $error['login'] = 'blank';
    }
}

?>

<div id="lead">
    <p><?php echo $settings->login['login_info_01']; ?></p>
    <p><?php echo $settings->login['login_info_02']; ?></p>
    <p>&raquo;<a href="index.php?page=signUp"><?php echo $settings->login['login_sign_up']; ?></a></p>
</div>
<form action="" method="post">
    <dl>
        <dt><?php echo $settings->login['login_input_email']; ?></dt>
        <dd>
            <input type="text" name="email" size="35" maxlength="255" 
            value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>"/>
            <?php if(isset($error['login']) && $error['login'] == 'blank') : ?>
                <p class="error"><?php echo $settings->loginError['login_error_email_blank']; ?></p>
            <?php endif; ?>
            <?php if(isset($error['login']) && !strcmp($error['login'], 'failed')) : ?>
                <p class="error"><?php echo $settings->loginError['login_error_email_failed']; ?></p>
            <?php endif; ?>
        </dd>
        <dt><?php echo $settings->login['login_input_password']; ?></dt>
        <dd>
            <input type="password" name="password" size="35" maxlength="255" 
            value="<?php echo isset($_POST['password']) ? h($_POST['password']) : ''; ?>" />
        </dd>
        <dt><?php echo $settings->login['login_check_info01']; ?></dt>
        <dd>
            <input id="save" type="checkbox" name="save" value="on" />
            <label for="save"><?php echo $settings->login['login_check_info02']; ?></label>
        </dd>
    </dl>
    <div>
        <input type="submit" value="<?php echo $settings->login['login_sign_in']; ?>"/>
    </div>
</form>
