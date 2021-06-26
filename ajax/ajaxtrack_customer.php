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
$group = $_POST['group'];

$start = substr($group,0,2);
$end = substr($group,-2,2);

// $searchByEnd = $_POST['searchByEnd'];

# datatable column index  => database column name
$columns = array( 
      1 => 'LastName', 
      2 => 'FirstName',
      3 => 'Age', 
      4 => 'Gender',
      5 => 'Number',
      6 => 'Email', 
      7 => 'SINNumber'
   );

## Search 
$searchQuery = " ";
if( !empty($group) && $group != '60'){
   $searchQuery.=" AND ( Age >= " . $start . " and Age <= " . $end . " ) ";
}
if( $group == '60' ){
   $searchQuery.=" AND ( Age >= 60 )";
}
if( !empty($_POST['columns'][1]['search']['value']) ){
   $searchQuery.=" AND ( LastName like '%".$_POST['columns'][1]['search']['value']."%') ";    
}
if( !empty($_POST['columns'][2]['search']['value']) ){
   $searchQuery.=" AND  ( FirstName like '%".$_POST['columns'][2]['search']['value']."%') ";
}
if( !empty($_POST['columns'][3]['search']['value']) ){
   $searchQuery.=" AND ( Age >= '".$_POST['columns'][3]['search']['value']."') ";    
}
if( !empty($_POST['columns'][4]['search']['value']) ){
    $searchQuery.=" AND ( Gender = '".$_POST['columns'][4]['search']['value']."') ";    
 }
if( !empty($_POST['columns'][5]['search']['value']) ){
   $searchQuery.=" AND  ( Number like '%".$_POST['columns'][5]['search']['value']."%') ";
}
if( !empty($_POST['columns'][6]['search']['value']) ){
   $searchQuery.=" AND ( Email like '%".$_POST['columns'][6]['search']['value']."%') ";    
}
if( !empty($_POST['columns'][7]['search']['value']) ){
    $searchQuery.=" AND ( SINNumber = '".$_POST['columns'][7]['search']['value']."') ";    
 }

// if($searchValue != ''){
//    $searchQuery .= " and (BraceletId=".$searchValue.") ";
// }

## Fetch records
$qry = 'SELECT 
            id,
            LastName,
            FirstName,
            concat(LastName," ", FirstName) as Name,
            Gender,
            TRIM(LEADING "0" FROM DATE_FORMAT(FROM_DAYS(DATEDIFF(date(NOW()), BirthDate)), "%Y")) AS Age,
            Number,
            Email,
            SINNumber
        FROM mydb.CustomerInfo';

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
     "LastName"=> $row['LastName'],
     "FirstName"=>$row['FirstName'],
     "Age"=>$row['Age'],
     "Gender"=>$row['Gender'],
     "Number"=>$row['Number'],
     "Email"=>$row['Email'],
     "SINNumber"=>$row['SINNumber'],
     "cid"=>$row['id']
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


