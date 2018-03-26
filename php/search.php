<script>
	var s=location.search.substring(1);//这个就是页面?后面的内容，自己处理一下
	s=s.replace('content=','');
	dataVal = {
   		content: s
   	};
	$.ajax({
   		url: 'search.php',
   		type: 'GET',
   		data: dataVal,
   		success: function(jsondata) {
   			
   		}
   });
</script>
<?php
	$searchContent = $_GET['content'];
	header("Content-type: text/html; charset=utf-8");
	$link = mysqli_connect("localhost","root","1009976636",'blog');
	if(!$link)
	{
	    $output = 'Unable to connect to the database server.';
	   	echo json_encode(array('status' => 'error','message'=> $output));
	    exit();
	}
	if(!mysqli_set_charset($link,'utf8'))
	{
	    $output = 'Unable to set database connection encoding.';
	    echo json_encode(array('status' => 'error','message'=> $output));
	    exit();
	}
	mysqli_query($link,"set names gbk2312");
	$sql = "select * from user where username like '%" . "$searchContent" . "%'";
	$result = mysqli_query($link,$sql);
	if (mysqli_num_rows($result) == 0)
		$status1 = "error"; 
	else
	{
		$status1 = "ok";
		echo "<table style='position:absolute;left:500px;top:40px; z-index:1;'>";  
		while($row = mysqli_fetch_assoc($result)["username"])
			 echo "<tr><td><a href='homepage.php?username=$row' >$row</td></tr>";
		echo "</table>";  
	}
	$sql = "select * from tweets where tweets like '%" . "$searchContent" . "%' order by id desc";
	$res = mysqli_query($link,$sql);
	echo "<div id='content' style='position:absolute;left:500px;top:230px;height:500px;'>";
	echo "<b><p>Related twitters:</b></p>";
	if (mysqli_num_rows($res) == 0)
		echo "<p>No related twitters!!</p>";
	while ($row= mysqli_fetch_array($res, MYSQLI_ASSOC))
	{
		$name = $row["username"];
		$info = $row["tweets"];
		$time = $row["tweet_date"];
		echo "<div style = 'width: 600px;height:100px;background-color: aliceblue'><b><a href='homepage.php?username=$name'>$name</a></b>
		<p>$info</p>
		<p style='position:relative;bottom:-15px;color:darkgray'>$time</p>
		</div>";
		echo "</br>";
	}
	echo "</div>";
?>
<html>
	<head><title>search result</title></head>
	<body>
		<div id="user" style="position: absolute;left:500px;width: 600px;height: 200px;background-color: aliceblue;">
			<b><p>Related user:</p></b>
			<p id="noresult"></p>
			<a id="userHref" href="homepage.php?username="></a>
		</div>
	</body>
	<script>
		var status1 ="<?php echo $status1;?>";
		if(status1 == "error")
		{
			document.getElementById("noresult").innerHTML = "No users";
		}
	</script>
</html>