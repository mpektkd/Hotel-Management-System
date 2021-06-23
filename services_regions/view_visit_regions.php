<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Datatable CSS -->
    <link href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

    <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $( "#datetimepicker1" ).datepicker();
    } );
    $( function() {
      $( "#datetimepicker2" ).datepicker();
    } );
    </script>

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

<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">Choose Time Interval</div>
      <div class="panel-body">
         <div class="row">
            <div class='col-md-6'>
               <div class="form-group">
                  <label class="control-label">Start Datetime</label>
                  <div class='input-group date' id='datetimepicker1'>
                     <input id='searchByStart' type='text' class="form-control" />
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                  </div>
                  <label class="control-label">End Datetime</label>
                  <div class='input-group date' id='datetimepicker2'>
                     <input id='searchByEnd' type='text' class="form-control" />
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                  </div>
               </div>
            </div>
        </div>
        <input type="button" class="btn btn-primary" value="Submit">
      </div>
   </div>
</div>
<p>Date: <input type="text" id="datepicker"></p>
<p>Date: <input type="text" id="datepicker"></p>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Regions Visits</h2>
                        <a href="create_customer.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add Visit</a>
                    </div>
                    <?php
                    // Include ../DBconnection file
                    require_once "../DBConnection.php";
                    
                    $rid = $_GET['rid'];
                    // Attempt select query execution
                    // $sql = "SELECT 
	
                    //           idCustomerVisitRegions,
                    //           b.BraceletId as NFCID,
                    //           LastName, 
                    //           FirstName,
                    //           SINNumber as SSN,
                    //           Gender,
                    //           TRIM(LEADING '0' FROM DATE_FORMAT(FROM_DAYS(DATEDIFF(date(NOW()), BirthDate)), '%Y')) AS Age,
                    //           Description_Place,
                    //           RegionName,
                    //           EntryDatetime,
                    //           ExitDatetime
                            
                    //       from CustomerVisitRegions as a
                    //       join Regions as c on c.idRegions=a.idRegions
                    //       join ActiveCustomerLiveToRooms as b on b.BraceletId=a.BraceletId
                    //       join Customer as d on d.idCustomer=b.idCustomer
                    //       join SIN as e on e.idCustomer=d.idCustomer
                    //       where c.idRegions=" . $rid .";";
                          
                    // if($result = mysqli_query($con, $sql)){
                        // if(mysqli_num_rows($result) > 0){
                            echo '<table id="empTable" class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>NFC ID</th>";
                                        echo "<th>LastName</th>";
                                        echo "<th>FirstName</th>";
                                        echo "<th>SSN</th>";
                                        echo "<th>Gender</th>";
                                        echo "<th>Age</th>";
                                        echo "<th>Description-place</th>";
                                        echo "<th>Region Name</th>";
                                        echo "<th>Entry Datetime</th>";
                                        echo "<th>Exit Datetime</th>";
                                        echo "<th></th>";
                                    echo "</tr>";
                                echo "</thead>";
                                // echo "<tbody>";
                                // while($row = mysqli_fetch_array($result)){
                                //     echo "<tr>";
                                //         echo "<td>" . $row['NFCID'] . "</td>";
                                //         echo "<td>" . $row['LastName'] . "</td>";
                                //         echo "<td>" . $row['FirstName'] . "</td>";
                                //         echo "<td>" . $row['SSN'] . "</td>";
                                //         echo "<td>" . $row['Gender'] . "</td>";
                                //         echo "<td>" . $row['Age'] . "</td>";
                                //         echo "<td>" . $row['Description_Place'] . "</td>";
                                //         echo "<td>" . $row['RegionName'] . "</td>";
                                //         echo "<td>" . $row['EntryDatetime'] . "</td>";
                                //         echo "<td>" . $row['ExitDatetime'] . "</td>";
                                //         echo '<td id="foo">';
                                //             echo '<a href="read_customer.php?id='. $row['idCustomerVisitRegions'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                //             echo '<a href="update_customer.php?id='. $row['idCustomerVisitRegions'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                //             echo '<a href="delete_customer.php?id='. $row['idCustomerVisitRegions'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                //             echo '<a href="../customer/active_customer.php?ssn=' . $row['SSN'] .'" class="btn btn-secondary ml-2">Check Profile</a>';    
                                //         echo "</td>";
                                        
                                //     echo "</tr>";
                                // }
                                // echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            // mysqli_free_result($result);
                    //     } else{
                    //         echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    //     }
                    // } else{
                    //     echo "Oops! Something went wrong. Please try again later.";
                    // }

                    ?>
                </div>
            </div>        
        </div>
    </div>
    <script>
  $(function () {
    $('#datetimepicker1').datetimepicker();
 });
 $(function () {
    $('#datetimepicker2').datetimepicker();
 });
</script>
<script>
$(document).ready(function(){


  var dataTable = $('#empTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    //'searching': false, // Remove default Search Control
    'ajax': {
       'url':'../ajax/ajaxvisit.php',
       'data': function(data){
          // Read values
          var start = $('#searchByStart').val();
          var end = $('#searchByEnd').val();
          var rid = $('#rid').val();
          console.log("adkjansjkl");

          // Append to data
          data.searchByStart = start;
          data.searchByEnd = end;
          data.rid = rid;
       }
    },
    'columns': [
       { data: 'NFCID'}, 
       { data: 'LastName'}, 
       { data: 'FirstName'}, 
       { data: 'SSN'}, 
       { data: 'Gender'}, 
       { data: 'Age' },
       { data: 'Description_Place' },
       { data: 'RegionName' },
       { data: 'EntryDatetime' },
       { data: 'ExitDatetime' },
       { data: 'id',
        "render": function(data, type, row, meta){
          return'<a href="../customer/active_customer.php?ssn=' + $row['SSN'] + '" class="btn btn-secondary ml-2">Check Profile</a>';
          }}
    ]

});

  $('#searchByStart').keyup(function(){
    dataTable.draw();
  });

  $('#searchByEnd').keyup(function(){
    dataTable.draw();
  });

  // $('#searchByPrice').change(function(){
  //   dataTable.draw();
  // });
});
</script>
</body>
</html>