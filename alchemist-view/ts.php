<?php    
    session_start();

    require_once("header.html");

	$ts_name = $_GET['ts_name'];

	if($ts_name == "Dashboard"){
		header("Location: dashboard.php");
        die();
    }

    require_once("php/check_session.php");
?>

<script src="js/coinmarketcap.js"></script>


<script>
    var tickers_price = get_tickers_price(600);
</script>

<?php
    $sql = "SELECT * FROM ts WHERE ts_name = '" . $ts_name . "'";
    $res = $mysqli->query($sql);

    $trading_system = array();
    while ($row = $res->fetch_assoc()) 
        $trading_system[] = $row;
    
    $trading_system = $trading_system[0];
    foreach ($trading_system as $key => $value)
        if(is_null($value))
            $trading_system[$key] = "Unknown";
    
?>

<?php
    $sql = "SELECT * FROM aum_history WHERE ts_name = '" . $ts_name . "' ORDER BY aum_datetime";
    $res = $mysqli->query($sql);

    $aum_history = array();
    while ($row = $res->fetch_assoc()) {
        $aum_history[] = $row;
    }
?>

<?php
    $sql = "SELECT * FROM ptf_allocation WHERE ts_name = '" . $ts_name . "'";
    $res = $mysqli->query($sql);

    $ptf_allocation = array();
    while ($row = $res->fetch_assoc()) 
        $ptf_allocation[] = $row;
    
?>

<?php
    $sql = "SELECT aum
            FROM aum_history 
            WHERE ts_name = '" . $ts_name . "' AND
                  aum_datetime = (SELECT MAX(d)
                                  FROM (SELECT aum_datetime AS d
                                        FROM aum_history
                                        WHERE ts_name = '" . $ts_name . "'
                                        ) AS T1
                                  )";
    $res = $mysqli->query($sql);

    $last_aum = array();
    while ($row = $res->fetch_assoc()) {
        $last_aum[] = $row["aum"];
    }
    $last_aum = $last_aum[0];
?>

<?php
    echo "\t\t<script>\n";
    echo "\t\t\tvar aum_history = " . json_encode($aum_history) . ";\n";
    echo "\t\t\tvar ptf_allocation = " . json_encode($ptf_allocation) . ";\n";
    echo "\t\t\tvar last_aum = " . json_encode($last_aum) . ";\n";
    echo "\t\t</script>\n";
?>

        <div class="main">

            <div class = "header">
                
                <?php echo $ts_name ?>

                <a href = "php/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>

            <div class="main_container">

                <div class="aum_visualization">
                    <canvas id="aum"></canvas>
                </div>

                <div class="allocation_visualizer">
                    <canvas id="allocation"></canvas>
                </div>
		
                <div class="details_visualizer">
                    <div class="center_table">
                        <table>
                            <?php
                                echo "<tr><td id='label'>Name</td><td id='value'>" . $trading_system["ts_name"] . "</td></tr>\n";
                                echo "<tr><td id='label'>Start date</td><td id='value'>" . $trading_system["datetime_added"] . "</td></tr>\n";
                                echo "<tr><td id='label'>Aum</td><td id='value'>" . $trading_system["aum"] . "</td></tr>\n";
                                echo "<tr><td id='label'>Portfolio type</td><td id='value'>" . $trading_system["ptf_type"] . "</td></tr>\n";
                                echo "<tr><td id='label'>Positions</td><td id='value'>" . count($ptf_allocation) . "</td></tr>\n";

                                $return = (end($aum_history)["aum"] - $aum_history[0]["aum"]) / $aum_history[0]["aum"] * 100;
                                echo "<tr><td id='label'>Return</td><td id='value'>" . round($return, 2) . "%</td></tr>\n";

                                //Calculate drawdowns
                                $drawdowns = array();
                                for($i = 0; $i < count($aum_history) - 1; $i++){
                                    if($aum_history[$i]["aum"] > $aum_history[$i + 1]["aum"]){
                                        $downtrend_arr = array();

                                        for($j = $i; $j < count($aum_history); $j++){
                                            if($aum_history[$j]["aum"] > $aum_history[$i]["aum"])
                                                break;
                                            $downtrend_arr[] = $aum_history[$j]["aum"];
                                        }

                                        $drawdowns[] = ((min($downtrend_arr) - $aum_history[$i]["aum"]) / ($aum_history[$i]["aum"]) * 100); 
                                    }
                                }

                                $max_drawdown = min($drawdowns);
                                echo "<tr><td id='label'>Max drawdown</td><td id='value'>" . round($max_drawdown, 2) . "%</td></tr>\n";

                            ?>
                        </table>
                    </div>
                </div>

            </div>

            <script src="js/line_chart.js"></script>
            <script src="js/doughnut_chart.js"></script>

        </div>

<?php
    require_once("left_panel.php");
?>
    </div>
<?php
    require_once("footer.html");
?>