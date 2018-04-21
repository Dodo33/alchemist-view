function get_btc_usd_price(){
	var resp;

	var xhttp = new XMLHttpRequest();
  	var url = "https://api.coinmarketcap.com/v1/ticker/bitcoin/";

  	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	resp = JSON.parse(xhttp.responseText);
	    }
  	};
 	xhttp.open("GET", url, false);
  	xhttp.send();

  	return resp[0]["price_usd"];
}



function get_tickers_price(limit){
	var resp;

	var xhttp = new XMLHttpRequest();
  	var url = "https://api.coinmarketcap.com/v1/ticker/?limit=" + limit;

  	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	resp = JSON.parse(xhttp.responseText);
	    }
  	};
 	xhttp.open("GET", url, false);
  	xhttp.send();

  	var ret_array = {};

  	for(var i = 0; i < resp.length; i++){
  		ret_array[resp[i]["symbol"]] = resp[i]["price_btc"];
  	}

  	return ret_array;
}