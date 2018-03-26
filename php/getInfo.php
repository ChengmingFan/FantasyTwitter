<?php
session_start(); 
$username = $_GET['username'];
$currentuser = $_SESSION['name'];
header('Content-Type: application/json');
$link = mysqli_connect("localhost","root","1009976636",'blog');
if(!$link)
{
   	echo "Unable to connect to the database server.";
    exit();
}
if(!mysqli_set_charset($link,'utf8'))
{
    echo "Unable to set database connection encoding.";
    exit();
}
mysqli_query($link,"set names gbk2312");
$sql = "select * from user where username = '$username'";
$result = mysqli_query($link, $sql);
$date = mysqli_fetch_assoc($result)["joindate"];
$table = "$currentuser" . "_tweets";
$sql = "select count(*) as num from tweets where username = '$username'";
$query = mysqli_query($link,$sql);
$count = mysqli_fetch_assoc($query)["num"];
//$sql = "select count(*) as num from '$table' where follow !=";
//$sql = "select * from " . $table . " order by id desc";
$followstatus = "";
if($currentuser == $username)
	$followstatus = 'self';
else
{
	$sql1 = "select * from $table where follow = '$username'";
	$query1 = mysqli_query($link,$sql1);
	if(mysqli_num_rows($query1) == 0)
		$followstatus = 'no';
	else
		$followstatus = 'yes';
}
$table = "$username"."_tweets";
$sql = "select count(*) as follownum from $table where follow is not null";
$query = mysqli_query($link,$sql);
$followcount = mysqli_fetch_assoc($query)["follownum"];
$sql = "select count(*) as followernum from $table where follower is not null";
$query = mysqli_query($link,$sql);
$followercount = mysqli_fetch_assoc($query)["followernum"];






$json ="";
$data =array();
$data1 = array();
$followusers = array();
if($username == $currentuser)
{
	class tweet 
	{
	public $status;
	public $info;
	public $time;
	}
	class time
	{
		public $time;
	}
	$sql = "select follow from $table where follow is not null";
	$res = mysqli_query($link,$sql);
	while ($row= mysqli_fetch_array($res, MYSQLI_ASSOC))
	{
		$followusers[] = $row["follow"];
	}
	$arraylength = count($followusers);
	for($i = 0;$i < $arraylength;$i++)
	{
		$username = $followusers[$i];
		$sql = "select * from tweets where username = '$username' order by id desc";
		$res = mysqli_query($link,$sql);	
		while ($row= mysqli_fetch_array($res, MYSQLI_ASSOC))
		{
		$tw =new tweet();
		$tw->status = 'ok';
		$tw->followstatus = $followstatus;
		$tw->follownumber = $followcount;
		$tw->followernumber = $followercount;
		$tw->joindate = $date;
		$tw->count = $count;
		$tw->username = $username;
		$tw->info = $row["tweets"];
		$tw->time = $row["tweet_date"];
		$data[]=$tw;
		$tm = new time();
		$tm->time = $row["tweet_date"];
		$data1[] = $tm;
		}
	}
	$sql = "select * from tweets where username = '$currentuser' order by id desc";
	$res = mysqli_query($link,$sql);
	while ($row= mysqli_fetch_array($res, MYSQLI_ASSOC))
	{
	$tw =new tweet();
	$tw->status = 'ok';
	$tw->followstatus = $followstatus;
	$tw->follownumber = $followcount;
	$tw->followernumber = $followercount;
	$tw->joindate = $date;
	$tw->count = $count;
	$tw->username = $currentuser;
	$tw->info = $row["tweets"];
	$tw->time = $row["tweet_date"];
	$data[]=$tw;
	$tm = new time();
	$tm->time = $row["tweet_date"];
	$data1[] = $tm;
	}
	if (count($data) == 0) 
	{
	         echo json_encode(array('status' => 'ok','followstatus' => $followstatus,'joindate' => $date,'follownumber' => $followcount,'followernumber' => $followercount,'count' => 0));
	         exit();
	}
	array_multisort($data1,SORT_DESC,$data);
	$json = json_encode($data);
	echo $json;
}
else
{
	
	$sql = "select * from tweets where username = '$username' order by id desc";
	$res = mysqli_query($link,$sql);
	$json ="";
	class tweet 
	{
	public $status;
	public $info;
	public $time;
	}
	if (mysqli_num_rows($res) == 0) 
	{
	         echo json_encode(array('status' => 'ok','followstatus' => $followstatus,'joindate' => $date,'follownumber' => $followcount,'followernumber' => $followercount,'count' => 0));
	         exit();
	}
	while ($row= mysqli_fetch_array($res, MYSQLI_ASSOC))
	{
	$tw =new tweet();
	$tw->status = 'ok';
	$tw->followstatus = $followstatus;
	$tw->follownumber = $followcount;
	$tw->followernumber = $followercount;
	$tw->joindate = $date;
	$tw->count = $count;
	$tw->username = $username;
	$tw->info = $row["tweets"];
	$tw->time = $row["tweet_date"];
	$data[]=$tw;
	}
	$json = json_encode($data);
	echo $json;
}
?> 