<?php
if ( (isset($_POST['first_name'])) && (isset($_POST['last_name'])) && (isset($_POST['email'])) && (isset($_POST['phone_number']))  ) {
    include 'functions.php';
    session_start(); //This is needed to hold SESSION variables and to get access to them
    $user_id=$_SESSION['user_id'];
    $email_before=$_SESSION['email'];

    //-------------------------------INPUT CHECK-------------------------------//
    //-----Clean input data-----//
    $first_name=clean_input($_POST['first_name']);
    $last_name=clean_input($_POST['last_name']);
    $email=clean_input($_POST['email']);
    $phone_number=clean_input($_POST['phone_number']);

    //-----Check first name-----//
    if (empty($first_name) || strlen($first_name) == 0) {
        exit("First name can't be empty");
    }
    if(preg_match('/[^A-Za-z\s-]/', $first_name)){
        exit("First name can only contain letters A-Z, whitespace and the hyphen symbol");
    }
    //-----Check last name-----//
    if (empty($last_name) || strlen($last_name) == 0) {
        exit("Last name can't be empty");
    }
    if(preg_match('/[^A-Za-z\s-]/', $last_name)){
        exit("Last name can only contain letters A-Z, whitespace and the hyphen symbol");
    }
    //-----Check email-----//
    if (empty($email) || strlen($email) == 0) {
        exit("Email can't be empty");
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        exit("Email is not a valid email address");
    }
    //Only allow numbers, hyphen, brackets, spaces and plus sign
    if((strlen($phone_number) > 0) && (!preg_match('/^(?=.*[0-9])[- +()0-9]+$/', $phone_number)) ){
        exit("Phone number not correct format!");
    }

    include 'connect.php'; //Kobler til database

    //-------------------------------CHECK IF EMAIL IS IN DATABASE ON ANOTHER USER-------------------------------//
    //Check input for special characters//prevent against SQL injection
    $email_sql = mysqli_real_escape_string($conn,$email);
    $user_id_sql=mysqli_real_escape_string($conn,$user_id);

    //Make SQL query
    $sql = ("SELECT email FROM user WHERE email=? AND NOT user_id=?") ;
    //Make a prepared statement//prevent against SQL injection
    $statement= $conn->prepare($sql);
    //Bind parameters
    $statement->bind_param("si", $email_sql, $user_id_sql);
    //Execute query
    if ($statement->execute() === TRUE) {
        //Store result
        $statement->store_result();
        //Check if we got any results from SQL-query
        if($statement->num_rows >= 1){
            //Close prepared statement
            $statement->close();
            //Close database connection
            mysqli_close($conn);
            $email_exists=true;
            exit("A user is already registered on this email!");
        }else{
            //Close prepared statement
            $statement->close();
            $email_exists=false;
        }

    }else{
        //Close prepared statement
        $statement->close();
        //Close database connection
        mysqli_close($conn);
        exit("Please contact web administrator");
    }

    //-------------------------------MAKE THE CORRECT SQL STRING-------------------------------//
    if ($email_exists==false){
        //Check input for special characters//prevent against SQL injection
        //mysqli_real_escape_string: Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection.
        $first_name_sql = mysqli_real_escape_string($conn,$first_name);
        $last_name_sql = mysqli_real_escape_string($conn,$last_name);
        $phone_number_sql= mysqli_real_escape_string($conn,$phone_number);
        //Phone number is optional so we run an if statement
        if($phone_number_sql=="" || $phone_number_sql==0){
            $sql =("UPDATE user SET first_name=? , last_name=?, email=? WHERE user_id=? AND email=?");
            $query=1;
        }else{
            $sql =("UPDATE user SET first_name=? , last_name=?, email=?, phone_number=? WHERE user_id=? AND email=?");
            $query=2;
        }
        //-------------------------------PREPARE AND RUN QUERY AND CREATE SESSION VARIABLES-------------------------------//
        //Make a prepared statement//prevent against SQL injection
        $statement= $conn->prepare($sql);
        //Bind parameters
        if($query==1){
            $statement->bind_param("sssis", $first_name_sql, $last_name_sql, $email_sql, $user_id_sql, $email_before);
        }elseif($query==2){
            $statement->bind_param("ssssis", $first_name_sql, $last_name_sql, $email_sql, $phone_number_sql, $user_id_sql, $email_before);
        }
        //Execute query
        if ($statement->execute() === TRUE) {
            //SELECT inserted variables from db and put in SESSION var.
            //Make SQL query
            $sql = ("SELECT user_id, first_name, last_name, email, phone_number FROM user WHERE email=? AND user_id=?") ;
            //Make a prepared statement//prevent against SQL injection
            $statement= $conn->prepare($sql);
            //Bind parameters
            $statement->bind_param("si", $email_sql, $user_id_sql);
            //Execute query
            if ($statement->execute() === TRUE) {
                //Store result
                $statement->bind_result($user_id, $first_name, $last_name, $email, $phone_number);
                //Check if we got any results from SQL-query
                while ($statement->fetch()){
                    //Put variables from db in SESSION variables
                    $_SESSION['user_id']=$user_id;
                    $_SESSION['first_name']=$first_name;
                    $_SESSION['last_name']=$last_name;
                    $_SESSION['email']=$email;
                    $_SESSION['phone_number']=$phone_number;
                }
                session_write_close();
                //Close statement
                $statement->close();
                //Database conn. close
                mysqli_close($conn);
                echo "success";
            }else{
                //Close statement
                $statement->close();
                //Database conn. close
                mysqli_close($conn);
                exit("Please contact web administrator");
            }
        }else{
            //Close statement
            $statement->close();
            //Database conn. close
            mysqli_close($conn);
            exit("Please contact web administrator");
        }
    }else{
        //Close statement
        $statement->close();
        //Database conn. close
        mysqli_close($conn);
        exit ("Please contact web administrator");
    }
}else{
    exit ("Try again");
}
?>