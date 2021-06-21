<?php
include 'DBConnection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
$searchByView = $_POST['searchByView'];
$searchByPrice = $_POST['searchByPrice'];

## Search 
$searchQuery = " ";
if($searchByView != ''){
   $searchQuery .= " and (View like '%".$searchByView."%' ) ";
}
if($searchByPrice != ''){
   $searchQuery .= " and (ChargePerDay <= ".$searchByPrice." ) ";
}
if($searchValue != ''){
   $searchQuery .= " and (Description_Place like '%".$searchValue."%') ";
}

## Total number of records without filtering
$qry = "SELECT count(*) as allcount from Room";
$sel = mysqli_query($con,$qry);
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$qry = "SELECT count(*) as allcount from Room as a 
        join Regions as b on b.idRegions=a.idRoom
        where 1";

$sel = mysqli_query($con,$qry . $searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$qry = "SELECT Description_Place, 
                NumberOfBeds,
                View,
                ChargePerDay,
                Floor
        from Room as a 
        join Regions as b on b.idRegions=a.idRoom
        where 1 ";
$empQuery = $qry . $searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "Description_Place"=>$row['Description_Place'],
     "NumberOfBeds"=>$row['NumberOfBeds'],
     "View"=>$row['View'],
     "ChargePerDay"=>$row['ChargePerDay'],
     "Floor"=>$row['Floor']
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