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
?>
<header class="songlist-header">
	<?php
$username=$_COOKIE['user'];
$findnumberofusersong="SELECT count(audio) AS total FROM user_post WHERE username='$username' AND audio !=''";
$getsongcount=mysqli_query($conn,$findnumberofusersong);
if(mysqli_num_rows($getsongcount) > 0){
	while ($row=mysqli_fetch_assoc($getsongcount)) {
	if($row['total'] > 9){
		echo "<button onclick='openAlbum()' style='font-weight:bold;' class='btn  btn-primary btn-default btn-md pull-right'>Compile your songs to album</button>";
	}elseif ($row['total'] < 9) {
	echo "<button onclick='openAlbum()' style='font-weight:bold;' class='btn btn-primary btn-default btn-md pull-right'>Compile your songs to EP</button>";
	}else{
		echo "";
	}
	}
}
?>
</header>
<div class="container song-list-holder">
<h2 style='color:white; font-weight:bold;'>Your Songs</h2>
<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM user_post WHERE username='$username' AND status !='shared' AND audio !=''ORDER BY userpostid desc;";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
echo "<li class='discparent'><img src='/nmusic/image/".$row['image']."' class='song-cover-avatar'><span class='song-title'>".$row['caption']."</span><span class='user-detail'>".streamcount($row['audio'])."</span><a href='listen.php?mid=".base64_encode($row['image'])."'>Listen</a><li>";
}
}else{
	echo "<h2 class='text-center' style='color:white;'>Go to your Profile and Upload A Song</h2>";
}
?>
</div>
<div class="albumcreatorholder" id="albumcreator">
<div class="albumcreator">
	<i style="color:white; cursor:pointer; font-size:20px; margin-left:20px;" class="fa fa-arrow-left" onclick="hidealbum()"></i>
	<div class="form-group">
	<h3 class="text-center" style="margin-top:0px; color:white;">Album Title / Name</h3>
	<textarea name="album" placeholder="Album Title" class="form-control" style="resize:none;"></textarea>
</div>
	<?php
$username=$_COOKIE['user'];
$sql="SELECT * FROM user_post WHERE username='$username' AND status !='shared' AND audio !=''ORDER BY userpostid desc;";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
echo "<li class='discparent'><img src='/nmusic/image/".$row['image']."' class='song-cover-avatar'><span class='song-title'>".$row['caption']."</span>
<input  type='checkbox' name='songs' value='".$row['caption']."'>
<input type='hidden' name='username' value='".$username."'>
<li>";
}
}
	?>

	<button type="submit" onclick='sendata()' class="btn btn-md btn-primary" name="compile">Compile</button>
		<script type="text/javascript">
	
	function sendata(){
	$("input[type=checkbox]:checked").each(function(index){
			window.info=$(this).val();
			alert(window.info);
		})
			$.ajax({
  url:'compilealbum.php',
  type:'POST',
  data:{songs:window.info},
  success:function(response){
    $("body").append(response);
  }
});
}
	</script>
</div>
</div>
<script>
	  document.title='Your Songs';
</script>
<script type="text/javascript">
	function openAlbum(){
		$("#albumcreator").css('display','block');
	}
		function hidealbum(){
		$("#albumcreator").css('display','none');
	}
</script>
<?php
mysqli_close($conn);
}
?>