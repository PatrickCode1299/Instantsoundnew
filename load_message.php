<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?>
<div class="container">
<div class='load-profile-holder'>
<?php
$sql="SELECT profile_pic FROM artiste_info WHERE username='$username'";
$result=mysqli_query($conn,$sql);
if($row=mysqli_fetch_assoc($result)){
	$reciever=$_COOKIE['user'];
	if($row['profile_pic']==''){
echo "<img src='/nmusic/profilepic/default.jpg' id='load-message-pic'>";
	}else{
echo "<img src='/nmusic/profilepic/".$row['profile_pic']."' id='load-message-pic'>";
	}
	echo "<span id='text-name'>".ucfirst($_COOKIE['user'])."</span>";
	$sql="SELECT count(message) AS total FROM chat WHERE reciever='$username' AND status=0";
	$result=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_assoc($result)){
		echo "<span style='color:white; float:right; font-size:13px; margin-top:15px;'>(".$row['total'].") Unread Messages</span>";
	}
}
?>
</div>
<div class='recent-messages-container'>
<?php
$username=$_COOKIE['user'];
$sql="SELECT *  FROM chat  JOIN artiste_info ON chat.username=artiste_info.username  WHERE chat.reciever='$username' AND chat.entrystatus='new'  ORDER BY chat.id desc LIMIT 10 ";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
	if($row['status']==0 && $row['profile_pic']=='' && $row['image']=='' && $row['image1'] ==''){
      echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/default.jpg' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:bold;'>".nl2br($row['message'])."</p></div>";
	}elseif($row['status']==0 && $row['profile_pic']!='' && $row['image']=='' && $row['image1'] ==''){
echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/".$row['profile_pic']."' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:bold; word-wrap:break-word; line-height:22px;'>".nl2br($row['message'])."</p></div>";
	}
	elseif($row['status']==1 && $row['profile_pic']=='' && $row['image']=='' && $row['image1'] ==''){
		 echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/default.jpg' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:400; word-wrap:break-word; line-height:22px;'>".nl2br($row['message'])."</p></div>";
	}
	elseif($row['status']==1 && $row['profile_pic']!='' && $row['image']=='' && $row['image1'] ==''){
echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/".$row['profile_pic']."' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:400; word-wrap:break-word; line-height:22px;'>".nl2br($row['message'])."</p></div>";
	}
	elseif($row['status']==0 && $row['profile_pic']=='' && $row['image']!='' || $row['image1'] !=''){
      echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/default.jpg' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:bold;'>Sent an image</p></div>";
	}elseif($row['status']==0 && $row['profile_pic']!='' && $row['image']!='' || $row['image1'] !=''){
echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/".$row['profile_pic']."' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:bold; word-wrap:break-word; line-height:22px;'>Sent an image</p></div>";
	}
	elseif($row['status']==1 && $row['profile_pic']=='' && $row['image']!='' || $row['image1'] !=''){
		 echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/default.jpg' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:400; word-wrap:break-word; line-height:22px;'>Sent an image</p></div>";
	}
	elseif($row['status']==1 && $row['profile_pic']!='' && $row['image']!='' || $row['image1'] !=''){
echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/".$row['profile_pic']."' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".ucfirst($row['username'])."</span></a><p id='text-message' style='font-weight:400; word-wrap:break-word; line-height:22px;'>Sent an image</p></div>";
	}
}
}else{
	echo "<p style='text-align:center; font-size:20px; color:white;'>Messages Will Appear Here</p>";
}

?>
</div>
</div>
<?php
mysqli_close($conn);
}
?>