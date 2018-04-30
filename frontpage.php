<!DOCTYPE html>
<?php 
    require "checkforlogin.php"; 
    require "database.php";
    
    $query = "SELECT firstname FROM Person WHERE studentID = '".$_SESSION['ID']."'";
    $name = $db->query($query);
    $name = $name->fetch_assoc();
    $name = $name['firstname']
    ?>
<html>
    <head>
        <title>AndrewSigalasPHP</title>
        <link rel= "stylesheet" href="styles/main.css">
    </head>
<body>
    <div class="headerbar">  <!--- Header Bar--->
         <img id = "logo" src= "pics/edugatelogo.png">
         <img id = "msubanner" src= "pics/msu%20banner.png">
        <p>Signed in as <?php echo $name;?></p>
    </div> <!---Header Bar Containing Logo and --->
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
        </div> <!---Sidebar containing "Home", "Courses" Page --->
        <div class="maincontent">
            <h2>Welcome to Edugate, <?php echo $name; ?>!</h2>
            <p>Your one stop for evertyhing to graduate!</p>
            <br>
            <h3>Upcoming Assignments</h3>
            <p>*Under Construction*</p>
            <ul id= "recasgmts" class= "courselist">
            <?php
                $query = "SELECT Section.course, asgmtname, duedate FROM Section, Enrolls_In INNER JOIN Assignment ON Enrolls_In.sectioncode = Assignment.assigned_by WHERE Enrolls_IN.studentID = ".$_SESSION['ID']." AND Enrolls_In.sectioncode = Section.sectioncode ORDER BY Assignment.duedate";
                $name = $db->query($query);
                
                if ($name->num_rows >= 3)
                {
                    for ($i = 0; $i < 3; $i++)
                    {
                        $asginfo = $name->fetch_assoc();
                        $date = strtotime($asginfo['duedate']);
                        $duedate = date('m/d', $date);
                        echo "<li>".$asginfo['course']."- ".$asginfo['asgmtname'].": due $duedate</li>";
                    }
                }
                else
                {
                    if ($name->num_rows == 0)
                    {
                        echo "<em>No assignments coming up</em>";
                    }
                    while ($asginfo = $name->fetch_assoc())
                    {
                        $date = strtotime($asginfo['duedate']);
                        $duedate = date('m/d', $date);
                        echo "<li>".$asginfo['course']."- ".$asginfo['asgmtname'].": due $duedate</li>";
                    }
                        
                }
                $db->close();
            ?>
            </ul>
        <!---</div>
    </div>
</body>
</html>--->
<?php require "footer.php"; ?>
        