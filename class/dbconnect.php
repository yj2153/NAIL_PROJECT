<?php
 try{
     $db = new PDO('mysql:dbname=myDB;host=127.0.0.1;charset=utf8', 'root', '');
 } catch(PDOExceiption $e){
     echo 'DB接続エラー：'.$e->getMessage();
 }