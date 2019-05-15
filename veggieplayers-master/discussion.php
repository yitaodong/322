<?php
/* Page to post discussions */
require 'db.php';
session_start();
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Discussions</title>
    <link rel="stylesheet" type="text/css" href="css/discussion.css">
    <link rel="stylesheet" type="text/css" href="css/mypost.css">
    <link rel="stylesheet" type="text/css" href="css/post.css">
    <link rel="stylesheet" type="text/css" href="css/time.css">
</head>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['postdiss'])) {
    	REQUIRE 'postdiss.php';

    }

    elseif(isset($_POST['viewpost'])) {
    	REQUIRE 'viewpost.php';

    }
    elseif(isset($_POST['delete_post'])) {
    	REQUIRE 'deletepost.php';
    }
    elseif(isset($_POST['updatepost'])) {
    	REQUIRE 'updatepost.php';
    }
    elseif(isset($_POST['recentpost'])) {
      REQUIRE 'recentpost.php';
    }
    elseif(isset($_POST['searchtime'])) {
        REQUIRE 'searchtime.php';
    }
    elseif(isset($_POST['uploadtime'])) {
        REQUIRE 'uploadtime.php';
    }
    elseif(isset($_POST['returntologin'])){
    	session_destroy();
    	echo '<script type="text/javascript">
        window.location="http://veggiebirds.web.engr.illinois.edu/index.php";
        </script>';
    }

}

?>

<body>
 <div class="navbar">
  <div class="dropdown">
            <?php
                if(isset($_SESSION['username'])){
                    $username = $_SESSION['username'];
                    echo '<button onclick="myFunction()" class="dropbtn" style="width:100px;">'.$username.'<i class="fa fa-caret-down"></i></button>';
                }else{
                    $_SESSION['message'] = "Please Log in!";
                    echo '<script type="text/javascript">window.location="http://veggiebirds.web.engr.illinois.edu/error.php";</script>';
                }
            ?>
            <div id="myDropdown" class="dropdown-content">
                <a href="#profile"><font color="black">Profile</font color></a>
                <a href="logout.php"><font color="black">Log Out</font color></a>
            </div>
  </div>
  <a href="#contact">Contact</a>
  <a href="https://wiki.illinois.edu/wiki/display/cs411sp18/Veggiebirds">About</a>
  <a href="http://veggiebirds.web.engr.illinois.edu/discussion.php">Home</a>
 
</div>

<div class="blended_grid">
<div class="pageHeader">
   
</div>
  
<div class="pageLeftMenu">
</div>
  
