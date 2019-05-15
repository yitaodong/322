<?php
session_start();

$sql = "SELECT COUNT(*), `userID` FROM `discussion` GROUP BY `userID`";

if($postresult = $mysqli -> query($sql)){
	while($row = $postresult ->fetch_assoc()){
			print($row['COUNT(*)']);
			print($row['userID']);
			print("\n");
	}


}
else{
    $_SESSION['message'] = 'Error happened';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
?>