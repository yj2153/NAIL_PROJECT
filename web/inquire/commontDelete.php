<?php
    require_once('../../class/autoLoad.php');
    require_once('../../class/dbconnect.php');
    session_start();

if(!empty($_REQUEST) && isset($_REQUEST['listNum']) && isset($_REQUEST['reply_id'])){
    $delete = $db->prepare('DELETE FROM inquire WHERE id=?');
    $delete->execute(array(
        $_REQUEST['reply_id']
    ));
}

        header('Location: ../../index.php?page=inquireView&listNum='.$_REQUEST['listNum']);
        exit();
?>