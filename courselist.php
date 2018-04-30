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
    </div> <!---Header Bar Containing Logo and --->
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
        <h2>Courses</h2>
        <ul class= "courselist">
            <?php
                include "database.php";
                    /* $db = new mysqli('localhost', 'admin', 'database12345!', 'andrewsigalasdatabase'); */
                    /* $query = "SELECT course, course_name FROM Section ORDER BY sectioncode"; */
                    
                switch ($_SESSION['priv'])
                {
                    case 1:
                        $query = "SELECT Section.sectioncode, Section.course, Section.course_name 
                                    FROM Enrolls_In 
                                    JOIN Section 
                                    ON Enrolls_In.sectioncode = Section.sectioncode 
                                    WHERE studentID = ".$_SESSION['ID'];

                        $sections = $db->query($query);
                        $resultsCount= $sections->num_rows;
                        
                        for ($i = 0; $i < $resultsCount; $i++)
                        {
                            $row = $sections->fetch_assoc();
                            echo '<li><a href= "course.php?courseID='.$row['sectioncode'].'">';
                            echo $row['course'].'- '.$row['course_name'].'</a></li>';
                        }
                        break;
                    case 2: /* In a teacher's view, courses that they are instructing are only listed.*/
                        $query = "SELECT sectioncode, course, course_name FROM Section WHERE instructorID = ".$_SESSION['ID'];
                        $sections = $db->query($query);
                        $resultsCount= $sections->num_rows;

                        for ($i = 0; $i < $resultsCount; $i++)
                        {
                            $row = $sections->fetch_assoc();
                            echo '<li><a href= "course.php?courseID='.$row['sectioncode'].'">';
                            echo $row['course'].'- '.$row['course_name'];
                            
                            /* Query pushed to retrieve number of students enrolled in a course.*/
                            $query2 = "SELECT count(*) AS studentcount FROM Enrolls_In WHERE sectioncode = ".
                                $row['sectioncode']." GROUP BY sectioncode";
                            $student_count = $db->query($query2)->fetch_assoc()['studentcount'];
                            echo " ($student_count students)</a></li>";
                        }
                        break;
                    case 3:             /* Admin view can view every course stored.*/
                        $query = "SELECT sectioncode, course, course_name FROM Section";
                        $sections = $db->query($query);
                        $resultsCount= $sections->num_rows;

                        for ($i = 0; $i < $resultsCount; $i++)
                        {
                            $row = $sections->fetch_assoc();
                            echo '<li><a href= "course.php?courseID='.$row['sectioncode'].'">';
                            echo $row['course'].'- '.$row['course_name'];
                            
                            $query2 = "SELECT count(*) AS studentcount FROM Enrolls_In WHERE sectioncode = ".
                                $row['sectioncode']." GROUP BY sectioncode";
                            $student_count = $db->query($query2)->fetch_assoc()['studentcount'];
                            echo " ($student_count students)</a></li>";
                        }
                        break;
                }
                $db->close();
            ?>
        </ul>
    </div>
</body>
</html>