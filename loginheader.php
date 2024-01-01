<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="An online music community  for upcoming artistes  in Africa and Nigeria to share their songs to listeners">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"/>  
<link rel="icon" type="img/png" href="/nmusic/css/instar.png">
<link rel="stylesheet" type="text/css" href="/nmusic/css/bootstrap-3.3.7-dist/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="/nmusic/fontawesome-free/css/all.css">
<script type="text/javascript" src='/nmusic/script/jquery-3.3.1.min.js'></script>
<!-- <script type="text/javascript" src="script/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="/nmusic/css/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script type="text/javascript" src="script/manipulateui.js"></script>
<title>Online Music Community For || Nigerian Musicians</title>
</head>
<body>
<?php
include_once '../nmusic/checkcount.php';
include_once '../nmusic/commentcount.php';
include_once '../nmusic/shares.php';
include_once '../nmusic/streamcount.php';
include_once '../nmusic/timeago.php';
?>
<nav id="flex-navbar">
	<span class="site-title-login" onclick="window.location.href='home.php';">Instasound9ja</span>
	<form class="form-inline header-form">
		<input type="text" placeholder="Enter an Artiste Name Or Song" onkeyup="runsearch()" name="searchquery" id="searchbox">
		<button type="submit"  name="search" class="btn btn-sm" id="searchsitebtn"><i id="searchwebsiteicon" class="fa fa-search"></i></button>
	</form>
	<ul class="list-inline list-unstyled flex-ul">
	<a href='home.php'><li><i class='fa fa-home' style='color:white; font-size:18px;'></i></li></a>
	<a href='profile.php'><li><i class='fa fa-user' style='font-size:18px; color:white;'></i></li></a>
	<li onclick="seen()"><i class='fa fa-bell' style='font-size:18px; color:white;' ></i><span style='color:white; border-radius:5px; padding:2px 2px; background:red; font-size:13px;'><?php 
			$username=$_COOKIE['user'];
			$sql="SELECT count(details) AS total FROM notifications WHERE owner='$username' AND status=0";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				if($row['total'] > 10){
                 echo "10+";
				}else{
                 echo $row['total'];
				}
			
			}
			?></span></li>
			<script type="text/javascript" src='script/seen.js'></script>
			<a href="load_message.php"><li><i class='fa fa-envelope' style="color:white; font-size:18px;"></i><span style='color:white; border-radius:5px; padding:2px 2px; background:red; font-size:13px;'><?php 
			$username=$_COOKIE['user'];
			$sql="SELECT count(message) AS total FROM chat WHERE reciever='$username' AND status=0";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				if($row['total'] > 10){
					echo "10+";
				}else{
                   echo $row['total'];
				}
				
			}
			?></span></li></a>
			<a href="songcart.php"><li><i class='fa fa-headphones' style="color:white; font-size:18px;"></i><span style='color:white; border-radius:5px; padding:2px 2px; background:red; font-size:13px;'><?php 
			$username=$_COOKIE['user'];
			$sql="SELECT count(audio) AS total FROM user_post WHERE username='$username' AND status !='shared' AND audio !=''";
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result)){
				if($row['total'] > 10){
					echo "10+";
				}else{
                   echo $row['total'];
				}
				
			}
			?></span></li></a>
			</a>
	<li id='showdropdown' onclick='dropdown()'  style='position:relative;'><i class='fa fa-cog' style='font-size:18px; color:white;'></i>
		<script type="text/javascript">
			function handle(){
	var result=confirm("Hey <?php echo $_COOKIE['user']; ?> Are You Leaving Now");
	if(result==true){
		window.location.href='logout.php';
	}else{
		
	}
}
		</script>
				<ul class='dropdown-menu'>
					<li onclick="window.location.href='connect.php';"><i class='fa fa-user-plus' style='font-size:18px;'></i></li>
					<li onclick='handle()'><i class='fa fa-share-square' style='font-size:18px;'></i></li>
					<li></li>
				</ul>
			</li>
		</ul>
</nav>

