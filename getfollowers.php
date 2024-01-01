<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.follower=artiste_info.username WHERE followership.following='$username' ORDER BY followership.id asc";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
$tounfollow=$row['follower'];
$sql3="SELECT follower FROM followership WHERE follower='$username' AND following='$tounfollow'";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){
if($row['profile_pic']==''){
echo "<ul class='following-list'>
	<li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".$row['follower']."'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
}else{
	echo "<ul class='following-list'>
	<li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form'  action='unfollow.php' class='ajax' value='".$row['follower']."'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='follower' value='".$_COOKIE['user']."'>
	<button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  name='unfollow' id='unfollow-button'>unfollow</button>
	</form></li><br />
	</ul>";
}
}else{
	if($row['profile_pic']==''){
echo "<ul class='following-list'>
	<li><img src='profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' class='ajax'  style='float:right; margin-top:10px;' action='follow.php'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='username' value='".$_COOKIE['user']."'>
	<button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
	</form></li><br />
	</ul>";
	}else{
		echo "<ul class='following-list'>
	<li><img src='profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a><form method='POST' class='ajax' style='float:right;  margin-top:10px;' action='follow.php'>
	<input type='hidden' name='following' value='".$row['follower']."'>
	<input type='hidden' name='username' value='".$_COOKIE['user']."'>
	<button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
	</form></li><br />
	</ul>";
	}
}
}
}else{
echo "<p style='text-align:center; font-size:18px; font-weight:bold; margin-top:10px;'>No Fan yet</p>";
}

	?>
	<script type="text/javascript">
	$('form.ajax').on('submit' ,function(e){
var that= $(this),
url= that.attr('action'),
type=that.attr('method'),
data={};
that.find('[name]').each(function(index, value){
	var that = $(this),
	  name=that.attr('name'),
	  value=that.val();
	  data[name]=value;

});
e.stopImmediatePropagation();
$.ajax({
	url:url,
	type:type,
	data:data,
	success:function(response){
    $("body").append(response);
	}
});

return false;
});
	</script>
<?php
mysqli_close($conn);
 }
?>