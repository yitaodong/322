<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1>Error</h1>
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        echo '<script type="text/javascript">
        window.location="http://veggiebirds.web.engr.illinois.edu/index.php";
        </script>';
    endif;
    ?>
    </p>     
    <a href="index.php"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>
