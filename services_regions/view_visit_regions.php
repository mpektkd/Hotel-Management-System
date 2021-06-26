<?php
// Include config file
require_once "../DBConnection.php";
 
// Define variables and initialize with empty values
$room = '';
$idroom = "";
$room_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["room"]) && !empty($_POST["room"])){
    // Get hidden input value
    $ssn = $_POST["ssn"];
    $room = $_POST["room"];

    $sql1 = "SELECT a.idCustomer 
            from Customer as a 
            join SIN as b on b.idCustomer=a.idCustomer 
                where SINNumber like '%" . $ssn. "%';";

    $sql3 = "SELECT idRoom from Room as a 
            join Regions as b on b.idRegions=a.idRoom 
                where Description_Place like '%" . $room . "%';";
            
    $id = mysqli_fetch_array(mysqli_query($con, $sql1), MYSQLI_ASSOC)['idCustomer'];
    $idroom = mysqli_fetch_array(mysqli_query($con, $sql3), MYSQLI_ASSOC)['idRoom'];
    
    // Check input errors before inserting in database
    if(empty($room_err)){
        // Prepare an update statement
        
        $sql2 = "INSERT INTO mydb.ActiveCustomerLiveToRooms (idCustomer, idRoom, ArrivalDatetime)
        values (" .$id. ", ".$idroom.", '" . date("Y-m-d H:i:s"). "');";

        mysqli_query($con, $sql2);

        header("location: ../customer/active_customer.php?ssn=" . $ssn);
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["rid"]) && !empty(trim($_GET["rid"]))){
        // Get URL parameter
        $rid = $_GET['rid'];
        $QRY = "SELECT Description_Place, RegionName from Regions where idRegions=" . $rid ;
        $RES = mysqli_query($con, $QRY); 

        $row = mysqli_fetch_assoc($RES);

        $regname = $row['RegionName'];
        $descr = $row['Description_Place'];
        
        }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="description" content="Datatable custom column search by jquery datepicker with server side data (php, mysql. jquery)" />
		<meta name="keywords" content="datatable, datatable serverside, datatable serach by datepicker, gridviw datepicker, datepicker search" />
		<meta name="author" content="Arkaprava majumder" />

		<link rel="stylesheet" type="text/css" href="../DataTables/DataTables-1.10.25/css/jquery.dataTables.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables/DataTables-1.10.25/js/jquery.dataTables.js"></script>
		 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     

		<style>
			div.container {
			    max-width: 1400px;
			    margin: 0 auto;
			}
			div.header {
			    margin: 0 auto;
			    max-width:980px;
			}
			body {
			    background: #f7f7f7;
			    color: #333;
			}
			.employee-search-input {
			    width: 100%;
			}
			.datepicker {
				float:left;width:30%;
			}
      td{
        white-space:nowrap;
      }
      .date{
        width: 30%
      }
		</style>
		
	</head>
	<body>
  <div style = "position:absolute; right:80px; top:20px;" id="back">
    <?php echo '<a href="view_services_regions.php" class="btn btn-secondary ml-2">Back</a>'?>
    </div>
<!-- HTML -->
  <p class ="date">
  <h4>Choose Start Datetime</h4>
    <input type="text" id="searchByStart" class="datepicker" >
  </p>
  <p class ="date">
   <h4>Choose End Datetime</h4>
    <input type="text" id="searchByEnd" class="datepicker" >
  </p>
      
		<div class="header"><h1>Visits for <?php echo $descr . " " .$regname ?></h1></div>
		<div class="container">
			<table id="empTable"  class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
          <th>NFC ID</th>
          <th>LastName</th>
          <th>FirstName</th>
          <th>SSN</th>
          <th>Gender</th>
          <th>Age</th>
          <th>Description-place</th>
          <th>Region Name</th>
          <th>Entry Datetime</th>
          <th>Exit Datetime</th>
          <th>check Profile</th>
					</tr>
				</thead>
				<thead>
					<tr>
          <td><input type="text" id="1" class="employee-search-input" ></td>
          <td><input type="text" id="2" class="employee-search-input" ></td>
          <td><input type="text" id="3" class="employee-search-input" ></td>
          <td><input type="text" id="4" class="employee-search-input" ></td>
          <td><input type="text" id="5" class="employee-search-input" ></td>
						<td><input type="text" id="6" class="employee-search-input" ></td>
						<td><input type="text" id="7" class="employee-search-input" ></td>
						<td><input type="text" id="8" class="employee-search-input" ></td>
            <td><input type="text" id="9" class="employee-search-input" ></td>
						<td><input type="text" id="10" class="employee-search-input" ></td>
					</tr>
				<!-- </thead> -->
			</table>
		</div>


    <script>
			$(document).ready(function() {
			
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
              var rid = <?php echo $rid; ?>;
              // Append to data
              data.searchByStart = start;
              data.searchByEnd = end;
              data.rid = rid;
              console.log(rid);
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
                return'<a href="../customer/active_customer.php?ssn=' + row['SSN'] + '" class="btn btn-secondary ml-2">Check Profile</a>';
                }}
          ]

});
				
				$("#employee-grid_filter").css("display","none");  // hiding global search box
				
				$('.employee-search-input').on( ' change', function () {   
					var i =$(this).attr('id');  // getting column index
					var v =$(this).val();  // getting search input value
					dataTable.columns(i).search(v).draw();
				} );
		
				 $( ".datepicker" ).datepicker({
				 	dateFormat: "yy-mm-dd",
					showOn: "button",
					showAnim: 'slideDown',
					showButtonPanel: true ,
					autoSize: true,
					buttonImage: "//jqueryui.com/resources/demos/datepicker/images/calendar.gif",
					buttonImageOnly: true,
					buttonText: "Select date",
					closeText: "Clear"
				});
				// $(document).on("click", ".ui-datepicker-close", function(){
				// 	$('.datepicker').val("");
				// 	dataTable.columns(5).search("").draw();
				// });
        $('#searchByStart').on( ' change', function(){
          var start = $('#searchByStart').val();
          console.log(start);
          dataTable.draw();
        });

        $('#searchByEnd').on( ' change', function(){
          var end = $('#searchByEnd').val();
          console.log(end);
          dataTable.draw();
        });
			} );



		</script>
	</body>
</html>
