<?php
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

$include = true;
include('../dbconn.php');

$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

$username = $_POST['username'];
$password = $_POST['password'];

$finalpassword = md5($password);

$found = false;
foreach($_POST as $value)
	foreach($array_char as $word){
	    if(substr_count($value, $word) > 0){
		    $found = true;
		}
	}

	if($found){
		echo '<div class="alert alert-danger alert-dismissible"><i class="icon fas fa-times"></i> Special characters not allowed!</div>';
    }
    else{
        $result = sqlsrv_fetch_array(sqlsrv_query($oConn, "SELECT COUNT(*) FROM RohanUser.dbo.TUser WHERE login_id = '$username' and login_pw = '$finalpassword'"));
        
        if($result[0] > 0)
        {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $finalpassword;
            echo '<div class="alert alert-success alert-dismissible"><i class="icon fas fa-check"></i> Login Success, Redirecting..</div>';
            echo '<meta http-equiv="refresh" content="3;url=mall.php" />';
        }
        else
        {
            echo '<div class="alert alert-danger alert-dismissible"><i class="icon fas fa-times"></i> Wrong Username or Password...</div>';
        }
    }
?>