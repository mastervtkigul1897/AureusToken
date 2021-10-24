<?php 
error_reporting(0);
session_start();
$username = $_SESSION['username'];

$include = true;
include('dbconn.php');

$getuser = sqlsrv_fetch_array(sqlsrv_query($db, "SELECT * FROM RohanUser.dbo.TUser WHERE login_id='$username'"));

?>

<label><i class="fa fa-btc" aria-hidden="true"></i> <?php echo number_format($getuser['points']); ?></label>