 <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
 echo "<script>window.location.href='index.php';</script>";
}else{
date_default_timezone_set('Africa/Lagos');
require 'db.php';
?>
<?php
include_once 'loginheader.php';
include_once '../nmusic/checkcount.php';
include_once '../nmusic/commentcount.php';
include_once '../nmusic/shares.php';
include_once '../nmusic/streamcount.php';
include_once '../nmusic/numberreducer.php';
?>
  
<div class="container-fluid standardprofilediv">
  <div class="container user-profile-holder">
    <div class="user-first-info" id="user-first-info">
      <?php
  $username=$_COOKIE['user'];
  $sql="SELECT coverbg FROM artiste_info WHERE username='$username'";
  $result=mysqli_query($conn,$sql);
  if($row=mysqli_fetch_assoc($result)){
   if($row['coverbg']==''){
    echo "<script>
      $('.user-first-info').css('background-image','url(../nmusic/bg/default.jpg)');
      $('.user-first-info').css({'background-repeat':'no-repeat', 'background-position':'center','background-attachment':'scroll','object-fit':'center', 'background-size':'cover'});
    </script>";
   }else{
   
echo "<script>
      $('.user-first-info').css('background-image','url(../nmusic/bg/".$row['coverbg'].")');
      $('.user-first-info').css({'background-repeat':'no-repeat', 'background-position':'50% 50%','background-attachment':'scroll','object-fit':'center', 'background-size':'cover'});
    </script>";
    
   }
  }
  ?>
  <?php
  $username=$_COOKIE['user'];
    $sql="SELECT profile_pic FROM artiste_info WHERE username='$username'";
    $result=mysqli_query($conn,$sql);
     if($row=mysqli_fetch_assoc($result)){
      if($row['profile_pic']==''){
      echo "<img src='/nmusic/profilepic/default.jpg' class='main-pic thumbnail img-responsive pull-left'>";
      }else{
        echo "<img src='/nmusic/profilepic/".$row['profile_pic']."' class='main-pic thumbnail img-responsive pull-left'>";
      }
     }

  ?>
  <span class="profile-heading-name"><?php echo ucfirst($_COOKIE['user']);  ?> </span>
  </div>
  <div class="user-full-info">
   <div class="main-artiste-info">
    <ul style="flex-grow:2; flex-shrink:1; flex-basis:80%;" class="list-inline list-unstyled artiste-infos">
      <li>All</li>
     <li><?php echo "<a href='profile.php?user=".base64_encode($_COOKIE['user'])."'>"; ?>Tracks</a></li>
      <li>Playlist</li>
      <li>Reposts</li>
      <li onclick='$(".edit-profile-div").css("display","block");'>Edit Profile</li>
    </ul>
    <button style="margin-right:5px; width:100px; height:40px; margin-left:auto;" class="btn btn-md btn-primary" onclick="popup()">Create Post</button>
</div>
    <div class="user-posts-container">
      <div class="posts">
        <?php
$username=$_COOKIE['user'];
if(isset($_GET['user'])){
$username=base64_decode($_GET['user']);
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
  echo streamcount($row['audio']);
  echo checkcount($row['post_day']);
  echo commentcount($row['post_day']);
   echo shares($row['post_day']);
   echo "<p style='font-size:10px; color:lightgrey; clear:both; font-weight:500;'>".time_ago_in_php($row['post_day'])."</p>";
    echo"
    </div>";
}
}else{
  echo "<h3>Click the create post button to upload a song.</h3>";
}
}else{
     $sql="SELECT * FROM user_post INNER JOIN artiste_info ON user_post.username=artiste_info.username WHERE user_post.username='$username' AND user_post.status !='shared' OR user_post.sharer='$username'  ORDER BY user_post.userpostid DESC LIMIT 5";
     $result=mysqli_query($conn,$sql);
     if(mysqli_num_rows($result) > 0){
    while($row=mysqli_fetch_assoc($result)){
      if($row['image']=='' && $row['profile_pic']=='' && $row['audio']=='' && $row['colorbg']=='white'){
       echo "<div class='text-posts'>
       <header class='description-header'>
       <img src='/nmusic/profilepic/default.jpg' id='post-profile-pic'>
       <span class='name-font' style='margin-top:0px; font-weight:bold;'>".$row['username']."</span>
       </header>
           <p class='text-posts-caption'>".nl2br(htmlspecialchars($row['caption']))."</p>
       </div>";
      }elseif ($row['image']=='' && $row['profile_pic']!='' && $row['colorbg']=='white') {
       echo "<div class='text-posts'>
       <header class='description-header'>
       <img src='/nmusic/profilepic/".$row['profile_pic']."' id='post-profile-pic'>
       <span class='name-font' style='margin-top:0px; font-weight:bold;'>".$row['username']."</span>
       </header>
            <p class='text-posts-caption'>".nl2br(htmlspecialchars($row['caption']))."</p>
       </div>";
      }
    }
      }else {
        echo "<h3 class='text-center'>NO POSTS YET</h3>";
      }
    }
        ?>
      </div>
      <div class="user-info-container">
    <div class="followers-profile">
   <figure><?php
    $username=$_COOKIE['user'];
  $sql="SELECT count(caption) AS total FROM user_post WHERE username='$username' AND status !='shared'";
  $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
      if($row['total'] > 1){
        echo $row['total']."<figcaption>Posts</figcaption>";
      }else{
        echo number_format_short($row['total'])."<figcaption>Post</figcaption>";
      }
    }
  ?></figure>
  <figure class='users_click' onclick='document.getElementById("follower-box").style.display="block"'><?php 
    $username=$_COOKIE['user'];
  $sql="SELECT count(follower) AS total FROM followership WHERE following='$username'";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
      if($row['total'] > 1){
        echo $row['total']."<figcaption>Followers</figcaption>";
      }else{
        echo number_format_short($row['total'])."<figcaption>Follower</figcaption>";
      }
    }
  ?></figure>
  <figure class='user_click' onclick='document.getElementById("following-box").style.display="block"'><?php 
    $username=$_COOKIE['user'];
  $sql="SELECT count(following) AS total FROM followership WHERE follower='$username'";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
      if($row['total'] > 1){
        echo $row['total']."<figcaption>Following</figcaption>";
      }else{
        echo number_format_short($row['total'])."<figcaption>Following</figcaption>";
      }
    }
  ?></figure>
