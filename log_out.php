<!DOCTYPE html>
<html lang="en">
<head>
    <title>Property home Search | Log out </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="description for web page" />
    <!--// Meta tag Keywords -->
    <?php include 'header_include_files_scripts.php' ;?>
    <?php
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    ?>
</head>
<body>
    <?php include 'navigation.php' ;?>
    <div id="log_out" style="text-align: center; min-height: 250px; margin-top: 10%;" >
        <h3>You are now logged out!</h3>
    </div>
    <?php include 'footer.php' ;?>
    <?php include 'footer_scripts.php' ;?>
</body>
</html>