<?php
$username = $_GET['username'];
$userpassword = $_GET['userpassword'];
date_default_timezone_set("Asia/Shanghai");
$signupdate = date("Y-m-d");
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
if(empty($username) || empty($userpassword) )
{
	echo "username or/and password can not be empty!";
	exit();
}
mysqli_query($link,"set names gbk2312");
$table = "$username" . "_tweets";
$sql = "create table " . $table . "(
   id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   follow VARCHAR(140),
   follower VARCHAR(140)
);";
mysqli_query($link,$sql);
$sql = "INSERT INTO user
(username,password,joindate)
VALUES('$username','$userpassword','$signupdate')";
if(!mysqli_query($link,$sql))
{
	echo "failed to sign up(user name has been used)";
	exit();
}
else
	echo "successed to sign up!";
?>