<!DOCTYPE html>
<html lang="en">
<head>
    <title>Property home Search | My ads </title>
    <!-- Meta tag Keywords -->    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="description for web page" />
    
    <!--// Meta tag Keywords -->
    <?php include 'header_include_files_scripts.php' ;?>
    <link href="css/my_ads.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <?php include 'navigation.php' ;?>
    <div id="content_wrapper_page">
        <div id="content_top_message">
            <h3>My ads</h3>
        </div>
        <?php
    //Connect to db and select all picture paths for user
    include 'connect.php'; //Database connection
    //Improved security by using mysqli_real_escape_string, protect against SQL-injection
    $user_id= $_SESSION['user_id'];
    $user_id = mysqli_real_escape_string($conn,$user_id);
    //GET user information based on email and password
    $sql = "SELECT headline, picture_paths FROM property WHERE user_id=?";
    //Prepare statement
    $statement= $conn->prepare($sql);
    //Bind parameters//protect against SQL-injection
    $statement->bind_param("i", $user_id);
    //Execute query
    if($statement->execute()===TRUE){
        //Bind result
        $statement->store_result();
        if($statement->num_rows>0){
            $statement->bind_result($headline, $picture_paths);
                while ($statement->fetch()){
                    $picture_array = explode("!-<<-!", $picture_paths);
                    $picture_path_1=$picture_array[0];
                    echo    "<div class='ad_content_wrapper'>";
                    echo    "<div class='heading'>";
                    echo        "<h3>$headline</h3>";
                    echo    "</div>";
                    echo    "<div class='picture_box'><img src='$picture_path_1'/></div>";
                    echo    "<div>";
                    echo        "<div class='viewbtn'>View</div>";
                    echo        "<div class='editbtn'>Edit</div>";
                    echo        "<div class='deletebtn'>Delete</div>";
                    echo    "</div>";
                    echo    "</div>";
                }
                session_write_close();
                //Close statement
                $statement->close();
                //Close database connection
                mysqli_close($conn);
            }else{
                session_write_close();
                //Close statement
                $statement->close();
                //Close database connection
                mysqli_close($conn);
                echo "<div id='err_msg'><h3>No ads registered yet</h3></div>";
        }
        }else{
            //Close statement
            $statement->close();
            //Close database connection
            mysqli_close($conn);
            echo("<div class='err_msg'><h3>Something went wrong. Contact web admin</h3></div>");
        }
        ?>
    </div>
    <div class="clearfix"></div>
    <?php include 'footer.php' ;?>
    <?php include 'footer_scripts.php' ;?>
</body>
</html>