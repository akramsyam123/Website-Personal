<?php
if(!isset($_SESSION))
{
session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>toko pakaian muslim azzahra</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
<!--
.style8 {font-size: 24px}
.style9 {font-size: 95%; font-weight: bold; color: #003300; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<body>
<div id="wrapper">
  
  <?php
  include "Header.php";
  ?>
  
  <div id="content">
    <h2><span style="color:#003300"> Welcome  <?php echo $_SESSION['Name'];?></span></h2>
     <ul>
      
      <?php

$con = mysqli_connect("localhost","root", "", "toko pakaian muslim azzahra");

$sql = "select * from Offer_Master";

$result = mysqli_query($con, $sql);

while($row = mysqli_fetch_array($result))
{
$Id=$row['OfferId'];
$Offer=$row['Offer'];
$Detail=$row['Detail'];
$Valid=$row['Valid'];
?>
     
        <li><?php echo $Offer;?> : <?php echo $Detail;?>: <?php echo $Valid;?></li>
        
     
      <?php
}

$records = mysqli_num_rows($result);
?>
      
      <?php

mysqli_close($con);
?>
    </ul>
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