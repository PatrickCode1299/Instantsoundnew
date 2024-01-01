<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
 echo "<script>window.location.href='index.php';</script>";
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?>
<?php
$fetchartistes="SELECT username FROM artiste_info";
$querystmt=mysqli_query($conn,$fetchartistes);
if(mysqli_num_rows($querystmt) > 0){
    while($getallartiste=mysqli_fetch_assoc($querystmt)){
       $keepartiste=$getallartiste['username'];
       $fetchartistesong="SELECT postid,username FROM streamcount WHERE username='$keepartiste'";
       $getresult=mysqli_query($conn,$fetchartistesong);
       while($eachsong=mysqli_fetch_assoc($getresult)){
           $findartistename=$eachsong['username'];
          $getuserandplays="SELECT username,count(username) AS total FROM streamcount WHERE username='$findartistename'";
          $runstmt=mysqli_query($conn,$getuserandplays);
          while($check=mysqli_fetch_assoc($runstmt)){
              echo $check['total']."".$check['username']."<br />";
          }
       }
       //$getartistenumber="SELECT count(postid) AS total FROM streamcount WHERE username='$keepartiste'";
       //$queryartistenumber=mysqli_query($conn,$getartistenumber);
       //while($numbers=mysqli_fetch_assoc($queryartistenumber)){
         //  echo "<h1>".$numbers['total']."</h1><br /><br />";
       //}


    }
}

?>
<?php
mysqli_close($conn);
}
?>