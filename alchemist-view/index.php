<?php
    require_once("header.html");
?>

        <div class = "center_form_container">
            
            <div class = "form_container">

                <div class = "form_title">
                    <img src = "img/logo.png"/>
                </div>

                <form class = "login_form" name = "login_form" method = "POST" action = "php/check_login.php">
                    
                    <br />

                    <label>Hostname</label> <br />
                    <input type = "text" name = "host" required/> <br />
                    <br />

                    <label>Database name</label> <br />
                    <input type = "text" name = "db_name" required /> <br />
                    <br />

                    <label>Username</label> <br />
                    <input type = "text" name = "user" required /> <br /> 
                    <br />

                    <label>Password</label> <br />
                    <input type = "password" name = "pwd" /> <br />
                    <br />
                    
                    <br />

                    <button type = "submit" name = "submit_button">Login</button> <br />
                    <br />

                </form>

            </div>

        </div>

        <div id="error_msg">
            <?php 
                if(isset($_GET["error"])){
                    echo "<i class='fa fa-exclamation-triangle' style='font-size: 28px'></i> <br />" . $_GET["error"];
                }
            ?>
        </div>

    </div>
<?php
    require_once("footer.html");
?>