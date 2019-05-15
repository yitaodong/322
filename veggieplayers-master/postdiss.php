<?php
session_start();
//set session variable
$email = $_SESSION['email'];;
$uidsql = "SELECT `userID` FROM `user_data` WHERE `email`='$email'";
        	
$result = $mysqli->query($uidsql);
$row = $result->fetch_assoc();
$uid = $row['userID'];
        //escape string
$postname = $mysqli->escape_string($_POST['postname']);
$text = $mysqli->escape_string($_POST['text']);

$sql = "INSERT INTO `post` (`postname`, `text`, `userID`) VALUES ('$postname', '$text', '$uid')";


if($postresult = $mysqli -> query($sql)){
    $_SESSION['message'] = 'Success';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/success.php";
    </script>';
}
else{
    $_SESSION['message'] = $postresult;
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
?>