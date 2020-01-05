<?php
 require('init.php');
 if(isset($_GET['id']) AND !empty($_GET['id']))
 {
   $id = (int)$_GET['id'];
   $student = $db->single("SELECT * FROM students WHERE id = '{$id}' ");
   $cardnum = $student->cardnum;

   if( $db->delete('students','id',$id) ){
     $db->delete('logs','cardnum',$cardnum);
     if(file_exists(getcwd()."/".$student->std_img)){
       unlink(getcwd()."/".$student->std_img);
     }
     if(file_exists(getcwd()."/".$student->parentTwo_img)){
        unlink(getcwd()."/".$student->parentTwo_img);
     }
    if(file_exists(getcwd()."/".$student->parentThree_img)){
        unlink(getcwd()."/".$student->parentThree_img);
    }
    if(file_exists(getcwd()."/".$student->parentFour_img) ) {
      unlink(getcwd()."/".$student->parentFour_img);
    }
    if(file_exists(getcwd()."/".$student->parentFive_img) ) {
      unlink(getcwd()."/".$student->parentFive_img);
    }
    if(file_exists(getcwd()."/".$student->parentOne_img)){
       unlink(getcwd()."/".$student->parentOne_img);
    }

     redirect('std.php?success=1');
   }else{
     redirect('std.php?success=0');
   }

 }
?>