</div>
<?php
    $username=$_COOKIE['user'];
   $sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
    if($row['user_bio']==''){

echo "<p style=' margin-top:20px; font-size:14px; text-align:center; font-family:arial;
        '>Customise Your Profile and add your User Bio</p>";

    }else{
        echo "<p class='bio-holder' style=' margin-top:20px; font-size:14px; text-align:center; font-family:arial;
        '>Bio:  ".$row['user_bio']."</p>";
        
    }
   }
    ?>
      </div>
    </div>
  </div>
  </div>
</div>
  <div class="black-div">
    <span class="pull-right" onclick="cancelbox()" style="font-size:50px; margin-right:20px; cursor:pointer; color:red;">&times;</span>
  <div class="upload-form-div">
     <h4 class="text-center" id="manipulate-header">Upload a new song or click this to</h4><center><button id="manipulate-btn" onclick="hidemusicForm()">Talk to fans</button></center>
    <?php echo"<form method='POST' id='upload-text-form' action='../nmusic/user_post.php' class='ajax' >
    <center><textarea id='maintext' name='text' onkeydown='checkcolors()'  style='resize:none; width:300px; margin-top:5px; border:1px solid lightgrey; padding-top:4px; padding-left:4px;' placeholder='Talk to Fans....'></textarea></center>
    <input type='hidden' id='colorloop' name='colorscheme' value='white'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <center><button type='submit' name='post_text' id='post-fan-button'>Post</button></center></form>";
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
  function streamcount(){
  
}
  </script>
    <form method="POST" id="upload-song-form" enctype='multipart/form-data'>
      <div class="music-upload">
        <h5 class="text-center">Add Song Title</h5>
    <textarea id='audio_content' name='description' style='resize:none; box-sizing:border-box; width:100%;  margin-top:5px; height:35px;' placeholder='Example:Love in the moon'>
    </textarea>
        <h5 class="text-center" style="font-weight:bold;">Click on this icon to open audio file (Mp3 Only)</h5>
      <label for="file-input">
        <i class="fa fa-headphones" style="color:blue; cursor:pointer; font-size:30px;" onclick="openfile()" /></i>
        <p id="audiofiledetails"></p>
      </label><br /><br />
      <label for="file-input">
         <i class="fa fa-image" style="color:blue; cursor:pointer; font-size:30px;" onclick="openimage()"></i>
         <p id="imagefiledetails"></p>
      </label>
        <h5 class="text-center" style="font-weight:bold;">Click on this icon to open song coverart or image (Png,jpg,jpeg)</h5>
      <input type="file"  name="audio" id="audio_song" />
      <input type='file'  id='audio_image' name='image' />
      <h5>Song Lyrics (Optional)</h5>
       <textarea name="lyrics" id="lyrics-bar"  style="resize:none; box-sizing:border-box; width:100%; margin-top:5px; height:100px; margin-bottom:5px;"></textarea>
      <button type="submit" name="upload_audio" class="btn btn-block btn-primary btn-md">Upload</button>
    </div>
    </form>
    <?php
