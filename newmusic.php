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
<div class='container' id='sitecontent'>
<?php
$songdetail=trim(htmlspecialchars(base64_decode($_GET['id'])));
switch ($songdetail) {
	case 'newmusic':
	     echo"<header class='song-list-header'>
	     <span class='pull-right' style='margin-top:20px;'>Genre: <button onclick='controldroplist()' class='btn btn-primary btn-md'>All Genres<span class='caret'></span></button></span>
         <h2 class='header-heading'>Recently Added Music</h2>
         <ul class='list-unstyled floatinglist'>
        <a href='newmusic.php?id=".base64_encode('Rap')."'><li>Rap</li></a>
        <a href='newmusic.php?id=".base64_encode('Soul')."'><li>Soul Music</li></a>
        <a href='newmusic.php?id=".base64_encode('Afropop')."'><li>Afropop</li></a>
	    </ul>
	     </header>";
	     echo"<script type='text/javascript'>
	document.title='Recent Releases | Listen On Instasound9ja';
</script>";
		$fetchnewsongs="SELECT DISTINCT audio,post_day,image,username,caption,genre FROM user_post WHERE audio !='' ORDER BY userpostid DESC ";
		$getnewsongs=mysqli_query($conn,$fetchnewsongs);
		if(mysqli_num_rows($getnewsongs) > 0){
			while ($getnewmusic=mysqli_fetch_assoc($getnewsongs)) {
  $songowner=$getnewmusic['username'];
  $songtitle=$getnewmusic['caption'];
				echo "<div class='song-info-wrapper'>
				<div class='play-btn-holder'>
				<button class='btn btn-sm playnewsongbtn' id='".$getnewmusic['audio']."' onclick=fireplayevent('".$getnewmusic['audio']."','".$getnewmusic['image']."','$songowner')><i class='fa fa-play'></i></button>
				<button class='btn btn-sm playnewsongbtn' style='display:none;' onclick=firepausevent('".$getnewmusic['audio']."','".$getnewmusic['image']."') id='".$getnewmusic['image']."'><i class='fa fa-pause'></i></button>
				</div>
                  <img src='/nmusic/image/".$getnewmusic['image']."' class='newsonglistimg img-thumbnail' />
                  <span class='eighteenem newsongusername'>".$getnewmusic['username']."</span>
                  <span class='eighteenem newsongname'>".$getnewmusic['caption']."</span>
                  <span class='thirteenem newsongdate'>Release Date: ".$getnewmusic['post_day']."
                  </span>";
                  if(empty($getnewmusic['genre'])){
                       echo "<span class='newsongenre'>Genre: <span class='badge badge-info m-2'>Unknown</span></span>";
			
                  }else{
                  	  echo "<span class='newsongenre'>Genre: <span class='badge badge-info m-2'>".$getnewmusic['genre']."</span></span>";
                  }
                  echo "<div class='song-info-list btn-group'>
                      <button class='btn btn-sm btn-default'>".streamcount($getnewmusic['audio'])."</button>
                  </div>";
                  	echo "</div>";
            
			}
		}else{
		echo "<h2>No new music Yet.</h2>";	
		}
		break;
	case 'Rap':
   echo"<header class='song-list-header'>
	     <span class='pull-right' style='margin-top:20px;'>Genre: <button onclick='controldroplist()' class='btn btn-primary btn-md'>Rap<span class='caret'></span></button></span>
         <h2 class='header-heading'>Recently Added Music</h2>
       <ul class='list-unstyled floatinglist'>
        <a href='newmusic.php?id=".base64_encode('newmusic')."'><li>All Genres</li></a>
        <a href='newmusic.php?id=".base64_encode('Soul')."'><li>Soul Music</li></a>
        <a href='newmusic.php?id=".base64_encode('Afropop')."'><li>Afropop</li></a>
	    </ul>
	     </header>";
	     echo"<script type='text/javascript'>
	document.title='Listen To Rap Music | Listen On Instasound9ja';
</script>";
	     $fetchnewsongs="SELECT DISTINCT audio,post_day,image,username,caption,genre FROM user_post WHERE audio !='' AND genre='Rap' ORDER BY userpostid DESC ";
		$getnewsongs=mysqli_query($conn,$fetchnewsongs);
		if(mysqli_num_rows($getnewsongs) > 0){
			while ($getnewmusic=mysqli_fetch_assoc($getnewsongs)) {
				$songowner=$getnewmusic['username'];
  $songtitle=$getnewmusic['caption'];
				echo "<div class='song-info-wrapper'>
				<div class='play-btn-holder'>
				<button class='btn btn-sm playnewsongbtn' id='".$getnewmusic['audio']."' onclick=fireplayevent('".$getnewmusic['audio']."','".$getnewmusic['image']."','$songowner')><i class='fa fa-play'></i></button>
				<button class='btn btn-sm playnewsongbtn' style='display:none;' onclick=firepausevent('".$getnewmusic['audio']."','".$getnewmusic['image']."') id='".$getnewmusic['image']."'><i class='fa fa-pause'></i></button>
				</div>
                  <img src='/nmusic/image/".$getnewmusic['image']."' class='newsonglistimg img-thumbnail' />
                  <span class='eighteenem newsongusername'>".$getnewmusic['username']."</span>
                  <span class='eighteenem newsongname'>".$getnewmusic['caption']."</span>
                  <span class='thirteenem newsongdate'>Release Date: ".$getnewmusic['post_day']."
                  </span><span class='newsongenre'>Genre: <span class='badge badge-info m-2'>".$getnewmusic['genre']."</span></span>
                  <div class='song-info-list btn-group'>
                      <button class='btn btn-sm btn-default'>".streamcount($getnewmusic['audio'])."</button>
                  </div>
                  </div>";
            
			}
		}else{
		echo "<h2>No new music Yet.</h2>";	
		}
		break;
	case 'Soul':
 echo"<header class='song-list-header'>
	     <span class='pull-right' style='margin-top:20px;'>Genre: <button onclick='controldroplist()' class='btn btn-primary btn-md'>R&B<span class='caret'></span></button></span>
         <h2 class='header-heading'>Recently Added Music</h2>
          <ul class='list-unstyled floatinglist'>
        <a href='newmusic.php?id=".base64_encode('Rap')."'><li>Rap</li></a>
        <a href='newmusic.php?id=".base64_encode('newmusic')."'><li>All Genres</li></a>
        <a href='newmusic.php?id=".base64_encode('Afropop')."'><li>Afropop</li></a>
	    </ul>
	     </header>";
	     echo"<script type='text/javascript'>
	document.title='Listen To Soul Music | Listen On Instasound9ja';
</script>";
          $genre="R&b";
	     $fetchnewsongs="SELECT DISTINCT audio,post_day,image,username,caption,genre FROM user_post WHERE audio !='' AND genre='$genre' ORDER BY userpostid DESC ";
		$getnewsongs=mysqli_query($conn,$fetchnewsongs);
		if(mysqli_num_rows($getnewsongs) > 0){
			while ($getnewmusic=mysqli_fetch_assoc($getnewsongs)) {
				$songowner=$getnewmusic['username'];
  $songtitle=$getnewmusic['caption'];
				echo "<div class='song-info-wrapper'>
				<div class='play-btn-holder'>
				<button class='btn btn-sm playnewsongbtn' id='".$getnewmusic['audio']."' onclick=fireplayevent('".$getnewmusic['audio']."','".$getnewmusic['image']."','$songowner')><i class='fa fa-play'></i></button>
				<button class='btn btn-sm playnewsongbtn' style='display:none;' onclick=firepausevent('".$getnewmusic['audio']."','".$getnewmusic['image']."') id='".$getnewmusic['image']."'><i class='fa fa-pause'></i></button>
				</div>
                  <img src='/nmusic/image/".$getnewmusic['image']."' class='newsonglistimg img-thumbnail' />
                  <span class='eighteenem newsongusername'>".$getnewmusic['username']."</span>
                  <span class='eighteenem newsongname'>".$getnewmusic['caption']."</span>
                  <span class='thirteenem newsongdate'>Release Date: ".$getnewmusic['post_day']."
                  </span><span class='newsongenre'>Genre: <span class='badge badge-info m-2'>".$getnewmusic['genre']."</span></span>
                  <div class='song-info-list btn-group'>
                      <button class='btn btn-sm btn-default'>".streamcount($getnewmusic['audio'])."</button>
                  </div>
                  </div>";
            
			}
		}else{
		echo "<h2>No new music Yet.</h2>";	
		}
		break;
	case 'Afropop':
		 echo"<header class='song-list-header'>
	     <span class='pull-right' style='margin-top:20px;'>Genre: <button onclick='controldroplist()' class='btn btn-primary btn-md'>Afropop<span class='caret'></span></button></span>
         <h2 class='header-heading'>Recently Added Music</h2>
          <ul class='list-unstyled floatinglist'>
        <a href='newmusic.php?id=".base64_encode('Rap')."'><li>Rap</li></a>
        <a href='newmusic.php?id=".base64_encode('Soul')."'><li>Soul Music</li></a>
        <a href='newmusic.php?id=".base64_encode('newmusic')."'><li>All Genres</li></a>
	    </ul>	     </header>";
	     echo"<script type='text/javascript'>
	document.title='Listen To Africa Best Songs | Listen On Instasound9ja';
</script>";
          $genre="Afropop";
	     $fetchnewsongs="SELECT DISTINCT audio,post_day,image,username,caption,genre FROM user_post WHERE audio !='' AND genre='$genre' ORDER BY userpostid DESC ";
		$getnewsongs=mysqli_query($conn,$fetchnewsongs);
		if(mysqli_num_rows($getnewsongs) > 0){
			while ($getnewmusic=mysqli_fetch_assoc($getnewsongs)) {
				$songowner=$getnewmusic['username'];
  $songtitle=$getnewmusic['caption'];
				echo "<div class='song-info-wrapper'>
				<div class='play-btn-holder'>
				<button class='btn btn-sm playnewsongbtn' id='".$getnewmusic['audio']."' onclick=fireplayevent('".$getnewmusic['audio']."','".$getnewmusic['image']."','$songowner')><i class='fa fa-play'></i></button>
				<button class='btn btn-sm playnewsongbtn' style='display:none;' onclick=firepausevent('".$getnewmusic['audio']."','".$getnewmusic['image']."') id='".$getnewmusic['image']."'><i class='fa fa-pause'></i></button>
				</div>
                  <img src='/nmusic/image/".$getnewmusic['image']."' class='newsonglistimg img-thumbnail' />
                  <span class='eighteenem newsongusername'>".$getnewmusic['username']."</span>
                  <span class='eighteenem newsongname'>".$getnewmusic['caption']."</span>
                  <span class='thirteenem newsongdate'>Release Date: ".$getnewmusic['post_day']."
                  </span><span class='newsongenre'>Genre: <span class='badge badge-info m-2'>".$getnewmusic['genre']."</span></span>
                  <div class='song-info-list btn-group'>
                      <button class='btn btn-sm btn-default'>".streamcount($getnewmusic['audio'])."</button>
                  </div>
                  </div>";
            
			}
		}else{
		echo "<h2>No new music Yet.</h2>";	
		}
		break;
	default:
	echo "<script>
       window.location.href='home.php';
		</script>";
		break;
}
?>
<div class="audio_player">
  <div id="controller-class">
    <div class="playin-song-details">
    <img id="playing-song-avatar" />
    <p id="playing-song-name"></p>
    <p id="playing-song-title"></p>
  </div>
  <audio id="songelement" onplay="isplaying()" ontimeupdate="updateTrackTime()" onpause="ispaused()" autoplay>

  </audio>
  <div class="control-buttons">
  <button class="audio_btn" id="previous"><i class="fa fa-step-backward" style="font-size:20px;"></i></button>
  <button id="play" class="audio_btn playbtn" onclick="standardplay()"><i class="fa fa-play-circle" style="font-size:30px;"></i></button>
  <button  id="pause" class="audio_btn pausebtn" onclick="standardpause()"><i class="fa fa-pause" style="font-size:30px;"></i></button>
  <button class="audio_btn" id="next"><i class="fa fa-step-forward" style="font-size:20px;"></i></button>
</div>
</div>
<div class="song-timing-holder">
  <span class="text-left starttime" id="currentTime"></span>
  <span class="text-right endtime" id="duration"></span>
</div>
</div>
</div>
</div>
<?php
include_once 'loginfooter.php';
}
?>