<!DOCTYPE html>
<html lang="en">
<head>
    <title>Property home Search | Master Page </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="description for web page"/>
<!--// Meta tag Keywords -->
    <?php include 'header_include_files_scripts.php' ;?>
    <link href="css/search_engine.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/google_map.js"></script>
    <!--Range slider-->
    <link rel="stylesheet" href="/css/ui_range_slider.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body onload=""> <!--TODO: Give user output if js not enabled-->
    <?php include 'navigation.php' ;?>
    <div class="clearfix">
        <div id="left_wrapper">
            <form id="searchengine_form">
                <div id="upper_box_wrapper">
                    <div id="for_rent_div" onclick="update_rent_div();">For Rent</div>
                    <div id="for_sale_div" onclick="update_sale_div();">For Sale</div>
                    <input type="text" name="for_rent" id="for_rent_input" value="true" hidden />
                    <input type="text" name="for_sale" id="for_sale_input" value="false" hidden />
                </div>
                <div id="search_box">
                    <!--City-->
                    <div id="city_div">
                        <label for="city">Location </label><!--TODO: Get city from db table-->
                        <select name="city" id="city_ddl" onchange="update_area_list(this.value);">
                            <option>Oslo</option>
                            <option>Trondheim</option>
                            <option>Bergen</option>
                            <option>Stavanger</option>
                            <option>Kristiansand</option>
                        </select>
                    </div>
                    <div id="sort_by_div">
                        <label for="sort_by">Sort by </label><!--Functionality not implemented-->
                        <select name="sort_by" id="sort_by_ddl" disabled>
                            <option disabled>Published</option>
                            <option disabled>Price low-high</option>
                            <option disabled>Price high-low</option>
                            <option disabled>Sqm high-low</option>
                            <option disabled>Sqm low-high</option>
                        </select>
                    </div>
                    <hr />
                    <div id="price_div">
                        <label for="price">Price</label>
                        <div class="slider_range" id="price_slider"></div>
                        <input type="text" name="price_min" id="price_min" value="0 $" class="txt_slider_left" readonly;>
                        <input type="text" name="price_max" id="price_max" value="5000000 $" class="txt_slider_right" readonly; />
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <label for="type" id="lbl_prop_type">Type </label>
                    <div id="property_type_div">
                        <div class="prop_type_div">
                            <input type="checkbox" name="property_type[]" value="Condo" checked/>Condo
                        </div>
                        <div class="prop_type_div">
                            <input type="checkbox" name="property_type[]" value="Apartment" checked />Apartment
                        </div>
                        <div class="prop_type_div">
                            <input type="checkbox" name="property_type[]" value="Serviced apartment" checked />Serviced apartment
                        </div>
                        <div class="prop_type_div">
                            <input type="checkbox" name="property_type[]" value="House" checked />House
                        </div>
                        <div class="prop_type_div">
                            <input type="checkbox" name="property_type[]" value="Villa" checked />Villa
                        </div>
                        <div class="prop_type_div">
                            <input type="checkbox" name="property_type[]" value="Penthouse" checked />Penthouse
                        </div>
                    </div>
                    <div class="outer_btn_div">
                        <!--Submit-->
                        <input id="submit_searchengine_btn" type="submit" value="SEARCH" onclick="submit_searchengine(this);" />
                        <!--More filters-->
                        <div id="show_more_filters_btn" onclick="showfilters()">+ More filters</div>
                    </div>
                    <!--User feedback if something goes wrong-->
                    <div id="ajax_feedback_top"></div>
                </div>
                <!--Searchbox Extension start-->
                <div id="search_box_extension">
                    <hr />
                    <div id="facility_div">
                        <label>Facilities</label>
                        <div id="facilities">
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_svim" value="Svimmingpool" />Svimmingpool
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_gym" value="Gym" />Gym
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_sauna" value="Sauna" />Sauna
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_bathtub" value="Bathtub" />Bathtub
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_aircon" value="Aircondition" />Aircondition
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_parking" value="Parking" />Parking
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_sec_guard" value="Securityguard" />Security guard
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_surveilance" value="Surveilance" />Surveilance
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_reception" value="Reception" />Reception
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_balcony" value="Balcony" />Balcony
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_view" value="View" />View
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_elevator" value="Elevator" />Elevator
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_garden" value="Garden" />Garden
                            </div>
                            <div class="fac_div">
                                <input type="checkbox" name="facilities[]" id="fac_reading_hall" value="Reading hall" />Reading hall
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!--Size-->
                    <div id="size">
                        <hr />
                        <label>Size: </label>
                        <div id="bedroom_div">
                            <label>Bedrooms</label>
                            <select name="bedrooms" id="bedroom_ddl">
                                <option>All</option>
                                <option>1+</option>
                                <option>2+</option>
                                <option>3+</option>
                                <option>4+</option>
                                <option>5+</option>
                            </select>
                        </div>
                        <div id="bathroom_div">
                            <label>Bathrooms</label>
                            <select name="bathrooms" id="bathroom_ddl">
                                <option>All</option>
                                <option>1+</option>
                                <option>2+</option>
                                <option>3+</option>
                                <option>4+</option>
                                <option>5+</option>
                            </select>
                        </div>
                        <div id="sqm_div">
                            <label for="size_slider">Sqm: </label>
                            <div name="size_slider" class="slider_range" id="size_slider"></div>
                            <input type="text" name="size_min" id="size_min" value="0" class="txt_slider_left" readonly;>
                            <input type="text" name="size_max" id="size_max" value="All" class="txt_slider_right" readonly; />
                        </div>
                    </div>
                    <!--Distance-->
                    <div id="distance">
                        <hr />
                        <label>Distance (by walking): </label>
                        <!--Grocery store-->
                        <div class="distance_div">
                            <label for="grocery_store_slider">Grocery store: </label>
                            <div class="slider_range" id="grocery_store_slider"></div>
                            <input type="text" name="distance_grocery_min" id="distance_grocery_min" value="0 min" class="txt_slider_left" readonly;>
                            <input type="text" name="distance_grocery_max" id="distance_grocery_max" value="more than 50 min" class="txt_slider_right" readonly;/>
                        </div>
                        <!--Shopping mall-->
                        <div class="distance_div">
                            <label for="shopping_mall_slider">Shopping mall: </label>
                            <div class="slider_range" id="shopping_mall_slider"></div>
                            <input type="text" name="distance_shopping_min" id="distance_shopping_min" value="0 min" class="txt_slider_left" readonly;>
                            <input type="text" name="distance_shopping_max" id="distance_shopping_max" value="more than 50 min" class="txt_slider_right" readonly; />
                        </div>
                        <!--BTS/MRT-->
                        <div id="outer_bts_div">
                            <div class="distance_div">
                                <label for="bts_slider">BTS/MRT: </label>
                                <div class="slider_range" id="bts_slider"></div>
                                <input type="text" name="distance_bts_min" id="distance_bts_min" value="0 min" class="txt_slider_left" readonly;>
                                <input type="text" name="distance_bts_max" id="distance_bts_max" value="more than 50 min" class="txt_slider_right" readonly; />
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="rent_rules_div">
                        <hr />
                        <label>Renting rules</label>
                        <div id="renting_rules">
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
                    </div>
                    <div id="area_div">
                        <hr />
                        <label>Areas</label>
                        <div id="inner_area_div">
                            <div class="area_div">
                                <!--TODO::Get content from database based on city choosen by using AJAX-->
                                <input type="checkbox" name="area[]" value="Bjerke" />Bjerke
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Frogner" />Frogner
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Slotsparken" />Slotsparken
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Furuseth" />Furuseth
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Marka" />Marka
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Sagene" />Sagene
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Ullern" />Ullern
                            </div>
                            <div class="area_div">
                                <input type="checkbox" name="area[]" value="Vindern" />Vindern
                            </div>
                        </div>
                    </div>                    
                    <div class="outer_btn_div">
                        <!--Submit-->
                        <input id="submit_searchengine_btn" type="submit" value="SEARCH" onclick="submit_searchengine(this);" />
                        <!--More filters-->
                        <div id="show_more_filters_btn" onclick="hidefilters()">- Less filters</div>
                        <!--User feedback if something goes wrong-->
                        <div id="ajax_feedback_bottom"></div>
                    </div>
                </div>
            </form>
            <div id="outer_ad_box_div">
                <!--<div class="ad_box">
                    <div class="picture_box"> <img src=""/></div>
                    <div class="info_box">
                        <div class="headline_box">Headline 45 characters long</div>
                        <div class="size_box">
                            <div class="sqm_box">185 Sqm</div>
                            <div class="bedroom_box">2 bed</div>                            
                        </div>
                        <div class="fac_box">Glyphicons </div>
                        <div class="price_box">500000000 $</div>
                    </div>
                </div>-->                
            </div>
        </div><!--End left wrapper-->
        <div id="map">
        </div>
    </div>
    <script type="text/javascript" src="js/searchengine.js"></script>
    <script type="text/javascript" src="js/searchengine_ajax.js"></script>
    <!--API for Google Maps-->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtykmo1_r2P4AwjnDdDsQub-hECM3yaU0&callback=initMap"></script>
    <?php include 'footer_scripts.php' ;?>
</body>
</html>