<div class="not-info-container" id="not-container">
	<span onclick="hidenot()" style='float:left; font-weight:bold; margin-left:8px; margin-top:5px; margin-bottom:8px; color:white; cursor:pointer; margin-top:2px; margin-right:10px;'><i class='fa fa-arrow-left' style='font-size:18px; color:white;'></i></span><span style='font-weight:bold; font-size:15px;  display:block; margin-top:5px; color:white; '>Notifications</span>
	<?php
	$owner=$_COOKIE['user'];
   $sql="SELECT * FROM notifications INNER JOIN artiste_info ON notifications.sender=artiste_info.username
    WHERE notifications.owner='$owner' ORDER BY notifications.id desc ";
   $result=mysqli_query($conn,$sql);
   if(mysqli_num_rows($result) > 0){
  while ($row=mysqli_fetch_assoc($result)) {
  if($row['profile_pic']=='' && $row['status']==0 && $row['location']=='comments'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; color:white; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='comments'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; color:white;  margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='comments') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; color:white;  '>".$row['details']."</p></a><span style='display:block;  float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='comments') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;    float:right;    clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='audio'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; word-wrap:break-word; color:white; '>".$row['details']."</p></a><span style='display:block;  float:right;    clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='audio'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;   float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='audio') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='audio') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='listen.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;  float:right;   clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
    elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='follow'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='follow'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='follow') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='follow') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['sender'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
     elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='reply'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='reply'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; color:white;  margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block;  float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='reply') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='reply') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='post_comment.php?mid=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400;  color:white; margin-top:4px; padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block;   float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
    elseif($row['profile_pic']=='' && $row['status']==0 && $row['location']=='shared'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block; float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif($row['profile_pic']!='' && $row['status']==0 && $row['location']=='shared'){
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:bold; margin-top:4px; color:white;  padding:2px 2px; word-wrap:break-word;'>".$row['details']."</p></a><span style='display:block; float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
  elseif ($row['profile_pic']=='' && $row['status']==1 && $row['location']=='shared') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/default.jpg' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; padding:2px 2px; color:white;  word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block; float:right;  clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }
   elseif ($row['profile_pic']!='' && $row['status']==1 && $row['location']=='shared') {
	echo "<li id='not-list'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><a href='info.php?id=".base64_encode($row['unique_id'])."' style='color:black;'><p style='font-weight:400; margin-top:4px; color:white;  padding:2px 2px; word-wrap:break-word; '>".$row['details']."</p></a><span style='display:block; float:right; clear:both; color:lightgrey; font-size:10px;'>".time_ago_in_php($row['day'])."</span></li>";
  }



  }
   }else{
echo "<p style='text-align:center; color:white;  font-weight:bold; margin-top:10px;'>No new notifications Yet</p>";
   }

function getnot(){
require 'db.php';
$owner=$_COOKIE['user'];
$day=date('Y-m-d');
$getoldnot="SELECT * FROM notifications WHERE owner='$owner'";
$findoldnot=mysqli_query($conn,$getoldnot);
while ($getallnot=mysqli_fetch_assoc($findoldnot)) {
	$clearoldnots="DELETE FROM notifications WHERE owner='$owner' AND duedate !='$day'";
	$execute=mysqli_query($conn,$clearoldnots);
}
}
getnot();

	?>
</div>
<div class="search-results">
<div id="response">
	
</div>
</div>
<section style="margin-top:0px; display:flex; flex-direction:row;">
<div class="info-container">
	<ul class="list-group" id="site-info">
		<li class="list-group-item eighteenem" onclick="window.location.href='discover.php';">Discover</li>
		<li class="list-group-item eighteenem">Genres</li>
		<li class="list-group-item eighteenem">Albums</li>
		<li class="list-group-item eighteenem" onclick="window.location.href='topchart.php';">Top Charts</li>
		<li class="list-group-item eighteenem">Favorites</li>
		<li class="list-group-item eighteenem">Around You</li>
	</ul>
</div>
<script type="text/javascript">
function hidebar(){
	$("#search-bar-box").css("display","none");
}
function nothing(){
alert("ok");
}
function dropdown(){
	$(".dropdown-menu").css('display','block');
	$(".dropdown-menu").css('height','80px');
}
function hidedropdown(){
	$(".dropdown-menu").css('display','none');
}
     $(document).click(function(){
$('.dropdown-menu').css('display','none');
});
 $(".dropdown-menu").click(function(e){
e.stopPropagation();
return false;
});
 $("#showdropdown").click(function(e){
e.stopPropagation();
return false;
});
</script>
