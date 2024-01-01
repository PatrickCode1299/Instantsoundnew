<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
require 'db.php';
?>
<?php
$search=trim($_POST['search']);
if(empty($search)){
	echo "";
}else{
$sql="SELECT * FROM artiste_info WHERE username REGEXP '$search'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
	if($row['profile_pic']=='' && $row['username']!=$_COOKIE['user']){
	echo "<a href='info.php?id=".base64_encode($row['username'])."'><li id='not-list'><img src='/nmusic/profilepic/default.jpg' id='not-profile-image' ><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['username']."</p></li></a><br />";
  }elseif($row['profile_pic']!='' && $row['username']!=$_COOKIE['user']){
  	echo "<a href='info.php?id=".base64_encode($row['username'])."'><li id='not-list'><img src='/nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['username']."</p></li></a><br />";
  }
  elseif($row['profile_pic']=='' && $row['username']==$_COOKIE['user']){
	echo "<a href='profile.php'><li id='not-list'><img src='/nmusic/profilepic/default.jpg' id='not-profile-image' ><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['username']."</p></li></a><br />";
  }else{
  	echo "<a href='profile.php'><li id='not-list'><img src='/nmusic/profilepic/".$row['profile_pic']."' id='not-profile-image' ><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['username']."</p></li></a><br />";
  }
}
}else{
$sql="SELECT * FROM user_post WHERE caption LIKE '%$search%' AND audio !=''";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while ($row=mysqli_fetch_assoc($result)) {
  echo "<a href='listen.php?mid=".base64_encode($row['image'])."'><li id='not-list'><img src='/nmusic/image/".$row['image']."' id='not-profile-image' ><p style='font-weight:400; margin-top:4px; padding:2px 2px; word-wrap:break-word;'>".$row['caption']."</p></li></a><br />";
}
}else{
  echo "There are no results matching your search";
}
}
}




?>
<?php
}
mysqli_close($conn);
?>