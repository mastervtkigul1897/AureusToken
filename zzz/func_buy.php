<?php

session_start();
$username = $_SESSION['username'];

$include = true;
include('../dbconn.php');

$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

$id = $_POST['id'];

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
        
        $getuser = sqlsrv_fetch_array(sqlsrv_query($db, "SELECT * FROM RohanUser.dbo.TUser WHERE login_id='$username'"));
        $getiteminfo = sqlsrv_fetch_array(sqlsrv_query($db, "SELECT * FROM RohanWeb_Aureus.dbo.TCategoryItems WHERE id = '$id'"));
        
        $name = $getiteminfo['name'];
        $price = $getiteminfo['price'];
        $type = $getiteminfo['type'];
        $stack = $getiteminfo['stack'];
        
		
		//echo "The Marketplace is under maintenance. We will let know you know soon. <br> (The prices are not final yet)";
		
        if($getuser['points'] >= $getiteminfo['price'])
        {
            $updatepoints = sqlsrv_query($db, "UPDATE RohanUser.dbo.TUser set points = points - $price WHERE login_id = '$username'");
            if($updatepoints)
            {
                $insertitem = sqlsrv_query($db, "INSERT INTO RohanMall.dbo.TItem SELECT $type ,0x00,$stack,0,0,0,0,0,user_id,GETDATE(),0 FROM RohanUser.dbo.TUser WHERE login_id = '$username'");
                if($insertitem)
                {
                    //sqlsrv_query($db, "INSERT INTO RohanMall.dbo.ItemLogs (item_type,item_name,item_price,username) VALUES ('$type','$name','$price','$username')");
                    sqlsrv_query($db, "INSERT INTO RohanWeb_Aureus.dbo.ItemLogs (item_type,item_name,item_price,username,date) VALUES ('$type','$name','$price','$username',GETDATE())");
                    echo "Purchase Successfully, Kindly Check Your Item Mall Inventory";
                }
                else
                {
                    echo "INSERTED ITEM QUERY ERROR";
                }
            }
            else
            {
                echo "QUERY ERROR";
            }
        }
        else
        {
            echo 'Purchase Failed, You Have Insufficient Funds In Your Account';
        }
    }

?>