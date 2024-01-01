<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
?>
<?php
if(isset($_POST['unfollow'])){
	$follower=$_POST['follower'];
	$following=$_POST['following'];
	require'db.php';
	$sql="DELETE FROM followership WHERE follower='$follower' AND following='$following'";
	$result=mysqli_query($conn,$sql);
	$sql2="DELETE FROM notifications WHERE sender='$follower' AND owner='$following' AND location='follow'";
	$result2=mysqli_query($conn,$sql2);
	echo "<script>
	$('.$following').html('<img src=loading.gif width=20px height=20px>');
	function loaderr(){
   $('.$following').css('display','none');
		
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";	
}

?>
<?php
mysqli_close($conn);
}
?>