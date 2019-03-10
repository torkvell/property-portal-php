<!DOCTYPE html>
<html lang="en">
<head>
    <title>Property home Search | Profile page </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="description for web page" />
    <!--// Meta tag Keywords -->
    <link href="css/user_main_page.css" rel="stylesheet" type="text/css" media="all" />
    <?php include 'header_include_files_scripts.php' ;?>
    <?php
    $first_name= $_SESSION['first_name'];
    $last_name= $_SESSION['last_name'];
    ?>
</head>
<body onload="fallback()">
    <?php include 'navigation.php' ;?>
    <div id="user_main_page_content_wrapper">
        <div id="welcome_div">
            <?php echo "<h3> Welcome " .$first_name. " " .$last_name. "</h3>";?>
        </div>
        <div id="button_wrapper">
            <a href="profile.php">
                <div id="profile_btn" class="user_main_page_btn">
                    <h3>Profile</h3>
                </div>
            </a>
            <a href="create_ad.php">
                <div id="create_ad_btn" class="user_main_page_btn">
                    <h3>Create ad</h3>
                </div>
            </a>
            <a href="my_ads.php">
                <div id="my_ads_btn" class="user_main_page_btn">
                    <h3>My ads</h3>
                </div>
            </a>
            <a href="log_out.php">
                <div id="log_out_btn" class="user_main_page_btn">
                    <h3>Log out</h3>
                </div>
            </a>
</div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <?php include 'footer.php' ;?>
    <?php include 'footer_scripts.php' ;?>
</body>
</html>