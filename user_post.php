<?php
if(isset($_POST['post_text'])){
	require 'db.php';
	$username=$_POST['username'];
	$caption=$_POST['text'];
	$colorbg=htmlspecialchars($_POST['colorscheme']);
	$day=date('Y-m-d H:i:s');
	if(empty($caption)){
echo "<script>
	$('#post-fan-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('.pop-div').css('display','none');
	window.location.href='profile.php';
	$('#post-fan-button').html('Post');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}else{
$sql="INSERT INTO user_post(username,caption,post_day,colorbg) VALUES(?,?,?,?);";
	$stmt=mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "Something Went Wrong";
	}else{
		mysqli_stmt_bind_param($stmt,"ssss",$username,$caption,$day,$colorbg);
		mysqli_stmt_execute($stmt);
	}
	echo "<script>
	$('#post-fan-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('.pop-div').css('display','none');
	window.location.href='profile.php';
	$('#post-fan-button').html('Post');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}
	
     mysqli_close($conn);	
}
?>
