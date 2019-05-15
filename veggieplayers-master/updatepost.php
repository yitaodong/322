<?php
session_start();
//set session variable
$email = $_SESSION['email'];;
$uidsql = "SELECT `userID` FROM `user_data` WHERE `email`='$email'";
            
$result = $mysqli->query($uidsql);
$row = $result->fetch_assoc();
$uid = $row['userID'];
if(!isset($uid) || !isset($email)){
    $_SESSION['message'] = 'Failed to get SESSION VARIABLES!';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
        //now we have current userID
if(!isset($_POST['postname']) || !isset($_POST['text']) || !isset($_POST['postID'])) {
    $_SESSION['message'] = 'Empty Input Field(s)!';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
$postname = $mysqli->escape_string($_POST['postname']);
$text = $mysqli->escape_string($_POST['text']);
$postId = $mysqli->escape_string($_POST['postID']);

$sql = "UPDATE `post` SET `postname` ='$postname', `text`='$text' WHERE `userID` = '$uid' AND `postID` = '$postId'";

if($postresult = $mysqli -> query($sql)){
    $_SESSION['message'] = 'Successfully Update!';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/success.php";
    </script>';
}
else{
    $_SESSION['message'] = 'Post Failed';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}

?>