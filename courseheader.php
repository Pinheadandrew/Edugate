<?php
    $sectionID = $_GET['courseID'];
?>
<html>
    <head>
        <title>AndrewSigalasPHP</title>
        <link rel= "stylesheet"href="styles/main.css">
        <link rel= "stylesheet" href= "styles/coursestyle.css">
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
        <div class= "course-navigation">
            <ul>
                <li>
                   <a href="course.php?courseID=<?php echo $sectionID;?>">
                       <?php 
                        include "database.php";
                       $query = 'SELECT course FROM Section WHERE sectioncode = "'.$sectionID.'"';
                        $course = $db->query($query)->fetch_assoc()['course'];
                    
                    /*$resultArray = $nameResult->fetch_assoc();
                    $coursename = $resultArray['course']; */
                       
                       echo $course;?>
                   </a>
                </li>
                <li><a href="assignments.php?courseID=<?php echo $sectionID;?>">Assignments</a></li>
                <li><a href="people.php?courseID=<?php echo $sectionID;?>">People</a></li>
                <?php
                    if ($_SESSION['priv'] == 2)
                    {
                        echo '<li><a href="managecourse.php?courseID='.$sectionID.'">Manage Course</a></li>';
                        echo '<li><a href="grademanager.php?courseID='.$sectionID.'">Grades</a></li>';
                    }
                ?>
            </ul>
        </div>
        <div class="maincontent">