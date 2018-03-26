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
	$table = "$c"."_tweets";
	$sql = "select follow from $table where follow is not null";
	$result = mysqli_query($link,$sql);
	echo "<table style='position:absolute;left:700px;top:50px; z-index:1;'>"; 
	echo "<tr><td><b>$c&apos;s follows: </b></td></tr>";
	while($row = mysqli_fetch_assoc($result)["follow"])
		echo "<tr><td><a href='homepage.php?username=$row'>$row</td></tr>";
	echo "</table>";  
?>