<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}
elseif (!isset($_GET['linkid'])|| is_numeric($_GET['linkid']) || strlen($_GET['linkid'])< 2) {
	header('Location:profile.php');
}
else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
include_once 'loginheader.php';
?>
<div style='padding:5px 5px; font-size:20px; margin:0 auto; background:lightgrey; color:black; margin-top:100px; border-radius:10px; max-width:100%; word-wrap:break-word; line-height:50px; '>
Copy this Link on your other social media handles profile like instagram,facebook,twitter and the rest in other to enable people outside instantsound listen to this song<br />
<?php echo"<small>localhost/instantsoundnew/listen.php?mid=".base64_encode(base64_decode($_GET['linkid']))."</small>"; ?>
</div>
<?php
mysqli_close($conn);
}
?>