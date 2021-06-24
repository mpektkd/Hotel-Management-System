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
$service = $_POST['service'];

## Search 
$searchQuery = " ";
if($service != ''){
   $searchQuery .= " and idServices= " . $service;
}
if($searchValue != ''){
   $searchQuery .= " and (Description like '%".$searchValue."%') ";
}

## Fetch records
$qry = "SELECT 

            c.idServices,
            a.Description as Description,
            a.TotalConsumption as TotalConsumption,
            a.TotalProfit as TotalProfit,
            a.CostPerUnit as CostPerUnit

        from MenuStatsLastSixMonths as a 
        join ServiceMenu as b on b.idServiceMenu=a.idServiceMenu
        join Services as c on c.idServices=b.idServices ";

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

$qry3 = "SELECT * from (" . $qry . ")as r where 1 ";
$empQuery = $qry3 . $searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
   $data[] = array(
     "Description"=> $row['Description'],
     "TotalConsumption"=>$row['TotalConsumption'],
     "TotalProfit"=>$row['TotalProfit'],
     "CostPerUnit"=>$row['CostPerUnit']
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


