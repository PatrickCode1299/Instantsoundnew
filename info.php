 <?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
 echo "<script>window.location.href='home.php';</script>";
}elseif (!isset($_GET['id'])) {
  echo "<script>window.location.href='home.php';</script>";
}elseif (is_numeric($_GET['id'])) {
 echo "<script>window.location.href='home.php';</script>";
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
  $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
  $sql="SELECT coverbg FROM artiste_info WHERE username='$username'";
  $result=mysqli_query($conn,$sql);
  if($row=mysqli_fetch_assoc($result)){
   if($row['coverbg']==''){
    echo "<script>
      $('.user-first-info').css('background-image','url(bg/default.jpg)');
      $('.user-first-info').css({'background-repeat':'no-repeat', 'background-position':'center','background-attachment':'scroll','object-fit':'center', 'background-size':'cover'});
    </script>";
   }else{
   
echo "<script>
      $('.user-first-info').css('background-image','url(bg/".$row['coverbg'].")');
      $('.user-first-info').css({'background-repeat':'no-repeat', 'background-position':'50% 50%','background-attachment':'scroll','object-fit':'center', 'background-size':'cover'});
    </script>";
    
   }
  }
  ?>
  <?php
    $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
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
  <span class="profile-heading-name"><?php echo ucfirst($username);  ?> </span>
  </div>
  <div class="user-full-info">
   <div class="main-artiste-info">
    <ul class="list-inline list-unstyled artiste-infos">
      <li>All</li>
      <li onclick="fetchTracks()">Tracks</li>
      <li>Playlist</li>
      <li>Reposts</li>
    </ul>
    <?php
       $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
       echo "
       <input type='hidden' id='userdata' name='user' value='".$username."'>
    ";
   $current=$_COOKIE['user'];
   if($username=='Superuser'){
    echo "";
   }else{
    $sql6="SELECT * FROM followership WHERE follower='$current' AND following='$username'";
$result6=mysqli_query($conn,$sql6);
if(mysqli_num_rows($result6) > 0){

echo "<form method='POST' style='float:right; margin-top:2px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))."'>
    <input type='hidden' name='following' value='".base64_decode($_GET['id'])."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))."'  id='unfollow-button' style='margin-top:0px;'>unfollow</button>
    </form>";
}else{
echo"<form method='POST' class='ajax'  style='float:right; margin-top:2px; margin-bottom:0px;' action='follow.php'>
    <input type='hidden'   name='following' value='".base64_decode($_GET['id'])."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit'  name='follow' class='".base64_decode($_GET['id'])."' id='unfollow-button' style='margin-top:0px;'>follow</button>
    </form>";
}
   }
 
echo"<form style='display:none;'>
<input type='hidden' id='infodata' name='nothing' value='".base64_decode($_GET['id'])."'>
</form>";

      ?>
</div>
    <div class="user-posts-container">
      <div class="posts">
        <?php
  $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
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
      }else{
        echo "<h3></h3>";
      }


        ?>
      </div>
      <div class="user-info-container">
    <div class="followers-profile">
   <figure><?php
      $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
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
  <figure class='users_click' onclick='showfollower()'><?php 
      $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
  $sql="SELECT count(follower) AS total FROM followership WHERE following='$username'";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
      if($row['total'] > 1){
        echo $row['total']."<figcaption>Fans</figcaption>";
      }else{
        echo number_format_short($row['total'])."<figcaption>Fan</figcaption>";
      }
    }
  ?></figure>
  <figure class='user_click' onclick='showfollowing()'><?php 
      $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
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
      $username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
   $sql="SELECT user_bio FROM artiste_info WHERE username='$username'";
   $result=mysqli_query($conn,$sql);
   if($row=mysqli_fetch_assoc($result)){
    if($row['user_bio']==''){

echo "<p style=' margin-top:20px; font-size:14px; text-align:center; font-family:arial;
        '>This user does not have a bio</p>";

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
  <img src="css/loading.gif" id="popimage" style="position:fixed; display:none; margin:0 auto; left:50px; right:50px; top:50px;" width="100px" height="100px">
</div>
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

  function fetchTracks(e){
  $.ajax({
      url:'fetchtracks.php',
      beforeSend: function (){
        $("#popimage").show();
      },
      complete: function(){
        $("#popimage").hide();
      },
      type:'POST',
      async:true,
     data:{data:$("#userdata").val()},
     success:function(response){
 $(".posts").append(response);
  }

  });
      e.stopImmediatePropagation();
}

  </script>
  </div>
  </div>
  <div class="follower-box" id="follower-box">
        <span style='color:black; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px;'>Followers</span>
    <?php echo"<form method='POST' style='margin-top:5px;'>
    <input type='hidden' id='main' name='username' value='".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))."'>
    <textarea name='search' onclick='showfollowerRes()' id='tofind' value='' onkeydown='checkfollowers()' style='resize:none; width:100%; border:none; height:30px;border:1px solid lightgrey; padding:4px 4px;' placeholder='Search ".mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])))." followers'></textarea>
    </form>"; 

    ?>
<div id='followers-response' onclick='hidefollowresponsebox()' class='following-res' style='position:fixed; display:none; height:100%;  padding:4px 4px; width:100%; opacity:0.8;   color:white; z-index:1; background:black;'>
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
    function showfollowerRes(){
        $("#followers-response").css('display','block');
    }
    function hidebox(){
        $("#follower-box").css('display','none');
        $("#following-box").css('display','none');
    }
    function hidefollowresponsebox(){
            $(".following-res").css('display','none');
    }
    </script>
    <?php
$username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
$currentname=$_COOKIE['user'];
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.follower=artiste_info.username WHERE followership.following='$username' ORDER BY followership.follower desc LIMIT 30";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
$tounfollow=$row['follower'];
$sql3="SELECT follower FROM followership WHERE follower='$currentname' AND following='$tounfollow'";
$result3=mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3) > 0){
$clearusername=$_COOKIE['user'];
if($row['profile_pic']=='' && $row['username']!=$clearusername){
echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form' action='unfollow.php' class='ajax'  value='".$row['follower']."'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
}
elseif ($row['profile_pic']!='' && $row['username']!=$clearusername) {
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' id='unfollow-form'  action='unfollow.php' class='ajax' value='".$row['follower']."'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['follower']."'  name='unfollow' id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
}
elseif ($row['profile_pic']!='' && $row['username']==$clearusername) {
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
else{
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
}else{
    $clearusername=$_COOKIE['user'];
    if($row['profile_pic']==''&& $row['username']!=$clearusername){
echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }elseif($row['profile_pic']!='' && $row['username']!=$clearusername){
        echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['follower'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['follower']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['follower']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['follower']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }
    elseif ($row['profile_pic']!='' && $row['username']==$clearusername) {
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
else{
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['follower']."</span></a></li><br />
    </ul>";
}
}
}
}else{
    echo "<p style='text-align:center;'><b>No Ones Feeling this user yet</b></p>";
}

    ?>

</div>
<div class="following-box" id="following-box">
          <span style='color:black; margin-left:10px;  cursor:pointer; ' onclick='hidebox()'><i class='fa fa-arrow-left' style='font-size:20px;'></i></span><span style='margin-left:5px;'>Following</span>
    <?php echo"<form method='POST' style='margin-top:5px;'>
    <input type='hidden' id='maintwo' name='username' value='".base64_decode($_GET['id'])."'>
    <textarea name='search' onclick='showfollowerResponse()' id='tofindtwo' value='' onkeydown='checkfollowing()' style='resize:none; width:100%; border:none; height:30px;border:1px solid lightgrey; padding:4px 4px;' placeholder='Search following'></textarea>
    </form>"; 

    ?>
<div id='following-response' class='follower-res' onclick='hideresponsebox()' style='position:fixed; display:none; height:100%;  padding:4px 4px; width:100%; opacity:0.8;   color:white; z-index:1; background:black;'>
</div>
    <script>
    function checkfollowing(){
 $.ajax({
    url:'findfollowing.php',
    type:'POST',
    data:{followinguser:$("#tofindtwo").val(),
    mainuser:$("#maintwo").val()
},
    success:function(response){
  $("#following-response").html(response)
    }
});
    }
    function showfollowerResponse(){
        $("#following-response").css('display','block');
    }
    function hidebox(){
        $("#follower-box").css('display','none');
        $("#following-box").css('display','none');
    }
    function hideresponsebox(){
        $(".follower-res").css('display','none');
    }
    </script>
    <?php
$username=mysqli_real_escape_string($conn,htmlspecialchars(base64_decode($_GET['id'])));
$sql="SELECT * FROM followership INNER JOIN artiste_info ON followership.following=artiste_info.username WHERE followership.follower='$username' ORDER BY followership.following desc LIMIT 30";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
    $tounfollow=$row['following'];
    $current=$_COOKIE['user'];
    $sql2="SELECT following FROM followership WHERE follower='$current' AND following='$tounfollow'";
    $result2=mysqli_query($conn,$sql2);
    if(mysqli_num_rows($result2) > 0){
 if($row['username']==$_COOKIE['user'] && $row['profile_pic']==''){
 echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']==$_COOKIE['user'] && $row['profile_pic'] !='') {
         echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']!=$_COOKIE['user'] && $row['profile_pic'] ==''){
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
    <input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
    }else{
  echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a><form method='POST' value='".$row['following']."' id='unfollow-form' class='ajax' action='unfollow.php'   style='float:right; margin-top:10px;'>
    <input type='hidden' id='unfollow-details' name='following' value='".$row['following']."'>
    <input type='hidden' name='follower' value='".$_COOKIE['user']."'>
    <button type='submit' name='unfollow' onclick='callaction()' class='".$row['following']."' id='unfollow-button'>unfollow</button>
    </form></li><br />
    </ul>";
    }
    }else{
 if($row['username']==$_COOKIE['user'] && $row['profile_pic']==''){
 echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']==$_COOKIE['user'] && $row['profile_pic'] !='') {
         echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='profile.php'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:black;'>".$row['following']."</span></a></li><br />
    </ul>";
    }elseif($row['username']!=$_COOKIE['user'] && $row['profile_pic'] ==''){
    echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/default.jpg' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['following']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['following']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }else{
  echo "<ul class='following-list'>
    <li><img src='../nmusic/profilepic/".$row['profile_pic']."' id='following-profile-pic'><a href='info.php?id=".base64_encode($row['following'])."'><span style='margin-left:2px; margin-top:20px; display:inline-block; font-weight:bold; color:white;'>".$row['following']."</span></a><form method='POST' style='float:right; margin-top:10px;' class='ajax' action='follow.php'>
    <input type='hidden' name='following' value='".$row['following']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit' name='follow' class='".$row['following']."' id='unfollow-button'>follow</button>
    </form></li><br />
    </ul>";
    }
    }
   
  
}
    ?>
</div>
<script type="text/javascript">
    function showfollowing(){
        $(".following-box").css('display','block');
    }
    function showfollower(){
        $(".follower-box").css('display','block');
    }

</script>
<script type='text/javascript'>
  document.title='Info';
    if(document.title=='Info'){
       $(".info-container").css('display','none');
  }
</script>

<?php
mysqli_close($conn);
}
?>