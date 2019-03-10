<?php
//Check if all required parameters are posted to script. If not: Exit script and give error message
if(isset($_POST['for_rent']) && isset($_POST['for_sale']) && isset($_POST['city']) && isset($_POST['price_min']) && isset($_POST['price_max']) && isset($_POST['bedrooms'])
    && isset($_POST['bathrooms']) && isset($_POST['size_min']) && isset($_POST['size_max']) && isset($_POST['distance_grocery_min']) && isset($_POST['distance_grocery_max']) && isset($_POST['distance_shopping_min'])
    && isset($_POST['distance_shopping_max']) && isset($_POST['distance_bts_min']) && isset($_POST['distance_bts_max']) ){
    include 'functions.php';
    //---------------------------------------------------------------------------------------------------//
    //-------------------------------INPUT CHECK
    //---------------------------------------------------------------------------------------------------//
    //----------------------------//
    //-----clean input
    //----------------------------//
    $for_rent= clean_input($_POST['for_rent']);
    $for_sale=clean_input($_POST['for_sale']);
    $city=clean_input($_POST['city']);
    //$sort_by=clean_input($_POST['sort_by']); //Not used in this version
    $price_min=clean_input($_POST['price_min']);
    $price_max=clean_input($_POST['price_max']);
    $bedrooms=clean_input($_POST['bedrooms']);
    $bathrooms=clean_input($_POST['bathrooms']);
    $size_min=clean_input($_POST['size_min']);
    $size_max=clean_input($_POST['size_max']);
    $grocery_min=clean_input($_POST['distance_grocery_min']);
    $grocery_max=clean_input($_POST['distance_grocery_max']);
    $shopping_min=clean_input($_POST['distance_shopping_min']);
    $shopping_max=clean_input($_POST['distance_shopping_max']);
    $bts_min=clean_input($_POST['distance_bts_min']);
    $bts_max=clean_input($_POST['distance_bts_max']);
    //----------------------------//
    //-----Ad type
    //----------------------------//
    //for_rent and for_sale can only equals 'true' or 'false' and can't be equal
    if($for_rent=="true" && $for_sale=="false"){
        $for_rent=true;
        $for_sale=false;
        $ad_type_sql="rent";
    }else if($for_rent=="false" && $for_sale=="true"){
        $for_rent=false;
        $for_sale=true;
        $ad_type_sql="sale";
    }else{
        exit("Error ad type rent & sale");
    }
    //----------------------------//
    //-----City
    //----------------------------//
    //data is cleaned - MAX str. length in db=45 - for extra security->check that parameter already exists in database
    if(strlen($city)>45 || strlen($city)<=0){
        exit("City can't contain more than 45 characters and can't be empty");
    }
    //----------------------------//
    //-----Sort by
    //----------------------------//
    //This functionality is not included in this version
    //data is cleaned
    //TODO:: Validate sorting parameter.
    //----------------------------//
    //-----Price min & max
    //----------------------------//
    //data is cleaned
    //remove $ symbol from string and check if only contains numbers 0-9
    $price_min= substr($price_min, 0, -2);
    $price_max= substr($price_max, 0, -2);
    if(!preg_match("/^[0-9]+$/", $price_min) || !preg_match("/^[0-9]+$/", $price_max)) {
        exit("Price can only contain numbers!");
    }
    //----------------------------//
    //-----Property type
    //----------------------------//
    if(isset($_POST['property_type'])){
        $count=0;
        //Loop through all property types set by user and create sql_string
        foreach($_POST['property_type'] as $property_type){
            $property_type= clean_input($property_type);
            //TODO: We whitelist user input by running this if statement. A better way would be to select all variables in db and do an in_array check. We need to whitelist the input as we don't use prepared statement
            if($property_type=="Condo" || $property_type=="Apartment" || $property_type=="Serviced apartment" || $property_type=="House" || $property_type=="Villa" || $property_type=="Penthouse"){
                //MAX str. length in db=45 - for extra security->check that parameter already exists in database
                if(strlen($property_type)>45 || strlen($property_type)<=0){
                    exit("Property type can't contain more than 45 characters and can't be empty");
                }
                if($count==0){
                    $property_type_sql= "'" .$property_type. "'";
                }
                else{
                    $property_type_sql=$property_type_sql. " OR property_type_name='" .$property_type. "'";
                }
                ++$count;
            }
            else{
                exit("Error on property type");
            }
        }
    }else{
        exit("Please choose an ad type");
    }
    //----------------------------//
    //-----Facilities
    //----------------------------//
    //Clean all inputs and put in new array
    if(isset($_POST['facilities'])){
        $facility_array=clean_post_array($_POST['facilities']);
    }
    //----------------------------//
    //-----Bedrooms
    //----------------------------//
    if($bedrooms!="All"){
        $bedrooms=substr($bedrooms, 0, -1);
    }else{
        $bedrooms=0;
    }
    //check if bedrooms only contain numbers
    if(!preg_match("/^[0-9]+$/", $bedrooms)) {
        exit("Bedrooms can only contain numbers!");
    }
    //----------------------------//
    //-----Bathrooms
    //----------------------------//
    if($bathrooms!="All"){
        $bathrooms=substr($bathrooms, 0, -1);
    }else{
        $bathrooms=0;
    }
    //check if bathrooms only contain numbers
    if(!preg_match("/^[0-9]+$/", $bathrooms)) {
        exit("Bedrooms can only contain numbers!");
    }
    //----------------------------//
    //-----Size min & Size max
    //----------------------------//
    //Check if size only contains numbers and not less than 0 or greater than 999
    if($size_min=="All" || $size_min>999){
        $size_min=999;
    }
    if($size_max=="All" || $size_min>999){
        $size_max=999;
    }
    if(!preg_match("/^[0-9]+$/", $size_min) || !preg_match("/^[0-9]+$/", $size_max)) {
        exit("Size min and max can only contain numbers!");
    }
    if( (!preg_match("/^\d{1,3}$/", $size_min)) || (!preg_match("/^\d{1,3}$/", $size_max)) ){
        exit("Size can't be less than 0 sqm. or more than 999 sqm.");
    }
    //----------------------------//
    //-----Distance variables
    //----------------------------//
    $grocery_min=clean_distance_var($grocery_min);
    $grocery_max=clean_distance_var($grocery_max);
    $shopping_min=clean_distance_var($shopping_min);
    $shopping_max=clean_distance_var($shopping_max);
    $bts_min=clean_distance_var($bts_min);
    $bts_max=clean_distance_var($bts_max);
    //----------------------------//
    //-----Renting rules
    //----------------------------//
    //Clean all inputs and put in new array
    if(isset($_POST['rent_rules'])){
        $rent_rule_array= clean_post_array($_POST['rent_rules']);
    }
    //----------------------------//
    //-----Areas
    //----------------------------//
    //Clean all inputs and put in new array
    $area_array=array();
    if(isset($_POST['area'])){
        $area_array= clean_post_array($_POST['area']);
    }
    //---------------------------------------------------------------------------------------------------//
    //-------------------------------Create SQL strings and select ads from db
    //---------------------------------------------------------------------------------------------------//
    include 'connect.php'; //Connect to database

    //Check input for special characters//prevent against SQL injection
    //mysqli_real_escape_string: Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection.
    $ad_type_sql = mysqli_real_escape_string($conn,$ad_type_sql);
    $city_sql= mysqli_real_escape_string($conn,$city);
    $price_min_sql= (int)mysqli_real_escape_string($conn,$price_min);
    $price_max_sql= (int)mysqli_real_escape_string($conn,$price_max);
    $bedrooms_sql=(int)mysqli_real_escape_string($conn,$bedrooms);
    $bathrooms_sql= (int)mysqli_real_escape_string($conn,$bathrooms);
    $size_min_sql=(int)mysqli_real_escape_string($conn,$size_min);
    $size_max_sql=(int)mysqli_real_escape_string($conn,$size_max);
    $grocery_min_sql=(int)mysqli_real_escape_string($conn,$grocery_min);
    $grocery_max_sql=(int)mysqli_real_escape_string($conn,$grocery_max);
    $shopping_min_sql=(int)mysqli_real_escape_string($conn,$shopping_min);
    $shopping_max_sql=(int)mysqli_real_escape_string($conn,$shopping_max);
    $bts_min_sql=(int)mysqli_real_escape_string($conn,$bts_min);
    $bts_max_sql=(int)mysqli_real_escape_string($conn,$bts_max);
    //----------------------------//
    //-----1. get property_type_id's from db
    //----------------------------//
    $sql="SELECT property_type_id FROM property_type WHERE property_type_name=$property_type_sql";
    //Execute query
    $result= $conn->query($sql);
    $property_type_id_array=array();
    while ($row = mysqli_fetch_array($result)) {
        $property_type_id_array[]= $row['property_type_id'];
    }
    //----------------------------//
    //-----2. Get city_id from db based on user input
    //----------------------------//
    $sql=("SELECT city_id FROM city WHERE city_name=?");
    //Make a prepared statement//prevent against SQL injection
    $statement= $conn->prepare($sql);
    //Bind parameters
    $statement->bind_param("s", $city_sql);
    //Execute query
    if ($statement->execute() === TRUE) {
        //Store result
        $statement->bind_result($city_id_returned);
        while ($statement->fetch()){
            //Put variables from db in new variables
            $city_id_sql=$city_id_returned;
        }
        //Close statement
        $statement->close();
    }else{
        //Close statement
        $statement->close();
        //Database conn. close
        mysqli_close($conn);
        exit("Something went wrong. Please contact web administrator");
    }
    //----------------------------//
    //-----3. Select all properties with search parameters from user input
    //-------3.1 Select all properties from property table in db with all property_type_id's set and put into multidimensional property_array
    //-------3.2 Loop through property_array and select only those properties which has the selected property_type_id selected by user
    //----------------------------//
    //3.1 Select all properties from property table in db with all property_type_id's set and put into multidimensional property_array
    $property_type_id_1=1;
    $property_type_id_2=2;
    $property_type_id_3=3;
    $property_type_id_4=4;
    $property_type_id_5=5;
    $property_type_id_6=6;
    $sql =("SELECT property_id, property_type_id, bedrooms, size, price, headline, picture_paths FROM property WHERE ad_type=? AND (property_type_id=? OR property_type_id=? OR property_type_id=? OR property_type_id=? OR property_type_id=? OR property_type_id=?) AND city_id=? AND bedrooms>=? AND bathrooms>=? AND size>=? AND size<=? AND price>=? AND price<=? AND grocery_store>=? AND grocery_store<=? AND shopping_mall>=? AND shopping_mall<=? AND bts_mrt>=? AND bts_mrt<=?");
    //Make a prepared statement//prevent against SQL injection
    $statement= $conn->prepare($sql);
    //Bind parameters
    $statement->bind_param("siiiiiiiiiiiiiiiiiii", $ad_type_sql, $property_type_id_1, $property_type_id_2, $property_type_id_3, $property_type_id_4, $property_type_id_5, $property_type_id_6, $city_id_sql, $bedrooms_sql, $bathrooms_sql, $size_min_sql, $size_max_sql, $price_min_sql, $price_max_sql, $grocery_min_sql, $grocery_max_sql, $shopping_min_sql, $shopping_max_sql, $bts_min_sql, $bts_max_sql);
    //Execute query
    if ($statement->execute() === TRUE) {
        //Store result
        $statement->bind_result($property_id, $property_type_id, $bedrooms, $size, $price, $headline, $picture_paths_returned);
        $property_array=array();
        while ($statement->fetch()){
            $picture_array=explode("!-<<-!",$picture_paths_returned);
            $picture_path_1=$picture_array[0];
            //Put variables from db into property_array
            $property_array[]= array("property_id"=>$property_id, "property_type_id"=>$property_type_id, "bedrooms"=>$bedrooms,"size"=>$size,"price"=>$price,"headline"=>$headline,"picture_path_1"=>$picture_path_1);
        }
        //Close statement
        $statement->close();
    }else{
        //Close statement
        $statement->close();
        //Database conn. close
        mysqli_close($conn);
        exit("Something went wrong. Please contact web administrator");
    }
    //3.2 Loop through property_array and select only those properties which has the selected property_type_id selected by user
    $property_array_temp=$property_array;
    $property_array=array();
        foreach($property_array_temp as $property){
            foreach($property_type_id_array as $property_type_id){
                $key=$property['property_type_id'];
                if($key==$property_type_id){
                    $property_array[]=$property;
                }
                }
            }
    //----------------------------//FACILITIES//--------------------------------//
    //-----4. If facilities are set: Sort out property_id's from property_array based on facilitys choosen by user
    //------4.1. Get all facility names from db
    //------4.2. Validate/whitelist facility name selected by user by comparing them with values from db
    //------4.3. Select all variables from property_facility table(join with facility table) and put into multidimensional array. We use this array to sort out property id's based on facilities choosen by user
    //------4.4. Loop through all property_ids in property_array and loop through all elements in prop_fac_array_db--> check if id's match
    //--------4.4.1. If id*s match put element facility_name into temp_fac_array
    //------4.5. If all elements in facility_array exist in temp_fac_array put property_id from property_array into  new property_array
    //------4.6 Loop through property_array and select only those properties which has the id in property_id_array --> create new property_array
    //----------------------------//
    if(isset($_POST['facilities'])){
        $property_id_array=array();
        //We loop through all facility inputs from user to validate them. We whitelist the input data by comparing it with values in db
        //4.1 Get all facility names from db
        $sql =("SELECT facility_name FROM facilities");
        $result= $conn->query($sql);
        $facility_name_db_array=array();
        while ($row = mysqli_fetch_array($result)) {
            $facility_name_db_array[] = $row['facility_name'];
        }
        // 4.2. Validate/whitelist facility name selected by user by comparing them with values in db
        foreach($facility_array as $facility_name){
            if(!in_array($facility_name, $facility_name_db_array)){
                //Database conn. close
                mysqli_close($conn);
                exit ("Something went wrong. Please contact web administrator");
            }
        }
        // 4.3. Select all variables from property_facility table(join with facility table) and put into multidimensional array. We use this array to sort out property id's based on facilities choosen by user
        //TODO: Improve SQL Query and select only those property id's which has values from facility_array
        $sql =("SELECT property_id, facility_name FROM facilities, property_facility WHERE facilities.facility_id=property_facility.facility_id ORDER BY property_id");
        $result= $conn->query($sql);
        $prop_fac_array_db=array();
        while ($row = mysqli_fetch_array($result)) {
            $prop_fac_array_db[] = array("property_id"=>$row['property_id'], "facility_name"=>$row['facility_name'])  ;
        }
        // 4.4. Loop through all property_ids in property_array and loop through all elements in prop_fac_array_db--> check if id's match
        $facility_array_count=count($facility_array);
        foreach($property_array as $property){
            $temp_fac_array=array();
            $property_id=$property['property_id'];
            foreach($prop_fac_array_db as $element){
                $element_prop_id=$element['property_id'];
                $element_fac_name=$element['facility_name'];
                //4.4.1. If id*s match put element facility_name into temp_fac_array
                if($element_prop_id==$property_id){
                    $temp_fac_array[]=$element_fac_name;
                }
            }
            //4.5. If all elements in facility_array exist in temp_fac_array put property_id from property_array into property_id_array
            $facility_array_intersect_count=count(array_intersect($facility_array,$temp_fac_array));
            if($facility_array_count==$facility_array_intersect_count){
                $property_id_array[]=$property_id;
            }
        }
        //4.6 Loop through property_array and select only those properties which has the id in property_id_array
        $property_array=clean_property_array($property_id_array, $property_array);
    }//end of facilities isset
    //----------------------------//RENTING RULES//--------------------------------//
    //-----5. If renting rules are set: Sort out property_id's from property_array based on renting_rules choosen by user
    //------5.1. Get all renting rule names from db
    //------5.2. Validate/whitelist renting rules inputs selected by user by comparing them with values from db
    //------5.3. Select all variables from renting_rules table(join with property_renting_rules table) and put into multidimensional array. We use this array to sort out property id's based on renting_rules choosen by user
    //------5.4. Loop through all property_ids in property_array and loop through all elements in prop_rent_rule_name_array_db--> check if id's match
    //--------5.4.1. If id*s match put element rent_rule_name from prop_rent_rules_array_db into temp_rent_rule_array
    //------5.5. If all elements in rent_rule_array exist in temp_rent_rule_array put property_id from property_array into property_id_array
    //------5.6 Loop through property_array and select only those properties which has the id in property_id_array --> create new property_array
    //----------------------------//
    if(isset($_POST['rent_rules']) && $ad_type_sql=="rent"){
        $property_id_array=array();
        //We loop through all renting rule inputs from user to validate them. We whitelist the input data by comparing it with values in db
        //5.1 Get all renting rules names from db
        $sql =("SELECT renting_rule_name FROM renting_rules");
        $result= $conn->query($sql);
        $rent_rule_name_db_array=array();
        while ($row = mysqli_fetch_array($result)) {
            $rent_rule_name_db_array[] = $row['renting_rule_name'];
        }
        // 5.2. Validate/whitelist renting rule name selected by user by comparing them with values in db
        foreach($rent_rule_array as $rent_rule_name){
            if(!in_array($rent_rule_name, $rent_rule_name_db_array)){
                //Database conn. close
                mysqli_close($conn);
                exit ("Something went wrong. Please contact web administrator");
            }
        }
        // 5.3. Select all variables from renting_rules table(join with property_renting_rules table) and put into multidimensional array. We use this array to sort out property id's based on renting_rules choosen by user
        //TODO: Improve SQL Query and select only those property id's which has values from rent_rule_array
        $sql =("SELECT property_id, renting_rule_name FROM renting_rules, property_renting_rules WHERE renting_rules.renting_rule_id=property_renting_rules.renting_rule_id ORDER BY property_id");
        $result= $conn->query($sql);
        $prop_rent_rule_name_array_db=array();
        while ($row = mysqli_fetch_array($result)) {
            $prop_rent_rule_name_array_db[] = array("property_id"=>$row['property_id'], "renting_rule_name"=>$row['renting_rule_name']);
        }
        // 5.4. Loop through all property_ids in property_array and loop through all elements in prop_rent_rule_name_array_db--> check if id's match
        $rent_rule_array_count=count($rent_rule_array);
        foreach($property_array as $property){
            $temp_rent_rule_array=array();
            $property_id=$property['property_id'];
            foreach($prop_rent_rule_name_array_db as $element){
                $element_prop_id=$element['property_id'];
                $element_rent_rule_name=$element['renting_rule_name'];
                //5.4.1. If id*s match put element renting_rule_name into temp_rent_rule_array
                if($element_prop_id==$property_id){
                    $temp_rent_rule_array[]=$element_rent_rule_name;
                }
            }
            //5.5. If all elements in rent_rule_array exist in temp_rent_rule_array put property_id from property_array into property_id_array
            $rent_rule_intersect_count=count(array_intersect($rent_rule_array,$temp_rent_rule_array));
            if($rent_rule_array_count==$rent_rule_intersect_count){
                $property_id_array[]=$property_id;
            }
        }
        //5.6 Loop through property_array and select only those properties which has the id in property_id_array
        $property_array=clean_property_array($property_id_array, $property_array);
    }//end of renting_rules isset
    //----------------------------//AREAS//--------------------------------//
    //-----6. If areas are set: Sort out property_id's from property_array based on areas choosen by user
    //------6.1. Get all area names from db
    //------6.2. Validate/whitelist area inputs selected by user by comparing them with values from db
    //------6.3. Create SQL string based on choosen area names. We don't use prepared statement as we need to create the string dynamically. The user input is also whitelisted by check against values in db.
    //------6.4. Select all property id's from property table in db where area name from user input equals area name from property table(join with city_area table)-->put into property_id_array
    //------6.5. Loop through property_array and select only those properties which has the id in property_id_array --> create new property_array
    //----------------------------//
    if(isset($_POST['area'])){
        //6.1. Get all area names from db
        $sql =("SELECT area_name FROM city_area");
        $result= $conn->query($sql);
        $rent_rule_name_db_array=array();
        while ($row = mysqli_fetch_array($result)) {
            $area_name_db_array[] = $row['area_name'];
        }
        // 6.2. Validate/whitelist area name selected by user by comparing them with values in db
        foreach($area_array as $area_name){
            if(!in_array($area_name, $area_name_db_array)){
                //Database conn. close
                mysqli_close($conn);
                exit ("Something went wrong. Please contact web administrator");
            }
        }
        //6.3. Create SQL string based on choosen area names. We don't use prepared statement as we need to create the string dynamically. The user input is also whitelisted by check against values in db.
        $area_sql="";
        $count=0;
        foreach($_POST['area'] as $area_name){
            if($count==0){
                $area_sql= "'" .$area_name. "'";
            }
            else{
                $area_sql=$area_sql. " OR area_name='" .$area_name. "'";
            }
            ++$count;
        }
        //6.4. Select all property id's from property table in db where area name from user input equals area name from property table(join with city_area table)-->put into property_id_array
        $sql =("SELECT property_id FROM property, city_area WHERE city_area.area_id=property.area_id AND city_area.city_id=property.city_id AND (area_name=$area_sql) ORDER BY property_id");
        $result= $conn->query($sql);
        $property_id_array=array();
        while ($row = mysqli_fetch_array($result)) {
            $property_id_array[] = $row['property_id'];
        }
        //6.5. Loop through property_array and select only those properties which has the id in property_id_array --> create new property_array
        $property_array=clean_property_array($property_id_array, $property_array);
    }//end of area isset
    if(count($property_array)>0){
        $string="";
        //Display property array to user
        foreach($property_array as $property){
            $img_path_1=$property['picture_path_1'];
            $headline=$property['headline'];
            $size=$property['size'];
            $bedrooms=$property['bedrooms'];
            $headline=$property['headline'];
            $price=$property['price'];
            $string= $string. "<div class='ad_box'>";
            $string= $string.    "<div class='picture_box'><img src='$img_path_1'/>";
            $string= $string.    "</div>";
            $string= $string.    "<div class='info_box'>";
            $string= $string.       "<div class='headline_box'>$headline</div>";
            $string= $string.       "<div class='size_box'>";
            $string= $string.           "<div class='sqm_box'>$size Sqm</div>";
            $string= $string.           "<div class='bedroom_box'>$bedrooms</div>";
            $string= $string.           "<div class='bed_glyphicon'><img src='/images/glyphicon_bed.png'/></div>";
            $string= $string.       "</div>";
            $string= $string.       "<div class='fac_box'></div>";
            $string= $string.       "<div class='price_box'>$price $</div>";
            $string= $string.   "</div>";
            $string= $string. "</div>";
            }
            //print json_encode($property(['property_id'], $property['bedrooms']);
        exit($string);
    }
    else{
        //Display no search results
        exit("No search result");
    }
}
else{
    exit("Missing data inputs. Please try again");
}
?>