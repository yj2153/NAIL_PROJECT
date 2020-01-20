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
<div id="lead">
    <h1><?php echo $settings->join['join_title']; ?></h1>
    <p><?php echo $settings->check['check_info']; ?></p>
</div>
 <form action="" method="post">
 <input type="hidden" name="action" value="submit"/>
 <div id="signDiv" > 
    <div id="signTblDiv">   
    <table style="width:100%; height:100%">
            <tr>
                <td>   
                    <table id="signTbl">
                            <tr>
                                <td><?php echo $settings->check['check_input_name']; ?></td>
                                <td>
                                    <?php echo h($_SESSION['join']['name']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td><?php echo $settings->check['check_input_email']; ?></td>
                                <td>
                                    <?php echo h($_SESSION['join']['email']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td><?php echo $settings->check['check_input_password']; ?></td>
                                <td>
                                    <?php echo $settings->check['check_input_password_value']; ?>
                                </td>
                            </tr>
                        </table>
                </td>
            </tr>
    </table>                
    </div>
        <div>
            <input type="button" onclick="location.href='index.php?page=signUp&action=rewrite'" value="<?php echo $settings->check['check_rewirte']; ?>"/>
            <input style="float:right;" type="submit" value="<?php echo $settings->check['check_regist']; ?>"/>
        </div>
</div>
 </form> 
