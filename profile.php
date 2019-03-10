<!DOCTYPE html>
<html lang="en">
<head>
    <title>Property home Search | Profile Page </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="description for web page" />
    <link href="css/profile_page.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/profile_update_handler.js"></script>
    <!--// Meta tag Keywords -->
    <?php include 'header_include_files_scripts.php' ;?>
    <?php
    $first_name= $_SESSION['first_name'];
    $last_name= $_SESSION['last_name'];
    $email=$_SESSION['email'];
    $phone_number=$_SESSION['phone_number'];
    ?>
</head>
<body>
    <?php include 'navigation.php' ;?>
    <div id="content_wrapper_profile_page">
        <div id="content_top_message">
            <h3>Profile</h3>
        </div>
        <div class="profile_update_form">
                <form id="profile_form">
                    <!--First name-->
                    <label for="first_name">First Name* </label>
                    <input type="text" required="" name="first_name" id="first_name" value="<?php echo $first_name; ?>" />
                    <!--Last name-->
                    <label for="last_name">Last Name* </label>
                    <input type="text" required="" name="last_name" id="last_name" value="<?php echo $last_name; ?>" />
                    <!--Email-->
                    <label for="email">Email* </label>
                    <input type="email" required="" name="email" id="email" value="<?php echo $email; ?>" />
                    <!--TODO: Enable password change-->
                    <!--Phone number-->
                    <label for="phone_number">Phone number </label>
                    <input type="text" name="phone_number" id="phone_number" value="<?php echo $phone_number; ?>" />
                    <!--Submit-->
                    <input type="submit" id="profile_update_btn" value="Update profile" onclick="profile_update_handler(this)" />
                    <div id="ajax_feedback"></div>
                </form>
            </div> 
    </div>
    <?php include 'footer.php' ;?>
    <?php include 'footer_scripts.php' ;?>
</body>
</html>