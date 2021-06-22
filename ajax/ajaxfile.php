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

## Fetch records
$qry = "SELECT * FROM(
   SELECT
   t.Description_Place as Description_Place, 
   t.NumberOfBeds as NumberOfBeds,
   t.View as View,
   t.ChargePerDay as ChargePerDay,
   t.Floor as Floor

   from
   (
   select 

   a.idRoom,
   Description_Place, 
   NumberOfBeds,
   View,
   ChargePerDay,
   Floor
   
      
   from Room as a
   join Regions as b on b.idRegions=a.idRoom
   )as t
   left join 
   (

   select 

   a.idRoom,
   Description_Place, 
   NumberOfBeds,
   View,
   ChargePerDay,
   Floor
   
      
   from Room as a
   join Regions as b on b.idRegions=a.idRoom
   join ActiveCustomerLiveToRooms as c on c.idRoom=b.idRegions
   where LeavingDatetime >= NOW()
   )as q on q.idRoom=t.idRoom
   where q.idRoom is Null and 1) as w
   where 1 ";

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


$empQuery = $qry . $searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "Description_Place"=> $row['Description_Place'],
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


