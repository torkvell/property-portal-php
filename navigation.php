<!--nav-wrapper start-->
    <div class="nav-wrapper" id="home">
        <!--top-bar start-->
         <div class="top-search-bar">
            <div class="header-top-nav">
                <!--PHP to show the right menu elements. Checks if session variable is set to tell if a user is logged in or not-->
                <?php if (isset($_SESSION['user_id'])){
                          echo "<ul>";
                          echo      "<li><a href='user_main_page.php' class='nav-user'>HOME</a></li>";
                          echo      "<li><a href='create_ad.php' class='nav-user'>CREATE AD</a></li>";
                          echo      "<li><a href='my_ads.php' class='nav-user'>MY ADS</a></li>";
                          echo      "<li><a href='log_out.php' class='nav-user'>LOG OUT</a></li>";
                          echo "</ul>";
                      }
                      else{
                        echo "<ul>";
                        echo    "<li><a href='#' data-toggle='modal' data-target='#myModal3'><i class='fa fa-key' aria-hidden='true'></i>LOGIN</a></li>";
                        echo    "<li><a href='#' data-toggle='modal' data-target='#myModal4'><i class='fa fa-lock' aria-hidden='true'></i>REGISTER</a></li>";
                        echo "</ul>";
                      }
                ?>
            </div>
        </div>
        <!-- Modal3 Login --> <!--From w3layouts educational template ref. w3layouts-License.txt-->
        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content news-w3l">
                    <div class="modal-header">
                        <button type="button" class="close w3l" data-dismiss="modal">&times;</button>
                        <h4>Login Your Account</h4>
                        <!--Login-->
                        <div class="login-main wthree">
                            <!--We run AJAX to check if user exist in DB. See login_register_handler.js for further code path-->
                            <form id="login_form">
                                <!--TODO: Make sure you have fallback solution for placeholder-->
                                <input type="email" placeholder="Email" required="" name="email" class="placeholder required" />
                                <input type="password" placeholder="Password" required="" name="password" class="placeholder required" />
                                <input type="submit" id="login_btn" value="Login" onclick="login_register_handler(this)" />
                                <div id="result_login"></div>
                            </form>
                        </div>
                        <!--//Login-->
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- //Modal3 -->
        <!-- Modal4 Register --> <!--From w3layouts educational template ref. w3layouts-License.txt-->
        <div class="modal fade" id="myModal4" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content news-w3l">
                    <div class="modal-header">
                        <button type="button" class="close w3l" data-dismiss="modal">&times;</button>
                        <h4>Register Now</h4>
                        <!--Register-->
                        <div class="login-main wthree">
                            <form id="register_form">
                                <!--TODO: Make sure you have fallback solution for placeholder-->
                                <input type="text" placeholder="First name*" required="" name="first_name" class="required placeholder" />
                                <input type="text" placeholder="Last name*" required="" name="last_name" class="required placeholder" />
                                <input type="email" placeholder="Email*" required="" name="email" class="required placeholder" />
                                <input type="password" placeholder="Password*" required="" name="password" class="required placeholder" />
                                <input type="password" placeholder="Confirm Password*" required="" name="password2" class="required placeholder" />
                                <input type="text" placeholder="Phone Number" name="phone_number" class="placeholder" />
                                <input type="submit" id="register_btn" value="Register Now" onclick="login_register_handler(this)" />
                                <div id="result_register"></div>
                            </form>
                        </div>
                        <!--//Register-->
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- //Modal4 Register-->
        <!--//top-bar end-->
        <!-- navigation start-->
        <div class="top-nav">
            <nav class="navbar navbar-default">
                <!-- navbar mobile start -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- //navbar mobile end -->
                </div>
                <!-- navbar-header start -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#contact_us" class="hvr-underline-from-center active">Contact us</a></li>
                        <li><a href="#blog" class="hvr-underline-from-center scroll">Blog</a></li>
                        <li><a href="#agencys" class="hvr-underline-from-center scroll">Agencys</a></li>
                        <li><a href="#locations" class="hvr-underline-from-center scroll">Locations</a></li>
                        <li><a href="index.php" class="hvr-underline-from-center scroll">Search engine</a></li>
                    </ul>
                </div>
                <!-- //navbar header end -->
                <div class="clearfix"> </div>
            </nav>
        </div>
        <div class="clearfix"></div>
        <!-- //navigation end -->
    </div>
    <!--//nav-wrapper end-->