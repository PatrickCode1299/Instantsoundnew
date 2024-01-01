
<?php
if(isset($_COOKIE['user']) && isset($_GET['mid'])){
	require 'db.php';
	include_once 'loginheader.php';
	//include_once 'listenstreamcount.php';

	$songid=base64_decode($_GET['mid']);
$sqlstream="SELECT * FROM user_post WHERE image='$songid'";
$resultstream=mysqli_query($conn,$sqlstream);
if($rowstream=mysqli_fetch_assoc($resultstream)){
	$username=$rowstream['username'];
	$hitid=$rowstream['audio'];
	$sql="INSERT INTO streamcount(username,postid) VALUES('$username','$hitid')";
$result=mysqli_query($conn,$sql);
}
?>
<div class='container-fluid' id='sitecontent'>
<div class="full-width-artiste-songs">
	<?php
    $getothersongs="SELECT DISTINCT username,audio,caption,genre,lyrics,post_day FROM user_post WHERE image='$songid' AND audio !='' AND status !='shared'";
    $query=mysqli_query($conn,$getothersongs);
    if(mysqli_num_rows($query) > 0){
      if($row=mysqli_fetch_assoc($query)){
      	$artistename=$row['username'];
      	$currentsongname=$row['audio'];
      	$GLOBALS['song_name'] = $row['caption'];
      	$GLOBALS['artiste_name'] = $row['username'];
      	$getartisteothersongs="SELECT DISTINCT username,audio,image,caption,post_day FROM user_post WHERE username='$artistename' AND audio !='$currentsongname' AND audio !='' ORDER BY userpostid desc";
      	$fetchothersongs=mysqli_query($conn,$getartisteothersongs);
      	while ($getsongs=mysqli_fetch_assoc($fetchothersongs)) {
        // $songs = array('songfile' => $getsongs['audio'],'songname'=>$getsongs['caption'],'songavatar'=>$getsongs['image'],'songowner'=>$getsongs['username']);
            // $allsongs=json_encode($songs);
        //echo "<script>alert('".$allsongs."')</script>";
    echo "<a href='listen.php?mid=".base64_encode($getsongs['image'])."'><li class='listendiscparent'><img id='".$getsongs['image']."' src='/nmusic/image/".$getsongs['image']."' class='song-cover-avatar'><span class='song-title'>".$getsongs['caption']."</span><p class='user-detail'>".$getsongs['username']."</p><li></a>";
      	}
      }
    }else{
    	echo "<h4 style='color:white;'>Other Songs Will Showcase Here.</h4>";
    }
	?>
</div>
<div class="player">
<h2 class="text-center" style="font-family:tahoma; font-weight:bold;">	<marquee id="songtitleplay" speed="5000"><?php echo ucfirst($GLOBALS['song_name']); echo"<span>   By   ".ucfirst($GLOBALS['artiste_name'])."</span>";?></marquee></h2>
	<div style="margin:0px auto; margin-bottom:10px; border-radius:50%; width:200px; height:200px; margin-top:10px;">
		<?php echo "<img class='rotate' id='playerdisc' src='/nmusic/image/".$songid."' style='width:100%; border:2px solid white; border-radius:50%; height:200px;'>"; ?>
    <span id="currentTime" class="pull-left"></span>
    <span id="duration" class="pull-right"></span>
	</div>
	<div style="display:flex; margin-top:10px; flex-direction:row; flex-wrap:nowrap; justify-content:center; align-items:center;">
		<?php echo"<span style='margin-top:10px; margin-bottom:5px;'><a href='../nmusic/audio/".$currentsongname."'  download='".$GLOBALS['song_name']."'><i class='fa fa-download' style='color:white; font-size:20px;'></i></span></a>"; 
	echo "<span style='color:white;'>".streamcount($currentsongname)."</span>"; 
echo"<input id='songdetail' type='hidden' value=' ".base64_decode($_GET['mid'])." '>";

?>
</div>
<div class="audiotoplay">
	 <audio id="songelement"  onplay="isplaying()" ontimeupdate="updateTrackTime()" onended="nextSong()" onpause="ispaused()" autoplay>
 <?php echo"<source id='pronetochange' src='/nmusic/audio/".$currentsongname."' type='audio/mpeg'>
    <source id='pronetochange' src='/nmusic/audio/".$currentsongname."' type='audio/ogg'>"; ?>
  </audio>

  <div class="listencontrols">
      <?php
$songowner=$row['username'];
$sql2="SELECT count(audio) AS total FROM user_post WHERE username='$songowner' AND audio !=''";
$result2=mysqli_query($conn,$sql2);
while($row2=mysqli_fetch_assoc($result2)){
  if($row2['total'] > 2){
echo "<form style='margin-top:0px; margin-right:0px;  float:left;' method='POST' action='prev.php'>
  <input type='hidden' name='data' value='".base64_decode($_GET['mid'])."'>
  <button type='submit' class='audio_btn' id='previous' name='prev' style='border:none; border:2px solid white; border-radius:50%;  opacity:1; background:none; cursor:pointer; padding:5px 5px; margin-left:5px;'><i class='fa fa-step-backward' style='border:2px solid white; border-radius:50%; padding:5px 5px;  font-size:20px;'></i></button>
  </form>
  ";
  ?>
  <button id='play' class="audio_btn playbtn"  onclick="document.getElementById('songelement').play()"><i style='border:2px solid white; border-radius:50%; padding:10px 10px;  font-size:30px;' class="fa fa-play-circle"></i></button>
  <button  id="pause" class="audio_btn pausebtn" onclick="document.getElementById('songelement').pause()"><i class="fa fa-pause" style="border:2px solid white; border-radius:50%; padding:10px 10px;  font-size:30px;"></i></button>
  <?php
  echo "
  <form method='POST' style='float:right; margin-left:0px; margin-top:0px;' action='next.php'>
  <input type='hidden' id='infodata' name='data' value='".base64_decode($_GET['mid'])."'>
  <button type='submit' name='next' style='border:none; opacity:1; border:2px solid white; cursor:pointer; padding:5px 5px; background:none; border-radius:50%;'><i class='fa fa-step-forward' style='border:2px solid white; border-radius:50%; padding:5px 5px; font-size:20px;'></i></button>
  </form>";
  }else{
    echo "";
  }
}
?>
  </div>
</div>
<div class="lyrics-content-holder">
  <?php
   $image=base64_decode($_GET['mid']);
   $getlyrics="SELECT lyrics FROM user_post WHERE image='$image'";
   $fetchlyric=mysqli_query($conn,$getlyrics);
   if(mysqli_num_rows($fetchlyric) > 0){
     if($row=mysqli_fetch_assoc($fetchlyric)){
      if(empty($row['lyrics'])){
    echo "<h5 style='color:white; font-weight:bold;'>No Lyrics Found For this Song</h5>";
      }else{
      echo "<h4>Song Lyrics</h4>";
      echo "<p>".nl2br($row['lyrics'])."</p> \n";

      }
    }
   }else{
    echo "<h5 style='color:white; font-weight:bold;'>No Lyrics Found For this Song</h5>";
   }
  ?>
</div>
</div>
</div>
<?php 
include_once 'loginfooter.php';
?>
 <script> 
 document.title='Player';
    if(document.title=='Player'){
       $('.info-container').css('display','none');
  }
  </script>
<?php
}elseif (!isset($_COOKIE['user']) && !isset($_GET['mid'])) {
	echo "<script>window.location.href='index.php';</script>";
}
elseif (!isset($_COOKIE['user']) && empty($_GET['mid'])) {
	echo "<script>window.location.href='index.php';</script>";
}
elseif (isset($_COOKIE['user']) && empty($_GET['mid'])) {
	echo "<script>window.location.href='index.php';</script>";
}
elseif (!isset($_COOKIE['user']) && isset($_GET['mid'])) {
	require 'db.php';
		$songid=base64_decode($_GET['mid']);
$sqlstream="SELECT * FROM user_post WHERE image='$songid'";
$resultstream=mysqli_query($conn,$sqlstream);
if($rowstream=mysqli_fetch_assoc($resultstream)){
	$username=$rowstream['username'];
	$hitid=$rowstream['audio'];
	$sql="INSERT INTO streamcount(username,postid) VALUES('$username','$hitid')";
$result=mysqli_query($conn,$sql);
}
?>
<?php
mysqli_close($conn);
}
?>