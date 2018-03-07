<?php
  $display_list = array(
    array("row"=>1,"word"=>"aaa","type"=>"B"),
    array("row"=>2,"word"=>"b","type"=>"M"),
    array("row"=>2,"word"=>"","type"=>"M"),
    array("row"=>3,"word"=>"c","type"=>"S"),
    array("row"=>3,"word"=>"ccc","type"=>"S"),
    array("row"=>3,"word"=>"","type"=>"S"),
    array("row"=>4,"word"=>"aaa","type"=>"B")
    );

    $row = 4;


    for ($i=1; $i <= 4; $i++) { 
      echo "今".$i."行目だよ";
      echo "<br>";
      foreach ($display_list as $value) {
        if ($value["row"] == $i){
          
            if ($value["word"] == ""){
              echo "!!!empty!!";
            }
          

          echo $value["word"];
          echo "<br>";



        }
      }


    }

?>