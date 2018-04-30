<?php require "checkforlogin.php"; 
    require "admincheck.php";?>
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
            $course = $_POST["coursecode"];
            $syllabus = addslashes(htmlspecialchars($_POST["syllabus"]));
            $title = $_POST["coursetitle"];
            $instructor = $_POST["instructor"];

            if (!$course || !$syllabus || !$title || !$instructor)
            {
                echo "<h3>You have not entered all the required details. <br>"
                    ."Please go back and try again.</h3>";
            }
            else
            {
                $title = addslashes($title);
                
                require "database.php";
                
                $query = "SELECT privilege FROM Person WHERE studentID = $instructor";
                $instructorcheck = $db->query($query);
                
                $instructorcheck = $instructorcheck->fetch_assoc();
                
                if (isset($instructorcheck['privilege']) && $instructorcheck['privilege'] != 2)
                {
                    echo "<script>window.alert(\"The instructor ID provided is not valid.\")</script>";
                }
                else
                {
                    $query = "INSERT into Section values( '', '$course', '$title', '$instructor', '$syllabus')";
                    $result = $db->query($query);

                    if ($result) 
                    {
                      echo "<br><h3>".$course." has been inserted into the sections listing.</h3>";
                    } 
                    else 
                    {
                      echo "<script>window.alert(\"An error has occurred. The class was not added.\")</script>";
                    }
                }
                /* $query = "INSERT into Section values ( '', '$course', '$title', '$instructor', '$syllabus')";
                $result = $db->query($query);

                if ($result) 
                {
                  echo "<br><h3>".$course." has been inserted into the sections listing.</h3>";
                } 
                else 
                {
                  echo "<script>window.alert(\"An error has occurred. The class was not added.\")</script>";
                } */
                $db->close();
            }
        ?>
            <br><h3><a href= "sitemanager.php" style= "color: lightgreen;">Back to Content Manager</a></h3>
        </div>
    </div>
    </body>
</html>