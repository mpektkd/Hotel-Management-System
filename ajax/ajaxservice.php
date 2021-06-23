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
$searchByService = $_POST['searchByService'];
$searchByPrice = $_POST['searchByPrice'];

## Search 
$searchQuery = " ";
if($searchByService != ''){
   $searchQuery .= " and (Service like '%".$searchByService."%' ) ";
}
if($searchByPrice != ''){
   $searchQuery .= " and (CostPerUnit <= ".$searchByPrice." ) ";
}
if($searchValue != ''){
   $searchQuery .= " and (Description_Place like '%".$searchValue."%') ";
}

## Fetch records
$qry = "SELECT 

            a.Description as Product,
            b.Description as Service,
            CostPerUnit as CostPerUnit,
            Description_Place,
            RegionName as RegionName,
            Floor ,
            d.idRegions


        from ServiceMenu as a
        join Services as b on b.idServices=a.idServices
        join ServicesAtSpecifiedRegions as c on c.idServices=b.idServices
        join Regions as d on d.idRegions=c.idOtherRegions";

## Total number of records without filtering
$qry1 = "SELECT count(*) as allcount from (".$qry.")as r  
                     where 1 ";

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
     "Product"=> $row['Product'],
     "Service"=>$row['Service'],
     "CostPerUnit"=>$row['CostPerUnit'],
     "Description_Place"=>$row['Description_Place'],
     "RegionName"=>$row['RegionName'],
     "Floor"=>$row['Floor'],
     "id"=>$row['idRegions']
     
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


