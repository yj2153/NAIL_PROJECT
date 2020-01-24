<?php

if(!empty($_POST)){
    //エラー項目の確認
    if($_POST['title'] == ''){
        $error['title'] = 'blank';
    }
    $fileName = $_FILES['image']['name'];
    if(!empty($fileName)){
        $ext = substr($fileName, -3);
        if($ext != 'jpg' && $ext != 'gif'){
            $error['image'] = 'type';
        }
    }

    if(empty($error)){
        //画像をアップロードする
        $image = date('YmdHis').$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], './resource/image/'.$image);

        //登録処理をする
        $statement = $db->prepare('INSERT INTO gallery SET title=?, picture=?, created=NOW()');
        echo $ret = $statement->execute(array(
            $_POST['title'],
            $image
        ));

        header('Location: index.php?page=gallery');
        exit();
    }
}

?>

 <form action="" method="post" enctype="multipart/form-data">
    
 <div id="title">
        <h1><?php echo $settings->gallery['gallery_submit']; ?></h1>
    </div>   
 <table id="registTbl">
        <tr>
            <td><?php echo h($settings->gallery['gallery_title']); ?></td>
            <td>
                <input type="text" name="title" size="35" maxlength="255" value="<?php echo isset($_POST['title']) ? h($_POST['title']) : ''; ?>" />
                <?php if(isset($error['title']) && $error['title'] == 'blank') : ?>
                    <p class="error"><?php echo h($settings->gallery['gallery_title_error']); ?></p>
                <?php endif; ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
            </td>   
        </tr>
        <tr>
            <td><?php echo h($settings->gallery['gallery_image']); ?></td>
            <td>
                <input type="file" name="image" size="35"/>
                <?php if(isset($error['image']) && $error['image'] == 'type') : ?>
                    <p class="error"><?php echo h($settings->gallery['gallery_image_error']); ?></p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <div id="submitDiv"><input type="submit" value="<?php echo h($settings->gallery['gallery_submit']); ?>"/></div>
 </form> 
