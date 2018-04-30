<?php require "checkforlogin.php"; ?>
<html>
    <head>
        <title>AndrewSigalasPHP</title>
        <link rel= "stylesheet" href="styles/main.css">
    </head>
<body>
    <div class="headerbar">  <!--- Header Bar--->
         <img id = "logo" src= "pics/edugatelogo.png">
         <img id = "msubanner" src= "pics/msu%20banner.png">
    </div>                  <!---Header Bar Containing Logo and --->
    <div class= "content">
        <div class="sidebar-navigation">
            <ul>
                <li><a href="courselist.php">Courses</a></li>
                <li><a href= "frontpage.php">Front Page</a></li>
                <?php
                    if ($_SESSION['priv'] == 3)
                    {
                        echo '<li><a href= "sitemanager.php">Site Manager</a></li>';
                    }
                ?>
                <li><a href="signout.php">Sign out</a></li>
            </ul>
        </div>  <!---Sidebar containing "Home", "Courses" Page --->
        
        <div class="maincontent">
            <h3>Content Management</h3>
        <?php
            $fname = $_POST["firstname"];
            $instructorID = htmlspecialchars($_POST["instructorID"]);
            $lname = $_POST["lastname"];
            $password = $_POST["password"];

            if (!$fname || !$lname || !$instructorID || !$password)
            {
                echo "<h3>You have not entered all the required details. <br>"
                    ."Please go back and try again.</h3>";
            }
            else
            {
                if (!get_magic_quotes_gpc()) 
                {
                    $fname = addslashes($fname);
                    $lname = addslashes($lname);
                    $instructorID = addslashes($instructorID);
                } 

                require "database.php";

                $query = "INSERT into Person VALUES( '', '$fname', '$lname', '$instructorID', PASSWORD('$password'), 2)";
                $result = $db->query($query);
                
                if ($result) 
                {
                  echo "<br><h3>".$fname." ".$lname." has been added as an Instructor!</h3>";
                  /* $users = "SELECT studentID, username FROM Student WHERE PASSWORD = ''";
                  $emptypasswords = $db->query($users);
                  $row = $emptypasswords->fetch_assoc();
                      
                  while($row)
                  {
                      $updatepassword = "UPDATE Student SET PASSWORD = PASSWORD('".$row['username']."') WHERE studentID = ".$row['studentID'];
                      $result = $db->query($updatepassword);
                      $row = $emptypasswords->fetch_assoc(); }*/
                } 
                else 
                {
                  echo "<script>window.alert(\"An error has occurred. The student was not added.\")</script>";
                }
                $db->close();
            }
        ?>
            <br><h3><a href= "sitemanager.php" style= "color: lightgreen;">Back to Site Manager</a></h3>
        </div>
    </div>
    </body>
</html>