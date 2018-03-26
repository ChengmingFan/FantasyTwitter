<?php
	$a = $_SERVER['HTTP_REFERER'];
	$b = strstr( $a, '=');
	$c = str_replace('=','',$b);
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
	$sql = "select * from tweets where username = '$c'";
	$res = mysqli_query($link,$sql);
	echo "<div id='content' style='position:absolute;left:500px;top:50px;height:500px;'>";
	echo "<b><p>$c&apos;s twitters:</b></p>";
	if (mysqli_num_rows($res) == 0)
		echo "<p>no twitters</p>";
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