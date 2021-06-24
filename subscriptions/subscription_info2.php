<?php 

// Include config file
include("../DBConnection.php");

$flag1 = 0;
$flag2 = 0;
// Processing form data when form is submitted
if(isset($_POST["sid"]) && !empty($_POST["sid"])){

    $flag1 = 1;
}

if(
    isset($_POST["product"]) && !empty($_POST["product"]) 
    &&
    isset($_POST["region"]) && !empty($_POST["region"]) 
    &&
    isset($_POST["quantity"]) && !empty($_POST["quantity"]) 
){
    $flag2 = 1;
}

if (
    isset($_POST["charge"]) && !empty($_POST["charge"]) 
    ){
        $flag3 = 1;
    }

if ($flag1 || $flag2 || $flag3){
    if ($flag1 = 1){
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
                    if ($flag2 = 0 && $flag3 = 0){
                        header("location: subscription_info2.php?bid=" . $bid . "&ssn=" .$ssn );  # -> subscritpion_info 
                    }
                    // exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    if ($flag2 = 1){

        $product = $_POST["product"];
        $region = $_POST["region"];
        $bid = $_POST["bid"];
        $ssn = $_POST["ssn"];

        //Get quantity
        if(isset($_POST["quantity"]) && !empty($_POST["quantity"]) ){

            $quantity = $_POST["quantity"];
        }
        else{ 
        
            $quantity = $_POST["quantity"]; 

        }

        //Validate quantity
        if($quantity <= 0){

            header("location: subscription_info2.php?bid=" . $bid . "&ssn=" .$ssn );     # -> subscritpion_info  
            // echo '<script>alert("quant")</script>';              
            echo $quantity;
        }
        //Get Date
        if(isset($_POST["date"]) && !empty($_POST["date"]) ){

            $date = $_POST["date"];
            echo $date;
        }
        else{ 
        
            $date = $_POST["date"]; 

        }

        //Validate Date
        if(!($date >= $arrival && $date <= $leaving)){

            header("location: subscription_info2.php?bid=" . $bid . "&ssn=" .$ssn );     # -> subscritpion_info                
            // echo '<script>alert("Date")</script>';
            echo $date;
        }

        //Get Payment
        if(isset($_POST["paid"]) && !empty($_POST["paid"]) && ($_POST["paid"] = 0 || $_POST["paid"] = 1)){

            $paid = $_POST["paid"];
        }
        //Default not Paid
        else{ $paid = 0; }


        // Prepare an update statement
        $SQL = "INSERT into mydb.ServiceCharge (BraceletId, idServiceMenu, idRegions, Quantity, Datetime, isPaid) 
                values(?, ?, ?, ?, ?, ?);";
        
        if($stmt = mysqli_prepare($con, $SQL)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiiisi", $param_bid, $param_smid, $param_rid, $param_quant, $param_date, $param_paid);
            
            // Set parameters
            $param_bid = $bid;
            $param_smid = $product;
            $param_rid = $region;
            $param_quant = $quantity;
            $param_date = $date;
            $param_paid = $paid;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                if($flag3 = 0){
                // Records updated successfully. Redirect to landing page
                    header("location: subscription_info2.php?bid=" . $bid . "&ssn=" .$ssn );# -> subscritpion_info 
                }
                // exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }

    if($flag3 = 1){

        $charge = $_POST['charge'];
        // Prepare an update statement
        $SQL = "UPDATE mydb.ServiceCharge 
                SET isPaid = 1 where idServiceCharge = ?";
        
        if($stmt = mysqli_prepare($con, $SQL)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_charge);
            
            // Set parameters
            $param_charge = $charge;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Records updated successfully. Redirect to landing page
                    header("location: subscription_info2.php?bid=" . $bid . "&ssn=" .$ssn );# -> subscritpion_info 
                // exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["bid"]) && !empty(trim($_GET["bid"]))){
        // Get URL parameter
        $bid =  trim($_GET["bid"]);
        $ssn = trim($_GET['ssn']);
        // Prepare a select statement

        $qry1 = "SELECT * from SubscribedServices as q 
                join Services as w on w.idServices=q.idSubscribed
                where idSubscribed not in (
                select 
                    idSubscribed
                from Services as a
                join SubscribedServices as b on b.idSubscribed=a.idServices
                join SubscriptionToServices as c on c.idServices=b.idSubscribed
                where BraceletId=". $bid . ")";

        $res1 = mysqli_query($con, $qry1);


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
                $result1 = mysqli_stmt_get_result($stmt);

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);

        //Charges Queries
        $QRY = "SELECT ArrivalDatetime, LeavingDatetime from
                ActiveCustomerLiveToRooms where BraceletId=" . $bid . "";

        $res2 = mysqli_query($con, $QRY);
        $row = mysqli_fetch_array($res2);

        $arrival = $row['ArrivalDatetime'];
        $leaving = $row['LeavingDatetime'];

        $qry2 = "SELECT 
	
                    b.idServiceCharge as idServiceCharge,
                    e.Description as Service,
                    d.Description as Product,
                    CostPerUnit,
                    Quantity,
                    CostAmount,
                    Description_Place,
                    RegionName,
                    Datetime,
                    isPaid
                    
                    
                
                from ActiveCustomerLiveToRooms as a
                join ServiceCharge as b on b.BraceletId=a.BraceletId
                join Regions as c on c.idRegions=b.idRegions
                join ServiceMenu as d on d.idServiceMenu=b.idServiceMenu
                join Services as e on e.idServices=d.idServices
                where a.BraceletId=?";

                if($stmt = mysqli_prepare($con, $qry2)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "i", $param_bid);

                    // Set parameters
                    $param_bid = $bid;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        $result2 = mysqli_stmt_get_result($stmt);

                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }

                // Close statement
                mysqli_stmt_close($stmt);

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
        .foo {
            white-space:nowrap;
            width: 100px;
        }
        #date{
            display: flex;  
            flex-wrap: wrap;
            
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
                    if($result1){
                        if(mysqli_num_rows($result1) > 0){
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
                                while($row = mysqli_fetch_array($result1)){
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
                                        // echo "<td>";
                                        // echo '<button id="foo" class="editbtn">See Info</button>';
                                        // echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result1);
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

                        while($row = mysqli_fetch_assoc($res1)){
                            echo $row['Description'];
                            echo "<option value='".$row['idServices']."'>".$row['Description']."</option>";
                            
                        }

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

<div style = "position:absolute; left:80px; top:20px;" id="back">
    <?php echo '<a href="../customer/active_customer.php?ssn='. $ssn . '" class="btn btn-secondary ml-2">Back</a>'?>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Charges Details</h2>
                        <a href="create_customer.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Customer</a>
                    </div>
                    <?php
                    if($result2){
                        if(mysqli_num_rows($result2) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Service</th>";
                                        echo "<th>Product</th>";
                                        echo "<th>Cost Per Unit</th>";
                                        echo "<th>Quantity</th>";
                                        echo "<th>Total Cost</th>";
                                        echo "<th>Description-Place</th>";
                                        echo "<th>Region Name</th>";
                                        echo "<th>Datetime</th>";
                                        echo "<th>Paid</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result2)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Service'] . "</td>";
                                        echo "<td>" . $row['Product'] . "</td>";
                                        echo "<td>" . $row['CostPerUnit'] . "</td>";
                                        echo "<td>" . $row['Quantity'] . "</td>";
                                        echo "<td>" . $row['CostAmount'] . "</td>";
                                        echo "<td>" . $row['Description_Place'] . "</td>";
                                        echo "<td>" . $row['RegionName'] . "</td>";
                                        echo "<td>" . $row['Datetime'] . "</td>";
                                        echo "<td>" . $row['isPaid'] . "</td>";
                                        echo '<td class="foo">';
                                            echo '<a href="update_charge.php?id='. $row['idServiceCharge'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_charge.php?id='. $row['idServiceCharge'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo '<form action="'. htmlspecialchars(basename($_SERVER['REQUEST_URI'])) . '" method="post">
                                                    <input type="hidden" name="ssn" value="' . $ssn . '"/>    
                                                    <input type="hidden" name="bid" value="' . $bid . '"/>    
                                                    <input type="hidden" name="charge" value="' . $row['idServiceCharge'] . '">
                                                    <input type="submit" class="btn btn-primary" value="Pay">
                                                    </form>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result2);
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

      <div class="panel-heading">Select Product and get bellow Related Region</div>

      <div class="panel-body">
      <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">      
            <div class="form-group">

                <label for="title">Select Product:</label>

                <select name="product" class="form-control">

                    <option value="">--- Select Product ---</option>


                    <?php


                        $sql = "SELECT * FROM mydb.ServiceMenu"; 

                        $result = mysqli_query($con,$sql);

                        while($row = mysqli_fetch_assoc($result)){

                            echo "<option value='".$row['idServiceMenu']."'>".$row['Description']."</option>";

                        }

                    ?>


                </select>

            </div>


            <div class="form-group">

                <label for="title">Select Region:</label>

                <select name="region" class="form-control" style="width:350px">

                </select>

            </div>
            <input type="hidden" name="ssn" value="<?php echo $ssn; ?>"/>    
            <input type="hidden" name="bid" value="<?php echo $bid; ?>"/>    
            <input type="hidden" name="arrival" value="<?php echo $arrival; ?>"/>    
            <input type="hidden" name="leaving" value="<?php echo $leaving; ?>"/>    
            <label for="quant">Quantity:</label>
            <input type='number' name='quantity' id="quant" placeholder='Enter Quantity'>
            <input type='number' name='paid' placeholder='Is Paid'>
            <div class="date" >
            <label for="date">Valid Period <?php echo "( ". $arrival . " - " . $leaving . " )" ?>:</label>
            <input type="text" class="date" name="date">
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
      </div>
    </form>
    </div>

</div>


<script>

 $('#date').on(' change keyup', function(){
    
    var date = $('#date').val();
    console.log(date);
  });

$( "select[name='product']" ).change(function () {

    var productID = $(this).val();

    if(productID) {


        $.ajax({

            url: "../ajax/ajaxpro.php",

            dataType: 'Json',

            data: {'id':productID},

            success: function(data) {

                $('select[name="region"]').empty();
                $.each(data, function(key, value) {

                    $('select[name="region"]').append('<option value="'+ key +'">'+ value +'</option>');

                });

            }

        });


    }else{

        $('select[name="region"]').empty();

    }

});

</script>

                  

</body>
</html>