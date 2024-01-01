<?php
if(isset($_POST['compile'])){
	//$albumname=$_POST['album'];
	$songs=$_POST['songs'];
	echo "<script>alert('$songs');</script>";
	//$username=$_POST['username'];
	require 'db.php';
	//$sql="UPDATE user_post SET album='yes' AND album_title='$albumname' WHERE username='$username' AND caption='$songs'";
}