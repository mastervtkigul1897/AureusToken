<?php

include_once('sql_priva.php');
include_once('sql_check.php');
include_once('sql_inject.php');
include_once('sql_injection.php');
include_once('sql_injection2.php');

$serverName = "(local)" ;
$uid        = 'sa'              ;
$pwd        = 'Haha!!'        ;

$connectionInfo = array( "UID"      =>  $uid        ,
                         "PWD"      =>  $pwd        ,
                         "Database" =>  "RohanUser"
                       );

$db = sqlsrv_connect( $serverName, $connectionInfo);
if( $db === false ) {
//  print_r( sqlsrv_errors(), true);
  die (-1000); # Unable to connect to the database
}

?>
