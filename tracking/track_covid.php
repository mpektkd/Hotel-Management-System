<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../DataTables/DataTables-1.10.25/css/jquery.dataTables.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables/DataTables-1.10.25/js/jquery.dataTables.js"></script>
		 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
            text-align: center;
            background: #f7f7f7;
            color: #333;
        }
        .employee-search-input1 {
            width: 100%;
        }
        .employee-search-input2 {
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
        margin: 0 auto;
      }
        form {
        width: 75%;
        margin: 0 auto;
}
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div style = "position:absolute; left:80px; top:20px;" id="back">
    <?php echo '<a href="../index.html" class="btn btn-secondary ml-2">Back</a>'?>
    </div>

<div class="header"><h1>Visits for <?php echo $descr . " " .$regname ?></h1></div>
<div class="container">
               <!-- Custom Filter -->
   <table>
     <tr>
       <td>
         <input type='number' id='searchByPrice' placeholder='Enter Price'>
       </td>
       <td>
         <select class="form-data" id='searchByGroup'>
         <div class="dropdown-content">
           <option value=''>-- Select View --</option>
           <option value='20-40'>20-40</option>
           <option value='40-60'>40-60</option>
           <option value='60'>60+</option>
        </div>
         </select>
       </td>
     </tr>
   </table>

   <!-- Table -->
			<table id="empTable1"  class="display dataTable table-bordered table-striped " cellspacing="0" width="30%">
				<thead>
					<tr>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Number</th>
          <th>Email</th>
          <th>SSN</th>
          <th>See Bookings</th>
					</tr>
				</thead>
				<thead>
					<tr>
          <td><input type="text" id="1" placeholder="Search by Last Name" class="employee-search-input1 dropdown-content" ></td>
          <td><input type="text" id="2" placeholder="Search by First Name" class="employee-search-input1 dropdown-content" ></td>
          <td><input type="text" id="3" placeholder="Search by >= Age" class="employee-search-input1 dropdown-content" ></td>
          <td><input type="text" id="4" placeholder="Search by Gender" class="employee-search-input1 dropdown-content" ></td>
          <td><input type="text" id="5" placeholder="Search by Number" class="employee-search-input1 dropdown-content" ></td>
          <td><input type="text" id="6" placeholder="Search by Email" class="employee-search-input1 dropdown-content" ></td>
          <td><input type="text" id="7" placeholder="Search by SSN" class="employee-search-input1 dropdown-content" ></td>
          <td><button class="btn" value="" onclick="filter_nfc(this)">Clear</button></td>
					</tr>
				</thead>
			</table>
		</div>


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
			<table id="empTable2"  class="displaydataTable table-bordered table-striped " cellspacing="0" width="30%">
				<thead>
					<tr>
          <th>NFCID</th>
          <th>ArrivalDatetime</th>
          <th>LeavingDatetime</th>
          <th>Room</th>
          <th></th>
					</tr>
				</thead>
			</table>
		</div>

        <div class="header"><h1>Visits for <?php echo $descr . " " .$regname ?></h1></div>
<div class="container">
               <!-- Custom Filter -->
   <table>
     <tr>
       <td>
         <input type='number' id='s1' placeholder='Enter Price'>
       </td>
       <td>
         <select class="form-data" id='s2'>
         <div class="dropdown-content">
           <option value=''>-- Select View --</option>
           <option value='20-40'>20-40</option>
           <option value='40-60'>40-60</option>
           <option value='60'>60+</option>
        </div>
         </select>
       </td>
     </tr>
   </table>
   <p class ="date">
  <h4>Choose Start Datetime</h4>
    <input type="text" id="start" class="datepicker" >
  </p>
  <p class ="date">
   <h4>Choose End Datetime</h4>
    <input type="text" id="end" class="datepicker" >
  </p>
   <!-- Table -->
			<table id="empTable3"  class="display dataTable table-bordered table-striped " cellspacing="0" width="30%">
				<thead>
					<tr>
          <th>Datetime</th>
          <th>Region From</th>
          <th>Region To</th>
					</tr>
				</thead>
                </thead>
				<thead>
                <tr>
                <td></td>
                <td><input type="text" id="8" placeholder="Search Region From" class="employee-search-input3 dropdown-content" ></td>
                <td><input type="text" id="9" placeholder="Search Region To" class="employee-search-input3 dropdown-content" ></td>
                </tr>
				</thead>
			</table>
		</div>

