<!--- Document containing list of . PHP will be deployed generate the list of that are 
also enrolled in that course by running SELECT query of all students . --->
<?php 
    require "checkforlogin.php"; 
    require "database.php";
    require "courseheader.php";
?>

            <h3>People</h3>
            <div id= "teacherbox">
                <h3>Instructor</h3>
                <?php
                    echo $db->query("SELECT CONCAT(firstname, ' ', lastname) AS teachername FROM Person, Section WHERE
                    Section.sectioncode = $sectionID AND Section.instructorID = Person.studentID")->fetch_assoc()
                        ['teachername'];
                ?>
            </div>
            <table class= "generatedtable">
                <tr><th>Name</th><th>Email</th><th>Role</th></tr>
                <?php                                       // Echos table of students enrolled in course.
                $query3 = 'SELECT firstname, lastname, username, privilege FROM Person, Enrolls_In WHERE Enrolls_In.sectioncode = '.$sectionID.
                    ' AND Enrolls_In.studentID = Person.studentID ORDER BY lastname';
                
                $studentsInCourse = $db->query($query3);
                $numOfStudents = $studentsInCourse->num_rows;
                
                for($j = 0; $j < $numOfStudents; $j++)
                {
                    $studentRow = $studentsInCourse->fetch_assoc();
                    echo "<tr><td>".$studentRow['firstname'].' '.$studentRow['lastname']."</td>";
                    echo "<td>".$studentRow['username']."@montclair.edu</td>";
                    echo "<td>";
                    switch($studentRow['privilege'])
                    {
                        case 1:
                            echo "Student</td></tr>";
                            break;
                        case 2:
                            echo "Teacher</td></tr>";
                            break;
                        case 3:
                            echo "Admin</td></tr>";
                            break;
                    }
                }
                $db->close();
                ?>
            </table>
        </div>  
    </div>
</body>
</html>