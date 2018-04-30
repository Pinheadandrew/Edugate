<?php
    if ($_SESSION['priv'] != 3)
    {
        header("Location: frontpage.php");
    }
?>