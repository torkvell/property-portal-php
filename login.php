<?php
include 'functions.php';
if ( isset($_POST['email']) && isset($_POST['password'])) {
    //-------------------------------INPUT CHECK-------------------------------//
    //-----Clean input data-----//
    $email = clean_input($_POST["email"]);
    $password = $_POST["password"];
    //Check if email is empty
    if (empty($_POST["email"]) || strlen($email) == 0) {
        exit("Email is empty");
    }else{
        //Check if email is formated correctly
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            exit("Email is not a valid email address");
        }
    }
    //Check if password is empty
    if (empty($_POST["password"]) || strlen($password) == 0) {
        exit("Password is empty");
    }
    //-------------------------------Connect, create, execute, close, handle-------------------------------//
    include 'connect.php'; //Database connection
    //Improved security by using mysqli_real_escape_string, protect against SQL-injection
    $email_sql = mysqli_real_escape_string($conn,$email);
    $password_sql = mysqli_real_escape_string($conn,$password);
    //GET user information based on email and password
    $sql = "SELECT user_id, first_name, last_name, email, phone_number FROM user WHERE email=? AND password=?" ;
    //Prepare statement
    $statement= $conn->prepare($sql);
    //Bind parameters//protect against SQL-injection
    $statement->bind_param("ss", $email_sql, $password_sql);
    //Execute query
    if($statement->execute()===TRUE){
        //Bind result
        $statement->store_result();
        if($statement->num_rows>=1){
            $statement->bind_result($user_id, $first_name, $last_name, $email, $phone_number);
            session_start(); //This is needed to hold SESSION variables
            while ($statement->fetch()){
            $_SESSION['user_id']= $user_id;
            $_SESSION['first_name']= $first_name;
            $_SESSION['last_name']= $last_name;
            $_SESSION['email']= $email;
            $_SESSION['phone_number']= $phone_number;
            }
            session_write_close();
            //Close statement
            $statement->close();
            //Close database connection
            mysqli_close($conn);
            echo "success";
        }
        else{
            //Close statement
            $statement->close();
            //Close database connection
            mysqli_close($conn);
            exit("Wrong username or password");
        }
    }
    else{
        //Close statement
        $statement->close();
        //Close database connection
        mysqli_close($conn);
        exit("Contact web administrator!");
    }
}
else{
    exit("Something went wrong! Try again");
}
?>