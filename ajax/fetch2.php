<?php
include('database_connection.php');
function mydate(string $x) {
    if ($x=='20-40'){
    return '19801211';}
    elseif($x=='40-60'){
        return '19601211';
        }
    elseif($x=='60+'){
        return '19901211';
    }
    
    ;
  }
$column = array('CustomerName', 'Gender', 'Address', 'City', 'PostalCode', 'Country');

if(isset($_POST['filter_gender2'], $_POST['filter_country2']) && $_POST['filter_gender2'] != '')
{
//  $query .= '
//  WHERE customer.BirthDate <= "'.mydate($_POST['filter_gender2']).'"  
//  ';
 $query="SELECT se.Description,     (COUNT(cu.BraceletId)*100*10/(SELECT COUNT(*) 
 from ActiveCustomerLiveToRooms 
 JOIN CustomerVisitRegions ON ActiveCustomerLiveToRooms.BraceletId=CustomerVisitRegions.BraceletId 
  JOIN Regions ON CustomerVisitRegions.idRegions=Regions.idRegions))  as maxx FROM Services as se 
  JOIN ServicesAtSpecifiedRegions as sere on se.idServices=sere.idServices 
  JOIN OtherRegions as other on sere.idOtherRegions=other.idOtherRegions 
  JOIN Regions as re on other.idOtherRegions=re.idRegions 
  JOIN CustomerVisitRegions as cu on re.idRegions=cu.idRegions 
  JOIN ActiveCustomerLiveToRooms AS act On cu.BraceletId=act.BraceletId 
  JOIN Customer as cus On cus.idCustomer=act.idCustomer and cus.BirthDate <= '".mydate($_POST['filter_gender2'])."'
  GROUP BY se.idServices ORDER BY maxx DESC ";
//  echo mydate($_POST['filter_gender2']);
}
else
{
    $query = "SELECT 
                se.Description, 
                (COUNT(cu.BraceletId)*100*10/(SELECT COUNT(*) 
            from ActiveCustomerLiveToRooms
            JOIN CustomerVisitRegions ON ActiveCustomerLiveToRooms.BraceletId=CustomerVisitRegions.BraceletId 
            JOIN Regions ON CustomerVisitRegions.idRegions=Regions.idRegions))  as maxx
            FROM Services as se 
            JOIN ServicesAtSpecifiedRegions as sere on se.idServices=sere.idServices 
            JOIN OtherRegions as other on sere.idOtherRegions=other.idOtherRegions 
            JOIN Regions as re on other.idOtherRegions=re.idRegions 
            JOIN CustomerVisitRegions as cu on re.idRegions=cu.idRegions 
            JOIN ActiveCustomerLiveToRooms AS act On cu.BraceletId=act.BraceletId 
            JOIN Customer as cus On cus.idCustomer=act.idCustomer
            GROUP BY se.idServices ORDER BY maxx
            DESC ";
}

// if(isset($_POST['order']))
// {
//  $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
// }
// else
// {
//  $query .= 'ORDER BY COUNT(cu.BraceletId) DESC ';
// }



if(isset($_POST["length"]) && $_POST["length"] != -1 && $_POST["length"] !="")
{
 $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();


$statement->execute();

$result = $statement->fetchAll();



$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['Description'];
 $sub_array[] = $row['maxx'];
 $data[] = $sub_array;
}

function count_all_data($connect)
{
    if(isset($_POST['filter_gender2'], $_POST['filter_country2']) && $_POST['filter_gender2'] != '')
    {
        $query = "SELECT se.Description,     (COUNT(cu.BraceletId)*100*10/(SELECT COUNT(*) 
        from ActiveCustomerLiveToRooms 
        JOIN CustomerVisitRegions ON ActiveCustomerLiveToRooms.BraceletId=CustomerVisitRegions.BraceletId 
         JOIN Regions ON CustomerVisitRegions.idRegions=Regions.idRegions))  as maxx FROM Services as se 
         JOIN ServicesAtSpecifiedRegions as sere on se.idServices=sere.idServices 
         JOIN OtherRegions as other on sere.idOtherRegions=other.idOtherRegions 
         JOIN Regions as re on other.idOtherRegions=re.idRegions 
         JOIN CustomerVisitRegions as cu on re.idRegions=cu.idRegions 
         JOIN ActiveCustomerLiveToRooms AS act On cu.BraceletId=act.BraceletId 
         JOIN Customer as cus On cus.idCustomer=act.idCustomer and cus.BirthDate <= '".mydate($_POST['filter_gender2'])."'
         GROUP BY se.idServices ORDER BY maxx DESC ";
    }
    else
    {
        $query = "SELECT 
                    se.Description, 
                    (COUNT(cu.BraceletId)*100*10/(SELECT COUNT(*) 
                from ActiveCustomerLiveToRooms
                JOIN CustomerVisitRegions ON ActiveCustomerLiveToRooms.BraceletId=CustomerVisitRegions.BraceletId 
                JOIN Regions ON CustomerVisitRegions.idRegions=Regions.idRegions))  as maxx
                FROM Services as se 
                JOIN ServicesAtSpecifiedRegions as sere on se.idServices=sere.idServices 
                JOIN OtherRegions as other on sere.idOtherRegions=other.idOtherRegions 
                JOIN Regions as re on other.idOtherRegions=re.idRegions 
                JOIN CustomerVisitRegions as cu on re.idRegions=cu.idRegions 
                JOIN ActiveCustomerLiveToRooms AS act On cu.BraceletId=act.BraceletId 
                JOIN Customer as cus On cus.idCustomer=act.idCustomer
                GROUP BY se.idServices ORDER BY maxx
                DESC";
    }
 
 $statement = $connect->prepare($query);
 $statement->execute();
 $statement->closeCursor();
 return $statement->rowCount();
}
$output = array(
 "draw"       =>  intval($_POST["draw"]),
 "recordsTotal"   =>  count_all_data($connect),
 "recordsFiltered"  =>  $number_filter_row,
 "data"       =>  $data
);


echo json_encode($output);

?>
