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
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div>
    <a href="view_customer.php" class="btn btn-secondary ml-2">Back</a>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Customer Bookings</h2>
                        <?php echo '<a href="../room/book_room.php?ssn=' . $_GET['ssn'] .'" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Book New Room</a>;'?>
                    </div>
                    <?php
                    // Include ../DBconnection file
                    require_once "../DBConnection.php";
                    $ssn = $_GET['ssn'];
                    // Attempt select query execution
                    $sql = "SELECT 
                                BraceletId,
                                LastName,
                                FirstName,
                                SINNumber,
                                ArrivalDatetime, 
                                LeavingDatetime,
                                TotalBill,
                                Description_Place
                                FROM 
                                        (SELECT 
                                                LastName,
                                                FirstName,
                                                SINNumber,
                                                a.idCustomer
                                        FROM Customer as a
                                        join SIN as b on b.idCustomer=a.idCustomer
                                        where SINNumber LIKE '%" . $ssn ."%'
                                        )as e
                                join ActiveCustomerLiveToRooms as c on c.idCustomer = e.idCustomer
                                join Regions as d on d.idRegions=c.idRoom
                                ;";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>BraceletId</th>";
                                        echo "<th>Lastname</th>";
                                        echo "<th>Firstname</th>";
                                        echo "<th>SSN</th>";
                                        echo "<th>ArrivalDatetime</th>";
                                        echo "<th>LeavingDatetime</th>";
                                        echo "<th>Bill</th>";
                                        echo "<th>Place</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['BraceletId'] . "</td>";
                                        echo "<td>" . $row['LastName'] . "</td>";
                                        echo "<td>" . $row['FirstName'] . "</td>";
                                        echo "<td>" . $row['SINNumber'] . "</td>";
                                        echo "<td>" . $row['ArrivalDatetime'] . "</td>";
                                        echo "<td>" . $row['LeavingDatetime'] . "</td>";
                                        echo "<td>" . $row['TotalBill'] . "</td>";
                                        echo "<td>" . $row['Description_Place'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_customer.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_customer.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_customer.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo '<a href="../subscriptions/subscription_info.php?bid='. $row[BraceletId] . '&ssn=' .$ssn . '" class="button">Subscritpions</a>';
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
 
                    // Close connection
                    mysqli_close($con);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>