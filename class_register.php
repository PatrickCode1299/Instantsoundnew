<?php
date_default_timezone_set('Africa/Lagos');
class register{
	private $username;
	private $phone;
	private $email;
	private $birthday;
	private $password;
   function __construct($username,$phone,$email,$password,$birthday){
   $this->username=$username;
   $this->phone=$phone;
   $this->email=$email;
   $this->password=$password;
   $this->birthday=$birthday;

   }
   function getinfo(){
   	require 'db.php';
   $username=ucfirst(trim(htmlspecialchars(stripcslashes(lcfirst($this->username)))));
   $phone=trim(htmlspecialchars(stripcslashes($this->phone)));
   $email=trim(htmlspecialchars(stripcslashes($this->email)));
   $birthday=$this->birthday;
   $password=trim(htmlspecialchars(stripcslashes($this->password)));
   $hashPassword = password_hash($password,PASSWORD_DEFAULT);
   $day=date('Y-m-d H:i:s');
  $sql="INSERT INTO artiste_info(username,phone,email,password,birthday,join_day) VALUES(?,?,?,?,?,?)";
   $stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
	echo "Sorry Something Went Wrong";
}else{
   $sql2="INSERT INTO followership(follower,following) VALUES('$username','Superuser')";
$result2=mysqli_query($conn,$sql2);
	mysqli_stmt_bind_param($stmt,"ssssss",$username,$phone,$email,$hashPassword,$birthday,$day);
	mysqli_stmt_execute($stmt);
   mysqli_close($conn);

}
   }
}


?>
