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
$qry = "SELECT 
            BraceletId,
            LastName,
            FirstName,
            SINNumber,
            ArrivalDatetime, 
            LeavingDatetime,
            TotalBill,
            Description_Place
        FROM 
            (SELECT 
                LastName,
                FirstName,
                SINNumber,
                a.idCustomer
            FROM Customer as a
            join SIN as b on b.idCustomer=a.idCustomer
            where SINNumber = '319-23-3782'
        )as e
        join ActiveCustomerLiveToRooms as c on c.idCustomer = e.idCustomer
        join Regions as d on d.idRegions=c.idRoom
                ;";

$res = mysqli_query($con,$qry);

?>
<table border="2" align="center" cellpadding="5" cellspacing="5">
        <tr>
        <th style="color:white;">BraceletId</th>
        <th style="color:white;">Lastname</th>
        <th style="color:white;">Firstname</th>
        <th style="color:white;">SSN</th>
        <th style="color:white;">ArrivalDatetime</th>
        <th style="color:white;">LeavingDatetime</th>
        <th style="color:white;">Bill</th>
        <th style="color:white;">Place</th>

        </tr>
        <?php
         while($row = mysqli_fetch_assoc($res)){
             $id = $row["BraceletId"];
        ?>
                <tr>
                <td style="color:white;"><?php echo $row["BraceletId"];?></td>
                <td style="color:white;"><?php echo $row["LastName"];?> </td>
                <td style="color:white;"><?php echo $row["FirstName"];?> </td>
                <td style="color:white;"><?php echo $row["SINNumber"];?> </td>
                <td style="color:white;"><?php echo $row["ArrivalDatetime"];?> </td>
                <td style="color:white;"><?php echo $row["LeavingDatetime"];?> </td>
                <td style="color:white;"><?php echo $row["TotalBill"];?> </td>
                <td style="color:white;"><?php echo $row["Description_Place"];?> </td>
                <td style="color:white;">
                <?php echo "<a href = 'BraceletInfo.php?id=$id'> link </a>"; ?>
                </td>
                </tr>
        <?php
        }

 ?>


<form method="post" action="<?php echo $PHP_SELF; ?>"> 
        <input type="radio" name = "view" value = "Street"> Street<br>
        <input type="radio" name = "view" value = "Sea"> Sea<br>
        <input type="radio" name = "view" value = "Castle"> Castle<br> 
        <input type="submit" name="submit" value="Get Selected Values" />

            <?php  

                if (isset($_POST['submit']) && isset($_POST['view'])) 
                {
                    
                    $view = $_POST['view'];  
                    echo $view;
                
                }

                $qry = "SELECT * FROM Room as a
                JOIN Regions as b on b.idRegions=a.idRoom
                where View = $view;";
            
                $rooms =  mysqli_query($con,$qry);
                
            ?>
           Rooms List :  
            <select name='rooms'>  
            <option value="">--- Select ---</option>  
            <?php  
            
                while($row=mysqli_fetch_assoc($rooms))
                {  
            ?>  
                    <option value="<?php echo $row['idRoom']; ?>">"<?php echo $row['Description_Place']; ?>"</option>  
            <?php 
            }  
            ?>  
            </select>  
            <input type="submit" name="Submit" value="Select" />  

</form>
<style>
    .filterDiv {
    float: left;
    background-color: #2196F3;
    color: #ffffff;
    width: 100px;
    line-height: 100px;
    text-align: center;
    margin: 2px;
    display: none;
    }

    .show {
    display: block;
    }

    .container {
    margin-top: 20px;
    overflow: hidden;
    }
</style>

<h2>Filter DIV Elements</h2>

<div class="container">
  <div class="filterDiv cars">BMW</div>
  <div class="filterDiv colors fruits">Orange</div>
  <div class="filterDiv cars">Volvo</div>
  <div class="filterDiv colors">Red</div>
  <div class="filterDiv cars animals">Mustang</div>
  <div class="filterDiv colors">Blue</div>
  <div class="filterDiv animals">Cat</div>
  <div class="filterDiv animals">Dog</div>
  <div class="filterDiv fruits">Melon</div>
  <div class="filterDiv fruits animals">Kiwi</div>
  <div class="filterDiv fruits">Banana</div>
  <div class="filterDiv fruits">Lemon</div>
  <div class="filterDiv animals">Cow</div>
</div>
</html>

