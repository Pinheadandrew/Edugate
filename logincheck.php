<?php
    if(empty($_POST["user"]) || empty($_POST["password"]))
    {
        header('location: index.html'); 
    }
    else
    {   
        require "database.php";
        $user = $db->real_escape_string($_POST["user"]);
        $password = $db->real_escape_string($_POST["password"]);
        
        $query = "SELECT studentID, privilege FROM Person WHERE username = '$user' AND PASSWORD = PASSWORD('$password')";
        
        $user = $db->query($query);
        
        if ($user->num_rows != 1)
        {
            header('location: index.html');
            // header('location: index.html');
        }
        else
        {   
            $result = $user->fetch_assoc();
            session_start();
            $_SESSION['ID'] = $result['studentID'];
            $_SESSION['priv'] = $result['privilege'];
            header('location: frontpage.php');
        }
        $db->close();
    }
?>