<?php
if(isset($_POST['follow'])){
require 'db.php';
$username=$_POST['username'];
$following=$_POST['following'];
$sql="INSERT INTO followership(follower,following) VALUES('$username','$following')";
$result=mysqli_query($conn,$sql);
$day=date('Y-m-d H:i:s');
$duedate=date('Y-m-d');
$sql2="INSERT INTO notifications(sender,details,owner,status,day,location,duedate) VALUES('$username','$username started to follow you','$following',0,'$day','follow','$duedate');";
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
?>