<?php
$username = $_GET['username'];
$userpassword = $_GET['userpassword'];
header('Content-Type: application/json');

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
$sql = ("select password from user where username = '$username'");
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) 
{
    if($userpassword == mysqli_fetch_assoc($result)["password"])
    {
    	session_start ();  
    	$_SESSION['user']=$username;
     	$url = '?username=' .$_SESSION['user'];
     	$_SESSION['loggd'] = true;//setting cookie avoid input address to visit directly
     	$_SESSION['name'] = $username;
        echo json_encode(array('status' => 'ok','message'=> $url));
    }
    else
        echo json_encode(array('status' => 'error','message'=>  'The username and/or password you specified are not correct.'));
}

else 
{
    echo json_encode(array('status' => 'error','message'=> 'The username does not exist!'));
}

?> 