<!DOCTYPE HTML>
<html>
<head>
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

</head>
<body bgcolor="#5bc0de">
<a href="profile_General.php" class="button">Back</a>
        <head>
                <link rel="stylesheet" type="text/css" href="button.css">
        </head>
<center><h2 style="color:white;">Customer Profile</h2></center>
<br>
    
<?php

include("DBConnection.php");
session_start();
$id = $_REQUEST["id"];
$ssn = $_GET["search1"];
$qry = "SELECT 
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

$res = mysqli_query($con,$qry);

?>
<table border="2" align="center" cellpadding="5" cellspacing="5">
        <tr>
        <th style="color:white;">BraceletId</th>
        <th style="color:white;">Lastname</th>
        <th style="color:white;">Firstname</th>
        <th style="color:white;">SSN</th>
        <th style="color:white;">ArrivalDatetime</th>
        <th style="color:white;">LeavingDatetime</th>
        <th style="color:white;">Bill</th>
        <th style="color:white;">Place</th>

        </tr>
        <?php
         while($row = mysqli_fetch_assoc($res)){
             $id = $row["BraceletId"];
        ?>
                <tr>
                <td style="color:white;"><?php echo $row["BraceletId"];?></td>
                <td style="color:white;"><?php echo $row["LastName"];?> </td>
                <td style="color:white;"><?php echo $row["FirstName"];?> </td>
                <td style="color:white;"><?php echo $row["SINNumber"];?> </td>
                <td style="color:white;"><?php echo $row["ArrivalDatetime"];?> </td>
                <td style="color:white;"><?php echo $row["LeavingDatetime"];?> </td>
                <td style="color:white;"><?php echo $row["TotalBill"];?> </td>
                <td style="color:white;"><?php echo $row["Description_Place"];?> </td>
                <td style="color:white;">
                <?php echo "<a href = 'BraceletInfo.php?id=$id'> link </a>"; ?>
                </td>
                </tr>
        <?php
        }

 ?>

<!-- HTML -->
<div >
   <!-- Custom Filter -->
   <table>
     <tr>
       <td>
         <input type='number' id='searchByPrice' placeholder='Enter Price'>
       </td>
       <td>
         <select id='searchByView'>
           <option value=''>-- Select View --</option>
           <option value='Street'>Street</option>
           <option value='Sea'>Sea</option>
           <option value='Castle'>Castle</option>
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
       'url':'ajaxfile.php',
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
        "render": function(data, type, row, meta){
          return'<a href="' + data + '">' + data + '</a>';
          }}, 
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

<div>
<a href="index.html" class="button">Back</a>
<center><h2 style = "color:white;">Add Service Charge</h2></center>
<form action = "Display_profile.php" method="get">
<br>
<center style="color:white;">

<div class="container">

    <div class="panel panel-default">

      <div class="panel-heading">Select State and get bellow Related City</div>

      <div class="panel-body">

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


      </div>

    </div>

</div>


<script>

$( "select[name='product']" ).change(function () {

    var productID = $(this).val();

  console.log(productID);
    if(productID) {


        $.ajax({

            url: "ajaxpro.php",

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

                  <input type='number' name='quantity' id='quantity' placeholder='Enter Quantity'>
                  <input type='submit'  id='submitCharge' placeholder='Submit'>

<script> 

        

</script>
            </div>
      </div>
      </div>
    </div>
</div>
</br>
<br>
<center style="color:white;">

 </div>

</html>

