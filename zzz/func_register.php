<?php
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';

$include = true;
include('../dbconn.php');

$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

$username = $_POST['username'];
$password = $_POST['password'];
$repassword= $_POST['repassword'];

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
        
        $checkaccount = sqlsrv_fetch_array(sqlsrv_query($oConn, "SELECT COUNT(*) FROM RohanUser.dbo.TUser where login_id = '$username'"));

        if($checkaccount[0] <= 0)
        {
            if($password == $repassword)
            {
                $q = sqlsrv_query($oConn, "INSERT INTO RohanUser.dbo.TUser (login_id,login_pw,login_pw2,grade,rpoints) VALUES ('$username','$finalpassword','$password','10','0')");
                if($q)
                {
                    echo '<div class="alert alert-success alert-dismissible"><i class="icon fas fa-check"></i> Register Success, Enjoy The Game..</div>';
                }
                else
                {
                    echo "QUERY ERROR!";
                }
            }
            else
            {
                echo '<div class="alert alert-danger alert-dismissible"><i class="icon fas fa-times"></i> Register Failed, Password Not Matched..</div>';
            }
        }
        else
        {
            echo '<div class="alert alert-danger alert-dismissible"><i class="icon fas fa-times"></i> Register Failed, Username Taken..</div>';
        }
    }
?>