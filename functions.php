<?php
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function clean_distance_var($data){
    //if data="more than 50 min" data equals 51
    if($data=="more than 50 min"){
        $data=51;
        //else remove last 4 char from string
    }else{
        $data=substr($data, 0, -4);
    }
    //check if data only contain numbers
    if(!preg_match("/^[0-9]+$/", $data)) {
        exit("Distance value can only contain numbers!");
    }
    if(strlen($data)>45){
        exit($data. "can't be more than 45 characters long");
    }
    return $data;
}
function close_all_and_exit(){
    $sql_error=true;
    //Close statement
    $statement->close();
    //Database conn. close
    mysqli_close($conn);
    exit ("Something went wrong. Please contact web administrator");
}
function clean_post_array($data){
    //Clean all inputs and put in new array
    //Run foreach statement
    $count=0;
    include 'connect.php'; //Connect to database
    foreach($data as $row_data){
        ++$count;
        //MAX str. length in db=45
        if(strlen($row_data)>45){
            exit("Name of . $data. can't be more than 45 characters long");
        }
        $row_data=clean_input($row_data);
        $row_data = mysqli_real_escape_string($conn,$row_data);
        $data_array[$count]=$row_data;
    }
    //Database conn. close
    mysqli_close($conn);
    return $data_array;
}
function clean_property_array($property_id_array, $property_array){
    $property_array_temp=$property_array;
    $property_array=array();
    foreach($property_array_temp as $property){
        $property_id_prop_array=$property['property_id'];
        foreach($property_id_array as $property_id){
            if($property_id==$property_id_prop_array){
                $property_array[]=$property;
            }
        }
    }
    return $property_array;
}
?>