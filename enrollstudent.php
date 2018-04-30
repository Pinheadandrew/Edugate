<?php
    require "checkforlogin.php";
    $sectionID= $_GET['courseID'];  // Gets $sectionCode to run queries.
    require "database.php";
    require "checkinstructor.php";
    require "courseheader.php";
?>
            <h3>Course Management</h3>
            <?php 
                if (empty($_POST["studentid"]))
                {
                    echo "<script>window.alert(\"An error has occurred. The input was not valid.\")</script>";
                }
                else
                {
                    $id = $_POST["studentid"];
                    $query = "INSERT into Enrolls_In values(".$id.", ".$sectionID.")";
                    $result = $db->query($query);
                    
                    if ($result)
                    {
                       $query2 = "SELECT firstname, lastname FROM Person WHERE studentID = $id";
                        $studentname = $db->query($query2);
                        $student = $studentname->fetch_assoc(); 
                        echo "<br><h3>".$student["firstname"]." ".$student["lastname"]." has been enrolled!</h3>";
                    } 
                    else 
                    {
                        echo "<script>window.alert(\"An error has occurred. The student was not enrolled.\")</script>";
                    }
                    $db->close();
                }
            ?>
            <br><h3><a href= "managecourse.php?courseID=<?php echo $sectionID; ?>" style= "color: lightgreen;">
            Back to Course Manager</a></h3>
        </div>
    </div>
    </body>
</html>