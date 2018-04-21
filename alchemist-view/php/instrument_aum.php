<?php
	session_start();
   	
    require_once("check_session.php");


	$btc_price = $_GET["btc_usd_price"];
	$id = $_GET["id"];
	$tickers_price_txt = $_GET["tickers_price"];

	$tickers_price_txt = ltrim($tickers_price_txt, "{ } ");
	$tickers_price_txt = substr($tickers_price_txt, 0, -1);
	$filename_path = "../temp/" . $_SESSION["hostname"] . "_" . $_SESSION["username"] . "_" . $_SESSION["database"] . ".txt";

	if($id == 0){
		$myfile = fopen($filename_path, "w");
		fwrite($myfile, $tickers_price_txt);
		fclose($myfile);
	}
	else{
		$myfile = fopen($filename_path, "a");
		fwrite($myfile, ", " . $tickers_price_txt);
		fclose($myfile);
	}


	if($id == 1){

		$tickers_price_str = file_get_contents($filename_path, FILE_USE_INCLUDE_PATH);
		$tickers_price_str = "{" . $tickers_price_str . "}";
		$tickers_price = json_decode($tickers_price_str, true);


		$sql = "SELECT instrument_id, instrument_type FROM instrument";
	    $res = $mysqli->query($sql);

	    $instrument_type_aum = array();
	    while ($row = $res->fetch_assoc()){
	        $my_aum = 0;

	        $sql = "SELECT ticker, amount 
	                FROM ts NATURAL JOIN ptf_allocation NATURAL JOIN instrument 
	                WHERE instrument_type = '" . $row["instrument_type"] . "'";
	        $sec_res = $mysqli->query($sql);

	        
	        $ticker_amount = array();
	        while($tr_result = $sec_res->fetch_assoc())
	            $ticker_amount[$tr_result["ticker"]] = $tr_result["amount"];

	        if($row["instrument_type"] == "cryptocurrency"){
	        	foreach ($tickers_price as $ticker => $price){
	        		if (array_key_exists($ticker, $ticker_amount))
	                    $my_aum += ($price * $ticker_amount[$ticker]);
	        	}
	        }

	        $instrument_type_aum[$row["instrument_type"]] = $my_aum;
	    } 

	    if(array_key_exists("cryptocurrency", $instrument_type_aum))
	        $instrument_type_aum["cryptocurrency"] = $instrument_type_aum["cryptocurrency"] * $btc_price;

	    unlink($filename_path);

	    echo json_encode($instrument_type_aum);
	}

    
    
?>