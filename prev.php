<?php
if(isset($_POST['prev'])){
$query=$_POST['data'];
require 'db.php';
$sql1="SELECT * FROM user_post WHERE image='$query'";
$result=mysqli_query($conn,$sql1);
if($row=mysqli_fetch_assoc($result)){
	$user=$row['username'];
	$sql2="SELECT image FROM user_post WHERE username='$user' AND audio !='' AND image !='$query'  ORDER BY  RAND() ASC ;";
	$result2=mysqli_query($conn,$sql2);
	if($row2=mysqli_fetch_assoc($result2)){
echo "<script>window.location.href='listen.php?mid=".base64_encode($row2['image'])."';</script>";
	}
}
}

mysqli_close($conn);
?>