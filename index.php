<?php
  require_once('./class/autoLoad.php');
  require_once('./class/dbconnect.php');
  require_once('./class/shotFunction.php');
  
  session_start();

  // 初期値設定
  $page="index";
  $userInfo = null;
  $lang = "ja"; //初期言語：日本語

 if(isset($_SESSION['userInfo']) && $_SESSION['time'] + 3600 > time()){
    //ログインしている
    $_SESSION['time'] = time();
 }

  //現在ページ
  if(isset($_REQUEST['page'])){
    $page = $_REQUEST['page'];
 }

  //ログイン情報取得
  if(isset($_SESSION['userInfo'])){
      $userInfo = $_SESSION['userInfo'];
  }

  //言語設定取得
  if(isset($_REQUEST['lang'])){
      $lang = $_REQUEST['lang'];
      $_SESSION['lang'] = $lang;
  }else if(isset($_SESSION['lang'])){
      $lang = $_SESSION['lang'];
  }

  //言語切り替え
  if($lang == 'ko'){
      //韓国語
      $settings = Settings::getInstance("./resource/ini/languageKO.ini");
  }else{
      //日本語
      $settings = Settings::getInstance("./resource/ini/languageJP.ini");
  }
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
    <head>
        <meta charest="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="format-detection" content="telephone=no" />
        <title>seulgiNail</title>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
        <!-- <script src="./script/media/common.js"></script> -->

        <link rel="stylesheet" href="./resource/css/reset.css"/>
        <!-- <link rel="stylesheet" media="(max-width:700px)" href="./resource/css/media/common.css"/> -->
        <link rel="stylesheet" href="./resource/css/common.css"/>
        <link rel="stylesheet" href="./resource/css/index.css"/>

        <?php switch($page){ 
                case "map":
                    echo '<link rel="stylesheet" href="./resource/css/info/map.css"/>';
                break;
                case "login": 
                    echo '<link rel="stylesheet" href="./resource/css/main/login.css"/>';
                break; 
                case "signUp": 
                case "signUpCheck": 
                    echo '<link rel="stylesheet" href="./resource/css/join/signUp.css"/>'; 
                break; 
                case "signUpOk": 
                break; 
                case "review":
                    echo '<link rel="stylesheet" href="./resource/css/review/review.css"/>';
                break; 
                case "inquire":
                echo '<link rel="stylesheet" href="./resource/css/inquire/inquire.css"/>';
                break;
                case "inquireMsg":
                    echo '<link rel="stylesheet" href="./resource/css/inquire/listRegist.css"/>';
                break;
                case "inquireView":
                echo '<link rel="stylesheet" href="./resource/css/inquire/listView.css"/>';
                break;
                case "nailMenu":
                    echo '<link rel="stylesheet" href="./resource/css/booking/menu.css"/>';
                break; 
                case "booking":
                    echo '<link rel="stylesheet" href="./resource/css/booking/booking.css"/>';
                    echo '<script src="./resource/script/booking/booking.js"></script>';
                break;
                case "bookingSel":
                    echo '<link rel="stylesheet" href="./resource/css/booking/menu.css"/>';
                    echo '<script src="./resource/script/booking/menuSel.js"></script>';
                break;
                case "bookingCheck":
                    echo '<link rel="stylesheet" href="./resource/css/booking/confirm.css"/>';
                break;
                case "bookingList":
                    echo '<link rel="stylesheet" href="./resource/css/booking/bookingList.css"/>';
                break;
                case "gallery":
                    echo '<link rel="stylesheet" href="./resource/css/gallery/list.css"/>';
                break;
                case "galleryView":
                    echo '<link rel="stylesheet" href="./resource/css/gallery/view.css"/>';
                break;
                case "galleryRegist":
                    echo '<link rel="stylesheet" href="./resource/css/gallery/regist.css"/>';
                break;
                default: 
                    echo '<link rel="stylesheet" href="./resource/css/info/info.css"/>';
                break; 
            } ?>

    </head>
   
    <body>
        <div id="header">
            <table id="headerTbl" style="width:99%; margin:0 auto;">
                <tr>
                    <td>
                        <!-- title -->
                        <h1><?php echo $settings->title['title']; ?></h1>
                    </td>
                    <td>
                        <!-- user name -->
                        <?php if(!empty($userInfo)) : ?>
                            <?php echo $userInfo->getName(); ?>
                        <?php else : ?>
                            guest
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- ログイン -->
                        <?php if(empty($userInfo)) : ?>
                            <a href="./index.php?page=login">Login</a>
                        <?php else : ?>
                            <a href="./web/main/logout.php">LogOut</a>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:right;">
                        <!-- language -->
                        <select id="langList" name="lang" onchange="location.href='index.php?lang=' + this.value;">
                            <option value="ja" <?php echo strcmp($lang,"ja") ? '' : 'selected'; ?>>日本語</option>
                            <option value="ko" <?php echo strcmp($lang,"ko") ? '' : 'selected'; ?>>한국어</option>
                        </select>
                    </td>
                </tr>
            </table>
            <div id="menu_div">
                <ui id="menu">
                    <li><a href="#"><?php echo $settings->menu['menu01']; ?></a>
                        <ul id="subMenu">
                            <li><a href="index.php"><?php echo $settings->subMenu['subMenu01_01']; ?></a></li>
                        <li><a href="index.php?page=map"><?php echo $settings->subMenu['subMenu01_02']; ?></a></li>
                        </ul>
                    </li>
                    <li><a href="#"><?php echo $settings->menu['menu02']; ?></a>
                        <ul id="subMenu">
                            <li><a href="index.php?page=nailMenu"><?php echo $settings->subMenu['subMenu02_03']; ?></a></li>
                            <li><a href="index.php?page=bookingSel"><?php echo $settings->subMenu['subMenu02_01']; ?></a></li>
                            <li><a href="index.php?page=bookingList"><?php echo $settings->subMenu['subMenu02_02']; ?></a></li>
                        </ul>
                    </li>
                    <li><a href="index.php?page=gallery"><?php echo $settings->menu['menu03']; ?></a></li>
                    <li><a href="index.php?page=inquire"><?php echo $settings->menu['menu04']; ?></a></li>
                    <li><a href="index.php?page=review"><?php echo $settings->menu['menu05']; ?></a></li>
                </ui>
            </div>
        </div>
        <!-- end header -->
        <div id="content">
            <?php switch($page){ 
                case "map":
                    include("./web/info/map.php"); 
                break;
                case "login": 
                    include("./web/main/login.php"); 
                break; 
                case "signUp": 
                    include("./web/join/signUp.php"); 
                break; 
                case "signUpCheck": 
                    include("./web/join/check.php"); 
                break; 
                case "signUpOk": 
                    include("./web/join/thanks.php"); 
                break; 
                case "review":
                    include("./web/review/review.php"); 
                break; 
                case "inquire":
                    include("./web/inquire/list.php"); 
                break;
                case "inquireMsg":
                    include("./web/inquire/listRegist.php"); 
                break;
                case "inquireView":
                    include("./web/inquire/listView.php"); 
                break;
                case "nailMenu":
                    include("./web/booking/menu.php"); 
                break;
                case "bookingSel":
                    include("./web/booking/menuSel.php"); 
                break;
                case "booking":
                    include("./web/booking/booking.php"); 
                break;
                case "bookingCheck":
                    include("./web/booking/confirm.php"); 
                break;
                case "bookingOK":
                    include("./web/booking/bookingOK.php"); 
                break;
                case "bookingList":
                    include("./web/booking/bookingList.php"); 
                break;
                case "gallery":
                    include("./web/gallery/list.php"); 
                break;
                case "galleryView":
                    include("./web/gallery/view.php"); 
                break;
                case "galleryRegist":
                    include("./web/gallery/regist.php"); 
                break;
                default: 
                    include("./web/info/info.php"); 
                break; 
            } ?>
        </div>
        <!-- end content -->
    </body>

</html>