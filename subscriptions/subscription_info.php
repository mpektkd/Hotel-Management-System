<?php 

// Include config file
include("../DBConnection.php");

// Processing form data when form is submitted
if(isset($_POST["sid"]) && !empty($_POST["sid"])){
    // Get hidden input value
    $sid = $_POST["sid"];
    $bid = $_POST["bid"];
    $ssn = $_POST["ssn"];
    
    echo $sid;
    echo $bid;
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an update statement
        $sql = "INSERT into SubscriptionToServices (BraceletId, idServices) values (?, ?);";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $param_bid, $param_sid);
            
            // Set parameters
            $param_bid = $bid;
            $param_sid = $sid;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: subscription_info.php?bid=" . $bid . "&ssn=" .$ssn );
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["bid"]) && !empty(trim($_GET["bid"]))){
        // Get URL parameter
        $bid =  trim($_GET["bid"]);
        $ssn = trim($_GET['ssn']);
        // Prepare a select statement

        $qry1 = "SELECT *
                from SubscribedServices as b
                join Services as c on c.idServices=b.idSubscribed"; 

        $res = mysqli_query($con, $qry1);
        $sql = "SELECT 
                    distinct
                    idSubscriptionToServices,
                    SubscriptionDatetime,
                    CostAmount, 
                    CostPerDay,
                    RegionName
        
        FROM SubscriptionToServices as a
        join SubscribedServices as b on b.idSubscribed=a.idServices
        join ServicesAtSpecifiedRegions as c on c.idServices=b.idSubscribed
        join Regions as d on d.idRegions=c.idOtherRegions
        where BraceletId= ?";

        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_bid);

            // Set parameters
            $param_bid = $bid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($con);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../error.php");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <style>
        .wrapper{
            width: 1200px;
            margin: 0 auto;
        }
        table tr td{
            width: auto;
            margin: 0;
        }
        table tr td:last-child{
            width: 120px;
        }
        #foo {
        white-space:nowrap;
        width: 100px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div style = "position:absolute; left:80px; top:20px;" id="back">
    <?php echo '<a href="../customer/active_customer.php?ssn='. $ssn . '" class="btn btn-secondary ml-2">Back</a>'?>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Subscription Details</h2>
                        <a href="create_customer.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Customer</a>
                    </div>
                    <?php
                    // Include ../DBconnection file
                    require_once "../DBConnection.php";
                    
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Subscription Datetime</th>";
                                        echo "<th>Total Cost</th>";
                                        echo "<th>Charge Per Day</th>";
                                        echo "<th>Region-Place</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['SubscriptionDatetime'] . "</td>";
                                        echo "<td>" . $row['CostAmount'] . "</td>";
                                        echo "<td>" . $row['CostPerDay'] . "</td>";
                                        echo "<td>" . $row['RegionName'] . "</td>";
                                        echo '<td id="foo">';
                                            echo '<a href="create_subscription.php?id='. $row['idSubscriptionToServices'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_subscription.php?id='. $row['idSubscriptionToServices'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_subscription.php?id='. $row['idSubscriptionToServices'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            
                                        echo "</td>";
                                        echo "<td>";
                                        echo '<button id="foo" class="editbtn">See Info</button>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 

                    ?>
                </div>
            </div>        
        </div>
    </div>
    <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Select Service and Submit</div>
      <div class="panel-body">
      <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">      
            <div class="form-group">
                <label class="form-group" for="title">Select One of Subscription Services</label>    
                <select name="sid" class="form-control">
                    <option value="">--- Select Service ---</option>


                    <?php

                        while($row = mysqli_fetch_assoc($res)){
                            echo $row['Description'];
                            echo "<option value='".$row['idServices']."'>".$row['Description']."</option>";
                            
                        }
                        // Close connection
                        mysqli_close($con);
                    ?>


                </select>
            </div>


            <div class="form-group">
                <input type="hidden" name="ssn" value="<?php echo $ssn; ?>"/>    
                <input type="hidden" name="bid" value="<?php echo $bid; ?>"/>    
                <input type="submit" class="btn btn-primary" value="Submit">    
            </div>  
        </form>

      </div>
    </div>
</div>
</body>
</html>