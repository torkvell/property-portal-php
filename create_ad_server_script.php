<?php
//Check if all required parameters are posted to script. If not: Exit script and give error message
if(isset($_POST['sale_or_rent']) && isset($_POST['property_type']) && isset($_POST['city']) && isset($_POST['area']) && isset($_POST['address']) && isset($_POST['bedrooms']) && isset($_POST['bathrooms'])
    && isset($_POST['size']) && isset($_POST['price']) && isset($_POST['headline']) && isset($_FILES['picture1']) && isset($_FILES['picture2']) && isset($_FILES['picture3'])){
    include 'functions.php';
    //-------------------------------CLEAN INPUT DATA-------------------------------//
    $sale_or_rent= clean_input($_POST['sale_or_rent']);
    $property_type=clean_input($_POST['property_type']);
    $city=clean_input($_POST['city']);
    $area=clean_input($_POST['area']);
    $address=clean_input($_POST['address']);
    $bedrooms=clean_input($_POST['bedrooms']);
    $bathrooms=clean_input($_POST['bathrooms']);
    $size=clean_input($_POST['size']);
    $price=clean_input($_POST['price']);
    $headline=clean_input($_POST['headline']);
    //-------------------------------INPUT CHECK-------------------------------//
    //-----------Ad type----------//
    //can only equals 'sale' or 'rent'
    if($sale_or_rent!='sale' && $sale_or_rent != 'rent'){
        exit("Ad type must have values 'sale' or 'rent'");
    }
    //-----------Property type---------//
    //data is cleaned - MAX str. length in db=45 - for extra security->check that parameter already exists in database
    if(strlen($property_type)>45 || strlen($property_type)<=0){
        exit("Property type can't contain more than 45 characters and can't be empty");
    }
    //-----------City----------//
    //data is cleaned - MAX str. length in db=45 - for extra security->check that parameter already exists in database
    if(strlen($city)>45 || strlen($city)<=0){
        exit("City can't contain more than 45 characters and can't be empty");
    }
    //-----------Area----------//
    //data is cleaned - MAX str. length in db=45 - for extra security->check that parameter already exists in database
    if(strlen($area)>45 || strlen($area)<=0){
        exit("Area can't contain more than 45 characters and can't be empty");
    }
    if($city!='Oslo'){ //TODO: We use this temporarily just for testing. Remove after ddl for area is populated from database with AJAX script
        $area='NA';
    }
    if(strlen($city)<=0){
        exit("City can't be empty");
    }
    //-----------Address----------//
    //data is cleaned - MAX str. length in db=45
    if(strlen($address)>45 || strlen($address)<=0){
        exit("Address can't contain more than 45 characters and can't be empty");
    }
    //-----------Bedrooms----------//
    //data is cleaned - can only contain numbers 0-99
    if(!preg_match("/^\d{1,2}$/", $bedrooms)){
        exit("Number of bedrooms can't be more than 99 or less than 0");
    }
    //-----------Bathrooms----------//
    //data is cleaned - can only contain numbers 0-99
    if(!preg_match("/^\d{1,2}$/", $bathrooms)){
        exit("Number of bathrooms can't be more than 99 or less than 0");
    }
    //----------Size----------//
    //data is cleaned - can only contain numbers 1-999
    if(!preg_match("/^\d{1,3}$/", $size)){
        exit("Size can't be less than 0 sqm. or more than 999 sqm.");
    }
    //-----------Price----------//
    //data is cleaned - can only contain numbers 0-9999999999
    if(!preg_match("/^\d{1,10}$/", $price)){
        exit("Price can't be less than 0 or more than 9999999999 ");
    }
    //-----------Headline----------//
    //data is cleaned - MAX str. length in db=25
    if(strlen($headline)>45 || strlen($headline)<=0){
        exit("Headline can't be more than 45 characters long and can't be empty"); //TODO: Show user how many characters left to use while typing
    }
    //-----------Description----------//
    //optional - MAX str. length in db=500
    if(isset($_POST['description'])){
        $description=clean_input($_POST['description']);
        if(strlen($description)>500){
            exit("Description can't be longer than 500 characters"); //TODO: Show user how many characters left to use while typing
        }
    }
    //-----------Facilities----------//
    //Clean all inputs and put in new array
    $facility_array=array();
    if(isset($_POST['facilities'])){
        //Run foreach statement
        $facility_count=0;

        foreach($_POST['facilities'] as $facility){
            ++$facility_count;
            //Facilities - MAX str. length in db=45
            if(strlen($facility)>45){
                exit("Name of facility can't be more than 45 characters long");
            }
            $facility=clean_input($facility);
            $facility_array[$facility_count]=$facility;
        }
    }
    //-----------Renting rules----------//
    //Clean all inputs and put in new array
    $rent_rule_array=array();
    if(isset($_POST['rent_rules'])){
        //Run foreach statement
        $rent_rule_count=0;

        foreach($_POST['rent_rules'] as $rent_rule){
            ++$rent_rule_count;
            //Facilities - MAX str. length in db=45
            if(strlen($rent_rule)>45){
                exit("Name of rent rule can't be more than 45 characters long");
            }
            $rent_rule=clean_input($rent_rule);
            $rent_rule_array[$rent_rule_count]=$rent_rule;
        }
    }
    //-----------Distance----------//
    //Grocery store
    if(isset($_POST['grocery_store'])){
        $grocery_store=clean_input($_POST['grocery_store']);
        if($grocery_store==0){
            exit("You need to provide info about distance to grocery store. It can't be 0");
        }
        if($grocery_store=="more than 50 min"){
            $grocery_store=51;
        }
        if($grocery_store=="less than 5 min"){
            $grocery_store=1;
        }
        if(!preg_match("/^\d{1,2}$/", $grocery_store)){
            exit("Distance to grocery store needs to be between 0 min. and 99 min.");
        }
    }
    else{
        exit("Missing data input for grocery store");
    }
    //Shopping mall
    if(isset($_POST['shopping_mall'])){
        $shopping_mall=clean_input($_POST['shopping_mall']);
        if($shopping_mall==0){
            exit("You need to provide info about distance to shopping mall. It can't be 0");
        }
        if($shopping_mall=="more than 50 min"){
            $shopping_mall=51;
        }
        if($shopping_mall=="less than 5 min"){
            $shopping_mall=1;
        }
        if(!preg_match("/^\d{1,2}$/", $shopping_mall)){
            exit("Distance to shopping mall needs to be between 0 min. and 99 min.");
        }
    }
    else{
        exit("Missing data input for shopping mall");
    }
    //BTS/MRT--Only required if Oslo is selected
    if(isset($_POST['bts'])){
        $bts=clean_input($_POST['bts']);
        if($_POST['city']=='Oslo'){
            if($bts==0){
                exit("You need to provide info about distance to bts/mrt. It can't be 0");
            }
            if($bts=="more than 50 min"){
                $bts=51;
            }
            if($bts=="less than 5 min"){
                $bts=1;
            }
        }
        else{
            $bts=99;
        }
        if(!preg_match("/^\d{1,2}$/", $bts)){
            exit("Distance to bts/mrt needs to be between 0 min. and 99 min.");
        }
    }else{
        exit("Missing data input for bts");
    }
    //-----------Pictures----------//
    // directory to store files
    $upload_directory= "/images/user_img/";
    // array to store filepaths
    $filepaths_img=array();
    //Define extensions that are allowed
    $expensions= array("jpeg","jpg","png","JPEG", "JPG","PNG");
    //Get the root path
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    //Variable to increment for each picture in foreach iteration below
    $row_number=1;
    //Go through all files and validate them

    ///TODO: If all pictures 1 to 3 are set and only contain jpeg,gif do foreach solution
    // TODO: If picture 4-5 is not empty and only contain jpeg, png do foreach solution

    foreach($_FILES as $picture=>$key){
        $fieldname = 'picture' .$row_number;
        $file_size = $_FILES[$fieldname]['size'];
        if($file_size==0 || $file_size==""){
            //If file size is 0 do nothing
        }else{
            $errors= false;
            $file_name = $_FILES[$fieldname]['name'];
            $file_size = $_FILES[$fieldname]['size'];
            $file_tmp = $_FILES[$fieldname]['tmp_name'];
            $file_type = $_FILES[$fieldname]['type'];
            $upload_file_path= SITE_ROOT.$upload_directory.$file_name;
            $tmp = explode('.', $file_name);
            $file_ext = end($tmp);

            //Exit and give error msg if file extension is not jpeg, jpg or png
            if(in_array($file_ext,$expensions)=== false){
                $errors=true;
                exit($fieldname. ": Extension not allowed, please choose a JPEG or PNG file.");
            }
            //Check that file size is not exceeded
            if($file_size > 8000000){
                $errors=true;
                exit($fieldname. ": File size can't be more than 8 MB");
            }
            //Make new name if file name exists
            $now = time();
            while(file_exists($upload_file_path)){
                $now++;
                $file_name= $now .$file_name;
                $upload_file_path= SITE_ROOT.$upload_directory.$file_name;//TODO: Improve by not uploading before checking if at least 3 valid pictures are selected
            }
            //TODO: Sanitize filename?
            if($errors==false){
                move_uploaded_file($file_tmp,$upload_file_path);
                $filepaths_img[$fieldname]=$upload_directory .$file_name;
            }else{
                exit("Something went wrong with picture uploads");
            }
        }
        ++$row_number;
    }
    //if upload file has less than 3 rows; Give error message
    if (count($filepaths_img) < 3){
        exit("You need to choose at least 3 pictures");
    }
    //-------------------------------Create SQL strings and insert into db-------------------------------//
    include 'connect.php'; //Connect to database

        //Check input for special characters//prevent against SQL injection
        //mysqli_real_escape_string: Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection.
        $ad_type_sql = mysqli_real_escape_string($conn,$sale_or_rent);
        $property_type_sql = mysqli_real_escape_string($conn,$property_type);
        $city_sql= mysqli_real_escape_string($conn,$city);
        $area_sql= mysqli_real_escape_string($conn,$area);
        $address_sql=mysqli_real_escape_string($conn,$address);
        $bedrooms_sql= mysqli_real_escape_string($conn,$bedrooms);
        $bathrooms_sql=mysqli_real_escape_string($conn,$bathrooms);
        $size_sql=mysqli_real_escape_string($conn,$size);
        $price_sql=mysqli_real_escape_string($conn,$price);
        $headline_sql=mysqli_real_escape_string($conn,$headline);
        $description_sql=mysqli_real_escape_string($conn,$description);
        $picture_paths=implode("!-<<-!", $filepaths_img);//All pictures will be stored in db as a complete string, separator is '!-<<-!'
        $picture_paths_sql=mysqli_real_escape_string($conn,$picture_paths);
        //Facility parameters gets cleaned in own solution
        //Renting rules parameters gets cleaned in own solution
        $grocery_store_sql=mysqli_real_escape_string($conn,$grocery_store);
        $shopping_mall_sql=mysqli_real_escape_string($conn,$shopping_mall);
        $bts_sql=mysqli_real_escape_string($conn,$bts);
        //----------------------------//
        //-----1. get property_type_id's from db
        //----------------------------//
        $sql="SELECT property_type_id FROM property_type WHERE property_type_name=?";
        //Make a prepared statement//prevent against SQL injection
        $statement= $conn->prepare($sql);
        //Bind parameters
        $statement->bind_param("s", $property_type_sql);
        //Execute query
        if ($statement->execute() === TRUE) {
            //Store result
            $statement->bind_result($property_type_id_returned);
            while ($statement->fetch()){
                //Put variables from db in new variables
                $property_type_id_sql=$property_type_id_returned;
                $sql_error=false;
            }
            //Close statement
            $statement->close();
        }else{
            $sql_error=true;
            //Close statement
            $statement->close();
            //Database conn. close
            mysqli_close($conn);
            exit("Something went wrong. Contact web admin");
            }
        //----------------------------//
        //-----2. Get city_id and area_id from db based on user input
        //----------------------------//
        $sql=("SELECT city.city_id, city_area.area_id FROM city, city_area WHERE city.city_id=city_area.city_id AND city_name=? AND area_name=?");
        //Make a prepared statement//prevent against SQL injection
        $statement= $conn->prepare($sql);
        //Bind parameters
        $statement->bind_param("ss", $city_sql, $area_sql);
        //Execute query
        if ($statement->execute() === TRUE) {
            //Store result
            $statement->bind_result($city_id_returned, $area_id_returned);
            while ($statement->fetch()){
                //Put variables from db in new variables
                $city_id_sql=$city_id_returned;
                $area_id_sql=$area_id_returned;
            }
            //Close statement
            $statement->close();
        }else{
            //Close statement
            $statement->close();
            //Database conn. close
            mysqli_close($conn);
            exit("Something went wrong. Contact web admin");
        }
        //----------------------------//
        //-----3. Now we insert everything into table for property
        //----------------------------//
        session_start(); //This is needed to hold SESSION variables and to get access to them
        $user_id=clean_input($_SESSION['user_id']);
        session_write_close();
        $sql =("INSERT INTO property (user_id, ad_type, property_type_id, city_id, area_id, address, bedrooms, bathrooms, size, price, headline, description, picture_paths, grocery_store, shopping_mall, bts_mrt) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        //Make a prepared statement//prevent against SQL injection
        $statement= $conn->prepare($sql);
        //Bind parameters
        $statement->bind_param("isiiisiiiisssiii", $user_id, $ad_type_sql, $property_type_id_sql, $city_id_sql, $area_id_sql, $address_sql, $bedrooms_sql, $bathrooms_sql, $size_sql, $price_sql, $headline_sql, $description_sql, $picture_paths_sql, $grocery_store_sql, $shopping_mall_sql, $bts_sql);
        //Execute query
        if ($statement->execute() === TRUE) {
            $sql_error=false;
            //Close statement
            $statement->close();
        }
        else{
            $sql_error=true;
            //Close statement
            $statement->close();
            //Database conn. close
            mysqli_close($conn);
            exit ("Something went wrong. Please contact web administrator");
        }
        //----------------------------//
        //-----4. Now we insert everything into table for property_facilities
        //----------------------------//
        //4.1 First we need the property_id from db
        if(count($facility_array)>0 && $sql_error==false){
            //We can use the picture paths as an unique key to get the property_id
            $sql =("SELECT property_id FROM property WHERE user_id=? AND picture_paths=?");
            $statement= $conn->prepare($sql);
            $statement->bind_param("ss", $user_id, $picture_paths_sql);
            if ($statement->execute() === TRUE) {
                $statement->bind_result($property_id_returned);
                while ($statement->fetch()){
                    $property_id=$property_id_returned;
                }
                $sql_error=false;
                //Close statement
                $statement->close();
            }else{
                $sql_error=true;
                //Close statement
                $statement->close();
                //Database conn. close
                mysqli_close($conn);
                exit ("Something went wrong. Please contact web administrator");
            }
            //4.2 Then we need the facility id for each facility types based on facility name from form. We go through all selected by using foreach
            foreach($facility_array as $facility){
                $sql =("SELECT facility_id FROM facilities WHERE facility_name=?");
                $statement= $conn->prepare($sql);
                $statement->bind_param("s", $facility);
                if ($statement->execute() === TRUE) {
                    $statement->bind_result($facility_id_returned);
                    while ($statement->fetch()){
                        $facility_id=$facility_id_returned;
                    }
                    $sql_error=false;
                    //Close statement
                    $statement->close();
                    //INSERT into property_facility table
                    $sql =("INSERT INTO property_facility (property_id, facility_id) VALUES(?,?)");
                    $statement= $conn->prepare($sql);
                    $statement->bind_param("ss", $property_id, $facility_id);
                    if ($statement->execute() === TRUE) {
                        $sql_error=false;
                        //Close statement
                        $statement->close();
                    }else{
                        $sql_error=true;
                        //Close statement
                        $statement->close();
                        //Database conn. close
                        mysqli_close($conn);
                        exit ("Something went wrong. Please contact web administrator");
                    }
                }else{
                    $sql_error=true;
                    //Close statement
                    $statement->close();
                    //Database conn. close
                    mysqli_close($conn);
                    exit ("Something went wrong. Please contact web administrator");
                }
            }
        }
        //---5---Now we insert everything into table for property_renting_rule
        //5.1 First we need the property_id from db
        if(count($rent_rule_array)>0 && $sql_error==false){
            //We can use the picture paths as an unique key to get the property_id
            $sql =("SELECT property_id FROM property WHERE user_id=? AND picture_paths=?");
            $statement= $conn->prepare($sql);
            $statement->bind_param("ss", $user_id, $picture_paths_sql);
            if ($statement->execute() === TRUE) {
                $statement->bind_result($property_id_returned);
                while ($statement->fetch()){
                    $property_id=$property_id_returned;
                }
                $sql_error=false;
                //Close statement
                $statement->close();
            }else{
                $sql_error=true;
                //Close statement
                $statement->close();
                //Database conn. close
                mysqli_close($conn);
                exit ("Something went wrong. Please contact web administrator");
            }
            //5.2 Then we need the renting_rule_id for each renting rule based on renting rule name from form. We go through all selected by using foreach
            foreach($rent_rule_array as $rent_rule){
                $sql =("SELECT renting_rule_id FROM renting_rules WHERE renting_rule_name=?");
                $statement= $conn->prepare($sql);
                $statement->bind_param("s", $rent_rule);
                if ($statement->execute() === TRUE) {
                    $statement->bind_result($rent_rule_id_returned);
                    while ($statement->fetch()){
                        $rent_rule_id=$rent_rule_id_returned;
                    }
                    $sql_error=false;
                    //Close statement
                    $statement->close();
                    //INSERT into property_renting_rule table
                    $sql =("INSERT INTO property_renting_rules (property_id, renting_rule_id) VALUES(?,?)");
                    $statement= $conn->prepare($sql);
                    $statement->bind_param("ss", $property_id, $rent_rule_id);
                    if ($statement->execute() === TRUE) {
                        $sql_error=false;
                        //Close statement
                        $statement->close();
                    }else{
                        $sql_error=true;
                        //Close statement
                        $statement->close();
                        //Database conn. close
                        mysqli_close($conn);
                        exit ("Something went wrong. Please contact web administrator");
                    }
                }else{
                    $sql_error=true;
                    //Close statement
                    $statement->close();
                    //Database conn. close
                    mysqli_close($conn);
                    exit ("Something went wrong. Please contact web administrator");
                }
            }
        }
        exit("success");
}
else{
    exit("Missing data inputs. Please try again");
}
?>