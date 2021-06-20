<!DOCTYPE HTML>
<html>
<body bgcolor="#5bc0de">
<a href="profile_General.php" class="button">Back</a>
        <head>
                <link rel="stylesheet" type="text/css" href="button.css">
        </head>
<center><h2 style="color:white;">Customer Profile</h2></center>
<br>

        
<?php
include("DBConnection.php");
session_start();
$id = $_REQUEST["id"];
echo $id;
$qry = "SELECT * from ServiceCharge
            where BreaceleId=$id
                ;";

$res = mysqli_query($con,$qry);

?>
<table border="2" align="center" cellpadding="5" cellspacing="5">
        <tr>
        <th style="color:white;">BraceletId</th>
        <th style="color:white;">ArrivalDatetime</th>
        <th style="color:white;">LeavingDatetime</th>
        <th style="color:white;">Bill</th>
        <th style="color:white;">Place</th>

        </tr>
        <?php
         while($row = mysqli_fetch_assoc($res)){
        ?>
                <tr>
                <td style="color:white;"><?php echo $row["IdServiceCharge"];?> </td>
                <td style="color:white;"><?php echo $row["ArrivalDatetime"];?> </td>
                <td style="color:white;"><?php echo $row["LeavingDatetime"];?> </td>
                <td style="color:white;"><?php echo $row["TotalBill"];?> </td>
                <td style="color:white;"><?php echo $row["Description_Place"];?> </td>
                </tr>
        <?php
        }

?>
</html>

