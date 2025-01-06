<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Toko Pakaian Muslim Azzahra</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
<!--
.style9 {font-size: 95%; font-weight: bold; color: #003300; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style10 {color: #FFFFFF}
-->
</style>
</head>
<body>
<div id="wrapper">
  
  <?php
  include "Header.php";
  ?>
  
  <div id="content">
    <h2><span style="color:#003300"> Welcome Administrator </span></h2>
    <table width="100%" border="1" bordercolor="#003300" >
      <tr>
        <td bgcolor="#4B692D" class="style10 style3"><strong>ID</strong></td>
        <td bgcolor="#4B692D" class="style10 style3"><strong>Customer Name</strong></td>
        <td bgcolor="#4B692D" class="style10 style3"><strong>Item Name</strong></td>
       
        <td bgcolor="#4B692D" class="style10 style3"><strong>Quantity</strong></td>
        <td bgcolor="#4B692D" class="style10 style3"><strong>Price</strong></td>
        <td bgcolor="#4B692D" class="style10 style3"><strong>Total</strong></td>
      
        <td bgcolor="#4B692D" class="style10 style3"><strong>Shipping Address</strong></td>
      </tr>


      <form method="get" action="">
  <label for="search">Search:</label>
  <input type="text" name="search" id="search" placeholder="Enter Customer Name, ID, or Item Name" />
  <button type="submit">Search</button>
  </form>

  <?php
$con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");

// Cek apakah parameter search diisi
$searchQuery = "";
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $searchQuery = "AND (
        user_registration.CustomerName LIKE '%$search%' OR
        user_registration.CustomerId LIKE '%$search%' OR
        shopping_cart_final.ItemName LIKE '%$search%'
    )";
}

// Query dengan filter pencarian
$sql = "SELECT 
            user_registration.CustomerId, 
            user_registration.CustomerName, 
            shopping_cart_final.ItemName, 
            shopping_cart_final.Quantity, 
            shopping_cart_final.Price, 
            shopping_cart_final.Total 
        FROM 
            user_registration 
        INNER JOIN 
            shopping_cart_final 
        ON 
            user_registration.CustomerId = shopping_cart_final.CustomerId 
        WHERE 1=1 $searchQuery";

$result = mysqli_query($con, $sql);

// Loop untuk menampilkan data
while ($row = mysqli_fetch_array($result)) {
    $Id = $row['CustomerId'];
    $CustomerName = $row['CustomerName'];
    $ItemName = $row['ItemName'];
    $Quantity = $row['Quantity'];
    $Price = $row['Price'];
    $Total = $row['Total'];
?>
<tr>
    <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Id; ?></strong></div></td>
    <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $CustomerName; ?></strong></div></td>
    <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $ItemName; ?></strong></div></td>
    <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Quantity; ?></strong></div></td>
    <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Price; ?></strong></div></td>
    <td class="style3"><div align="left" class="style9 style5"><strong><?php echo $Total; ?></strong></div></td>
    <td class="style3"><a href="Detail.php?CustomerId=<?php echo $Id; ?>">Shipping Address</a></td>
</tr>
<?php
}

// Menghitung jumlah data yang ditemukan
$records = mysqli_num_rows($result);
?>
<tr>
    <td colspan="7" class="style3"><div align="left" class="style12"><?php echo "Total " . $records . " Records"; ?> </div></td>
</tr>


<form method="get" action="Laporan_order.php">
    <h3>Filter Laporan</h3>
    <label for="filter">Filter:</label>
    <select name="filter" id="filter" required>
        <option value="perhari">Per Hari</option>
        <option value="perbulan">Per Bulan</option>
        <option value="pertahun">Per Tahun</option>
    </select>
    <br />

    <label for="tanggal">Tanggal:</label>
    <input type="date" name="tanggal" id="tanggal" />
    <br />

    <label for="bulan">Bulan:</label>
    <input type="month" name="bulan" id="bulan" />
    <br />

    <label for="tahun">Tahun:</label>
    <input type="number" name="tahun" id="tahun" placeholder="YYYY" />
    <br />

    <button type="submit" name="cetak_laporan">Cetak Laporan</button>
</form>


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
