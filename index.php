<!DOCTYPE html>
<html>
	<title>Datatable Demo9   DataTable Search By Datepicker | CoderExample</title>
	<head>
		<meta name="description" content="Datatable custom column search by jquery datepicker with server side data (php, mysql. jquery)" />
		<meta name="keywords" content="datatable, datatable serverside, datatable serach by datepicker, gridviw datepicker, datepicker search" />
		<meta name="author" content="Arkaprava majumder" />
		<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
			
				var dataTable =  $('#employee-grid').DataTable( {
				processing: true,
				serverSide: true,
				ajax: "employee-grid-data.php", // json datasource

				} );
				
				$("#employee-grid_filter").css("display","none");  // hiding global search box
				
				$('.employee-search-input').on( 'keyup click change', function () {   
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
				$(document).on("click", ".ui-datepicker-close", function(){
					$('.datepicker').val("");
					dataTable.columns(5).search("").draw();
				});
			} );

		</script>
		<style>
			div.container {
			    max-width: 980px;
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
				float:left;width:70%;
			}
		</style>
		
	</head>
	<body>
		<div class="header"><h1>DataTable Search By Datepicker</h1></div>
		<div class="container">
			<table id="employee-grid"  class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Employee name</th>
						<th>Salary</th>
						<th>Position</th>
						<th>City</th>
						<th>Extension</th>
						<th>Joining date</th>
						<th>Age</th>
					</tr>
				</thead>
				<thead>
					<tr>
						<td><input type="text" id="0"  class="employee-search-input"></td>
						<td><input type="text" id="1" class="employee-search-input"></td>
						<td><input type="text" id="2" class="employee-search-input" ></td>
						<td><input type="text" id="3" class="employee-search-input" ></td>
						<td><input type="text" id="4" class="employee-search-input" ></td>
						<td  valign="middle"><input  readonly="readonly" type="text" id="5" class="employee-search-input datepicker" ></td>
						<td><input type="text" id="6" class="employee-search-input" ></td>
					</tr>
				</thead>
			</table>
		</div>
	</body>
</html>
