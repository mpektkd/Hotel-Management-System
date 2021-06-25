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
$bid = $_POST['bid'];
// if($searchValue != ''){
//    $searchQuery .= " and (BraceletId=".$searchValue.") ";
// }
# datatable column index  => database column name
$columns = array( 
   1 => 'EntryDatetime', 
   2 => 'ExitDatetime',
);

## Search 

$searchQuery = ' ';
if( !empty($_POST['columns'][1]['search']['value']) ){
   $searchQuery.=" AND ( EntryDatetime = '".$_POST['columns'][1]['search']['value']."') ";    
}

if( !empty($_POST['columns'][2]['search']['value']) ){
   $searchQuery.=" AND  ( ExitDatetime = '".$_POST['columns'][2]['search']['value']."') ";
}

if($searchByStart != '' && ($searchByEnd != '')){
   $searchQuery .= " and ( EntryDatetime between '".$searchByStart .
                     "' and '".$searchByEnd."' ) ";
}
if(($searchByStart != '') && ($searchByEnd == '')){
   $searchQuery .= " and ( EntryDatetime >= '".$searchByStart."' ) ";
}
if(($searchByStart == '') && ($searchByEnd != '')){
   $searchQuery .= " and ( EntryDatetime <= '".$searchByEnd."' ) ";
}
## Fetch records
$qry = '';
if($bid != ''){
$qry = 'SELECT 

         a.idCustomerVisitRegions as vid, 
         concat(b.Description_Place, " ", b.RegionName, " ", Floor, "- Floor" ) as Region,
         EntryDatetime,
         ExitDatetime


      FROM CustomerVisitRegions as a
      join Regions as b on b.idRegions=a.idRegions
      where a.BraceletId=' . $bid ;
}


## Total number of records without filtering
$qry1 = "SELECT count(*) as allcount from (".$qry.")as r";

$sel = mysqli_query($con,$qry1);
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$qry2 = "SELECT count(*) as allcount from (".$qry .")as r
        where 1 ";

$sel = mysqli_query($con,$qry2 . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];


$qry3 = "SELECT * from (".$qry .")as r
        where 1 ";

$empQuery = $qry3 . $searchQuery." order by " . $columnName . " " . $columnSortOrder ." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "Region"=> $row['Region'],
     "EntryDatetime"=>$row['EntryDatetime'],
     "ExitDatetime"=>$row['ExitDatetime'],
     "vid"=>$row['vid']
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


