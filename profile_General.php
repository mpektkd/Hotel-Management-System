<!DOCTYPE HTML>
<html>
<body bgcolor="#5bc0de">
        <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="bootstrap.css">
                <link rel="stylesheet" type="text/css" href="button.css">
        </head>
<a href="index.html" class="button">Back</a>
<center><h2 style = "color:white;">Customer Profile</h2></center>
<form action = "Display_profile.php" method="get">
<br>
<center style="color:white;">Customer SSN:
<input type="text" name="search1" size="48">
</br>
<br>
<center style="color:white;">


<input type="submit" value="submit">
<input type="reset" value="Reset">
</center>
<br>

</form>



<?php

include("DBConnection.php");

$sql = "SELECT * FROM mydb.CustomerInfo";
$result = mysqli_query($con,$sql);

?>
<br>
<table border="2" align="center" cellpadding="5" cellspacing="5">
        <tr>
        <th style="color:white;">Lastname</th>
        <th style="color:white;">Firstname</th>
        <th style="color:white;">BirthDate</th>
        <th style="color:white;">Gender</th>
        <th style="color:white;">Number</th>
        <th style="color:white;">Email</th>
        <th style="color:white;">SSN</th>
        <th style="color:white;">SSNDocument</th>
        <th style="color:white;">SSNIssueAuthority</th>
        </tr>
        <?php
                while($row=mysqli_fetch_assoc($result)){
                ?>
                        <tr>
                                <td style="color:white;"><?php echo $row["LastName"]; ?></td>
                                <td style="color:white;"><?php echo $row["FirstName"]; ?></td>
                                <td style="color:white;"><?php echo $row["BirthDate"]; ?></td>
                                <td style="color:white;"><?php echo $row["Gender"]; ?></td>
                                <td style="color:white;"><?php echo $row["Number"]; ?></td>
                                <td style="color:white;"><?php echo $row["Email"]; ?></td>
                                <td style="color:white;"><?php echo $row["SINNumber"]; ?></td>
                                <td style="color:white;"><?php echo $row["SINDocument"]; ?></td>
                                <td style="color:white;"><?php echo $row["SINIssueAuthority"]; ?></td>
                                
                        </tr>
                <?php
                }
?>

</body>
</html>





