<?php
    require "checkforlogin.php";
    require "database.php";
    require "courseheader.php";
?>

            <h3>Assignments</h3>
            <table class= "generatedtable">
                <tr><th>Name</th><th>Due Date</th><th>Score</th><th>Points</th></tr>
                    <?php    
                        $query2 = 'SELECT asgmtID, asgmtname, duedate, points FROM Assignment WHERE assigned_by = '.$sectionID
                            .' ORDER BY duedate'; 
                        $asgmtResult = $db->query($query2);
                        $numResults = $asgmtResult->num_rows;     /* sectioncode Of Course returned to be stored in variable for future query */
                        
                        if ($numResults == 0)
                        {
                            echo "<tr><td colspan = 4><em>No assignments</em></td></tr>";
                        }
                        else
                        {
                          /* Two variables to store the amounts of points the student has earned on assignments
                             they have been graded on (totalPoints) and the maximum amount of points (maxPoints), 
                             so they can be displayed as a percentage at the bottom of the table. */
                            
                          $totalPoints = 0;         
                          $highestPoints = 0;
                          for($j = 0; $j < $numResults; $j++)
                          {
                              $row= $asgmtResult->fetch_assoc();
                              $duedate = new DateTime($row['duedate']); // Converts due date from database to readable form,
                              $duedate = $duedate->format("M. j");     // i.e Mar. 25
                              
                              echo "<tr><td>".$row['asgmtname']."</td><td>$duedate</td>";

                              $query3 = "SELECT grade FROM Grade WHERE asgmtID = ".$row['asgmtID'].
                                  " AND studentID = ".$_SESSION['ID'];
                              $gradeResult = $db->query($query3);
                              $grade = $gradeResult->fetch_assoc();
                              if ($grade)
                              {
                                  echo "<td>".$grade['grade']."</td>";
                                  $totalPoints += $grade['grade'];
                                  $highestPoints += $row['points'];
                              }
                              else
                              {
                                 echo "<td> - </td>";
                              }
                              echo "<td>".$row['points']."</td></tr>";
                          }
                            echo "<tr><td colspan= 2><strong>Total</strong></td>
                                <td colspan= 2><strong> $totalPoints / $highestPoints</strong></td></tr>";
                        }
                        $db->close();
                    ?>
            </table>
        </div>
    </div>
    </body>
</html>