
		<div class="left">
			<div class="left_panel_title">
				<img src="img/logo.png"/>
			</div>
			<div class="menu_left_panel">
				<form action="ts.php" method="POST">
					<ul>
						<li><a href="dashboard.php">Dashboard</a></li>

						<?php
							$sql = "SELECT ts_name FROM ts";
							$res = $mysqli->query($sql);

							while ($row = $res->fetch_assoc()) 
								echo "<li><a href='ts.php?ts_name=" . $row["ts_name"] . "'>" . $row["ts_name"] . "</a></li>";
							
						?>

					</ul>
				</form>
			</div>
		</div>

