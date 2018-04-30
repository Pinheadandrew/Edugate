<?php
            $title = $_POST["title"];
            $body = htmlspecialchars($_POST["body"]);
            $sectionID = $_GET['courseID'];

            if (!$body || !$title)
            {
                echo "<h3>You have not entered all the required details. <br>"
                    ."Please go back and try again.</h3>";
            }
            else
            {
                if (!get_magic_quotes_gpc()) 
                {
                    $title = addslashes($title);
                    $body = addslashes($body);
                } 
                
                $post_date = date("Y-m-d H:i:s"); // Gets current date and time of submission, YYYY-MM-DD hh:mm:ss

                require "database.php";

                $query = "INSERT into Notification VALUES( '', $sectionID, '$title', '$body', '$post_date')";
                $result = $db->query($query);
                
                if ($db->affected_rows == 1) 
                {
                  echo "New thing!";
                } 
                else 
                {
                  echo "No new thing!";
                }
                $db->close();
            }
        ?>