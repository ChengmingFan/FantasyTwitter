<?php
session_start(); 
$wanttofollowuser = $_GET['followname'];
$currentuser = $_SESSION['name'];
header('Content-Type: application/json');
$link = mysqli_connect("localhost","root","1009976636",'blog');
if(!$link)
{
    $output = 'Unable to connect to the database server.';
    echo $output;
    exit();
}
if(!mysqli_set_charset($link,'utf8'))
{
    $output = 'Unable to set database connection encoding.';
    echo $output;
    exit();
}
mysqli_query($link,"set names gbk2312");
$table = "$currentuser" . "_tweets";
$sql = "INSERT INTO " . $table."(
follow)
VALUES('$wanttofollowuser')";
mysqli_query($link,$sql);
$table = "$wanttofollowuser" . "_tweets";
$sql = "INSERT INTO " . $table."(
follower)
VALUES('$currentuser')";
if(mysqli_query($link,$sql))
	echo json_encode(array('followstatus' => 'ok'));
else
	echo "fail";
?>