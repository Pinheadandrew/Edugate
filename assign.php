<?php
    require "checkforlogin.php";
    $sectionID = $_GET['courseID'];
    require "database.php";
    require "checkinstructor.php";
    require "courseheader.php";
?>

            <h3>Content Management</h3>
            <?php 
                $asgname = addslashes($_POST["asgname"]);
                $duedate = $_POST["duedate"];
                $points = $_POST["points"];

                if ($asgname && $duedate && $points)
                {
                    $query = "INSERT into Assignment values( '', '$asgname', '$duedate', '$points', '$sectionID')";
                    $result = $db->query($query);

                    if ($result) 
                    {
                        echo "<br><h3>".$asgname." has been assigned.</h3>";
                    } 
                    else 
                    {
                        echo "<script>window.alert(\"An error has occurred. The assignment was not added.\");</script>";
                    }
                    $db->close();
                }
                else
                {
                    echo "<script>window.alert(\"An error has occurred. The assignment was not added.\");</script>";
                    header("Location: managecourse.php?course=".$course);
                }
            ?>
            <br><h3><a href= "managecourse.php?courseID=<?php echo $sectionID;?>" style= "color: lightgreen;">
                Back to Course Manager</a></h3>
        </div>
    </div>
    </body>
</html>