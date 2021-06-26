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
        .employee-search-input4 {
            width: 100%;
        }
        .datepicker {
            float:left;width:30%;
        }
      td{
        white-space:nowrap;
      }
      .date{
        width: 10%
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

<div class="header"><h2>Choose Customer</h2></div>
<div class="container">
  <!-- Custom Filter -->
   <table>
     <tr>
       <td>
         <select class="form-data" id='searchByGroup'>
         <div class="dropdown-content">
           <option value=''>-- Select Group --</option>
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
          <td><button class="btn" value="" onclick="choose(this)">Clear</button></td>
					</tr>
				</thead>
			</table>
		</div>
    <div class="header"><h2 id="cname">Choose Reservation for None</script></h2></div>
    <p class ="date">
  <h6 class = "pull-left" >Choose Start Datetime:</h6>
    <input type="text" id="searchByStart" class = "datepicker" >
  </p>
  <p class ="date">
   <h6 class = "pull-left" >Choose End Datetime:</h6>
    <input type="text" id="searchByEnd" class="datepicker" >
  </p>
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
<div class="container">
<div class="header"><h3>Track Region</h3></div>
    <p class ="date">
  <h6 class = "pull-left" >Choose Start Datetime:</h6>
    <input type="text" id="start" class = "datepicker" >
  </p>
  <p class ="date">
   <h6 class = "pull-left" >Choose End Datetime:</h6>
    <input type="text" id="end" class="datepicker" >
  </p>
   <!-- Table -->
			<table id="empTable3"  class="display dataTable table-bordered table-striped " cellspacing="0" width="30%">
				<thead>
					<tr>
          <th>Region</th>
          <th>Entry Datetime</th>
          <th>Exit Datetime</th>
          <th></th>
					</tr>
				</thead>
				<thead>
                <tr>
                <td></td>
                <td><input type="text" id="8" placeholder="Search Entry Datetime" class="employee-search-input3 dropdown-content" ></td>
                <td><input type="text" id="9" placeholder="Search Exit Datetime" class="employee-search-input3 dropdown-content" ></td>
                </tr>
				</thead>
			</table>
		</div>

    <div class="header"><h3>Possible Cases</h3></div>
    <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="mt-5 mb-3 clearfix">
            <button class="btn btn-success pull-center" value="1" onclick="find_all(this)">Find All</button>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="container">
   <!-- Table -->
			<table id="empTable4"  class="display dataTable table-bordered table-striped " cellspacing="0" width="30%">
				<thead>
					<tr>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Age</th>
          <th>Gender</th>
          <th>BirthDate</th>
          <th>Number</th>
          <th>SINNumber</th>
          <th>Region</th>
          <th>Entry Datetime</th>
          <th>Exit Datetime</th>
          <th>Times</th>
					</tr>
				</thead>           
				<thead>
					<tr>
          <td><input type="text" id="10" placeholder="Last Name" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="11" placeholder="First Name" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="12" placeholder="Age" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="13" placeholder="Gender" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="14" placeholder="BirthDate" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="15" placeholder="Number" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="16" placeholder="SSN" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="17" placeholder="Region" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="18" placeholder="Entry" class="employee-search-input4 dropdown-content" ></td>
          <td><input type="text" id="19" placeholder="Exit" class="employee-search-input4 dropdown-content" ></td>
					</tr>
				</thead>
			</table>
		</div>

<script>
    var cid;
    var bid;
    var vid;
    var choose ;
    var track;
    var cases;
    var find_all;
    var all = 0;
    var name = '';

    $(document).ready(function() {

      choose = function(button) { 

        var str = $(button).val();
        var res = str.split(",");
        cid = res[0];
        name = res[2] + " " + res[1];
        document.getElementById('cname').innerHTML = 'Choose Reservation for ' + name;
        dataTable2.draw();
        bid = '';
        dataTable3.draw();
        vid = '';
        dataTable4.draw();
        };

        track = function(button) {   
          bid = $(button).val();
          dataTable3.draw();
        };

        cases = function(button){
          vid = $(button).val();
          all = 0;
          console.log(vid);
          dataTable4.draw();
        };

        find_all = function(button) {   
          all = $(button).val();
          dataTable4.draw();
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
            { data: 'cid',
            "render":function(data, type, row, meta){
              var first = row['FirstName'];
              var last = row['LastName'];
            return   '<button class="btn" value="' + [data, first, last] + '" onclick="choose(this)">Choose</button>';

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
              data.cid = cid;
            }
          },
          'columns': [
            { data: 'NFCID'}, 
            { data: 'ArrivalDatetime'}, 
            { data: 'LeavingDatetime'}, 
            { data: 'Room'}, 
            { data: 'bid',
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
                'url':'../ajax/ajaxtrack_visits.php',
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
                    { data: 'Region'}, 
                    { data: 'EntryDatetime'}, 
                    { data: 'ExitDatetime'}, 
                    { data: 'vid',
                    "render":function(data, type, row, meta){
                    return   '<button class="btn" value="' + data + '" onclick="cases(this)">See Cases</button>';

                    }}, 
                    
                ]

        });

          var dataTable4 = $('#empTable4').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          //'searching': false, // Remove default Search Control
          'ajax': {
            'url':'../ajax/ajaxtrack_cases.php',
            'data': function(data){

              var group = $('#s4').val();
              data.group = group;
              data.vid = vid;
              data.all = all;
              data.bid = bid;

            }
            },
            'columns': [
              { data: 'LastName'}, 
              { data: 'FirstName'}, 
              { data: 'Age'}, 
              { data: 'Gender'}, 
              { data: 'BirthDate'}, 
              { data: 'Number'}, 
              { data: 'SINNumber'}, 
              { data: 'Region'}, 
              { data: 'EntryDatetime'},
              { data: 'ExitDatetime'}, 
              { data: 'Times'},
            ]
          });

        // $("#employee-grid_filter").css("display","none");  // hiding global search box
        
        $('.employee-search-input1').on( 'keyup click change', function () {   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            console.log(v);
            console.log(i);
            dataTable1.columns(i).search(v).draw();
        } );

        $('#searchByGroup').on(' keyup click change ', function(){
            dataTable1.draw();
        });

        $('.employee-search-input3').on( 'keyup click change', function () {   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            console.log(v);
            console.log(i);
            dataTable3.columns(i-7).search(v).draw();
        } );

        $('.employee-search-input4').on( 'keyup click change', function () {   
            var i =$(this).attr('id');  // getting column index
            var v =$(this).val();  // getting search input value
            console.log(v);
            console.log(i);
            dataTable4.columns(i-9).search(v).draw();
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

        $('#searchByStart').on( 'keyup click change', function(){
          var start = $('#searchByStart').val();
        //   console.log(start);
          dataTable2.draw();
        });

        $('#searchByEnd').on( 'keyup click change', function(){
          var end = $('#searchByEnd').val();
        //   console.log(end);
          dataTable2.draw();
        });


        $('#start').on( 'keyup click change', function(){
          var start = $('#start').val();
          console.log(start);
          dataTable3.draw();
        });

        $('#end').on( 'keyup click change', function(){
          var end = $('#end').val();
          console.log(end);
          dataTable3.draw();
        });
});
		</script>

   

</body>
</html>