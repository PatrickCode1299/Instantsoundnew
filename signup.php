<?php
require 'db.php';
if(isset($_POST['join'])){
	$uname=$_POST['username'];
	$uphone=$_POST['phone'];
	$uemail=$_POST['email'];
	$upassword=$_POST['password'];
	$ubirthday=$_POST['birthday'];
		if(empty($uname) || empty($uphone) || empty($uemail)  || empty($upassword) || empty($ubirthday)){
	echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('All fields are required');
		$('#join-button').html('Join');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";	
	}
	elseif (strlen($uname) <3) {
		echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Username is too short <span class=close onclick=hideresponse() id=close>&times;</span>');
		$('#join-button').html('Join');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";	
	}elseif (strlen($uname) >16) {
		echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Username is too long <span class=close onclick=hideresponse() id=close>&times;</span>');
		$('#join-button').html('Join');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}
	elseif (!is_numeric($uphone)) {
		echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Fake phone number<span class=close onclick=hideresponse() id=close>&times;</span>');
		$('#join-button').html('Join');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}
	elseif(strlen($upassword) < 6){
			echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Password is too short <span class=close onclick=hideresponse() id=close>&times;</span>');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";	
	}elseif ($upassword==$uname || $upassword==$uemail || $upassword==$uphone) {
		echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Please Use a more secure Password <span class=close onclick=hideresponse() id=close>&times;</span>');
		$('#join-button').html('Join');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}else{
		$sql="SELECT username,email FROM artiste_info WHERE username='$uname' OR email='$uemail'";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result) > 0){
				echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Username or Email already taken <span class=close onclick=hideresponse() id=close>&times;</span>');
		$('#join-button').html('Join');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
		}else{
include_once 'class_register.php';
		$user=new register($_POST['username'],$_POST['phone'],$_POST['email'],$_POST['password'],$_POST['birthday']);
		$user->getinfo();
		 $value=$_POST['username'];
	     setcookie("user",$value,time()+(86400 * 180),'/');
	     $email=$_POST['email'];
	     setcookie("email",$email,time()+(86400 * 180),'/');
	     $phone=$_POST['phone'];
	    setcookie("phone",$phone,time()+(86400 * 180),'/');
			echo "<script>
	$('#join-button').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function hi(){
	window.location.href='home.php';
	}
		setTimeout(hi,4000);
		clearInterval();

	</script>";
		}
		
	}
mysqli_close($conn);
}
?>