<div class="pageContent">
      <!-- Tab links -->
    <div class="tab">
      <!--<button id = "d_section" class="tablinks" onclick="openSection(event, 'Game_Info')">Game Info</button>-->
      <button id = "d_section" class="tablinks" onclick="openSection(event, 'Posts')" style="width:20%;">Posts</button>
      <button class="tablinks" onclick="openSection(event, 'MyPosts')" style="width:20%;">My Posts</button>
      <button class="tablinks" onclick="openSection(event, 'Search')" style="width:20%;">Search</button>
      <button class="tablinks" onclick="openSection(event, 'Teammate')" style="width:20%;">Team</button>
      <button class="tablinks" onclick="openSection(event, 'Time')" style="width:20%;">Time</button>
    </div>

      <!-- Tab content -->
    <!--<div id="Game_Info" class="tabcontent">
      <h3>Game Info</h3>
      <p>Reserve for Game Info</p>
    </div>-->
    
    <div id="Teammate" class="tabcontent">
      <h3>Find my Teammates</h3>
      <form action="discussion.php" method="post" autocomplete="off">
      <button class="button button-block" name="searchtime"/>SEARCH</button>
    </form>
    </div>
    
    <div id="Time" class="tabcontent">
      <h3>Upload My Game Time</h3>
      <form class="time-form" action="discussion.php" method="post" autocomplete="off">
          <div class="field-wrap">
          <label class="time-label">
            START<span class="req">*</span>
              </label>
          <input type="number" required autocomplete="off" name="starttime" min="0"/>
        </div>

        <div class="field-wrap">
          <label class = "time-label">
            END<span class="req">*</span>
          </label>
          <input type="number" required autocomplete="off" name="endtime" min="0"/>
        </div>
      <button class="button button-block" name="uploadtime" />UPLOAD</button>
    </form>
    </div>

    <div id="Search" class="tabcontent">
        <h1>Search Post on Key</h1>
          <form action="discussion.php" method="post" autocomplete="off">

        <div class="field-wrap">
          <label>
            Key<span class="req">*</span>
              </label>
          <input type="text" required autocomplete="off" name="key"/>
        </div>

        <div class="field-wrap">
          <label>
            Weight of title to text<span class="req">*</span>
          </label>
          <input type="number" required autocomplete="off" name="weight" min="0"/>
        </div>

        <button class="button button-block" name="viewpost" />Search</button>
                
          </form>
        <div class="search-output">
            
        </div>
    </div>

    <div id="Posts" class="tabcontent">
      <!--<form action="discussion.php" method="post" autocomplete="off">-->
            <?php

                $sql = "SELECT * FROM `post` ORDER BY `timestamp` DESC";


                if($result = $mysqli -> query($sql)){
                    while($row = $result -> fetch_assoc()) {
    	                echo '<button id="'.$row["postID"].'" onclick="getPostText(this.id)">'.$row["postname"].'</button>
    	                    <div id="'.$row["postID"].'" name="textblock" style="display:none;">
    	                    <p>'.$row["text"].'</p>
    	                    </div>';
                    }
                    
                }
                else{
                    $_SESSION['message'] = 'Post Failed';
                    echo '<script type="text/javascript">window.location="http://veggiebirds.web.engr.illinois.edu/error.php";</script>';
                }
            ?>
      <!--<button class="button button-block" name="recentpost" />RECENT</button>-->
    <!--</form>-->
    </div>
        

    <div id="MyPosts" class="tabcontent">
      <!--<h3>My Posts</h3>
      <p>Reserve for My Posts</p>-->
      <form id="mypostform" action="discussion.php" method="post" autocomplete="off">
        <table class="my-post-table">
            <tr>
                <th></th>
                <th>Title</th>
            </tr>
            <!--Generate titles of my posts-->
            <?php
            $sql = "SELECT * FROM `post`, `user_data` WHERE `user_data`.`userID` = `post`.`userID` AND `email` = '$email' ORDER BY `timestamp` DESC";


            if($result = $mysqli -> query($sql)){
                while($row = $result -> fetch_assoc()) {
    	            echo '<tr>
    	                <td><input type="checkbox" name="postID[]" value="'. $row['postID']. '" ></td>
    	                <td id="post_name_cell">'. $row['postname']. '</td>
    	                <td id="post_text_cell" style="display:none;">'.$row['text'].'</td>
    	            </tr>';
                }
            }
            else{
                $_SESSION['message'] = 'Post Failed';
                 echo '<script type="text/javascript">
                window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
                    </script>';
            }
            ?>
        </table>
            <!-- BOTTOM BUTTON GROUP-->
            <input type="checkbox" id="select_all_btn" onclick='selectAll()'><span style="color:white;">Select All</span>
            <button class = "create_post" name="create_post" onclick="hideMyPosts()">Create</button>
            <button class = "edit_post" name="edit_post" onclick="getPostData()">Edit</button>
            <button class="deletePost" name= "delete_post">Delete</button>
      </form>
      
        <div class ="c_mypost" id="postdiss">
				<h1>Post your thoughts!</h1>
			    <form action="discussion.php" method="post" autocomplete="off">

				<div class="field-wrap">
					<label>
						Postname (Title)<span class="req">*</span>
					    </label>
					<input type="text" required autocomplete="off" name="postname"/>
				</div>

				<div class="field-wrap">
					<label>
						Content<span class="req">*</span>
					</label>
					<input type="text" required autocomplete="off" name="text"/>
				</div>

				<button class="button button-block" name="postdiss" />POST</button>
                
                <button class="return_mypost_post"/>RETURN</button>
			    </form>

		</div>
			
	    <div class ="c_mypost" id="editpost">
	            <form action="discussion.php" method="post" autocomplete="off">
	                <div class="field-wrap">
					    <label>
						    Postname (Title)<span class="req">*</span>
					    </label>
					    <input type="text" required autocomplete="off" id="editPostname" name="postname" value="postName"/>
				    </div>

				    <div class="field-wrap">
					    <label>
						    Content<span class="req">*</span>
					    </label>
					    <input type="text" required autocomplete="off" id="editText" name="text" value="editText"/>
				    </div>
				    
				    <div class="field-wrap" style="display:none;">
					    <label>
						    Post ID<span class="req">*</span>
					    </label>
					    <input type="edit_post_id" required autocomplete="off" id="edit_post_id" name="postID" value="postID"/>
				    </div>
				    
	                <button class="button button-block" name="updatepost" />Update</button>
                
                    <button class ="return_mypost_edit" />RETURN</button>
	            </form>
	    </div>
    </div>
