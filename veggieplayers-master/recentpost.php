<?php
//session_start();
//set session variable

$sql = "SELECT * FROM `post` ORDER BY `timestamp` DESC LIMIT 5";


if($result = $mysqli -> query($sql)){
    while($row = $result -> fetch_assoc()) {
    	echo "<br>NOW TITLE!!!". $row['postname']. "    HOW TEXT!!!". $row['text']. "<br>";
    }
}
else{
    $_SESSION['message'] = 'Post Failed';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
?>