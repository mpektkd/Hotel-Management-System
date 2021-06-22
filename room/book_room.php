<?php
// Include config file
require_once "../DBConnection.php";
 
// Define variables and initialize with empty values
$lastname = $firstname = $phone = "";
$lastname_err = $firstname_err = $phone_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate address address
    $input_last = trim($_POST["lastname"]);
    if(empty($input_last)){
        $lastname_err = "Please enter an Last Name.";     
    } else{
        $lastname = $input_last;
    }

    // Validate name
    $input_first = trim($_POST["firstname"]);
    if(empty($input_first)){
        $firstname_err = "Please enter a Name.";
    } elseif(!filter_var($input_first, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $firstname_err = "Please enter a valid Name.";
    } else{
        $firstname = $input_first;
    }
     
    // Validate salary
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the phone.";     
    } elseif(!filter_var($input_phone, FILTER_SANITIZE_NUMBER_INT)){
        $input_phone = "Please enter a validate phone.";
    } else{
        $phone = $input_phone;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an update statement
        $sql = "CALL mydb.UpdateCustomer (?, ?, ?, ?);";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", $param_id, $param_first, $param_last, $param_phone);
            
            // Set parameters
            $param_id = $id;
            $param_first = $firstname;
            $param_last = $lastname;
            $param_phone = $phone;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ../index.html");
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
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>
    <script src="../../extensions/Editor/js/dataTables.editor.min.js"></script> -->
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

    <style>
        #quant{
            width: 1200px;
            margin: 0;
        }
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
        /* display: inline-block; */
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
    </style>
    <!-- <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script> -->
</head>
<body>
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
         <select class="dropbtn" id='searchByView'>
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
   <table id='empTable' class='display dataTable'>
     <thead>
       <tr>
         <th>Room</th>
         <th>Number of Beds</th>
         <th>View</th>
         <th>Price Per Day</th>
         <th>Floor</th>
       </tr>
     </thead>

   </table>
</div>

<script>
$(document).ready(function(){


  var dataTable = $('#empTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    //'searching': false, // Remove default Search Control
    'ajax': {
       'url':'../ajaxfile.php',
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
       { data: 'Description_Place',
        // "render": function(data, type, row, meta){
        //   return'<a href="' + data + '">' + data + '</a>';
        //   }
        }, 
       { data: 'NumberOfBeds' },
       { data: 'View' },
       { data: 'ChargePerDay' },
       { data: 'Floor' },
    ]

});


  $('#searchByView').keyup(function(){
    dataTable.draw();
  });

  $('#searchByPrice').change(function(){
    dataTable.draw();
  });
});
</script>

    

</body>
</html>