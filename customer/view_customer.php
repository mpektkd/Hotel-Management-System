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
            width: 1400px;
            margin: 0 auto;
        }
        table tr td{
            width: auto;
            white-space:nowrap;
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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Customer Details</h2>
                        <a href="create_customer.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Customer</a>
                    </div>
                    <?php
                    // Include ../DBconnection file
                    require_once "../DBConnection.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM mydb.CustomerInfo";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>LastName</th>";
                                        echo "<th>FirstName</th>";
                                        echo "<th>BirthDate</th>";
                                        echo "<th>Gender</th>";
                                        echo "<th>Number</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>SSN</th>";
                                        echo "<th>SSNDocument</th>";
                                        echo "<th>SSNIssueAuthority</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['LastName'] . "</td>";
                                        echo "<td>" . $row['FirstName'] . "</td>";
                                        echo "<td>" . $row['BirthDate'] . "</td>";
                                        echo "<td>" . $row['Gender'] . "</td>";
                                        echo "<td>" . $row['Number'] . "</td>";
                                        echo "<td>" . $row['Email'] . "</td>";
                                        echo "<td><a href=\"active_customer.php?ssn=" . $row['SINNumber'] . "\">" . $row['SINNumber'] . "</a>" . "</td>";
                                        echo "<td>" . $row['SINDocument'] . "</td>";
                                        echo "<td>" . $row['SINIssueAuthority'] . "</td>";
                                        echo '<td id="foo">';
                                            echo '<a href="read_customer.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_customer.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_customer.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            
                                        echo "</td>";
                                        // echo "<td>";
                                        // echo '<button id="foo" class="editbtn">See Info</button>';
                                        // echo "</td>";
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
 
                    // Close connection
                    mysqli_close($con);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>