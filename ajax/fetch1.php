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

if(isset($_POST['filter1'], $_POST['filter_country1']) && $_POST['filter1'] != '')
{
//  $query .= '
//  WHERE customer.BirthDate <= "'.mydate($_POST['filter1']).'"  
//  ';

    if ($_POST['filter1']=='20-40'){

        $query="SELECT 
                    re.RegionName,
                    re.Description_Place,re.Floor , 
                    COUNT(act.BraceletId) 
                FROM Regions as re 
                JOIN CustomerVisitRegions as custre ON re.idRegions=custre.idRegions 
                JOIN ActiveCustomerLiveToRooms as act ON custre.BraceletId=act.BraceletId
                JOIN Customer as customer ON act.idCustomer=customer.idCustomer  
                join OtherRegions as w on w.idOtherRegions=re.idRegions
                and customer.BirthDate <= '19801211' 
                GROUP BY re.idRegions ORDER BY COUNT(act.BraceletId) DESC ";


    }
        elseif($_POST['filter1']=='40-60'){

            $query="SELECT 
                    re.RegionName,
                    re.Description_Place,re.Floor , 
                    COUNT(act.BraceletId) 
                FROM Regions as re 
                JOIN CustomerVisitRegions as custre ON re.idRegions=custre.idRegions 
                JOIN ActiveCustomerLiveToRooms as act ON custre.BraceletId=act.BraceletId
                JOIN Customer as customer ON act.idCustomer=customer.idCustomer  
                join OtherRegions as w on w.idOtherRegions=re.idRegions
                and customer.BirthDate between '19601211' and '19801211' 
                GROUP BY re.idRegions ORDER BY COUNT(act.BraceletId) DESC ";

            }
        elseif($_POST['filter1']=='60+'){


            $query="SELECT 
                    re.RegionName,
                    re.Description_Place,re.Floor , 
                    COUNT(act.BraceletId) 
                FROM Regions as re 
                JOIN CustomerVisitRegions as custre ON re.idRegions=custre.idRegions 
                JOIN ActiveCustomerLiveToRooms as act ON custre.BraceletId=act.BraceletId
                JOIN Customer as customer ON act.idCustomer=customer.idCustomer  
                join OtherRegions as w on w.idOtherRegions=re.idRegions
                and customer.BirthDate >= '19901211' 
                GROUP BY re.idRegions ORDER BY COUNT(act.BraceletId) DESC ";

    //  echo mydate($_POST['filter1']);
    }
}
else
{
    $query = "SELECT 
                re.RegionName,
                re.Description_Place,
                re.Floor ,
                COUNT(act.BraceletId)
            FROM Regions as re 
            JOIN CustomerVisitRegions as custre ON re.idRegions=custre.idRegions
            JOIN ActiveCustomerLiveToRooms as act ON custre.BraceletId=act.BraceletId 
            JOIN Customer as customer ON act.idCustomer=customer.idCustomer
            join OtherRegions as w on w.idOtherRegions=re.idRegions  
            GROUP BY re.idRegions ORDER BY COUNT(act.BraceletId) DESC ";
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
 $sub_array[] = $row['RegionName'];
 $sub_array[] = $row['Description_Place'];
 $sub_array[] = $row['Floor'];
 $sub_array[] = $row['COUNT(act.BraceletId)'];
 $data[] = $sub_array;
}

function count_all_data($connect)
{
    if(isset($_POST['filter1'], $_POST['filter_country1']) && $_POST['filter1'] != '')
    {
        $query = "SELECT 
                    re.RegionName,
                    re.Description_Place,re.Floor , 
                    COUNT(act.BraceletId) 
                FROM Regions as re 
                JOIN CustomerVisitRegions as custre ON re.idRegions=custre.idRegions 
                JOIN ActiveCustomerLiveToRooms as act ON custre.BraceletId=act.BraceletId
                JOIN Customer as customer ON act.idCustomer=customer.idCustomer  
                join OtherRegions as w on w.idOtherRegions=re.idRegions
                and customer.BirthDate <= '".mydate($_POST['filter1'])."' 
                GROUP BY re.idRegions ORDER BY COUNT(act.BraceletId) DESC ";
    }
    else
    {
        $query = "SELECT 
                    re.RegionName,
                    re.Description_Place,
                    re.Floor ,
                    COUNT(act.BraceletId)
                FROM Regions as re 
                JOIN CustomerVisitRegions as custre ON re.idRegions=custre.idRegions
                JOIN ActiveCustomerLiveToRooms as act ON custre.BraceletId=act.BraceletId 
                JOIN Customer as customer ON act.idCustomer=customer.idCustomer 
                join OtherRegions as w on w.idOtherRegions=re.idRegions 
                GROUP BY re.idRegions ORDER BY COUNT(act.BraceletId) DESC ";
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
