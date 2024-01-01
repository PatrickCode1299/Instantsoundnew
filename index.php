<?php
if(isset($_COOKIE['user'])&&isset($_COOKIE['email']) && isset($_COOKIE['phone'])){
  echo "<script>window.location.href='home.php';</script>";
}else{
if(isset($_SESSION['u_email'])){
  echo "<script>window.location.href='home.php';</script>";
}else{
?>
<?php
include_once 'header.php';
require 'db.php';
?>
<div class="contenido" style="flex:2;">
<ul class="backgroundslider">
<li></li>
<li></li>
<li></li> 
<li></li>	
</ul>
<div class="container-fluid" id="sitecontent">
<div class="recent-song-heading">
<?php 
$fetchrandomsong="SELECT audio,image,caption,username FROM user_post WHERE audio !='' ORDER BY RAND()";
$getsong=mysqli_query($conn,$fetchrandomsong);
if(mysqli_num_rows($getsong) > 0){
if($row=mysqli_fetch_assoc($getsong)){
  $GLOBALS['isartistename'] = $row['username'];
  $GLOBALS['issongname'] = $row['caption'];
	echo "<h2 class='recent-song-cap'>Recently Added</h2><div class='placer'><img src='/nmusic/image/".$row['image']."' class='song-avatar img-circle'><span class='text-info'>".$row['caption']."</span><button type='button' class='play-song-button' id='".$row['caption']."' onclick=fireplayevent('".$row['audio']."','".$row['image']."')><i class='fa fa-play' style='font-size:20px;'></i></button></div>";
}
}else{
	echo "<script>alert('Wrong Query');</script>";
}
?>

</div>
<h2 class="twentyem trending-header">Trending Around You</h2>
<p class="caption pointer" onclick="loginForm()">See More</p>
<div class="trending-around-you">
<?php
$findsongname="SELECT DISTINCT audio,image,caption FROM user_post WHERE audio !='' ORDER BY RAND()";
$getsongname=mysqli_query($conn,$findsongname);
if(mysqli_num_rows($getsongname) > 0){
	while($row1=mysqli_fetch_assoc($getsongname)){
		$songid=$row1['audio'];
		$songname=$row1['caption'];
		$image=$row1['image'];
		$findstreamcount="SELECT postid, count(postid) AS total FROM streamcount WHERE postid='$songid';";
		$calculatecount=mysqli_query($conn,$findstreamcount);
		if($row2=mysqli_fetch_assoc($calculatecount)){
			$song=$row2['postid'];
			$sql3="SELECT username FROM user_post WHERE audio='$song';";
			$getsql3=mysqli_query($conn,$sql3);
			if($row3=mysqli_fetch_assoc($getsql3)){
			$count=$row2['total'];
			if($count > 100){
              $song=$row1['caption'];
            $username=$row3['username'];
           // echo "<script>alert('$song + $count+ $username');</script>";
             echo "<div class='row-songs'>
             <img src='/nmusic/image/".$image."' class='row-image img-rounded' onmouseover=opensong()>
             <p class='song-name'>".$song."</p>
             <p class='artiste-name thirteenem'>".$username."</p>
             </div>"; 
			}
			}
			
		}
	}
}
?>
</div>
<div class="new-song-holder">
	<div class='list-group list-unstyled'>
		<h3 style="font-family:tahoma; font-weight:bold;" class="twentyem">New Songs</h3>
	<?php
    $fetchnewsong="SELECT DISTINCT audio,image,username,caption FROM user_post WHERE audio !='' ORDER BY userpostid desc LIMIT 5 ";
    $getnewsong=mysqli_query($conn,$fetchnewsong);
    if(mysqli_num_rows($getnewsong)> 0){
     while($rownewsong=mysqli_fetch_assoc($getnewsong)){
     	echo "
         <li><img src='/nmusic/image/".$rownewsong['image']."' class='img-rounded small-img'><span class='song-title thirteenem'>".$rownewsong['caption']."</span><p class='artiste-detail'>".$rownewsong['username']."</p></li>
   ";
     }
    }else{

    }
	?>
</div>
<div class='list-group list-unstyled'>
	 	<h3 style="font-family:tahoma; font-weight:bold;" class="twentyem">Recent Songs</h3>
	<?php
    $fetchrecentsong="SELECT DISTINCT audio,image,username,caption FROM user_post WHERE audio !='' ORDER BY userpostid asc LIMIT 5 ";
    $getrecentsong=mysqli_query($conn,$fetchrecentsong);
    if(mysqli_num_rows($getrecentsong)> 0){
     while($rowoldsong=mysqli_fetch_assoc($getrecentsong)){
     	echo "
         <li><img src='/nmusic/image/".$rowoldsong['image']."' class='img-rounded small-img'><span class='song-title thirteenem'>".$rowoldsong['caption']."</span><p class='artiste-detail'>".$rowoldsong['username']."</p></li>
     ";
     }
    }else{

    }
	?>
</div>
</div>
<div class="audio_player">
  <div id="controller-class">
    <div class="playin-song-details">
    <img id="playing-song-avatar" />
    <p id="playing-song-name"><?php echo  $GLOBALS['issongname'];  ?></p>
    <p id="playing-song-title"><?php echo $GLOBALS['isartistename']; ?></p>
  </div>
  <audio id="songelement" onplay="isplaying()" ontimeupdate="updateTrackTime()" onpause="ispaused()" autoplay>

  </audio>
  <div class="control-buttons">
  <button class="audio_btn" id="previous"><i class="fa fa-step-backward" style="font-size:20px;"></i></button>
  <button id="play" class="audio_btn playbtn" onclick="document.getElementById('songelement').play()"><i class="fa fa-play-circle" style="font-size:30px;"></i></button>
  <button  id="pause" class="audio_btn pausebtn" onclick="document.getElementById('songelement').pause()"><i class="fa fa-pause" style="font-size:30px;"></i></button>
  <button class="audio_btn" id="next"><i class="fa fa-step-forward" style="font-size:20px;"></i></button>
</div>
</div>
<div class="song-timing-holder">
  <span class="text-left starttime" id="currentTime"></span>
  <span class="text-right endtime" id="duration"></span>
</div>
</div>
</div>
<div class="register-form">
    <!--<h4 class="text-bold text-info">Join the instantsound music community
and
listen to hits from talented african artistes</h4>-->

  <span class="pull-right twentyem text-danger cancelform">&times;</span>
  <form method="POST" class='ajax signin-collector-holder register-collector' action="signup.php">
      <h4 class="instasoundinfo pull-left" >Join the instantsound music community<br> and<br> listen to hits from talented african artistes</h4>
     <h3 style="text-align:center; font-weight:bold; color:white; font-family:tahoma;">Instantsound Sign Up</h3>
      <span><i class="fa fa-user" style="color:white; font-size:15px; margin-right:5px;">Username</i></span><input type="text" id="join-username"  onmouseout="hide()" onkeydown="checkusername()"  placeholder="username" name="username" class="form-control" required>
   <p id="result" style="color:red;"></p>
     <span><i class="fa fa-phone" style="color:white; font-size:15px; margin-right:5px;">Phone</i></span><input type="phone" id="join-username" onmouseout="hidephone()" onkeydown="checkphone()"  placeholder="phone" name="phone" class="form-control" required>
   <p id="resultphone" style="color:red;"></p>
      <span><i class="fa fa-envelope" style="color:white; font-size:15px; margin-right:5px;">Email</i></span><input type="email" id="join-username" placeholder="john@example.com" name="email" class="form-control" required>

   <p id="resultemail"></p>
      <span><i class="fa fa-key" style="color:white; font-size:15px; margin-right:5px;">Password</i></span><input type="password" id="join-username" onmouseout="hidepass()" onkeydown="checkpass()"  placeholder="password" name="password" class="form-control" required>

   <p id="resultpass" style="color:red;"></p>
      <span><i class="fa fa-birthday-cake" style="color:white; font-size:15px; margin-right:5px;">Birthday</i></span><input type="date" id="join-username" name="birthday" required>
  <button name="join" id="join-button" type="submit">Join</button>
  </form>
<form method="POST" action="checklogin.php" class="ajax login-collector-holder">
    <h3 style="text-align:center; font-weight:bold; color:white; font-family:tahoma;">Instantsound Log In</h3>
      <span><i class="fa fa-user" style="color:white; font-size:15px; margin-right:5px;">Username</i></span><input type="text" id="join-username"  placeholder="username" name="username" class="form-control" required>

      <span><i class="fa fa-key" style="color:white; font-size:15px; margin-right:5px;">Password</i></span><input type="password" id="join-username"   placeholder="password" name="password" class="form-control" required>
        <button name="submit" class="sign-in" id="join-button" type="submit">Login</button>
        <p id="error" style="background: pink; margin: 30px auto 0px; padding: 3px 5px; border-radius: 5px; left: 10%; top: 20%; height: 40px; right: 10%; bottom: auto; color: red; display: none; position: fixed; z-index: 1;"></p>
</form>


</div>
<div class="play-trending-song-div">
  
</div>
</div>
</section>
<?php
include_once 'footer.php';
mysqli_close($conn);
?>
<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script type="text/javascript">
$('form.ajax').on('submit' ,function(){
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
function checkusername(){
  $("#result").html("Cannot be less than 3 characters");
}
function checkphone(){
  $("#resultphone").html("Cannot be less than 11 characters and must be a valid digit");
}
function hide(){
  $("#result").html("");
}
function checkpass(){
  $("#resultpass").html("Cannot be less than six characters and must contain alphanumeric chars");
}
function hidepass(){
  $("#resultpass").html("");
}
function hidephone(){
  $("#resultphone").html("");
}
function hideresponse(){
  $("#error").css('display','none');
}
$(".cancelform").on("click",function(){
$(".register-form").css('display','none');
});
</script>


</body>
<?php
  }
}
?>