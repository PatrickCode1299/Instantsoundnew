 <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
 echo "<script>window.location.href='index.php';</script>";
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?>
<div class="container-fluid" id="sitecontent">
	<h3 class="heading-home">Browse</h3>
<div class="home-info-header list-inline list-unstyled">
	<li class="eighteenem">Overview</li>
	<li class="eighteenem">Charts</li>
	<li class="eighteenem" onclick="window.location.href='newmusic.php?id=<?php echo base64_encode('newmusic');?>';">New Releases</li>
	<li class="eighteenem">Discover</li>
	<li class="eighteenem">Shows</li>
	<hr />
</div>
<h4 class="heading-text">Listen to Africa Best Songs</h4>
<div class="buttongroup">
		<div class="new-music" id="new-song">
<?php 
	$fetchnewsongimage="SELECT audio,image FROM user_post WHERE audio !='' ORDER BY RAND()";
	$getnewsongimage=mysqli_query($conn,$fetchnewsongimage);
	if(mysqli_num_rows($getnewsongimage) > 0){
      if($row=mysqli_fetch_assoc($getnewsongimage)){
      	echo "<img src='/nmusic/image/".$row['image']."' class='img-round' />";
      }
	}else{

	}
	?>
    <p class="placer-text eighteenem text-center" onclick="window.location.href='newmusic.php?id=<?php echo base64_encode('newmusic');?>';">New Music<br />Now</p>
	</div>
	<div class="new-music" id="new-song">
			<?php 
	$fetchnewsongimage="SELECT audio,image FROM user_post WHERE audio !='' AND genre='Rap' ORDER BY RAND();";
	$getnewsongimage=mysqli_query($conn,$fetchnewsongimage);
	if(mysqli_num_rows($getnewsongimage) > 0){
      if($row=mysqli_fetch_assoc($getnewsongimage)){
      	echo "<img src='/nmusic/image/".$row['image']."' class='img-round' />";
      }
	}else{

	}
	?>
	 <p class="placer-text eighteenem text-center" onclick="window.location.href='newmusic.php?id=<?php echo base64_encode('Rap');?>';">Rap<br />All Day</p>
	</div>
	<div class="new-music" id="new-song">
		<?php 
		$genre='R&b';
	$fetchnewsongimage="SELECT audio,image FROM user_post WHERE audio !='' AND genre='$genre' ORDER BY RAND();";
	$getnewsongimage=mysqli_query($conn,$fetchnewsongimage);
	if(mysqli_num_rows($getnewsongimage) > 0){
      if($row=mysqli_fetch_assoc($getnewsongimage)){
      	echo "<img src='/nmusic/image/".$row['image']."' class='img-round' />";
      }
	}else{

	}
	?>
	 <p class="placer-text eighteenem text-center" onclick="window.location.href='newmusic.php?id=<?php echo base64_encode('Soul');?>';">Touch My<br />Soul</p>
	</div>
	<div class="new-music" id="new-song">
		<?php 
		$genre='Afropop';
	$fetchnewsongimage="SELECT audio,image FROM user_post WHERE audio !='' AND genre='$genre' ORDER BY RAND();";
	$getnewsongimage=mysqli_query($conn,$fetchnewsongimage);
	if(mysqli_num_rows($getnewsongimage) > 0){
      if($row=mysqli_fetch_assoc($getnewsongimage)){
      	echo "<img src='/nmusic/image/".$row['image']."' class='img-round' />";
      }
	}else{

	}
	?>
	 <p class="placer-text eighteenem text-center" onclick="window.location.href='newmusic.php?id=<?php echo base64_encode('Afropop');?>';">Feel The<br />Beat</p>
	</div>
</div>
	<?php
	$username=$_COOKIE['user'];
$sql1="SELECT following FROM followership WHERE follower='$username' AND following !='Superuser' ORDER BY  RAND() DESC";
$result1=mysqli_query($conn,$sql1);
if(mysqli_num_rows($result1) > 0){
while($row=mysqli_fetch_assoc($result1)){
$following=$row['following'];
$sql3="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$following' OR user_post.sharer='$following' OR user_post.status='sponsored' ORDER BY  user_post.userpostid desc LIMIT 10";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){
	while($row=mysqli_fetch_assoc($result3)){

}
 } 
  } 
   }else{
   	echo "<h4 class='heading-text'>Follow This People</h4>";
   	echo "<div class='to-follow-box'>";
$sql="SELECT * FROM artiste_info WHERE username !='$username' AND username !='Superuser'  ORDER BY RAND() LIMIT 8; ";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
if($row['profile_pic']==''){
echo "<div class='follow-box'>
          <center><img src='/nmusic/profilepic/default.jpg' id='following-image'></center>
          <a href='info.php?id=".base64_encode($row['username'])."'><p style='font-size:15px; text-align:center; margin-bottom:0px; color:white; font-family:arial; font-weight:bold; '>".$row['username']."</p></a>
          <form action='follow.php' method='POST' class='ajax'>
          <input type='hidden' name='username' value='".$_COOKIE['user']."'>
          <input type='hidden' name='following' value='".$row['username']."'>
          <center><button type='submit' value='".$row['username']."' class='".$row['username']."' name='follow'  id='follow-button'>Follow</button></center>
          </form>
  </div>";
}else{
echo "<div class='follow-box'>
          <center><img src='/nmusic/profilepic/".$row['profile_pic']."' id='following-image'></center>
          <a href='info.php?id=".base64_encode($row['username'])."'><p style='font-size:15px; text-align:center; margin-bottom:0px; color:white; font-family:arial; font-weight:bold; '>".$row['username']."</p></a>
          <form action='follow.php' method='POST' class='ajax'>
          <input type='hidden' name='username' value='".$_COOKIE['user']."'>
          <input type='hidden' name='following' value='".$row['username']."'>
          <center><button type='submit' value='".$row['username']."' class='".$row['username']."' name='follow'  id='follow-button'>Follow</button></center>
          </form>
  </div>";
}
  
}
echo"</div>";
	}

	?>	
	
</div>
</div>
</div>
<script type="text/javascript" src="script/manipulateui.js"></script>
<?php
mysqli_close($conn);
}
?>