<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	echo "<script>window.location.href='index.php';</script>";
}
elseif (!isset($_GET['mid']) || !isset($_GET['unique_id'])) {
echo "<script>window.location.href='index.php';</script>";
}elseif (is_numeric($_GET['mid'])|| is_numeric($_GET['unique_id'])) {
	echo "<script>window.location.href='index.php';</script>";
}
else{
require 'db.php';
?>
<?php
include_once 'loginheader.php';
?><br /><br />
<?php
$username=$_COOKIE['user'];
$unique_id=base64_decode($_GET['unique_id']);
$sql="UPDATE chat SET status=1 WHERE  unique_id='$unique_id' AND reciever='$username'";
$result=mysqli_query($conn,$sql);
?>
<div class='chat-holder' style="box-sizing:border-box;   width:100%; position:absolute;">
	<button id='recent-button' style='background:none; float:left; border:none; cursor:pointer; margin-top:20px; margin-left:10px; margin-bottom:5px;' onclick='sidebar()'>
		<span id='nav'></span>
		<span id='nav'></span>
		<span id='nav'></span>
	</button>
<h6><?php $mid=base64_decode($_GET['mid']); 
echo $mid; ?><span class='dholder' onclick='showSettings()' style='color:red; cursor:pointer; float:right;'><i class='fa fa-ellipsis-v' style='font-size:18px;'></i></span></h6>
<div class='dialog' style='display:none;'>
	
	<span style='padding-top:10px; padding-left:5px; cursor:pointer; display:block; ' onclick='showWallpaper()'>Wallpaper</span>
	<span style='padding-top:10px; padding-left:5px; display:block; cursor:ponter; '>Chatcolors</span>
	
</div>

<script type="text/javascript">
function showSettings(){
	$(".dialog").css('display','block');
}
function showWallpaper(){
	$(".wallpaper").css('display','block');
	$(".dialog").css('display','none');
}
$(document).click(function(){
$('.dialog').css('display','none');
});
$(".dholder").click(function(e){
e.stopPropagation();
return false;
});
$(".dialog").click(function(e){
e.stopPropagation();
return false;
});
$(document).click(function(){
$('.recent-messages-bar').css('display','none');
});
$(".recent-messages-bar").click(function(e){
e.stopPropagation();
return false;
});
$("#recent-button").click(function(e){
e.stopPropagation();
return false;
});
</script>
<?php
$sql="SELECT * FROM chat INNER JOIN artiste_info ON chat.username=artiste_info.username WHERE chat.unique_id='$unique_id' ORDER BY chat.id asc";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$person=$_COOKIE['user']; 
	if($row['username']!=$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='sender'><img src='/nmusic/profilepic/default.jpg' id='inbox-pic'><p id='inbox-message'>".$row['message']."</p> <p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic'] !='' && $row['image']=='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''  ) {
	echo "<div class='sender'><img src='/nmusic/profilepic/".$row['profile_pic']."'  id='inbox-pic'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; font-size:11px; font-weight:400; color:white; clear:both;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic']=='' && $row['image'] !='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='sender-img'><img src='/nmusic/chat/".$row['image']."' id='inbox-sent-image' style='display:block; width:100%; height:auto;'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic'] !='' && $row['image'] !='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='sender-img'><img src='/nmusic/chat/".$row['image']."' id='inbox-sent-image' style='display:block; width:100%; height:auto;'><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}
	elseif($row['username']!=$person && $row['profile_pic']=='' && $row['image'] !='' && $row['image1']!='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div style='float:right; background:yellow; width:300px; height:auto; margin-top:10px; padding:4px 4px; clear:both;'><div style='display:flex; flex-direction:row; flex-wrap:nowrap;'><img src='/nmusic/chat/".$row['image']."'  style='width:50%; height:10%;'><img src='/nmusic/chat/".$row['image1']."'  style='width:50%; height:10%;'></div><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}elseif($row['username']!=$person && $row['profile_pic'] !='' && $row['image'] !='' && $row['image1']!='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div style='float:right; background:yellow; width:300px; height:auto; margin-top:10px; padding:4px 4px; clear:both;'><div style='display:flex; flex-direction:row; flex-wrap:nowrap;'><img src='/nmusic/chat/".$row['image']."'  style='width:50%; height:10%;'><img src='/nmusic/chat/".$row['image1']."'  style='width:50%; height:10%;'></div><p id='inbox-message'>".$row['message']."</p><p style='text-align:right; clear:both; font-size:11px; font-weight:400; color:white;'>".time_ago_in_php($row['day'])."</p></div><br />";
	}
	elseif ($row['username'] !=$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio'] !='' && $row['emoji']=='') {
				echo "";
	}elseif ($row['username'] !=$person && $row['profile_pic']!='' && $row['image']=='' && $row['audio'] !='' && $row['emoji']=='') {
		echo "";
	}elseif ($row['username'] !=$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio'] =='' && $row['emoji']!='') {
		echo "<div class='sender'><img src='/nmusic/profilepic/default.jpg' id='inbox-pic'><img src='/nmusic/emoji/".$row['emoji']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p></div><br />";
	}elseif ($row['username'] !=$person && $row['profile_pic']!='' && $row['image']=='' && $row['audio'] =='' && $row['emoji']!='') {
		echo "<div class='sender'><img src='profilepic/".$row['profile_pic']."'  id='inbox-pic'><img src='/nmusic/emoji/".$row['emoji']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p></div><br />";
	}elseif($row['username']==$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='current'><p id='inbox-message'>".$row['message']."</p></div>";
	}elseif($row['username']==$person && $row['profile_pic'] !='' && $row['image']=='' && $row['audio']=='' && $row['emoji']==''  ) {
	echo "<div class='current'><p id='inbox-message'>".$row['message']."</p></div>";
	}elseif($row['username']==$person && $row['profile_pic']==''&& $row['image'] !='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div class='img-current'><img src='/nmusic/chat/".$row['image']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p></div><br />";
	}elseif($row['username']==$person && $row['profile_pic'] !='' && $row['image'] !='' && $row['image1']=='' && $row['audio']=='' && $row['emoji']==''){
				echo "<div class='img-current'><img src='/nmusic/chat/".$row['image']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p></div><br />";
	}
	elseif($row['username']==$person && $row['profile_pic']==''&& $row['image'] !='' && $row['image1']!='' && $row['audio']=='' && $row['emoji']==''){
		echo "<div style='float:left; background:lightgrey; width:300px; height:auto; margin-top:10px; padding:4px 4px; clear:both;'><div style='display:flex; flex-direction:row; flex-wrap:nowrap;'><img src='/nmusic/chat/".$row['image']."'  style='width:50%; height:10%;'><img src='/nmusic/chat/".$row['image1']."'  style='width:50%; height:10%;'></div><p id='inbox-message'>".$row['message']."</p></div><br />";
	}elseif($row['username']==$person && $row['profile_pic'] !='' && $row['image'] !='' && $row['image1']!='' && $row['audio']=='' && $row['emoji']==''){
				echo "<div style='float:left; background:lightgrey; width:300px; height:auto; margin-top:10px; padding:4px 4px; clear:both;'><div style='display:flex; flex-direction:row; flex-wrap:nowrap;'><img src='/nmusic/chat/".$row['image']."'  style='width:50%; height:10%;'><img src='/nmusic/chat/".$row['image1']."'  style='width:50%; height:10%;'></div><p id='inbox-message'>".$row['message']."</p></div><br />";
	}
	elseif ($row['username']==$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio'] !='' && $row['emoji']=='') {
		echo "";		
	}elseif ($row['username']==$person && $row['profile_pic']!='' && $row['image']=='' && $row['audio'] !='' && $row['emoji']=='') {
		echo "";
	}elseif ($row['username']==$person && $row['profile_pic']=='' && $row['image']=='' && $row['audio'] =='' && $row['emoji']!='') {
		echo "<div class='current'><img src='/nmusic/emoji/".$row['emoji']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p></div><br />";
	}elseif ($row['username']==$person && $row['profile_pic']!='' && $row['image']=='' && $row['audio'] =='' && $row['emoji']!='') {
		echo "<div class='audio-current'><img src='/nmusic/emoji/".$row['emoji']."' id='inbox-sent-image' style='display:block;'><p id='inbox-message'>".$row['message']."</p></div><br />";
	}
}
?>
<div class='getrecentresponse' style='padding:5px 5px; height:auto; clear:both;'>
	

</div>
<?php
echo "<div  id='browse-image'>
<span style='float:right; clear:both; color:red; font-size:30px; cursor:pointer;' onclick='hideimagebox()'>&times;</span>
<form method='POST' action='../nmusic/".htmlspecialchars('sendimage.php')."' enctype='multipart/form-data'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='hidden' name='reciever'  value='".base64_decode($_GET['mid'])."'>
<input type='hidden' name='unique_id'  value='".base64_decode($_GET['unique_id'])."'>
<input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
<input type='file' style='margin-bottom:5px;'  name='image1'><br />
<input type='file' style='margin-bottom:5px; clear:both;' name='image2'><br />
<textarea name='text' style='resize:none; width:80%; border-radius:40px; padding-top:8px; padding-left:5px;' placeholder='Enter your message here'></textarea>
<button type='submit' name='send_image' id='send-image-button'><i class='fa fa-paper-plane' style='font-size:20px;'></i></button>
</form>
</div>
";
?>
<?php
echo"<form method='POST' id='text-form' class='ajax' action='../nmusic/ping.php' style='  width:100%; clear:both;  ' enctype='multipart/form-data'>
<input type='hidden' name='username' value='".$_COOKIE['user']."'>
<input type='hidden' name='reciever'  value='".base64_decode($_GET['mid'])."'>
<input type='hidden' name='unique_id' id='ajaxid' value='".base64_decode($_GET['unique_id'])."'>
<input type='hidden' name='day' value='".date('Y-m-d H:i:s')."'>
 <textarea name='message' placeholder='Type a Message...' style='resize:none; clear:both; padding-left:8px; border:none; width:80%; border-radius:40px; padding-top:5px;  margin-bottom:0px; height:50px; position:relative;   '></textarea>
 <div style='display:inline;'><i class='fa fa-camera' style=' color:lightgrey;  cursor:pointer; font-size:25px;  margin-top:20px; display:inline; position:absolute; right:30%;' onclick='you()'></i></div>
 <button type='submit' name='submit' id='send-message-button'><i class='fa fa-paper-plane' style='font-size:20px;'></i></button>
</form>
";
?>
</div>
<script type="text/javascript">
function you(){
	$("#browse-image").css('display','block');
	$("#text-form").css('display','none');
}
function hideimagebox(){
	$("#browse-image").css('display','none');
	$("#text-form").css('display','block');
}
</script>
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
    $(".getrecentresponse").append(response);
	}
});