if(isset($_POST['upload_audio'])){
if(empty($_POST['description'])){
  echo "<script>alert('Please Include Song description In form');</script>";
}else{
$username=$_COOKIE['user'];
$getgenre="SELECT genre FROM artiste_info WHERE username='$username'";
$queryreq=mysqli_query($conn,$getgenre);
if($getreq=mysqli_fetch_assoc($queryreq)){
$GLOBALS['usergenre'] = $getreq['genre'];
}
$genre=$GLOBALS['usergenre'];
$day=date('Y-m-d H:i:s');
$caption=htmlspecialchars(ucwords(str_replace("'", "", $_POST['description'])));
$lyrics=htmlspecialchars($_POST['lyrics']);
$imagename=$_FILES['image']['name'];
$imagesize=$_FILES['image']['size'];
$imagetype=$_FILES['image']['type'];
$imageerror=$_FILES['image']['error'];
$imagetmp=$_FILES['image']['tmp_name'];
$imageext=explode(".", $imagename);
$imagerealname=strtolower(end($imageext));
$audioname=$_FILES['audio']['name'];
$audiosize=$_FILES['audio']['size'];
$audiotype=$_FILES['audio']['type'];
$audioerror=$_FILES['audio']['error'];
$audiotmp=$_FILES['audio']['tmp_name'];
$audioext=explode(".", $audioname);
$audiorealname=strtolower(end($audioext));
$allowed=array('jpg','jpeg','png','PNG','JPG','JPEG');
$songarray=array('mp3','wav');
if(in_array($imagerealname,$allowed) && in_array($audiorealname,$songarray)){
if($imagesize < 1000000){
if($imageerror===0 && $audioerror===0){
$audionamenew=uniqid('',true).".".$audiorealname;
$imagenamenew=uniqid('',true).".".$imagerealname;
$audiodir='../nmusic/audio/'.$audionamenew;
$imagedir='../nmusic/image/'.$imagenamenew;
$sql="INSERT INTO user_post(username,caption,image,post_day,audio,genre,lyrics) VALUES(?,?,?,?,?,?,?)";
 $stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
  echo "Sorry Something Went Wrong";
}else{
  mysqli_stmt_bind_param($stmt,"sssssss",$username,$caption,$imagenamenew,$day,$audionamenew,$genre,$lyrics);
  mysqli_stmt_execute($stmt);
  move_uploaded_file($audiotmp, $audiodir);
move_uploaded_file($imagetmp, $imagedir);

}
$sql1="SELECT follower FROM followership WHERE following='$username'";
$result1=mysqli_query($conn,$sql1);
while($row1=mysqli_fetch_assoc($result1)){
  $owner=$row1['follower'];
  $sql2="INSERT INTO notifications(sender,details,owner,status,day,location,unique_id)VALUES('$username','$username uploaded a new song','$owner',0,'$day','audio','$imagenamenew');";
  $result2=mysqli_query($conn,$sql2);
}
echo "<script>alert('Song Uploaded Sucessfuly');</script>";
 echo "<script>
  window.location.href='profile.php';
</script>";
}else{
  echo "<script>alert('We can't Upload the image and song on our site wrong format in production');</script>";
  echo "<script>
  window.location.href='profile.php';
  </script>";
  
}
}else{
    echo"<script>alert('Please Resize the image or reduce the size of song in studio');</script>";
    echo "<script>
  window.location.href='profile.php';
  </script>";
}
}else{
  echo "<script>alert('Image and audio can only be png,jpg,mp3 and wav format');</script>";
    echo "<script>
  window.location.href='profile.php';
  </script>";
  
}
}

}

