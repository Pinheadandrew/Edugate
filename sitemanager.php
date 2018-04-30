<?php require "checkforlogin.php"; 
    require "admincheck.php"; ?>
<html>
    <head>
        <title>AndrewSigalasPHP</title>
        <link rel= "stylesheet" href="styles/main.css">
        <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
        <script>
          tinymce.init({
            selector: '#syllabus'
            });
        </script>
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
            <div class= "managecols">
                <form action= "addclass.php" method= "post">
                    <p><strong>Add class:</strong></p>
                    <p>Course code: <input type= "text" name="coursecode" maxlength = "7"/></p>
                    <p>Course title: <input type= "text" name="coursetitle" maxlength = "25"/></p>
                    <p>Instructor ID: <input type= "text" name="instructor" maxlength = "5"/></p>
                    <p>Syllabus:</p><textarea id= "syllabus" name="syllabus" cols = "50" rows= "10"></textarea>
                    <br><input type="submit" value="Add Course" />
                </form>
                <form action="addstudent.php" method="post">
                    <p><strong>Add student:</strong></p>
                    <p>First name: <input type= "text" name="firstname" maxlength = "15"/></p>
                    <p>Last name: <input type= "text" name="lastname" maxlength = "15"/></p>
                    <p>Student ID: <input type= "text" name="studentID" maxlength = "30"/></p>
                    <p>Password: <input type= "text" name="password" maxlength = "40"/></p>
                    <input type="submit" value="Add Student" />
                </form>
            </div>
            <div class= "managecols">
                <form action="addinstructor.php" method="post">
                    <p><strong>Add Instructor:</strong></p>
                    <p>First name: <input type= "text" name="firstname" maxlength = "15"/></p>
                    <p>Last name: <input type= "text" name="lastname" maxlength = "15"/></p>
                    <p>Institutional ID: <input type= "text" name="instructorID" maxlength = "30"/></p>
                    <p>Password: <input type= "text" name="password" maxlength = "40"/></p>
                    <input type="submit" value="Add Student" />
                </form>
            </div>
        </div>
    </div>
    </body>
</html>