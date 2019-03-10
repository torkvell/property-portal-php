<?php
if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['phone_number']) ) {
    include 'functions.php';
    //-------------------------------INPUT CHECK-------------------------------//
    //-----Clean input data-----//
    $first_name=clean_input($_POST['first_name']);
    $last_name=clean_input($_POST['last_name']);
    $email=clean_input($_POST['email']);
    $phone_number=clean_input($_POST['phone_number']);

    $password = $_POST['password'];
    $password2= $_POST['password2'];

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
    //-----Check passwords-----//
    //Check if password is less than 7 digits.
    if(strlen($password) < 7){
        exit("Password must at least be 7 characters long!");
    }
    //if passwords are identical: strcmp return 0 if strings are identical(case sensitive)
    if(strcmp($password,$password2)!=0){
        exit("Passwords do not match!");
    }
    //Only allow numbers, hyphen, brackets, spaces and plus sign
    if((strlen($phone_number) > 0) && (!preg_match('/^(?=.*[0-9])[- +()0-9]+$/', $phone_number)) ){
        exit("Phone number not correct format!");
    }
    //-------------------------------CHECK IF EMAIL IS IN DATABASE ON ANOTHER USER-------------------------------//
    include 'connect.php'; //Connect to database
    $email_exists=true;
    //Check input for special characters//prevent against SQL injection
    $email_sql = mysqli_real_escape_string($conn,$email);

    //Make SQL query
    $sql = ("SELECT email FROM user WHERE email=?") ;
    //Make a prepared statement//prevent against SQL injection
    $statement= $conn->prepare($sql);
    //Bind parameters
    $statement->bind_param("s", $email_sql);
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
        $password_sql= mysqli_real_escape_string($conn,$password); //TODO: HASH password with salting before insert
        $phone_number_sql= mysqli_real_escape_string($conn,$phone_number);
        //Phone number is optional so we run an if statement
        if($phone_number_sql=="" || $phone_number_sql==0){
            $sql =("INSERT INTO user (first_name, last_name, email, password) VALUES (?,?,?,?)");
            $query=1;
        }else{
            $sql =("INSERT INTO user (first_name, last_name, email, password, phone_number) VALUES (?,?,?,?,?)");
            $query=2;
        }
        //-------------------------------PREPARE AND RUN QUERY AND CREATE SESSION VARIABLES-------------------------------//
        //Make a prepared statement//prevent against SQL injection
        $statement= $conn->prepare($sql);
        //Bind parameters
        if($query==1){
            $statement->bind_param("ssss", $first_name_sql, $last_name_sql, $email_sql, $password_sql);
        }
        if($query==2){
            $statement->bind_param("sssss", $first_name_sql, $last_name_sql, $email_sql, $password_sql, $phone_number_sql);
        }

        //Execute query
        if ($statement->execute() === TRUE) {
            //SELECT inserted variables from db and put in SESSION var.
            //Make SQL query
            $sql = ("SELECT user_id, first_name, last_name, email, phone_number FROM user WHERE email=?") ;
            //Make a prepared statement//prevent against SQL injection
            $statement= $conn->prepare($sql);
            //Bind parameters
            $statement->bind_param("s", $email_sql);
            //Execute query
            if ($statement->execute() === TRUE) {
                //Store result
                $statement->bind_result($user_id, $first_name, $last_name, $email, $phone_number);
                session_start(); //This is needed to hold SESSION variables and to get access to them
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
            exit ("Please contact web administrator");
        }
    }
    else{
        mysqli_close($conn);
        exit ("Please contact web administrator");
    }
}else{
    exit ("Try again");
}
?>