<?php
    require "database.php";
    $studentID = $_GET['id'];           /* Collect assignment number, student number and grade filled in */
    $asgmt = $_GET['asgmt'];
    $sectionID = $_GET['courseID'];
    $new_grade = $_POST['grade'];

    /* Query ran to see if the student of that row has already been graded on the assignment.
       If yes, an UPDATE Statement is made to reset the score of that student's grade. Otherwise,
       a new record is inserted into the Grade table between the student, the assignment, and the new grade.*/

    $resultRow = $db->query("SELECT * FROM Grade WHERE asgmtID = $asgmt  
        AND studentID = $studentID");                                                    
    if ($resultRow->num_rows == 0)     /* If student has not yet been graded on that assignment, a new record is inserted into the                                       Grade table between the student, the assignment, and the new grade. */
    {
        $insert = $db->query("INSERT INTO Grade VALUES ($studentID, $asgmt, $new_grade)");
        header("Location: grademanager.php?courseID=$sectionID");
    }
    else               /* Otherwise, an UPDATE Statement is made to reset the score of that student's grade on the assignment. */
    {
        $update = $db->query("UPDATE Grade SET grade = $new_grade WHERE studentID = $studentID
            AND asgmtID = $asgmt");
        header("Location: grademanager.php?courseID=$sectionID");
    }
    $db->close();
?>