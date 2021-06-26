<?php

// include_once(dirname( dirname(__FILE__) )."/ajax/database_connection.php");

// $country = '';
// $query = "SELECT DISTINCT Country FROM tbl_customer ORDER BY Country ASC";
// $statement = $connect->prepare($query);
// $statement->execute();
// $result = $statement->fetchAll();
// foreach($result as $row)
// {
//  $country .= '<option value="'.$row['Country'].'">'.$row['Country'].'</option>';
// }

?>

<html>
 <head>
  <title>Select Service Statistics Per Age Group</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  

  
 </head>
 <body>
 <div style = "position:absolute; left:80px; top:20px;" id="back">
    <?php echo '<a href="../index.html" class="btn btn-secondary ml-2">Back</a>'?>
    </div>
  <div class="container box">
   <h3 align="center">Select Service Statistics Per Age Group</h3>
   <br />
   <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
     <div class="form-group">
      <select name="filter_gender" id="filter_gender" class="form-control" required>
       <option value="">Select Age Group</option>
       <option value="20-40">20-40</option>
       <option value="40-60">40-60</option>
       <option value="60+">60+</option>

      </select>
     </div>

     </div>
     <div class="form-group" align="center">
      <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
     </div>
    </div>
    <div class="col-md-4"></div>
   </div>
   <div class="table-responsive">
    <table id="customer_data" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%">Description</th>
       <th width="10%">Total Usages</th>
      </tr>
     </thead>
    </table>
    <br />
    <br />
    <br />
   </div>
  </div>
  <div class="container box">
   <h3 align="center">Select Service Statistics Per Age Group</h3>
   <br />
   <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
     <div class="form-group">
      <select name="filter_gender2" id="filter_gender2" class="form-control" required>
       <option value="">Select Age Group</option>
       <option value="20-40">20-40</option>
       <option value="40-60">40-60</option>
       <option value="60+">60+</option>

      </select>
     </div>

     </div>
     <div class="form-group" align="center">
      <button type="button" name="filter" id="filter2" class="btn btn-info">Filter</button>
     </div>
    </div>
    <div class="col-md-4"></div>
   </div>
   <div class="table-responsive">
    <table id="customer_data2" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%">Description</th>
       <th width="10%">Total Usages %</th>
      </tr>
     </thead>
    </table>
    <br />
    <br />
    <br />
   </div>
  </div>
  <div class="container box">
   <h3 align="center">Select Region Statistics Per Age Group</h3>
   <br />
   <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
     <div class="form-group">
      <select name="filter1" id="filter1" class="form-control" required>
       <option value="">Select Age Group</option>
       <option value="20-40">20-40</option>
       <option value="40-60">40-60</option>
       <option value="60+">60+</option>

      </select>
     </div>

     </div>
     <div class="form-group" align="center">
      <button type="button" name="filter" id="filter1" class="btn btn-info">Filter</button>
     </div>
    </div>
    <div class="col-md-4"></div>
   </div>
   <div class="table-responsive">
    <table id="customer_data1" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%">RegionName</th>
       <th width="20%">Description_Place</th>
       <th width="20%">Floor</th>
       <th width="10%">Total Attendances</th>
      </tr>
     </thead>
    </table>
    <br />
    <br />
    <br />
   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  fill_datatable();
  
  function fill_datatable(filter_gender = '', filter_country = '')
  {
   var dataTable = $('#customer_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "searching" : false,
    "ajax" : {
     url:"../ajax/fetch.php",
     type:"POST",
     data:{
      filter_gender:filter_gender, filter_country:filter_country
     }
    
    }
   });

  }
  
  $('#filter').click(function(){
   var filter_gender = $('#filter_gender').val();
   var filter_country = $('#filter_country').val();
   if(filter_gender != '' && filter_country != '')
   {
    $('#customer_data').DataTable().destroy();
    fill_datatable(filter_gender, filter_country);
   }
   else
   {
    alert('Select Both filter option');
    $('#customer_data').DataTable().destroy();
    fill_datatable();
   }
  });
  
  
 });
 
</script>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  fill_datatable1();
  
  function fill_datatable1(filter1 = '', filter_country1 = '')
  {
   var dataTable = $('#customer_data1').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "searching" : false,
    "ajax" : {
     url:"../ajax/fetch1.php",
     type:"POST",
     data:{
      filter1:filter1, filter_country1:filter_country1
     }
    
    }
   });

  }
  
  $('#filter1').click(function(){
   var filter1 = $('#filter1').val();
   var filter_country1 = $('#filter_country1').val();
   if(filter_country1 != '' && filter_country1 != '')
   {
    $('#customer_data1').DataTable().destroy();
    fill_datatable1(filter1, filter_country1);
   }
   else
   {
    alert('Select Both filter option');
    $('#customer_data1').DataTable().destroy();
    fill_datatable1();
   }
  });
  
  
 });
 
</script>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
    fill_datatable2();
  
  function fill_datatable2(filter_gender2 = '', filter_country2 = '')
  {
   var dataTable = $('#customer_data2').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "searching" : false,
    "ajax" : {
     url:"../ajax/fetch2.php",
     type:"POST",
     data:{
      filter_gender2:filter_gender2, filter_country2:filter_country2
     }
    
    }
   });

  }
  
  $('#filter2').click(function(){
   var filter_gender2 = $('#filter_gender2').val();
   var filter_country2 = $('#filter_country2').val();
   if(filter_gender2 != '' && filter_country2 != '')
   {
    $('#customer_data2').DataTable().destroy();
    fill_datatable2(filter_gender2, filter_country2);
   }
   else
   {
    alert('Select Both filter option');
    $('#customer_data2').DataTable().destroy();
    fill_datatable2();
   }
  });
  
  
 });
 
</script>