<script>
    var cid;
    var bid;
    var filter_nfc ;
    var track;
    
    $(document).ready(function() {
        
        filter_nfc = function(button) {   
            cid = $(button).val();
            dataTable2.draw();
        };
        track = function(button) {   
            bid = $(button).val();
            dataTable3.draw();
        };

        var dataTable1 = $('#empTable1').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
          'url':'../ajax/ajaxtrack_customer.php',
          'data': function(data){

            var group = $('#searchByGroup').val();
            data.group = group;

          }
          },
          'columns': [
            { data: 'LastName'}, 
            { data: 'FirstName'}, 
            { data: 'Age'}, 
            { data: 'Gender'}, 
            { data: 'Number'}, 
            { data: 'Email'},
            { data: 'SINNumber'}, 
            { data: 'id',
            "render":function(data, type, row, meta){
            return   '<button class="btn" value="' + data + '" onclick="filter_nfc(this)">Choose</button>';

       }}
          ]

        });

        var dataTable2 = $('#empTable2').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
          'url':'../ajax/ajaxtrack_bracelet.php',
          'data': function(data){
              // Read values
              var start = $('#searchByStart').val();
              var end = $('#searchByEnd').val();
              // Append to data
              data.searchByStart = start;
              data.searchByEnd = end;
              data.id = cid;
            }
          },
          'columns': [
            { data: 'NFCID'}, 
            { data: 'ArrivalDatetime'}, 
            { data: 'LeavingDatetime'}, 
            { data: 'Room'}, 
            { data: 'id',
            "render":function(data, type, row, meta){
            return   '<button class="btn" value="' + data + '" onclick="track(this)">Track</button>';
            }},
            ]

        });

        var dataTable3 = $('#empTable3').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                //'searching': false, // Remove default Search Control
                'ajax': {
                'url':'../ajax/ajaxtrack_passes.php',
                'data': function(data){
                    // Read values
                    var start = $('#start').val();
                    var end = $('#end').val();
                    // Append to data
                    data.searchByStart = start;
                    data.searchByEnd = end;
                    data.bid = bid;
                    }
                },
                'columns': [
                    { data: 'Datetime'}, 
                    { data: 'RegionFrom'}, 
                    { data: 'RegionTo'}, 
            //         { data: 'id',
            //         "render":function(data, type, row, meta){
            //         return   '<button class="btn" value="' + data + '" onclick="track(this)">Track</button>';

            //    }}, 
                    
                ]

        });

        // $("#employee-grid_filter").css("display","none");  // hiding global search box
        
        $('.employee-search-input1').on( 'keyup click change', function () {   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            dataTable1.columns(i).search(v).draw();
        } );

        $('#searchByGroup').on(' change ', function(){
            dataTable1.draw();
        });

        $('.employee-search-input2').on( 'keyup click change', function () {   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            console.log(v);
            console.log(i);
            dataTable2.columns(i-6).search(v).draw();
        } );

        $('.employee-search-input3').on( 'keyup click change', function () {   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            dataTable3.columns(i).search(v).draw();
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
        $('#searchByStart').on( 'change', function(){
          var start = $('#searchByStart').val();
        //   console.log(start);
          dataTable2.draw();
        });

        $('#searchByEnd').on( 'change', function(){
          var end = $('#searchByEnd').val();
        //   console.log(end);
          dataTable2.draw();
        });


        $('#start').on( 'change', function(){
          var start = $('#start').val();
        //   console.log(start);
          dataTable2.draw();
        });

        $('#end').on( 'change', function(){
          var end = $('#end').val();
        //   console.log(end);
          dataTable2.draw();
        });
});
		</script>

   

</body>
</html>