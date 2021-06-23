<?php
include '../DBConnection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
// $searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByStart = $_POST['searchByStart'];
$searchByEnd = $_POST['searchByEnd'];
$rid = $_POST['rid'];

# datatable column index  => database column name
$columns = array( 
      1 => 'NFCID', 
      2 => 'LastName',
      3 => 'FirstName', 
      4 => 'SSN',
      5 => 'Gender', 
      6 => 'Age',
      7 => 'Description_Place', 
      8 => 'RegionName',
      9 => 'EntryDatetime', 
      10 => 'ExitDatetime'
   );

## Search 
$searchQuery = " ";
if( !empty($_POST['columns'][1]['search']['value']) ){
   $searchQuery.=" AND ( NFCID = ".$_POST['columns'][1]['search']['value'].") ";    
}

if( !empty($_POST['columns'][2]['search']['value']) ){
   $searchQuery.=" AND  ( LastName = '".$_POST['columns'][2]['search']['value']."') ";
}
if( !empty($_POST['columns'][3]['search']['value']) ){
   $searchQuery.=" AND ( FirstName = '".$_POST['columns'][3]['search']['value']."') ";    
}

if( !empty($_POST['columns'][4]['search']['value']) ){
   $searchQuery.=" AND  ( SSN >= '".$_POST['columns'][4]['search']['value']."') ";
}
if( !empty($_POST['columns'][5]['search']['value']) ){
   $searchQuery.=" AND ( Gender = '".$_POST['columns'][5]['search']['value']."') ";    
}
if( !empty($_POST['columns'][6]['search']['value']) ){
   $searchQuery.=" AND  ( Age >= ".$_POST['columns'][6]['search']['value'].") ";
}
if( !empty($_POST['columns'][7]['search']['value']) ){
   $searchQuery.=" AND ( Description_Place like '%".$_POST['columns'][7]['search']['value']."%') ";    
}

if( !empty($_POST['columns'][8]['search']['value']) ){
   $searchQuery.=" AND  ( RegionName like '%".$_POST['columns'][8]['search']['value']."%') ";
}
if( !empty($_POST['columns'][9]['search']['value']) ){
   $searchQuery.=" AND ( EntryDatetime = '".$_POST['columns'][9]['search']['value']."') ";    
}

if( !empty($_POST['columns'][10]['search']['value']) ){
   $searchQuery.=" AND  ( ExitDatetime = '".$_POST['columns'][10]['search']['value']."') ";
}

if($searchByStart != '' && ($searchByEnd != '')){
   $searchQuery .= " and ( EntryDatetime between '".$searchByStart .
                     "' and '".$searchByEnd."' ) ";
}
if($searchByStart != '' && ($searchByEnd = '')){
   $searchQuery .= " and ( EntryDatetime >= '".$searchByStart."' ) ";
}
if($searchByStart = '' && ($searchByEnd != '')){
   $searchQuery .= " and ( EntryDatetime <= '".$searchByEnd."' ) ";
}
// if($searchValue != ''){
//    $searchQuery .= " and (BraceletId=".$searchValue.") ";
// }

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

$empQuery = $qry3 . $searchQuery." order by EntryDatetime ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "NFCID"=> $row['NFCID'],
     "LastName"=>$row['LastName'],
     "FirstName"=>$row['FirstName'],
     "SSN"=>$row['SSN'],
     "Gender"=>$row['Gender'],
     "Age"=>$row['Age'],
     "Description_Place"=>$row['Description_Place'],
     "RegionName"=>$row['RegionName'],
     "EntryDatetime"=>$row['EntryDatetime'],
     "ExitDatetime"=>$row['ExitDatetime'],
     "id"=>$row['idCustomerVisitRegions']
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