?>
  </div>
  </div>
  <div class='edit-profile-div'>
  <button id='hideedit' style='background:none; border:none; cursor:pointer; margin-top:8px; ' onclick='$(".edit-profile-div").css("display","none"); '><i style="color:white;" class='fa fa-arrow-left' style='font-size:20px;'></i></button>
    <h2 style="text-align:center; font-size:20px; color:white; font-weight:bold;">Edit profile</h2>
  <div style='margin-top:10px; padding:4px 4px;'><form method='POST' action='../nmusic/bio.php' class='ajax'>
    <?php echo"<input type='hidden' name='username' value='".$_COOKIE['user']."'>"; ?>
    <center>
    <textarea placeholder='Write bio.....' name='bio' class='bioarea' onkeydown='raisebutton()'  style='resize:none;  font-size:15px; color:white; background:#333; box-sizing:border-box; border:none; padding-top:4px; border-bottom:2px solid lightgrey; width:100%;'><?php
   $sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
    if($row['user_bio']==''){

echo "Type your bio(Cannot be greater than 140 characters)";

    }else{
      echo $row['user_bio'];
      
    }
   }
  ?></textarea>
    <button id='update-bio-button' type='submit' name='bio-update' style='display:none; width:100%; margin-top:0px; padding:4px 4px; box-sizing:border-box; background:none; border-radius:5px; border:none; border:1px solid black; cursor:pointer; color:white; margin-bottom:10px;'>Update bio</button>
</center></form></div>

    <button class='coverButton' style='border:none; margin-top:0px; background:none; padding:4px 4px; border:1px solid black; margin-bottom:10px; color:white; cursor:pointer; box-sizing:border-box; border-radius:5px; width:100%;' onclick='showbg()'>Cover Photo</button>
  <?php
  echo "<form method='POST' class='bgform' style='margin-top:5px; display:none;' action='../nmusic/bg.php' enctype='multipart/form-data'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='file' name='file'><br />
<button type='submit' name='coverbg' style='margin-top:5px; color:white;  padding:5px 5px; border:none; background:none;  border:1px solid black; margin-bottom:10px; border-radius:5px;  cursor:pointer; width:100%;'>Update Coverphoto</button>
  </form>";

  ?>
  <button class='edit-profile-button'>Change Profilepic</button>
  <form method='POST' id='editpic-form'  style='display:none; margin-top:5px;'  enctype='multipart/form-data' action='<?php echo htmlspecialchars('../nmusic/changepic.php');  ?>'>
  <input type='hidden' name='username' value='<?php echo $_COOKIE['user']; ?>'>
  <input type='file' name='file' value='file' id='file-browse'><br />
  <button type='submit' name='update' id='update'>Update Profiepic</button>
