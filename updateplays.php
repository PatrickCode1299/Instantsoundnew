 <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email']) || !isset($_POST['songid'])){
 echo "<script>window.location.href='index.php';</script>";
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$username=$_COOKIE['user'];
$songid=$_POST['songid'];
$updateplays="INSERT INTO streamcount(postid,username) VALUES('$songid','$username')";
$querysong=mysqli_query($conn,$updateplays);

$getplays="SELECT count(username) AS total FROM streamcount WHERE postid='$songid'";
$fetchplays=mysqli_query($conn,$getplays);
if(mysqli_num_rows($fetchplays) > 0){
if($fetchresult=mysqli_fetch_assoc($fetchplays)){
	if($fetchresult['total'] > 1){
		echo "<script>
         updatedetail={
         	songname:'".$songid."',
         	numberofplays:'".$fetchresult['total']." Plays',
         }
		</script>";

	}else{
			echo "<script>
         updatedetail={
         	songname:'".$songid."',
         	numberofplays:'".$fetchresult['total']." Play',
         }
		</script>";
	}
}
}else{

}

?>
<?php
}
?>