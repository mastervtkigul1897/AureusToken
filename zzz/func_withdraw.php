<?php 

error_reporting(0);
session_start();
$username = $_SESSION['username'];
$wallet = $_SESSION['wallet'];

$checkpost = $_POST['check'];

$include = true;
include('../dbconn.php');

if($checkpost == "check"){

    $array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

    $amount = $_POST['amount'];
    $date = strtotime("+7 day");
    $date_release = date('M d, Y', $date);
    $str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $shuffled = str_shuffle($str);
    $shuffled = strtoupper(substr($shuffled,1,10));
    $reference = $shuffled;

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
        else
        {
        $getuser = sqlsrv_fetch_array(sqlsrv_query($db, "SELECT * FROM RohanUser.dbo.TUser WHERE login_id='$username'"));

        if($amount > 0)
        {
            if($getuser['points'] >= $amount)
            {
                $updatepoints = sqlsrv_query($db, "UPDATE RohanUser.dbo.TUser set points = points - $amount WHERE login_id = '$username'");
                if($updatepoints)
                {
                    $insertitem = sqlsrv_query($db, "INSERT INTO RohanWeb_Aureus.dbo.TWithdraw (wallet_address,amount,username,date_request,date_release,reference_id) VALUES ('$wallet','$amount','$username',GETDATE(),'$date_release','$reference')");
                    if($insertitem)
                    {
                        echo "Your withdraw request has been successfully sent to the administrator <br><br> Release Date: $date_release <br> Reference ID: $reference";
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
                echo 'Insufficient Aureus Token in your account';
            }
        }
        else
        {
            echo "Amount cannot be zero or a negative value";
        }
    }
}
?>