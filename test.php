<?php 
error_reporting(0);
include('dbconn.php'); 

        $curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://deep-index.moralis.io/api/v2/0x1009Ca3F14D0f75a462609678801E0b71360abeD/nft?chain=bsc&format=decimal",
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

        if($nft_id != "")
        {
            $updatestatus = sqlsrv_query($db, "UPDATE RohanWeb_Aureus.dbo.NFT SET active = 0 WHERE nft_id = '$nft_id'");   

            if($updatestatus)
            {
                echo "Your account is now activated!";
            }
            else
            {
                echo "QUERY ERROR";
            }
        }
        else
        {
            echo "You don't have NFT.";
        }
        

?>