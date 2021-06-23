<?php
include '../DBConnection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByStart = $_POST['searchByStart'];
$searchByEnd = $_POST['searchByEnd'];
$rid = $_POST['rid'];

## Search 
$searchQuery = " ";
if($searchByStart != ''){
   $searchQuery .= " and ( EntryDatetime between ".$searchByView;
}
if($searchByEnd != ''){
   $searchQuery .= " and ".$searchByPrice." ) ";
}
if($searchValue != ''){
   $searchQuery .= " and (BraceletId=".$searchValue.") ";
}

## Fetch records
$qry = "SELECT 
	
            idCustomerVisitRegions,
            b.BraceletId as NFCID,
            LastName, 
            FirstName,
            SINNumber as SSN,
            Gender,
            TRIM(LEADING '0' FROM DATE_FORMAT(FROM_DAYS(DATEDIFF(date(NOW()), BirthDate)), '%Y')) AS Age,
            Description_Place,
            RegionName,
            EntryDatetime,
            ExitDatetime

        from CustomerVisitRegions as a
        join Regions as c on c.idRegions=a.idRegions
        join ActiveCustomerLiveToRooms as b on b.BraceletId=a.BraceletId
        join Customer as d on d.idCustomer=b.idCustomer
        join SIN as e on e.idCustomer=d.idCustomer
        where c.idRegions=" . $rid;

## Total number of records without filtering
$qry1 = "SELECT count(*) as allcount from (".$qry.")as r  
                     where 1 ";

$sel = mysqli_query($con,$qry1);
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$qry2 = "SELECT count(*) as allcount from (".$qry .")as r
        where 1";

$sel = mysqli_query($con,$qry2 . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


$qry3 = "SELECT * from (".$qry .")as r
        where 1";

$empQuery = $qry3 . $searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "NFCID"=> $row['Description_Place'],
     "LastName"=>$row['NumberOfBeds'],
     "FirstName"=>$row['View'],
     "SSN"=>$row['ChargePerDay'],
     "Gender"=>$row['Floor'],
     "Age"=>$row['ChargePerDay'],
     "Description_Place"=>$row['ChargePerDay'],
     "RegionName"=>$row['ChargePerDay'],
     "EntryDatetime"=>$row['ChargePerDay'],
     "ExitDatetime"=>$row['ChargePerDay']
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);


