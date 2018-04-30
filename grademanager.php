<?php 
    require "checkforlogin.php";
    require "database.php";
    $sectionID = $_GET['courseID'];
    require "checkinstructor.php";
    require "courseheader.php";
?>
    <h3>Grades for 
    <?php
        
        /* Runs query to collect course name  */
        $query = "SELECT course FROM Section WHERE sectioncode = $sectionID"; 
        $course = $db->query($query)->fetch_assoc()['course'];
        echo $course;
    ?>
    </h3>

<div class= "gradesection">
    <ul>
        <?php    
            $query2 = 'SELECT asgmtID, asgmtname, duedate, points FROM Assignment WHERE assigned_by = '.$sectionID.
                              ' ORDER BY duedate'; 
            $asgmtResult = $db->query($query2);
            $numResults = $asgmtResult->num_rows;     /* Generates table with each of course's assignments listed, with
                                                         each student listed as a row, along with HTML input box of their score
                                                         ('-' if not graded yet) and a button to update score. */
                        
            if ($numResults == 0)
            {
                echo "<li>No Assignments to be Graded.</li>";
            }
            else
            {
                $row= $asgmtResult->fetch_assoc();                  
                while($row)
                {
                    $asgmtID = $row['asgmtID'];             /* Header of each table contains assignment's name, duedate, and                                                    points.
                    /* Header of each assignment table, */
                    echo "<li><table><tr class=\"headerrow\"><td>".$row['asgmtname'].       
                        "</td><td>".$row['points']." points</td><td>".$row['duedate']."</td></tr><tbody>";  
                    
                    /* Within each assignment's table, list of students */ 
                    $result3 = $db->query("SELECT Student.studentID, firstname, lastname        
                                            FROM Person as Student 
                                            JOIN Enrolls_In 
                                                ON Student.studentID = Enrolls_In.studentID 
                                            WHERE Enrolls_In.sectioncode = $sectionID 
                                            ORDER BY lastname");
                    $studentrow = $result3->fetch_assoc();
                    
                    while ($studentrow)
                    {
                        $studentID = $studentrow['studentID'];
                        echo "<tr><td>".$studentrow['firstname']." ".$studentrow['lastname']."</td><td></td>";
                        echo "<td><form action= \"postgrade.php?id=$studentID&asgmt=$asgmtID&courseID=$sectionID
                        \" method= \"post\"><input type = \"text\" name = \"grade\" maxlength = 3 value = ";
                        
                        $grade = $db->query("SELECT grade FROM Grade WHERE asgmtID = $asgmtID
                                 AND studentID = $studentID")->fetch_assoc()['grade'];
                        
                        if ($grade)
                        {
                            echo "\"$grade\"/>";
                        }
                        else
                        {
                             echo "\"-\"/>";
                        }
                        echo "<input type = \"submit\" value = \"Post Grade\" />
                              </form></td></tr>";
                        $studentrow= $result3->fetch_assoc();
                    }
                    echo "</tbody></table></li>";
                    
                    /* Run query to determine if there is a grade made for student on the                                            assignment that is headed. If there is for that student, display score in                                      HTML input. Else, display '-'". */

                    $row= $asgmtResult->fetch_assoc();
                }
            }
            $db->close();
        ?>
    </ul>
</div>
</div>
</body>

</html>