</form>
    <script type="text/javascript">
  $(".edit-profile-button").click(function(){
  $(".edit-profile-button").css('display','none');
   $("#editpic-form").css('display','block');
  });
  </script>
  <?php
  $status=$_COOKIE['user'];
  $checkusercountry="SELECT country FROM artiste_info WHERE username='$status'";
  $fetchquery=mysqli_query($conn,$checkusercountry);
  if($row=mysqli_fetch_assoc($fetchquery)){
    if($row['country']==''){
      echo "<h2 style='margin-bottom:0px; color:white; font-size:20px; font-weight:bold; margin-left:5px; ''>Country</h2>
  <form method='POST' action='../nmusic/update_location.php'>
  <select  name='country' style='box-sizing:border-box; width:100%; border-radius:5px;'>
    <option  value='country'>Country</option>
    <option  value='Nigeria'>Nigeria</option>
    <option  value='Ghana'>Ghana</option>
    <option  value='Kenya'>Kenya</option>
    <option  value='Tanzania'>Tanzania</option>
    <option  value='Cameroon'>Cameroon</option>
  </select>
  <button type='submit' name='countryupdate' style='border:none; background:black; font-weight:normal; padding:4px 4px; box-sizing:border-box; cursor:pointer; color:white; border:1px solid black; border-radius:5px; margin-left:2px;'>Update Country</button>
</form>";
    }else{
      echo "";
    }
  }
  ?>
  <?php
  $status=$_COOKIE['user'];
  $checkusercountry="SELECT genre FROM artiste_info WHERE username='$status'";
  $fetchquery=mysqli_query($conn,$checkusercountry);
  if($row=mysqli_fetch_assoc($fetchquery)){
    if($row['genre']==''){
  echo"<h2 style='margin-bottom:0px; color:white; font-size:20px; font-weight:bold; margin-left:5px;'>Music Genre / Category</h2>
  <form method='POST' action='../nmusic/update_genre.php'>
  <select name='genre' style='box-sizing:border-box; width:100%; border-radius:5px;'>
    <option  value='Rap'>Rap</option>
    <option  value='R&b'>R&B / Soul</option>
    <option  value='Afropop'>Afropop</option>
    <option  value='Instrumentalist'>Instrumentalist</option>
    <option value='null'>I don't sing</option>

  </select>
  <button type='submit' name='genreupdate' style='border:none; background:black; font-weight:normal; padding:4px 4px; box-sizing:border-box; cursor:pointer; color:white; border-radius:5px; border:1px solid black; margin-left:2px;'>Update</button>
</form>";
}else{
echo "";
}
}
?>
</div>
<div class='following-box' id='following-box'>
  <span style='color:white; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px; color:white;'>Following</span>
  
  <?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username WHERE followership.follower='$username' ORDER BY followership.id desc LIMIT 30";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
  if($row['profile_pic']=='' && $row['username']!='Superuser'){
echo "<ul class='following-list'>
  <li id='".$row['following']."'><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
  <input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
  <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
  <button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
  </form></li><br />
  </ul>";
  }
  elseif ($row['profile_pic']=='' && $row['username']=='Superuser') {
    echo "<ul class='following-list'>
  <li id='".$row['following']."'><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a></li><br />
  </ul>";
  }
  elseif ($row['profile_pic']!='' && $row['username']=='Superuser') {
    echo "<ul class='following-list'>
  <li id='".$row['following']."'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a></li><br />
  </ul>";
  }
  else{
    echo "<ul class='following-list'>
  <li id='".$row['following']."'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
  <input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
  <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
  <button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
  </form></li><br />
  </ul>";
  }
  
}
}else{
echo "<p style='text-align:center; font-size:15px; font-weight:bold; margin-top:10px;'>Follow people to stream their songs and get more followers</p>";
}

  ?>
  
</div>
<div class='follower-box' id="follower-box" >
  <span style='color:white; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px; color:white;'>Followers</span>
  <?php echo"<form method='POST' style='margin-top:5px;'>
    <input type='hidden' id='main' name='username' value='".$_COOKIE['user']."'>
    <textarea name='search'  onclick='showfollowerResponse()' id='tofind' value='' onkeydown='checkfollowers()' style='resize:none; width:100%; border:none; height:30px;border:1px solid lightgrey; padding:4px 4px;' placeholder='Search followers'></textarea>
  </form>"; 

  ?>
<div id='followers-response' onclick='hideresponsebox()' class='follower-res' style='position:fixed; margin-top:0px; display:none; height:100%;  padding:4px 4px; width:100%; opacity:0.8;   color:white; z-index:1; background:black;'>
</div>
  <script>
  function checkfollowers(){
 $.ajax({
  url:'findfollowers.php',
  type:'POST',
  data:{user:$("#tofind").val(),
  current:$("#main").val()
},
  success:function(response){
  $("#followers-response").html(response)
  }
});
  }
  function showfollowerResponse(){
    $("#followers-response").css('display','block');
  }
  function hideresponsebox(){
    $(".follower-res").css('display','none');
  }
  </script>
  <?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.follower=artiste_info.username WHERE followership.following='$username' ORDER BY followership.id desc LIMIT 30";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
