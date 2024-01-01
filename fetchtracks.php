<?php
require 'db.php';
$username=$_POST['data'];
$fetchusersongs="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$username' AND user_post.status !='shared' AND user_post.audio !=''  ORDER BY user_post.userpostid DESC LIMIT 5;";
$getsongs=mysqli_query($conn,$fetchusersongs);
if(mysqli_num_rows($getsongs) > 0){
while ($row=mysqli_fetch_assoc($getsongs)) {
 echo "<div style='padding:5px 5px; margin-top:5px; position:relative;background:#333; border:1px solid grey; border-radius:5px; margin-left:4px; margin-right:4px;'>
    <h3 style='background:none;  display:inline;'>
    <a href='linkholder.php?linkid=".base64_encode($row['image'])."' style='color:red;'><span style='float:right;'><i style='color:red;' class='fa fa-headphones'></i></span></a>
    <img src='../nmusic/profilepic/".$row['profile_pic']."' id='post-profile-pic'><span class='name-font' style='margin-top:15px; display:inline; font-weight:bold;'>".$row['username']." (Audio)</span></h3>
<div style=' box-sizing:border-box; margin-top:10px;  opacity:0.8; width:100%;  background:black; height:auto;'>
<a href='listen.php?mid=".base64_encode($row['image'])."'><p id='songname' style='text-align:center;  word-wrap:break-word;    color:white; '>".htmlspecialchars($row['caption'])."</p></a>
<center><img src='../nmusic/image/".$row['image']."'style='width:100px; margin:0px auto; border:2px solid white; border-radius:50%;  height:100px;'></center><br />
<a href='listen.php?mid=".base64_encode($row['image'])."'><p id='songname'>Listen In Libary</p></a>
   </div>
    ";
    }
    mysqli_close($conn);
}else{
	echo "<h3>There are no tracks from this user yet.</h3>";
}