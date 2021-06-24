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
$id = $_POST['id'];

// if($searchValue != ''){
//    $searchQuery .= " and (BraceletId=".$searchValue.") ";
// }

$searchQuery = ' ';
if($searchByStart != '' && ($searchByEnd != '')){
    $searchQuery .= " and ( ArrivalDatetime between '".$searchByStart .
                      "' and '".$searchByEnd."' ) ";
 }
 if($searchByStart != '' && ($searchByEnd = '')){
    $searchQuery .= " and ( ArrivalDatetime >= '".$searchByStart."' ) ";
 }
 if($searchByStart = '' && ($searchByEnd != '')){
    $searchQuery .= " and ( ArrivalDatetime <= '".$searchByEnd."' ) ";
 }
## Fetch records
if($id != ''){
$qry = 'SELECT 
		
            a.BraceletId as NFCID,
            ArrivalDatetime,
            LeavingDatetime,
            concat(Description_Place, " ", Floor , "-Floor") as Room



        from ActiveCustomerLiveToRooms as a 
        join Room as b on b.idRoom=a.idRoom
        join Regions as c on c.idRegions=b.idRoom
        where a.BraceletId=' . $id ;
}
else{
    $qry = 'SELECT 
		
            a.BraceletId as NFCID,
            ArrivalDatetime,
            LeavingDatetime,
            concat(Description_Place, " ", Floor , "-Floor") as Room



        from ActiveCustomerLiveToRooms as a 
        join Room as b on b.idRoom=a.idRoom
        join Regions as c on c.idRegions=b.idRoom';

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
     "NFCID"=> $row['NFCID'],
     "ArrivalDatetime"=>$row['ArrivalDatetime'],
     "LeavingDatetime"=>$row['LeavingDatetime'],
     "Room"=>$row['Room'],
     "id"=>$row['NFCID']
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


