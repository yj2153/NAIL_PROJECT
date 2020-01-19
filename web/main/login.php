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
    <h1>Login</h1>
</div>
<form action="" method="post">
    <div id="loginDiv">
        <div id="loginTblDiv">
            <table style="width:100%; height:100%;">
               <tr>
                    <td>
                        <table id="loginTbl">
                            <tr>
                                <td><?php echo $settings->login['login_input_email']; ?></td>
                                <td>
                                    <input type="text" name="email" size="35" maxlength="255" 
                                    value="<?php echo isset($_POST['email']) ? h($_POST['email']) : ''; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $settings->login['login_input_password']; ?></td>
                                <td>
                                    <input type="password" name="password" size="35" maxlength="255" value="<?php echo isset($_POST['password']) ? h($_POST['password']) : ''; ?>" />
                                <td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php if(isset($error['login']) && $error['login'] == 'blank') : ?>
                                        <p class="error"><?php echo $settings->loginError['login_error_email_blank']; ?></p>
                                    <?php endif; ?>
                                    <?php if(isset($error['login']) && !strcmp($error['login'], 'failed')) : ?>
                                        <p class="error"><?php echo $settings->loginError['login_error_email_failed']; ?></p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                                <td colspan="2">
                                    <input id="save" type="checkbox" name="save" value="on" />
                                    <label for="save"><?php echo $settings->login['login_check_info02']; ?></label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div style="width:90%; margin:0 auto;">
            <input type="button" onclick="location.href='index.php?page=signUp'" value="<?php echo $settings->login['login_sign_up']; ?>"/>
            <input type="submit" style="float:right;" value="<?php echo $settings->login['login_sign_in']; ?>"/>
        </div>
    </div>
</form>
