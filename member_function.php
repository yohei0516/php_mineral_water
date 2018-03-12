<?php 

// session_start();

//DBの接続
require('dbconnect.php');

   var_dump($_GET['member_id']);
  
  if(isset($_GET['member_id'])){
    $member_id = $_GET['member_id'];
    var_dump($member_id);
  }

    // function member($member_id){
    //   var_dump($member_id);

    // 関数の中に書く
    // require('dbconnect.php');
    $sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$member_id;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $profile_member = $stmt->fetch(PDO::FETCH_ASSOC);
  // }





 ?>