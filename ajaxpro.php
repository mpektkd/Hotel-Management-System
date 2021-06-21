<?php

    include("DBConnection.php");
    session_start();

   $sql = "SELECT * from ServiceMenu as a
   join Services as b on b.idServices=a.idServices
   join ServicesAtSpecifiedRegions as c on c.idServices=b.idServices
   join Regions as d on d.idRegions=c.idOtherRegions 
   where idServiceMenu= ".$_GET['id'].";"; 

    $result = mysqli_query($con,$sql);

   $json = [];

   while($row = mysqli_fetch_assoc($result)){

        $json[$row['idRegions']] = "'" . $row['Description_Place'] ." " . $row['RegionName']."'";

   }


   echo json_encode($json);

?>