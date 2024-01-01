<?php
if(isset($_POST['submit'])){
	require 'db.php';
	$username=$_POST['username'];
	$password=$_POST['password'];
	if(empty($username) || empty($password)){
			echo "<script>
	$('.sign-in').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('All fields are required<span class=close onclick=hideresponse() id=close>&times;</span>');
		$('.sign-in').html('Login');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}else{
$sql="SELECT * FROM artiste_info WHERE username='$username' OR email='$username' OR phone='$username'";
	$result=$conn->query($sql);
	if(mysqli_num_rows($result) > 0){
     if($row=mysqli_fetch_assoc($result)) {
     	$hashPassword= password_verify($password, $row['password']);
     	if($hashPassword == false){
                    	echo "<script>
	$('.sign-in').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Incorrect Username or Password<span class=close onclick=hideresponse() id=close>&times;</span>');
		$('.sign-in').html('Login');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	  }elseif ($hashPassword==true) {
	     $value=$row['username'];
	     setcookie("user",$value,time()+(86400 * 180),'/');
	     $email=$row['email'];
	     setcookie("email",$email,time()+(86400 * 180),'/');
	     $phone=$row['phone'];
	    setcookie("phone",$phone,time()+(86400 * 180),'/');
		session_start();
	 	 $_SESSION['u_name']=$row['username'];
	    $_SESSION['u_phone'] = $row['phone'];
	    $_SESSION['u_email'] = $row['email'];
	    $_SESSION['u_genre'] = $row['genre'];
	    $_SESSION['u_pass'] = $row['password'];
	    $_SESSION['u_birth'] = $row['birthday'];
		echo "<script>
	$('.sign-in').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function hi(){
	window.location.href='home.php';
	}
		setTimeout(hi,4000);
		clearInterval();

	</script>";
	  }
     }
	}else{
	echo "<script>
	$('.sign-in').html('<img src=/nmusic/loading.gif width=20px height=20px>');
	function loaderr(){
	$('#error').css('display','block');
		$('#error').html('Incorrect Username or Password<span class=close onclick=hideresponse() id=close>&times;</span>');
		$('.sign-in').html('Login');
	}
		setTimeout(loaderr,4000);
		clearInterval();

	</script>";
	}
	}
	
}

?>