<?php 
$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");
$found = false;
foreach($_GET as $value)
  foreach($array_char as $word){
    if(substr_count($value, $word) > 0){
      $found = true;
    }
  }
?>