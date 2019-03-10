<!DOCTYPE html>
<html lang="en">
<head>
    <title>Property Home Search | Create Ad </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="description for web page" />
    <link href="css/create_ad.css" rel="stylesheet" type="text/css" media="all" />
    <!--Script for slider-->
    <script type="text/javascript" src="js/create_ad_js_handler.js"></script>
    <!--Ajax script to post form data to server side script-->
    <script type="text/javascript" src="js/create_ad_ajax_script.js"></script>
    <!--// Meta tag Keywords -->
    <?php include 'header_include_files_scripts.php' ;?>
</head>
<body><!--TODO: Create alert if js is not active-->
    <?php include 'navigation.php' ;?>
    <div id="content_wrapper_create_ad">
        <div id="content_top_message">
            <h3>Create Ad</h3>
        </div>
            <form id="create_ad_form" enctype="multipart/form-data">
                <!--Type-->
                <label>Type: </label>
                <div id="radio_sale_rent" class="ad_content_inner_wrapper">
                    <!--Ad type-->
                    <div class="ad_content_div">
                        <label for="ad_type">Ad type: </label>
                            <input type="radio" name="sale_or_rent" id="ad_type_for_sale" value="sale" required="" onchange="hide_rent_div();" />For Sale
                            <input type="radio" name="sale_or_rent" id="ad_type_for_rent" value="rent" checked="checked" required="" onchange="show_rent_div();" />For Rent
                    </div>
                    <!--Property type-->
                    <div class="ad_content_div">
                        <label for="property_type">Property type: </label>
                        <select name="property_type" id="property_type" required="">
                            <option>Condo</option>
                            <option>Apartment</option>
                            <option>Serviced apartment</option>
                            <option>House</option>
                            <option>Villa</option>
                            <option>Penthouse</option>
                        </select>
                    </div>
                </div>
                <hr>
                <label>Location: </label>
                <div id="location" class="ad_content_inner_wrapper">
                    <!--City-->
                    <div class="ad_content_div">
                        <label for="city">City: </label><!--TODO: Get city from db list-->
                        <select name="city" id="city" required="" onchange="update_area_list(this.value);">
                            <option>Oslo</option>
                            <option>Trondheim</option>
                            <option>Bergen</option>
                            <option>Stavanger</option>
                            <option>Kristiansand</option>
                        </select>
                    </div>
                    <!--Area-->
                    <div id="outer_area_div">
                        <div class="ad_content_div">
                            <label for="area">Area: </label><!--TODO: Get areas based on city chosen from db. Do this by sending AJAX request to script when city input is changed(onchange event update_area_list) and populate drop down list with returned values-->
                            <select name="area" id="area" required="">
                                <option>Bjerke</option>
                                <option>Frogner</option>
                                <option>Slotsparken</option>
                                <option>Furuseth</option>
                                <option>Marka</option>
                                <option>Sagene</option>
                                <option>Ullern</option>
                                <option>Vindern</option>
                            </select>
                        </div>
                    </div>
                    <!--Address-->
                    <div class="ad_content_div">
                        <label for="address">Address: </label>
                        <input type="text" name="address" id="address" required=""/>
                    </div>
                </div>
                <hr>
                <label>Info: </label>
                <div id="info" class="ad_content_inner_wrapper">
                    <!--Bedrooms-->
                    <div class="ad_content_div">
                        <label for="bedrooms">Bedrooms: </label>
                        <select name="bedrooms" id="bedrooms" required="">                            
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <!--Bathrooms-->
                    <div class="ad_content_div">
                        <label for="bathrooms">Bathrooms: </label>
                        <select name="bathrooms" id="bathrooms" required="">                            
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <!--Size-->
                    <div id="size" class="ad_content_div">
                        <label for="size">Size(sqm): </label>
                        <input type="text" name="size" id="size" required=""/>
                    </div>
                    <!--Price-->
                    <div id="price" class="ad_content_div">
                        <label for="price">Price: </label>
                        <input type="text" name="price" id="price" required=""/>
                    </div>
                    <hr>
                    <!--Headline-->
                    <div class="ad_content_div">
                        <label for="headline">Headline: </label>
                        <input type="text" name="headline" id="headline" required=""/>
                    </div>
                    <!--Description-->
                    <div id="description_box">
                        <label for="description">Description: </label>
                        <textarea name="description" id="description" cols="50" rows="10"></textarea>
                    </div>
                    <!--Pictures--> <!--TODO: Let user add more pictures--> 
                    <div id="pictures" class="ad_content_div">
                        <label for="picture1">Pictures: </label>
                        <input type="file" name="picture1" id="picture1" required=""/> 
                        <input type="file" name="picture2" id="picture2" required=""/>
                        <input type="file" name="picture3" id="picture3" required=""/>
                        <input type="file" name="picture4" id="picture4" />
                        <input type="file" name="picture5" id="picture5" />
                    </div>
                </div>
                <hr>
                <!--Facilities-->
                <label>Facilities: </label><!--TODO: Get facilities from db.-->
                <br />
                <div id="facilities" class="ad_content_inner_wrapper">
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_svim" value="svimmingpool" />Svimmingpool
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_gym" value="gym" />Gym
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_sauna" value="sauna" />Sauna
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_bathtub" value="bathtub" />Bathtub
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_aircon" value="aircondition" />Aircondition
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_parking" value="parking" />Parking
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_sec_guard" value="securityguard" />Security guard
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_surveilance" value="surveilance" />Surveilance
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_reception" value="reception" />Reception
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_balcony" value="balcony" />Balcony
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_view" value="view" />View
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_elevator" value="elevator" />Elevator
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_garden" value="garden" />Garden
                    </div>
                    <div class="fac_div">
                        <input type="checkbox" name="facilities[]" id="fac_reading_hall" value="reading hall" />Reading hall
                    </div>
                </div>  
                <div class="clearfix"></div>
                <hr />
                <!--Rent rules-->
                <div id="renting_rule_hide_show_div"> <!--TODO: Get renting rules from db.-->
                    <label>Renting rules: </label>
                    <br />
                    <div id="renting_rules" class="ad_content_inner_wrapper">
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_pet" value="Pets allowed" />Pets allowed
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_smoking" value="Smoking allowed" />Smoking allowed
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_internet" value="Internet included" />Internet included
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_tv" value="TV included" />TV included
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_electricity" value="Electricity included" />Electricity included
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_furnishing" value="Furnished" />Furnished
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_cleaning" value="Cleaning included" />Cleaning included
                        </div>
                        <div class="rent_div">
                            <input type="checkbox" name="rent_rules[]" id="rule_washing_machine" value="Washing machine" />Washing machine
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                </div>
                <!--Distance-->
                <label>Distance(by walking): </label>
                <br />
                <div id="distance">
                    <!--Grocery store-->
                    <div class="distance_div">
                        <label for="grocery_store">Grocery store: </label>
                        <input type="range" name="grocery_store" id="grocery_store" min="0" max="51" value="0" required="" onchange="update_lbl_slider(1, this.value);"/>
                        <label id="lbl_slider_grocery">0</label>
                        <label class="lbl_slider_min">min.</label>
                    </div>
                    <!--Shopping mall-->
                    <div class="distance_div">
                        <label for="shopping_mall">Shopping mall: </label>
                        <input type="range" name="shopping_mall" id="shopping_mall" min="0" max="51" value="0" required="" onchange="update_lbl_slider(2, this.value);"/>
                        <label id="lbl_slider_shopping">0</label>
                        <label class="lbl_slider_min">min.</label>
                    </div>
                    <!--BTS/MRT-->
                    <div id="outer_bts_div">
                        <div class="distance_div">
                            <label for="bts">BTS/MRT: </label>
                            <input type="range" name="bts" id="bts" min="0" max="51" value="0" onchange="update_lbl_slider(3, this.value);" />
                            <label id="lbl_slider_bts">0</label>
                            <label class="lbl_slider_min">min.</label>
                        </div>
                    </div>
                </div>
                <!--Submit-->
                <div id="submit_create_ad">
                    <input id="create_ad_btn" type="submit" value="Save ad" onclick="create_ad_ajax_script(this);" />
                    <div id="ajax_feedback"></div>
                </div>
</form>
    </div>
    <?php include 'footer.php' ;?>
    <?php include 'footer_scripts.php' ;?>
</body>
</html>