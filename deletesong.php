<?php
include_once 'db.php';
$song=$_GET['mid'];
$getimage="SELECT * FROM user_post WHERE audio='$song'";
$imageresult=mysqli_query($conn,$getimage);
if($row=mysqli_fetch_assoc($imageresult)){
	$notimage=$row['image'];
	$sql1="DELETE FROM notifications WHERE unique_id='$notimage'";
	$result1=mysqli_query($conn,$sql1);
	$sql="DELETE FROM user_post WHERE audio='$song'";
    $result=mysqli_query($conn,$sql);
    unlink("audio/".$song);
    header('Location:songcart.php');
}
?>