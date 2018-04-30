<?php
    require "checkforlogin.php";
    require "database.php";
    $sectionID= $_GET['courseID'];
    require "checkinstructor.php";
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
                       $query = 'SELECT course FROM Section WHERE sectioncode = '.$sectionID;
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
                        echo "<li><a href=\"managecourse.php?courseID=$sectionID\">Manage Course</a></li>";
                        echo "<li><a href=\"grademanager.php?courseID=$sectionID\">Grades</a></li>";
                    }
                ?>
            </ul>
        </div>
        <div class="maincontent">
            <h3>Course Management</h3>
            <form action= "assign.php?courseID=<?php echo $sectionID;?>" method= "post">
                <p><strong>Add assignment:</strong></p>
                <p>Name: <input type= "text" name="asgname" size = "35"/></p>
                <p>Due Date: <input type= "date" name="duedate" size = "10"/></p>
                <p>Points: <input type= "text" name="points" size= "3"/></p>
                <input type="submit" value="Add Assignment" />
            </form>
            <form action= "enrollstudent.php?courseID=<?php echo $sectionID; ?>" method="post">
                <p><strong>Enroll student:</strong></p>
                <p>Student Number: <input type= "text" name="studentid" size = "5"/></p>
                <input type="submit" value="Add Student" />
            </form>
        </div>
        <table id= "studenttable">
                <tr><th>Student Number</th><th>Name</th></tr>
                <?php 
                    include "database.php";
                    $query = "SELECT studentID, firstname, lastname 
                                FROM Person 
                                WHERE studentID NOT IN 
                                    (SELECT Person.studentID FROM Person 
                                     JOIN Enrolls_In
                                        ON Person.studentID = Enrolls_In.studentID
                                     WHERE Enrolls_In.sectioncode = $sectionID)
                                        AND privilege = 1"; 
                    $students = $db->query($query);
                    $resultCount= $students->num_rows; 
                
                    for ($i = 0; $i < $resultCount; $i++)
                    {
                        $student= $students->fetch_assoc();
                        echo "<td>".$student['studentID']."</td>";
                        echo "<td>".$student['firstname']." ".$student['lastname']."</td>";
                        echo "</tr>";
                    }
                    $db->close();
                ?>
            </table>
        </div>
    </body>
</html>