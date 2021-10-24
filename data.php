<?php
error_reporting(0);
include('dbconn.php'); 

if(isset($_POST['Registration'])){

	$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

	$wallet = $_POST['wallet'];
	$username = $_POST['username'];
	$password = $_POST['password'];

	$found = false;
	foreach($_POST as $value)
	foreach($array_char as $word){
	if(substr_count($value, $word) > 0){
		$found = true;
		}
	}

	if($found){
		echo 'Please do not use special characters.';
	}
	else
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://deep-index.moralis.io/api/v2/$wallet/erc20?chain=bsc",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"accept: application/json",
				"X-API-Key: OFU4DzntdMoWvQJqjXax1cuvHJwxCISTHNi0LguBXX2Omo3IDhgfBpJ4jhDqEroV"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$result = json_decode($response);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$myarray = array();
			$feedbackGiven = FALSE;
			$status = 0;
			foreach ($result as $r) {
				if($r->symbol == "AUREUSRH")
				{
					if(substr($r->balance, 0, -9) >= 2000000)
					{
						if (!$feedbackGiven)
						{
							$feedbackGiven = TRUE;
							$status = 1; //Sufficient Fund
							array_push($myarray, $r->symbol);
						}
					}
					else
					{
						if (!$feedbackGiven)
						{
							$feedbackGiven = TRUE;
							$status = 2; //Insufficient Fund
							array_push($myarray, $r->symbol);
						}
					}
				}
				else
				{
					
				}
			}

			if($status == 1 && $myarray[0] == "AUREUSRH")
			{
				$gettokendb = sqlsrv_fetch_array(sqlsrv_query($db,"SELECT COUNT(*) FROM RohanUser.dbo.TUser where wallet = '$wallet'"));
				$getuserdb = sqlsrv_fetch_array(sqlsrv_query($db,"SELECT COUNT(*) FROM RohanUser.dbo.TUser where login_id = '$username'"));

				$hashpass = md5($password);

				if($gettokendb[0] > 0)
				{
					echo "<script>alert('This token is already used.')</script>";
				}
				if($getuserdb[0] > 0)
				{
					echo "<script>alert('This username is already exist.')</script>";
				}

				if($gettokendb[0] <= 0 && $getuserdb[0] <= 0)
				{
					$createaccount = sqlsrv_query($db, "INSERT INTO RohanUser.dbo.TUser (login_id,login_pw,grade,wallet,active) VALUES ('$username','$hashpass','10','$wallet','0')");
					if($createaccount)
					{
						echo '<meta http-equiv="refresh" content="0;url=reg_success.html" />';
					}
					else
					{
						echo "Query Error";
					}
				}
			}
			if($status == 2 && $myarray[0] == "AUREUSRH")
			{
				echo '<meta http-equiv="refresh" content="0;url=reg_failed.html" />';
			}
			if(!$myarray)
			{
				echo '<meta http-equiv="refresh" content="0;url=reg_noaureus.html" />';
				
			}
		}
	}
}

if(isset($_POST['Login']))
{
	$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

	$username = $_POST['username'];
	$password = $_POST['password'];

	$found = false;
	foreach($_POST as $value)
	foreach($array_char as $word){
	if(substr_count($value, $word) > 0){
		$found = true;
		}
	}

	if($found){
		echo 'Please do not use special characters.';
	}
	else
	{
		$hashpass = md5($password);
		$getinfouser = sqlsrv_fetch_array(sqlsrv_query($db, "SELECT * FROM RohanUser.dbo.TUser where login_id = '$username' and login_pw = '$hashpass'"));

		if($getinfouser[1] != "")
		{
			if($getinfouser['active'] == 0)
			{
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['wallet'] = $getinfouser['wallet'];
				$_SESSION['active'] = $getinfouser['active'];
				//echo "<script>alert('Please activate your account first before you can play.')</script>";
				echo '<meta http-equiv="refresh" content="0;url=index.php" />';
			}
			else
			{
				session_start();
				$_SESSION['username'] = $username;
				$_SESSION['wallet'] = $getinfouser['wallet'];
				$_SESSION['active'] = $getinfouser['active'];
				//echo "<script>alert('Your account is already activated.')</script>";
				echo '<meta http-equiv="refresh" content="0;url=index.php" />';
			}
			
		}
		else
		{
			echo "<script>alert('Wrong Username or Password')</script>";
			echo '<meta http-equiv="refresh" content="0;url=index.php" />';
		}
		
	}
}

if(isset($_POST['Activate']))
{
	$array_char = array("'","/","\\","*",":","!","?", "&", "%", "ù","^", "$", "=","¨","{","}","(",")","~","[","]","ç","à","é","€","§",";","¤","°","£","`","<",">");

	$found = false;
	foreach($_POST as $value)
	foreach($array_char as $word){
	if(substr_count($value, $word) > 0){
		$found = true;
		}
	}

	if($found){
		echo 'Please do not use special characters.';
	}
	else
	{
		//error_reporting(0);
		session_start();
		$username = $_SESSION['username'];
		$wallet = $_SESSION['wallet'];
		$active = $_SESSION['active'];

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://deep-index.moralis.io/api/v2/$wallet/nft?chain=bsc&format=decimal",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"accept: application/json",
				"X-API-Key: OFU4DzntdMoWvQJqjXax1cuvHJwxCISTHNi0LguBXX2Omo3IDhgfBpJ4jhDqEroV"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$result = json_decode($response);
        
        foreach ($result->result as $r) {
            $getnftid = sqlsrv_query($db, "SELECT * FROM RohanWeb_Aureus.dbo.NFT WHERE active = '1'");
            while($row = sqlsrv_fetch_array($getnftid))
            {
                if($r->token_id == $row[1])
                {
                    $nft_id = $row[1];
					
                }
            }
        }
		
		if($wallet != "0xe8F6311A615b4E5f50bb2C6071c725518207337d")
		{
			if($nft_id != "")
			{
				$updatestatus = sqlsrv_query($db, "UPDATE RohanWeb_Aureus.dbo.NFT SET active = 0 WHERE nft_id = '$nft_id'");   

				if($updatestatus)
				{
					$activate = sqlsrv_query($db, "UPDATE RohanUser.dbo.TUser SET active = 1, token_id = '$nft_id' WHERE login_id = '$username'");
					
					if($activate)
					{
						$_SESSION['active'] = 1;
						echo "<script>alert('Congratulations, your account is now activated!')</script>";
						echo '<meta http-equiv="refresh" content="0;url=index.php" />';
					}
					else
					{
						echo "QUERY ERROR";
					}
				}
				else
				{
					echo "QUERY ERROR";
				}
			}
			else
			{
				echo '<script>alert("Sorry, your wallet does not have NFT!")</script>';
				echo '<meta http-equiv="refresh" content="0;url=index.php" />';
			}
		}
		else
		{
			echo '<script>alert("You cannot use this wallet address")</script>';
			echo '<meta http-equiv="refresh" content="0;url=index.php" />';
		}
		
	}
}
?>