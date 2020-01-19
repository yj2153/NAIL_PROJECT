<?php 
if(!isset($_SESSION['join'])){
    header('Location: index.php');
    exit();
}
?>

<p><?php echo $settings->thanks['thanks_info']; ?></p>
<p><a href="index.php"><?php echo $settings->thanks['thanks_login']; ?></a></p>
