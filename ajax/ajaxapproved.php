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
// $searchByStart = $_POST['searchByStart'];
// $searchByEnd = $_POST['searchByEnd'];
$bid = $_POST['bid'];

# datatable column index  => database column name
$columns = array( 
      1 => 'EntryID', 
      2 => 'RegionFrom',
      3 => 'FloorFrom', 
      4 => 'RegionTo',
      5 => 'FloorTo' 
   );

## Search 
$searchQuery = " ";
if( !empty($_POST['columns'][1]['search']['value']) ){
   $searchQuery.=" AND ( EntryID = ".$_POST['columns'][1]['search']['value'].") ";    
}

if( !empty($_POST['columns'][2]['search']['value']) ){
   $searchQuery.=" AND  ( RegionFrom like '%".$_POST['columns'][2]['search']['value']."%') ";
}
if( !empty($_POST['columns'][3]['search']['value']) ){
   $searchQuery.=" AND ( FloorFrom = '".$_POST['columns'][3]['search']['value']."') ";    
}

if( !empty($_POST['columns'][4]['search']['value']) ){
   $searchQuery.=" AND  ( RegionTo like '%".$_POST['columns'][4]['search']['value']."%') ";
}
if( !empty($_POST['columns'][5]['search']['value']) ){
   $searchQuery.=" AND ( FloorTo = '".$_POST['columns'][5]['search']['value']."') ";    
}
// if($searchByStart != '' && ($searchByEnd != '')){
//    $searchQuery .= " and ( EntryDatetime between '".$searchByStart .
//                      "' and '".$searchByEnd."' ) ";
// }
// if($searchByStart != '' && ($searchByEnd = '')){
//    $searchQuery .= " and ( EntryDatetime >= '".$searchByStart."' ) ";
// }
// if($searchByStart = '' && ($searchByEnd != '')){
//    $searchQuery .= " and ( EntryDatetime <= '".$searchByEnd."' ) ";
// }
// if($searchValue != ''){
//    $searchQuery .= " and (BraceletId=".$searchValue.") ";
// }

## Fetch records
$qry = 'SELECT 

            idApprovedEntries as idApprovedEntries,
            b.idEntriesToRegions as EntryID,
            concat( c.Description_Place," ", c.RegionName) as RegionFrom,
            c.Floor as FloorFrom,
            concat( d.Description_Place," ", d.RegionName) as RegionTo,
            d.Floor as FloorTo

        from ApprovedEntries as a
        join EntriesToRegions as b on b.idEntriesToRegions=a.idEntriesToRegions
        join Regions as c on c.idRegions=b.idRegionsFrom
        join Regions as d on d.idRegions=b.idRegionsTo
        where BraceletId=' . $bid;

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

$empQuery = $qry3 . $searchQuery." order by RegionFrom ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "EntryID"=> $row['EntryID'],
     "RegionFrom"=>$row['RegionFrom'],
     "FloorFrom"=>$row['FloorFrom'],
     "RegionTo"=>$row['RegionTo'],
     "FloorTo"=>$row['FloorTo'],
     "idApprovedEntries"=>$row['idApprovedEntries']
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


