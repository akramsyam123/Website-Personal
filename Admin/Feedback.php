<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>toko pakaian muslim azzahra</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
<!--
.style9 {font-size: 95%; font-weight: bold; color: #003300; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style3 {font-weight: bold}
-->
</style>
</head>
<body>
<div id="wrapper">
  
  <?php
  include "Header.php";
  ?>
  
  <div id="content">
    <h2><span style="color:#003300"> Feedback From Customers</span></h2>
    <table width="100%" border="1" bordercolor="#003300" >
      <tr>
        <th height="32" bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Id</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Customer Name</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Feedback</strong></div></th>
        <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style9 style5"><strong>Date</strong></div></th>
         <th bgcolor="#BDE0A8" class="style3"><div align="left" class="style12">Delete</div></th>
      </tr>

      <form method="get" action="">
  <label for="search">Search by Customer Name:</label>
  <input type="text" name="search" id="search" />
  <button type="submit">Search</button>
</form>

      <?php
$con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");

// Cek jika ada parameter pencarian
$searchQuery = "";
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $searchQuery = " AND user_Registration.CustomerName LIKE '%$search%'";
}

// Query dengan filter pencarian jika ada
$sql = "SELECT Feedback_Master.FeedbackId, user_Registration.CustomerName, Feedback_Master.Feedback, Feedback_Master.Date 
        FROM Feedback_Master, user_Registration 
        WHERE Feedback_Master.CustomerId = user_Registration.CustomerId $searchQuery";

$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    $Id = $row['FeedbackId'];
    $Name = $row['CustomerName'];
    $Feedback = $row['Feedback'];
    $Date = $row['Date'];
?>
      <tr>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Id; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Name; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Feedback; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Date; ?></strong></div></td>
        <td class="style3"><div align="left" class="style9 style5"><strong><a href="DeleteFeedback.php?FeedbackId=<?php echo $Id; ?>">Delete</a></strong></div></td>
      </tr>
<?php
}

$records = mysqli_num_rows($result);
?>
      <tr>
        <td colspan="5" class="style3"><div align="left" class="style12"><?php echo "Total " . $records . " Records"; ?> </div></td>
      </tr>
<?php

mysqli_close($con);
?>

    </table>
    <p align="justify">&nbsp;</p>
    <table width="100%" border="0" cellspacing="3" cellpadding="3">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p><img src="img/gamis.jpg" alt="box" width="100" height="100" hspace="10" align="left" class="imgleft" title="box" /></p></td>
        <td><p><img src="img/abaya.jpg" alt="box" width="100" height="100" hspace="10" align="left" class="imgleft" title="box" /></p></td>
        <td><p><img src="img/kaftan.jpg" alt="box" width="100" height="100" hspace="10" align="left" class="imgleft" title="box" /></p></td>
      </tr>
      <tr>
        <td height="26" bgcolor="#BCE0A8"><div align="center" class="style9">gamis</div></td>
        <td bgcolor="#BCE0A8"><div align="center" class="style9">abaya</div></td>
        <td bgcolor="#BCE0A8"><div align="center" class="style9">kaftan</div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </div>
 <?php
 include "Right.php";
 ?>
  <div style="clear:both;"></div>
   <?php
 include "Footer.php";
 ?>
</div>
</body>
</html>