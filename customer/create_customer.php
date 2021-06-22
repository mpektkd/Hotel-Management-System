<?php
// Include config file
require_once "../DBConnection.php";
 
// Define variables and initialize with empty values
$first_name = $last_name = $birth_date = $gender = $phone_number = $email = $ssn = $ssn_document = $ssn_issue_auth = "";
$first_name_err = $last_name_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $birth_date = trim($_POST["birth_date"]);
    $gender = trim($_POST["gender"]);
    $phone_number = trim($_POST["phone_number"]);
    $email = trim($_POST["email"]);
    $ssn = trim($_POST["ssn"]);
    $ssn_document = trim($_POST["ssn_document"]);
    $ssn_issue_auth = trim($_POST["ssn_issue_auth"]);

    
    
    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "CALL mydb.CreateCustomer (?, ?, ?, ?, ?, ?, ?, ?, ?);";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_first_name, $param_last_name, $param_birth_date, $param_gender, $param_ssn, $param_ssn_document, $param_ssn_issue_auth, $param_email, $param_phone_number);
            
            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_birth_date = $birth_date;
            $param_gender = $gender;
            $param_ssn = $ssn;
            $param_ssn_document=$ssn_document;
            $param_ssn_issue_auth = $ssn_issue_auth;
            $param_email = $email;
            $param_phone_number = $phone_number;


            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: view_customer.php");
                exit();
            } else{
                printf("Error message: %s\n", $stmt->error);
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div>
    <a href="view_customer.php" class="btn btn-secondary ml-2">Back</a>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add customer record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback"><?php echo $first_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                            <span class="invalid-feedback"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Birth Date</label>
                            <input type="text" name="birth_date" class="form-control <?php echo (!empty($birth_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birth_date; ?>">
                            <span class="invalid-feedback"><?php echo $birth_date;?></span>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select id="genders" name="gender">
                                <option value="F">Female</option>
                                <option value="M">Male</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" class="form-control <?php echo (!empty($phone_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_number; ?>">
                            <span class="invalid-feedback"><?php echo $phone_number_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>SSN</label>
                            <input type="text" name="ssn" class="form-control <?php echo (!empty($ssn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ssn; ?>">
                            <span class="invalid-feedback"><?php echo $ssn_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>SSN Document</label>
                            <select id="ssn_document" name="ssn_document">
                                <option value="Passport">Passport</option>
                                <option value="ID Card">ID Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>SSN Issue Authority</label>
                            <select id="ssn_issue_auth" name="ssn_issue_auth">
                                <option value="Police Station">Police Station</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="view_customer.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>