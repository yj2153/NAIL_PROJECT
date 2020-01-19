<?php
    require_once('../../class/autoLoad.php');
    require_once('../../class/dbconnect.php');
    session_start();
    
    if(isset($_SESSION['userInfo'])){
        $userInfo=$_SESSION['userInfo'];
        $id = $userInfo->getId();

        //投稿を検索する
        $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
        $messages->execute(array($id));
        $message = $messages->fetch();

        if($message['member_id'] == $id){
            //削除する
            $del = $db->prepare('DELETE FROM posts WHERE id=?');
            $del->execute(array($id));
        }
    }

    header('Location: ../index.php?page=review');
    exit(); 
?>