</div>
  
<div class="pageRightMenu">
</div>
  
<div class="pageFooter">
    <footer class="footer">Copyright &copy; Veggiebirds</footer>
</div>
  
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    <script src="js/discussion.js"></script>
    <script>
    function openSection(evt, section) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(section).style.display = "block";
        evt.currentTarget.className += " active";
    }

    //User Drop Down list

    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    /*function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
     for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
     }
    }
    }
    */
    document.getElementById("d_section").click();

    /*select all checkboxes
    The idea of following function "selectAll" come from
    http://www.includehelp.com/code-snippets/javascript-select-unselect-check-unckecck-all-checkboxes.aspx*/
    function selectAll(){
    	var items = document.getElementsByName("postID[]")
    	var selectBTN = document.getElementById("select_all_btn")
    	if(selectBTN.checked==true)
        {
            for(var i=0; i<items.length; i++){
					if(items[i].type=='checkbox')
						items[i].checked=true;
		    }
        } else {
            for(var i=0; i<items.length; i++){
					if(items[i].type=='checkbox')
						items[i].checked=false;
		    }
        }
    }
    
    function hideMyPosts(){
        var posts = document.getElementById("mypostform")
        posts.style.display = "none";
    }
    
    function getPostData(){
        var checkboxes = document.getElementsByName("postID[]");
        var postIDs = []
        var numCheckedIDs = 0
        for(var i = 0; i <checkboxes.length; i++){
            if(checkboxes[i].checked){
                postIDs[numCheckedIDs] = checkboxes[i].value;
                numCheckedIDs +=1;
                
            }
        }
        if(numCheckedIDs == 1){
            var postID = postIDs[0];
            document.getElementById("edit_post_id").value = postID;
            document.getElementById('#mypostform').style.display="none";
            document.getElementById('#editpost').style.display = "block";
        } else if(postIDs.length < 1){
            alert("Please SELECT ONE post!");
            document.getElementById('#editpost').style.display = "none";
        } else{
            alert("CANNOT EDIT MULTIPLE posts!");
           document.getElementById('#editpost').style.display = "none";
        }
    }
    
    function getPostText(btn_id){
        
        var divs = document.getElementsByName("textblock");
        for(var i = 0; i < divs.length; i++) {
            if(divs[i].getAttribute("id") == btn_id){
                divs[i].style.display = "block";
                
            } else{
                divs[i].style.display = "none";
            }
        }
    }
    
    /*function searchData(){
        
        var aWeight = document.getElementsByName("weight")[0].value;
        var aKey = document.getElementsByName("key")[0].value;
       
        alert(aWeight);
        alert(aKey);
        var datastring = "weight=" + aWeight + "key=" + aKey;
        $.ajax({
            type: "POST",
            url: "viewpost.php",
            data: datastring,
            success: function( data ) {
                alert(data);
                $('.search_output').html(data);
            } 
        
        });
    }
    
    function searchTeam(){
        $.ajax({
            type: "POST",
            url: "searchtime.php",
            data: "",
            success: function( data ) {
                alert(data);
                //$('.search_output').html(data);
            } 
        
        });
    }*/
    </script>
    
</body>
</body>
</html>
