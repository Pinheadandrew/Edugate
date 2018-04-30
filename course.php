<?php
    require "checkforlogin.php"; 
    require "courseheader.php";
?>
            <h3><?php
                    require "database.php";
                    $query = 'SELECT course, course_name, syllabus FROM Section WHERE sectioncode = "'.$sectionID.'"';
                    $nameResult = $db->query($query);
                    
                    $resultArray = $nameResult->fetch_assoc();
                    $coursename = $resultArray['course_name'];
                    $syllabus = $resultArray['syllabus'];
                    $course = $resultArray['course'];
                    echo $coursename;
                ?>
            </h3>
            <p>
                <?php $syllabus = html_entity_decode($syllabus);
                    //$syllabus = strip_tags($syllabus);
                    echo $syllabus;
                ?>
            </p>
            <div id= "announcements">
                <h3>Announcements</h3>
                    <ul>
                    <?php
                        /* ORIGINAL SCRIPT, 6/17/17
                        
                        $notifications = "SELECT title, content, date FROM Notification WHERE sectioncode = $sectionID ORDER
                        BY date DESC"; 
                        
                        $nameResult = $db->query($notifications);
                        $resultArray = $nameResult->fetch_assoc();

                        if ($resultArray)
                        {
                            while ($resultArray)
                            {
                                $title = $resultArray['title'];
                                $content = html_entity_decode($resultArray['content']);
                                $date = $resultArray['date'];
                                echo "<li>$title- Posted on $date<div class=\"ann-content
                                \">
                                    $content</div></li>";
                                $resultArray = $nameResult->fetch_assoc();
                            }
                        }
                        else
                        {
                            echo "<em style= \"padding-left: 5px;\">No announcements.</em>";
                        }
                        */
            
                        /* Testing retrieval of month's name and day number from MySQL query
                           - Added date to SELECT clause in order to return time in date()operation. */
                        $notifications = "SELECT title, content, date, MONTHNAME(date) AS month, DAY(date) AS daynumber 
                        FROM Notification WHERE sectioncode = $sectionID ORDER
                        BY date DESC";
                        $nameResult = $db->query($notifications);
                        $resultArray = $nameResult->fetch_assoc();

                        if ($resultArray)
                        {
                            while ($resultArray)
                            {
                                $title = $resultArray['title'];
                                $content = html_entity_decode($resultArray['content']);
                                $month = substr($resultArray['month'], 0, 3);
                                $time = new DateTime($resultArray['date']);
                                $time = $time->format("g:i a");
                                /* $time = date("H:i",$resultArray['date']); */
                                $day = $resultArray['daynumber'];
                                echo "<li>$title- Posted on $month. $day at $time<div class=\"ann-content
                                \">
                                    $content</div></li>";
                                $resultArray = $nameResult->fetch_assoc();
                            }
                        }
                        else
                        {
                            echo "<li><em style= \"padding-left: 5px;\">No announcements.</em></li>";
                        }
                        $db->close();
                    ?>
                    </ul>
                <?php 
                    if ($_SESSION['priv'] == 2) { /* The teacher view can post new announcements.*/
                        ?>
                        <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
                            <script>
                                tinymce.init({
                                selector: '#syllabus'
                                });
                            </script>
                            <p><strong>Post New Announcement:</strong></p>
                            <form action= "postannouncement.php?courseID=<?php echo $sectionID; ?>" method= "post">
                              <label>Title: <input name= "title" type= "text" width= 100></label><br><br>
                              <textarea id= "syllabus" name="body" cols = "50" rows= "10"></textarea>
                              <input type= "submit" name= "announcement" value= "Post Announcement" >
                </form>
                        
                <?php } ?>
                <?php 
                   /* if ($_SESSION['priv'] == 2) {
                     echo "<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
                            <script>
                                tinymce.init({
                                selector: '#syllabus'
                                });
                            </script>
                            <p><strong>Post New Announcement:</strong>
                            </p><textarea id= \"syllabus\" name=\"syllabus\" 
                            cols = \"50\" rows= \"10\"></textarea>";
                            }*/
                ?>
            </div>
        </div>   <!-- Main body page -->
    </div>
</body>
</html>