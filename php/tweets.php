<?php
	$username = $_GET['username'];
	$content = $_GET['content'];

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
//$table = $username . "_tweets";
//$sql = "INSERT INTO $table
//(tweets)
//VALUES('$content')";
$sql = "INSERT INTO tweets
(username,tweets)
VALUES('$username','$content')";
if(!mysqli_query($link,$sql))
	echo "fail";
else
	echo "send successfully";
?> 