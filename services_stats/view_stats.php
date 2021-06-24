<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Datatable CSS -->
    <link href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

    <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
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
        /* Style The Dropdown Button */
        .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
        position: relative;
        display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #f1f1f1}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
        display: block;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
        background-color: #3e8e41;
        }
        body {
        text-align: center;
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
    <a href="../index.html" class="btn btn-secondary ml-2">Back</a>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Services Statistics</h2>
                        <a href="create_customer.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Customer</a>
                    </div>
                    <?php
                    // Include ../DBconnection file
                    require_once "../DBConnection.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM mydb.ServicesStatsLastSixMonths";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Description</th>";
                                        echo "<th>Region Name</th>";
                                        echo "<th>Profit</th>";
                                        echo "<th>Preference</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Description'] . "</td>";
                                        echo "<td>" . $row['RegionName'] . "</td>";
                                        echo "<td>" . $row['Profit'] . "</td>";
                                        echo "<td>" . $row['Preference'] . "</td>";
                                        echo '<td id="foo">';
                                            echo '<input type="button" class="btn btn-primary" value="Choose">';    
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
 
                    ?>
                </div>
            </div>        
        </div>
    </div>

    </div>
    <div class="container">

<div class="panel panel-default">

  <div class="panel-heading"><h4>Select Service and get bellow Related Product Statistics</h4></div>

  <div class="panel-body">
  <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">      
        <div class="form-group">

            <select id="sid" name="service" class="form-control">

                <option value="">--- Select Service ---</option>


                <?php


                    $sql = "SELECT * FROM mydb.Services"; 

                    $result = mysqli_query($con,$sql);

                    while($row = mysqli_fetch_assoc($result)){

                        echo "<option value='".$row['idServices']."'>".$row['Description']."</option>";

                    }

                ?>


            </select>

        </div>

   <!-- Table -->
   <table id='empTable' class='display dataTable '> 
       <!-- table table-bordered table-striped -->
     <thead>
       <tr>
         <th>Description</th>
         <th>Total Consumption</th>
         <th>Total Profit</th>
         <th>Cost Per Unit</th>
       </tr>
     </thead>

   </table>
</div>
</div>
<script>
$(document).ready(function(){


  var dataTable = $('#empTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    //'searching': false, // Remove default Search Control
    'ajax': {
       'url':'../ajax/ajaxstats.php',
       'data': function(data){
          // Read values
          var service = $("#sid" ).val();
          console.log(service);
          // Append to data
          data.service = service;
       }
    },
    'columns': [
       { data: 'Description'}, 
       { data: 'TotalConsumption' },
       { data: 'TotalProfit' },
       { data: 'CostPerUnit' }
    ]

});


  $("#sid" ).on('change ', function(){
    dataTable.draw();
  });

});
</script>

</body>
</html>