return false;
});
	</script>
<div class='recent-messages-bar' id='recent-message-bar'>
	<h2 style='text-align:center; color:white; font-weight:bold;'>Recent</h2>
	<?php
	$unique_id=base64_decode($_GET['unique_id']);
 $sql="SELECT * FROM chat WHERE username !='$mid' AND reciever='$username' AND entrystatus='new' ORDER BY id desc";
 $result=mysqli_query($conn,$sql);
 if(mysqli_num_rows($result) > 0){
 while($row=mysqli_fetch_assoc($result)){
 	$getpic=$row['username'];
 	$sql5="SELECT profile_pic FROM artiste_info WHERE username='$getpic'";
 	$result5=mysqli_query($conn,$sql5);
 	while($row5=mysqli_fetch_assoc($result5)){
      $GLOBALS['pic'] = $row5['profile_pic'];
 	}
 	if($row['status']==0 &&  $GLOBALS['pic']=='' ){
      echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/default.jpg' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".$row['username']."</span></a><p id='text-message' style='font-weight:bold; font-size;13px;'>".$row['message']."</p></div>";
	}elseif($row['status']==0 &&  $GLOBALS['pic']!='' ){
echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/".$GLOBALS['pic']."' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".$row['username']."</span></a><p id='text-message' style='font-weight:bold; font-size:13px;'>".$row['message']."</p></div>";
	}
	elseif($row['status']==1 &&  $GLOBALS['pic']==''){
		 echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/default.jpg' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".$row['username']."</span></a><p id='text-message' style='font-weight:400; font-size:13px;'>".$row['message']."</p></div>";
	}
	elseif($row['status']==1 &&  $GLOBALS['pic']!='' ){
echo "<div id='each-message-div'><a href='info.php?id=".base64_encode($row['username'])."'><img src='/nmusic/profilepic/".$GLOBALS['pic']."' id='sender-message-pic'></a><a href='inbox.php?mid=".base64_encode($row['username'])."&amp;unique_id=".base64_encode($row['unique_id'])."'><span class='usernaame-sender'>".$row['username']."</span></a><p id='text-message' style='font-weight:400; font-size:13px;'>".$row['message']."</p></div>";
	}
 }
 }else{
 	echo "<p style='color:white;'>No Recent Messages</p>";
 }

	?>
</div>
<script type="text/javascript">
	 document.title='Conversation';
    if(document.title=='Conversation'){
       $(".info-container").css('display','none');
  }
function sidebar(){
	$("#recent-message-bar").css('display','block');
	$("#recent-message-bar").css('width','250px'); 
}
function getrecent(){
	$.ajax({
	url:'../nmusic/getrecent.php',
	type:'POST',
	data:{unique_id:$("#ajaxid").val()},
	success:function(response){
    $(".getrecentresponse").append(response);
	}
});
}
setInterval(getrecent,2000);
</script>
</body>
</html>
<?php
mysqli_close($conn);
}
?>