<?php
// Include config file
require_once "../DBConnection.php";
 
// // Define variables and initialize with empty values
// $room = '';
// $idroom = "";
// $room_err = "";
 
// // Processing form data when form is submitted
// if(isset($_POST["room"]) && !empty($_POST["room"])){
//     // Get hidden input value
//     $ssn = $_POST["ssn"];
//     $room = $_POST["room"];

//     $sql1 = "SELECT a.idCustomer 
//             from Customer as a 
//             join SIN as b on b.idCustomer=a.idCustomer 
//                 where SINNumber like '%" . $ssn. "%';";

//     $sql3 = "SELECT idRoom from Room as a 
//             join Regions as b on b.idRegions=a.idRoom 
//                 where Description_Place like '%" . $room . "%';";
            
//     $id = mysqli_fetch_array(mysqli_query($con, $sql1), MYSQLI_ASSOC)['idCustomer'];
//     $idroom = mysqli_fetch_array(mysqli_query($con, $sql3), MYSQLI_ASSOC)['idRoom'];
    
//     // Check input errors before inserting in database
//     if(empty($room_err)){
//         // Prepare an update statement
        
//         $sql2 = "INSERT INTO mydb.ActiveCustomerLiveToRooms (idCustomer, idRoom, ArrivalDatetime)
//         values (" .$id. ", ".$idroom.", '" . date("Y-m-d H:i:s"). "');";

//         mysqli_query($con, $sql2);

//         header("location: ../customer/active_customer.php?ssn=" . $ssn);
         
//         // Close statement
//         mysqli_stmt_close($stmt);
//     }
    
//     // Close connection
//     mysqli_close($con);
// } else{
//     // Check existence of id parameter before processing further
//     if(isset($_GET["ssn"]) && !empty(trim($_GET["ssn"]))){
//         // Get URL parameter
//         $ssn =  trim($_GET["ssn"]);
        
//         }
// }

 
// Processing form data when form is submitted
if(isset($_POST["rid"]) && !empty($_POST["rid"])){
    // Get hidden input value
    $ssn = $_POST["ssn"];
    $rid = $_POST["rid"];

    $sql1 = "SELECT a.idCustomer 
            from Customer as a 
            join SIN as b on b.idCustomer=a.idCustomer 
                where SINNumber like '%" . $ssn. "%';";

    $id = mysqli_fetch_array(mysqli_query($con, $sql1), MYSQLI_ASSOC)['idCustomer'];
    
    // Check input errors before inserting in database
        // Prepare an update statement
        
      $sql2 = "INSERT INTO mydb.ActiveCustomerLiveToRooms (idCustomer, idRoom, ArrivalDatetime)
      values (" .$id. ", ".$rid.", '" . date("Y-m-d H:i:s"). "');";

      mysqli_query($con, $sql2);

      header("location: ../customer/active_customer.php?ssn=" . $ssn);
        
      // Close statement
      mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($con);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["ssn"]) && !empty(trim($_GET["ssn"]))){
        // Get URL parameter
        $ssn =  trim($_GET["ssn"]);
        
        }
}
?>
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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>
    <script src="../../extensions/Editor/js/dataTables.editor.min.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        #quant{
            width: 1200px;
            margin: 0;
        }
        .wrapper{
            width: 400px;
            margin: 0 auto;
        }
        table tr td{
            width: auto;
            margin: 0;
        }
        table tr td:last-child{
            width: 120px;
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
        form {
        width: 75%;
        margin: 0 auto;
}
    </style>
    <!-- <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script> -->
</head>
<body>
    <div style = "position:absolute; left:80px; top:20px;" id="back">
    <?php echo '<a href="../customer/active_customer.php?ssn='. $ssn . '" class="btn btn-secondary ml-2">Back</a>'?>
    </div>
<!-- HTML -->

</div>
<div class="dropdown">
   <!-- Custom Filter -->
   <table>
     <tr>
       <td>
         <input type='number' id='searchByPrice' placeholder='Enter Price'>
       </td>
       <td>
         <select class="form-data" id='searchByView'>
         <div class="dropdown-content">
           <option value=''>-- Select View --</option>
           <option value='Street'>Street</option>
           <option value='Sea'>Sea</option>
           <option value='Castle'>Castle</option>
        </div>
         </select>
       </td>
     </tr>
   </table>

   <!-- Table -->
   <table id='empTable' class='display dataTable table-bordered table-striped'>
     <thead>
       <tr>
         <th>Room</th>
         <th>Number of Beds</th>
         <th>View</th>
         <th>Price Per Day</th>
         <th>Floor</th>
         <th></th>
       </tr>
     </thead>

   </table>
</div>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Choose Room</h2>
                    <p>Please edit the input values and submit to insert customer booking.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Room </label>
                            <input type="text" name="room" class="form-control">
                            <span class="invalid-feedback"><?php echo $room_err;?></span>
                        </div>
                        <input type="hidden" name="ssn" value="<?php echo $ssn; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <?php echo '<a href="../customer/active_customer.php?ssn='. $ssn . '" class="btn btn-secondary ml-2">Cancel</a>'?>
                    </form>
                </div>
            </div>        
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
       'url':'../ajax/ajaxfile.php',
       'data': function(data){
          // Read values
          var view = $('#searchByView').val();
          var price = $('#searchByPrice').val();
          
          // Append to data
          data.searchByView = view;
          data.searchByPrice = price;
       }
    },
    'columns': [
       { data: 'Description_Place'}, 
       { data: 'NumberOfBeds' },
       { data: 'View' },
       { data: 'ChargePerDay' },
       { data: 'Floor' },
       { data: 'idRoom',
       "render":function(data, type, row, meta){
          
          var ssn = "<?php echo $ssn ?>";
          console.log(ssn);
          var url = "<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>";

          return   '<form action="'+ url +'" method="post"><input type="hidden" name="rid" value="'+ data +'"/><input type="hidden" name="ssn" value="'+ ssn +'"/><input type="submit" class="btn btn-primary" value="Book"></form>';

       }}
    ]

});


  $('#searchByView').on('change ', function(){
    dataTable.draw();
  });

  $('#searchByPrice').change(function(){
    dataTable.draw();
  });
});
</script>

    

</body>
</html>