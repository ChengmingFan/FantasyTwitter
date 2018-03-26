<?php 
session_start(); 
if(!$_SESSION['loggd'])
{
	echo 'error';
	exit();
}
$c = $_SESSION['name'];
?> 
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<script type="text/javascript" src="../js/jquery.js"></script>
		<link href="../css/homepage1.css" type="text/css" rel="stylesheet">
		<title>homepage</title>
	</head>
	<body  style="background-color:rgb(230, 236, 240);">
	<style>
		a:link,a:visited{color:cornflowerblue;}  
	</style> 
		 <div class="header">
        <span>
       	<img src="../img/homepage.png" style="width: 40px;height: 40px;position:absolute;top:3px;left: 50px;cursor: pointer;" onclick="returnToHomepage()">
       	<p id="topusername" style="position: absolute;left: 90px;top: -25px;font-size: 30px;color: #1296DB;cursor: pointer;"onclick="returnToHomepage()">test<p>
        <img src="../img/logo2.png" style="width: 60px;height: 53px;position:absolute;top:-5px;left: 810px;">
        <div>
        <input  id = "searchBox"type="text" placeholder="search something"/>
        <img src="../img/search.png" style="width: 30px;height: 30px;position:absolute;top:6px;right: 103px;" onclick="search()">
        </div>
        </span>
    	</div>
		<div id="userinfo" style="background-color: aliceblue;">
			<b><p id="homepageusername"></p></b>
			<b><p id="jiondate"></p></b>
			<b><p>Tweets: <a id="tweetCount"></a></p></b>
			<b><p id="follow">Following: <a id="getfollow"></a></p></b>
			<b><p id="follower">Followers: <a id="getfollower"></a></p></b>
			<button class="btn1" id="followBtn" onclick="follow()">follow</button>
		</div>
		<div id="newmicroblog">
			<textarea id="content"></textarea>
			<button class="btn" onclick="twwet()">Tweet</button>
		</div>
		<div id="info">
			
		</div>
		<script>
	var s=location.search.substring(1);//这个就是页面?后面的内容，自己处理一下
	s=s.replace('username=','');
	document.cookie = name+" = "+s+";" 
	var current ="<?php echo $c;?>";
	document.getElementById("getfollow").href = "getfollow.php?username="+s;
	document.getElementById("getfollower").href = "getfollower.php?username="+s;
	document.getElementById("tweetCount").href = "getTweets.php?username="+s;
	document.getElementById("homepageusername").innerHTML = "Username: " +s;
	document.getElementById("topusername").innerHTML = current;
	if(s == current)
	{
		document.getElementById("followBtn").style.display = 'none';
	}
	else
	{
		document.getElementById("newmicroblog").style.display = 'none';
		document.getElementById("info").style.top = '70px';
	}
	function getInfo() {
 	dataVal = {
 		username: s
 	};
 	$.ajax({
 			url: 'getInfo.php',
 			type: 'GET',
 			data: dataVal,
 			success: function(msg) {
   				if(msg.count == 0)
   				{
   					document.getElementById("jiondate").innerHTML = "Joindate: " + msg.joindate;
   					document.getElementById('tweetCount').innerHTML =  msg.count;
   					document.getElementById('getfollow').innerHTML = msg.follownumber;
	   				document.getElementById('getfollower').innerHTML = msg.followernumber;
	   				if(msg.followstatus == 'yes')
   						document.getElementById('followBtn').innerHTML = 'unfollow';
   				}
   				else
   				{
	   				document.getElementById("jiondate").innerHTML = "Joindate: " + msg[0].joindate;
	   				document.getElementById('tweetCount').innerHTML = msg[0].count;
	   				document.getElementById('getfollow').innerHTML = msg[0].follownumber;
	   				document.getElementById('getfollower').innerHTML = msg[0].followernumber;
	   				for(var i = 0; i < getJsonLength(msg); i++) {
	   					if(msg[i].status == 'ok') {
	   						if(msg[i].info == null)
	   							break;
	   						var tweet = document.createElement('div');
	   						tweet.style.backgroundColor= "white";
	   						tweet.style.wordWrap="break-word";
	   						tweet.style.overflow = "hidden";
	   						tweet.style.height = "100px";
	   						tweet.innerHTML = "<b style='color:lightskyblue'>" + "<a href='homepage.php?username="+msg[i].username + "'>" + msg[i].username + "</a>" + "</b>" + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + "</br><p class = 'detail' style='color:black'>" +msg[i].info + "</p><p class='time'>" + msg[i].time + "</p>";
	   						var br = document.createElement('div');
	   						br.innerHTML = "</br>"
	   						document.getElementById("info").appendChild(tweet);
	   						document.getElementById("info").appendChild(br);
   						}
   					}
	   				if(msg[0].followstatus == 'yes')
   						document.getElementById('followBtn').innerHTML = 'unfollow';
   				}
   					
 		}
 	});
 };
getInfo();

 function twwet() {
 	var content = document.getElementById('content').value;
 	dataVal = {
 		username: s,
 		content: content
 	};
 	$.ajax({
 		url: 'tweets.php',
 		type: 'GET',
 		data: dataVal,
 		success: function(msg) {
			alert(msg); 
//			location.reload();
			var newBlog = document.getElementById('content');
			var con = document.getElementById("info");
			con.innerHTML = "";
			newBlog.value = "";
			getInfo();
 		}
 	});
 };
 function follow()
 {
 	var a = document.getElementById("followBtn").innerHTML;
 	if(a == "follow")
 	{
	   	dataVal = {
	   		followname: s
	   	};
	   	$.ajax({
	   		url: 'follow.php',
	   		type: 'GET',
	   		data: dataVal,
	   		success: function(msg) {
	   			if(msg.followstatus == 'ok')
	   			{
	   				document.getElementById("followBtn").innerHTML = "unfollow";
	   				location.reload();
	   			}
	   		}
	   	})
	}
 	if(a == "unfollow")
 	{
 		dataVal = {
	   		followname: s
	   	};
	   	$.ajax({
	   		url: 'unfollow.php',
	   		type: 'GET',
	   		data: dataVal,
	   		success: function(msg) {
	   			if(msg.followstatus == 'ok')
	   			{
	   				document.getElementById("followBtn").innerHTML = "follow";
	   				location.reload();
	   			}
	   		}
	   	})
 	}
 };
function returnToHomepage()
{
	window.location.href="homepage.php?username=" + current;
};
$('#searchBox').bind('keypress', function (event) {
            if (event.keyCode == "13") {
            	var content = document.getElementById('searchBox').value;
                window.location.href="search.php?content=" + content;
            }
        });
function search()
{
	var content = document.getElementById('searchBox').value;
	var search = document.getElementById('searchBox');
	search.value = "";
	window.location.href="search.php?content=" + content;
};
 function getJsonLength(jsonData)//get the length of json
	        {
	        	var jsonLength = 0;
	        	for(var item in jsonData) {
	        		jsonLength++;
	        	}
	        	return jsonLength;
	        }
		</script>
	</body>
</html>