$tounfollow=$row['follower'];
$sql3="SELECT follower FROM followership WHERE follower='$username' AND following='$tounfollow'";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){
if($row['profile_pic']==''){
echo "<ul class='following-list'>
  <li id='".$row['follower']."'><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".$row['follower']."'>
  <input type='hidden' name='following' value='".$row['follower']."'>
  <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
  <button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  id='unfollow-button'>unfollow</button>
  </form></li><br />
  </ul>";
}else{
  echo "<ul class='following-list'>
  <li id='".$row['follower']."'><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form'  action='unfollow.php' class='ajax' value='".$row['follower']."'>
  <input type='hidden' name='following' value='".$row['follower']."'>
  <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
  <button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  name='unfollow' id='unfollow-button'>unfollow</button>
  </form></li><br />
  </ul>";
}
}else{
  if($row['profile_pic']==''){
echo "<ul class='following-list'>
  <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' class='ajax'  style='float:right; margin-top:10px;' action='follow.php'>
  <input type='hidden' name='following' value='".$row['follower']."'>
  <input type='hidden' name='username' value='".$_COOKIE['user']."'>
  <button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
  </form></li><br />
  </ul>";
  }else{
    echo "<ul class='following-list'>
  <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' class='ajax' style='float:right;  margin-top:10px;' action='follow.php'>
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
</div>
<script type="text/javascript" src='script/getfollowers.js'></script>
<script type="text/javascript">
$('form.bio').on('submit' ,function(){
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
$('.close-bar').click(function(){
$(".side-bar").css('display','none');
$(".main-profile").css('margin-left','auto');
$("#postarea").css('margin-left', 'auto');


});
function showbox(){
  $("#edit-bio-button").css('display','none');
  $("#user-bio-form").css('display','block');
}
function sidebar(){
$(".side-bar").css('display','block');
  $(".side-bar").css('width','250px');
  $(".main-profile").css('margin-left','250px');
$("#postarea").css('margin-left', '250px'); 
}
function raisebutton(){
  $("#update-bio-button").css('display','block');
}
function showbg(){
  $(".bgform").css('display','block');
  $(".coverButton").css('display','none');
}
</script>
<script type='text/javascript'>
  document.title='Profile';
    if(document.title=='Profile'){
       $(".info-container").css('display','none');
  }
  function openfile(){
    document.getElementById("audio_song").click();
    let fileinfo=$("#audio_song").val();
    $("#audiofiledetails").html(fileinfo);
  }
   function openimage(){
    document.getElementById("audio_image").click();
    let fileinfo=$("#audio_image").val();
    $("#imagefiledetails").html(fileinfo);
  }
 
function popup(){
  $(".black-div").css('display','block');
}
function cancelbox(){
  $(".black-div").css('display','none');
}
function hidemusicForm(){
  $("#upload-text-form").css("display","block");
  $("#upload-song-form").css("display","none");
    let changeheader=document.getElementById("manipulate-header");
  changeheader.innerHTML="Upload a new song click this to";
  let changebtnattr=document.getElementById("manipulate-btn");
  changebtnattr.innerHTML="Upload Music";
  changebtnattr.setAttribute("onclick","resetButton()");
}
function resetButton(argument) {
  $("#upload-text-form").css("display","none");
  $("#upload-song-form").css("display","block");
    let changebtnattr=document.getElementById("manipulate-btn");
     changebtnattr.innerHTML="Talk to fans";
     let changeheader=document.getElementById("manipulate-header");
  changeheader.innerHTML="Upload a new song or click this and";

  changebtnattr.setAttribute("onclick","hidemusicForm()");
}
  function hidebox(){
    $(".following-box").css("display","none");
    $(".follower-box").css('display','none');
  }
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