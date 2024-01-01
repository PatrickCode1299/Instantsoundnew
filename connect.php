
<?php
if(!isset($_COOKIE['user']) || !isset($_COOKIE['email'])){
	header('Location:index.php');
}else{
include_once 'db.php';
?>
<?php
include_once 'loginheader.php';
?><br /><br /><br /><br />
<div class="findnewpeople" >
	<h2 style="text-align:center; font-weight:bold; color:white;">Follow This People</h2>
<?php
$user=$_COOKIE['user'];
$fetchusercountry="SELECT country FROM artiste_info WHERE username='$user'";
$fetchcountry=mysqli_query($conn,$fetchusercountry);
if($row=mysqli_fetch_assoc($fetchcountry)){
	$country=$row['country'];
	$fetchpeople="SELECT * FROM artiste_info WHERE username !='$username' AND country='$country' OR country !='$country' AND country !=''";
$fetchresult=mysqli_query($conn,$fetchpeople);
while ($row=mysqli_fetch_assoc($fetchresult)) {
	$nottoconnectwith=$row['username'];
	$mainuser=$_COOKIE['user'];
	$findnewpeople="SELECT * FROM followership WHERE follower='$mainuser' AND following='$nottoconnectwith' ";
	$fetchdem=mysqli_query($conn,$findnewpeople);
if(mysqli_num_rows($fetchdem) > 0){
	echo "";
}else{
	$getshortinfo="SELECT profile_pic,username FROM artiste_info WHERE username='$nottoconnectwith'";
	$process=mysqli_query($conn,$getshortinfo);
	while($i=mysqli_fetch_assoc($process)) { 
		if($i['profile_pic']==''){
echo "<li style='position:relative; list-style:none; margin-top:10px;'><img src='profilepic/default.jpg' id='connect-avatar'><form method='POST' class='ajax'  style='float:right; margin-top:2px; margin-bottom:0px;' action='follow.php'>
    <input type='hidden'   name='following' value='".$i['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit'  name='follow' class='".$i['username']."' id='unfollow-button' style='margin-top:0px;'>follow</button>
    </form><a href='info.php?id=".base64_encode($i['username'])."' style='color:white;'><span class='mutual-username'>".$i['username']."</span></a></li>";
		}else{
			echo "<li style='position:relative; list-style:none; margin-top:10px;'><img src='../nmusic/profilepic/".$i['profile_pic']."' id='connect-avatar'><form method='POST' class='ajax'  style='float:right; margin-top:2px; margin-bottom:0px;' action='follow.php'>
    <input type='hidden'   name='following' value='".$i['username']."'>
    <input type='hidden' name='username' value='".$_COOKIE['user']."'>
    <button type='submit'  name='follow' class='".$i['username']."' id='unfollow-button' style='margin-top:0px;'>follow</button>
    </form><a href='info.php?id=".base64_encode($i['username'])."' style='color:white;'><span class='mutual-username'>".$i['username']."</span></a></li>";
		}
		
	}


}
}
}







?>
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
    </script>
</body>
</html>
<?php
mysqli_close($conn);
}
?>