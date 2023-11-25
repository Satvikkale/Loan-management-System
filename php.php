<?php
// Set database credentials
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "loan1";

// Establish database connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}




/////////////////// for new account register 
if (isset($_POST['SignUp'])) 
{
    // Get username and password from form
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $pancardno = $_POST['pancardno'];
    
    // Get PAN card photo from form and move it to server directory
    $pancard_tmp_name = $_FILES['pancard']['tmp_name'];
    $pancard_name = $_FILES['pancard']['name'];
    $pancard_path = "uploads/" . $pancard_name; // Path to store in database
    move_uploaded_file($pancard_tmp_name, $pancard_path);
    
    // Validate form data
    $errors = array();
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($pancardno)) {
        $errors[] = "PAN Card number is required";
    }

    
    // If no errors, insert user data into database and redirect to next page
    if (count($errors) == 0) 
    {
        // Escape special characters to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $email = mysqli_real_escape_string($conn, $email);
        $pancardno = mysqli_real_escape_string($conn, $pancardno);
        $pancard_path = mysqli_real_escape_string($conn, $pancard_path);

        

        // Insert user data into database
        $sql = "INSERT INTO create_new_user (user_id, Username, Email, `Pan Card No`, `Pan Card`, Password) VALUES ('$user_id', '$username', '$email', '$pancardno', '$pancard_path', '$password')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to next page
            header("Location: login.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Show error messages
        $error_msg = implode(", ", $errors);
        echo "<script>alert('$error_msg');</script>";
    }

    // if (mysqli_query($conn, $sql)) 
    // {
    //     header("Location: login.html");
    //     exit();
    // } else 
    // {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }

}


////////////////////// for login page----->

else if (isset($_POST['Login'])) 
{
    // Get username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Escape special characters to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query database for user with matching credentials
    $sql = "SELECT * FROM create_new_user WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) 
    {
        // If user exists with matching credentials, redirect to loaninfo.html
        header("Location: loaninfo.html");
        exit();
    } else 
    {
        // If no matching user found, display error message
        header("Location: invalidlogin.html");
        exit();
    }
}


//////////////for loaninfo page

elseif (isset($_POST['Next'])) 
{
    // Get loan information from form
    $user_id = $_POST['user_id'];
    $loan_type = $_POST['loan_type'];
    $loan_amount = $_POST['loan_amount'];
    $subject = $_POST['subject'];
    
    
   
    // Validate form data
    $errors = array();
    if (empty($user_id)) {
        $errors[] = "UserID is required";
    }
    if (empty($loan_type)) {
        $errors[] = "Loan Type is required";
    }
    if (empty($loan_amount)) {
        $errors[] = "Loan Amount is required";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    


    
    // If no errors, insert user data into database and redirect to next page
    if (count($errors) == 0) 
    {
    
        // Insert loan data into database
        $sql = "INSERT INTO `loaninfo` (`user_id`, `loan_type`, `loan_amount`, `subject`) VALUES ('$user_id', '$loan_type', '$loan_amount', '$subject')";
    
    
        if (mysqli_query($conn, $sql)) 
        {
            header("Location: accountinfo.html");
            exit();
        } else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }else {
        // Show error messages
        $error_msg = implode(", ", $errors);
        echo "<script>alert('$error_msg');</script>";
    }

}

//////////////for account info

elseif (isset($_POST['Submit'])) 
{
    // Get loan information from form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $aadhar_no = $_POST['aadhar_no'];
    // $aadhar_card = $_POST['aadhar_card'];
    $account_no = $_POST['account_no'];
    $ifsc_code = $_POST['ifsc_code'];

    // Get PAN card photo from form and move it to server directory
    $aadhar_card_tmp_name = $_FILES['aadhar_card']['tmp_name'];
    $aadhar_card_name = $_FILES['aadhar_card']['name'];
    $aadhar_card_path = "uploads/" . $aadhar_card_name; // Path to store in database
    move_uploaded_file($aadhar_card_tmp_name, $aadhar_card_path);
    
   
    // Validate form data
    $errors = array();
    if (empty($first_name)) {
        $errors[] = "First Name is required";
    }
    if (empty($last_name)) {
        $errors[] = "Last Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($aadhar_no)) {
        $errors[] = "Aadhar no. is required";
    }
    if (empty($account_no)) {
        $errors[] = "Account no. is required";
    }
    if (empty($ifsc_code)) {
        $errors[] = "IFSC code is required";
    }


    
    // If no errors, insert user data into database and redirect to next page
    if (count($errors) == 0) 
    {
    
        // Escape special characters to prevent SQL injection
        $first_name = mysqli_real_escape_string($conn, $first_name);
        $$last_name = mysqli_real_escape_string($conn, $last_name);
        $account_no = mysqli_real_escape_string($conn, $account_no);
        $aadhar_no = mysqli_real_escape_string($conn, $aadhar_no);
        $aadhar_card_path = mysqli_real_escape_string($conn, $aadhar_card_path);

        // Insert loan data into database
        $sql = "INSERT INTO `accountinfo` (`first_name`, `last_name`, `email`, `date_of_birth`, `aadhar_no`, `aadhar_card`, `account_no`, `ifsc_code`) VALUES ('$first_name', '$last_name', '$email', '$date_of_birth', '$aadhar_no', '$aadhar_card_path', '$account_no', '$ifsc_code')";
    
    
        if (mysqli_query($conn, $sql)) 
        {
            header("Location: index.html");
            exit();
        } else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }else {
        // Show error messages
        $error_msg = implode(", ", $errors);
        echo "<script>alert('$error_msg');</script>";
    }

}



elseif (isset($_POST['Send'])) 
{
    // Get loan information from form
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    
    // Validate form data
    $errors = array();
    if (empty($user_id)) {
        $errors[] = "User_Id is required";
    }
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($subject)) {
        $errors[] = "subject is required";
    }
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    


    
    // If no errors, insert user data into database and redirect to next page
    if (count($errors) == 0) 
    {
    
        // Insert loan data into database
        $sql = "INSERT INTO `contact` (`user_id`, `name`, `email`, `subject`, `message`) VALUES ('$user_id', '$name', '$email', '$subject', '$message')";
        
    
        if (mysqli_query($conn, $sql)) 
        {
            header("Location: index.html");
            exit();
        } else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }else {
        // Show error messages
        $error_msg = implode(", ", $errors);
        echo "<script>alert('$error_msg');</script>";
    }

}




// Close database connection
mysqli_close($conn);
?>