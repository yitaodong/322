<?php
session_start();
/*
//set session variable
$email = $_SESSION['email'];;
$uidsql = "SELECT `userID` FROM `user_data` WHERE `email`='$email'";
            
$result = $mysqli->query($uidsql);
$row = $result->fetch_assoc();
$uid = $row['userID'];
        //now we have current userID
$postname = $mysqli->escape_string($_POST['postname']);



$sql = "DELETE FROM `discussion` WHERE `userID` = '$uid' AND `postname` = '$postname'";

if($postresult = $mysqli -> query($sql)){
    $_SESSION['message'] = 'Success';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
else{
    $_SESSION['message'] = 'Post Failed';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}*/


$postID = $_POST['postID'];
$nc = count($postID);
if ($nc > 0)
{
    /*for($i=0;$i<$nc;$i++)
    {
        $post_id = $postID[$i];
        mysql_query("DELETE FROM data WHERE 'postID' ='$post_id'");

    }*/
    foreach ($postID as $post_id){
       $sql = "DELETE FROM `post` WHERE `postID` ='$post_id'";
        if($postresult != $mysqli -> query($sql)){
   
            $_SESSION['message'] = 'Post Failed';
            echo '<script type="text/javascript">
            window.location="http://veggiebirds.web.engr.illinois.edu/error.php;</script>';
        }
    }
}

?>