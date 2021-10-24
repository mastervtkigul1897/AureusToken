<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<?php

// Anti-SQL Injection 
function check_inject() 
  { 
    $badchars = array(";","'","*","/"," \ ","DROP", "SELECT", "UPDATE", "DELETE", "drop", "select", "update", "delete", "WHERE", "where", "-1", "-2", "-3","-4", "-5", "-6", "-7", "-8", "-9",); 
   
    foreach($_POST as $value) 
    { 
	$value = clean_variable($value);

	if(in_array($value, $badchars)) 
      { 
        die("คุณกรอกข้อมูลไม่ถูกต้อง\n<br />\n"); 
      } 
      else 
      { 
        $check = preg_split("//", $value, -1, PREG_SPLIT_OFFSET_CAPTURE); 
        foreach($check as $char) 
        { 
          if(in_array($char, $badchars)) 
          { 
            die("คุณกรอกข้อมูลไม่ถูกต้อง\n<br />\n"); 
          } 
        } 
      } 
    } 
  } 
function clean_variable($var) 
	{ 
	$newvar = preg_replace('/[ด]/', '', $var); 
	return $newvar; 
	}

?>