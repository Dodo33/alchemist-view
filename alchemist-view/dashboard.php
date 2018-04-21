<?php    
    session_start();
    
    require_once("header.html");

    require_once("php/check_session.php");
?>


<script src="js/coinmarketcap.js"></script>


<script>
    var btc_usd_price = get_btc_usd_price();
    var tickers_price = get_tickers_price(750);
</script>


<script>

    function object_to_array_of_json(arr) {
        res = [];
        for(var key in arr)
            res.push(["\"" + key + "\":" + arr[key]]);
        return res;
    }

    function from_array_to_object(arr){
        json_string = "{";
        for(var i=0;i<arr.length;i++){
            json_string += (arr[i] + ",");
        }
		
		//Remove last char (,)
        json_string = json_string.substring(0, json_string.length - 1);
        json_string += "}";

        return JSON.parse(json_string);
    }

    function middle_element(arr){
        for(var i=0;i<arr.length;i++)
            if(i >= (arr.length / 2))
                return arr[i];
		return 0;
    }

    function from_json_array_to_2_array(arr, separator){
        first = [];
        second = [];

        middle = false;

        for(var i=0;i<arr.length;i++){
            if(arr[i] == separator)
                middle = true;

            if(middle == false)
                first.push(arr[i]);
            else
                second.push(arr[i]);
        }

        return [first, second];
    }

    arr = object_to_array_of_json(tickers_price);
    mid_elem = middle_element(arr);
    two_arrays = from_json_array_to_2_array(arr, mid_elem);

    console.log(arr);
    console.log(mid_elem);
    console.log(two_arrays);

    var sum_aum;

    //First request
    var xhttp = new XMLHttpRequest();
    var url = "php/instrument_aum.php?btc_usd_price=" + btc_usd_price + "&id=0&tickers_price=" + JSON.stringify(from_array_to_object(two_arrays[0]));

    //console.log(url);

    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);
        }
    };
    xhttp.open("GET", url, false);
    xhttp.send();


    //Second one
    var xhttp = new XMLHttpRequest();
    var url = "php/instrument_aum.php?btc_usd_price=" + btc_usd_price + "&id=1&tickers_price=" + JSON.stringify(from_array_to_object(two_arrays[1]));

    //console.log(url);

    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);
            sum_aum = xhttp.responseText;
        }
    };
    xhttp.open("GET", url, false);
    xhttp.send();


    sum_aum = JSON.parse(sum_aum);
</script>

		<div class = "main">
			<div class = "header">
				
				<img src = "img/logo.png" />

                <a href = "php/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
			</div>

			<div class = "main_container">

				<div id = "total_portfolios_value">
                    Total portfolios value: <span id = "span_ptfs_value"></span> $
                </div>

                <div class = "instrument_allocation">
                    <canvas id = "inst_all"></canvas>
                </div>

                <div class = "last_orders">
                    <table>
                        <tr>
                            <th>Datetime</th>
                            <th>Exchange</th>
                            <th>Asset</th>
                            <th>Instrument</th>
                            <th>Order type</th>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Broker</th>
                            <th>Operation</th>
                        </tr>
                        <?php
                            $sql = "SELECT * 
									FROM executed_order 
										 NATURAL JOIN (SELECT exchange_name, website AS exchange_website FROM exchange) AS exch
										 NATURAL JOIN (SELECT broker_name, website AS broker_website FROM broker) AS brok
                                         NATURAL JOIN instrument
									ORDER BY order_datetime 
									LIMIT 10";
                            $res = $mysqli->query($sql);
							
							#https://www.bittrex.com/Market/Index?MarketName=BTC-XVG
							#https://poloniex.com/exchange#btc_eth
                            while($row = $res->fetch_assoc()){
                                echo "<tr>";
                                echo "<td>" . $row["order_datetime"] . "</td>";
                                echo "<td><a href='https://" . $row["exchange_website"] . "'>" . $row["exchange_name"] . "</a></td>";
								
								if($row["exchange_name"] == "bittrex")
									$ticker = "<a href='https://" . $row["exchange_website"] . "/Market/Index?MarketName=BTC-" . $row["ticker"] . "'>" . $row["ticker"] . "</a>";
								else if($row["exchange_name"] == "poloniex")
									$ticker = "<a href='https://" . $row["exchange_website"] . "/exchange#btc_" . $row["ticker"] . "'>" . $row["ticker"] . "</a>";
								else
									$ticker = $row["ticker"];
									
                                echo "<td>" . $ticker . "</td>";
                                echo "<td>" . $row["instrument_type"] . "</td>";
                                echo "<td>" . $row["order_type"] . "</td>";
                                echo "<td>" . $row["amount"] . "</td>";

                                if($row["price"] == NULL)
                                    echo "<td>Unknown</td>";
                                else
                                    echo "<td>" . $row["price"] . "</td>";
                                
                                echo "<td><a href='https://" . $row["broker_website"] . "'>" . $row["broker_name"] . "</a></td>";
                                echo "<td>" . $row["operation"] . "</td>";
                                echo "</tr>";
                            }

                        ?>
                    </table>
                </div>

			</div>

			<script src = "js/pie_chart.js"></script>

            <script>
                var sum = 0;
                for(var key in sum_aum)
                    sum += sum_aum[key];
                
                document.getElementById("span_ptfs_value").innerHTML = Math.round(sum);
            </script>

		</div>

<?php
    require_once("left_panel.php");
?>

	</div>

<?php
    require_once("footer.html");
?>