<!DOCTYPE html>
<html>
<head>
    <!-- Datatable CSS -->
    <link href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

    <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body>

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
       { data: 'Description_Place' }, 
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