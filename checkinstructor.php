<?php
    $query = "SELECT instructorID FROM Section WHERE sectioncode = $sectionID";
    $runit = $db->query($query);
    $instructorID = $runit->fetch_assoc();
    $instructorID = $instructorID['instructorID'];
    
    if ($_SESSION['priv'] != 2 || $_SESSION['ID'] != $instructorID)
    {
        header("Location: frontpage.php");
    }
?>