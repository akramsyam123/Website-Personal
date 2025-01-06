<?php require_once('../Connections/shop.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = stripslashes($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_GET['CustomerId'])) {
  $colname_Recordset1 = $_GET['CustomerId'];
}

$query_Recordset1 = sprintf("SELECT CustomerName, Address, City, Email, Mobile, Gender FROM user_registration WHERE CustomerId = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysqli_query($shop, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Online Cloth Shopping</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
<!--
.style9 {font-size: 95%; font-weight: bold; color: #003300; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style10 {
	font-size: 14px;
	font-weight: bold;
}
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
    <p align="justify" class="style10">Shipping Address Detail</p>
    <a href="detail.php?cetak_pdf=1" class="btn btn-success mb-3">Cetak PDF</a>
    <table width="100%" border="0">   
      </tr>
      <?php do { ?>
        <tr>
         <td bgcolor="#BDE0A8"><strong>CustomerName</strong></td> 
        <td bgcolor="#BDE0A8"><?php echo $row_Recordset1['CustomerName']; ?></td></tr>
        <tr>  <td bgcolor="#E3F2DB"><strong>Address</strong></td>  
        <td bgcolor="#E3F2DB"><?php echo $row_Recordset1['Address']; ?></td></tr>
        <tr> <td bgcolor="#BDE0A8"><strong>City</strong></td> 
        <td bgcolor="#BDE0A8"><?php echo $row_Recordset1['City']; ?></td></tr>
       <tr>  <td bgcolor="#E3F2DB"><strong>Email</strong></td> 
       <td bgcolor="#E3F2DB"><?php echo $row_Recordset1['Email']; ?></td></tr>
        <tr> <td bgcolor="#BDE0A8"><strong>Mobile</strong></td>  
        <td bgcolor="#BDE0A8"><?php echo $row_Recordset1['Mobile']; ?></td></tr>
        <tr> <td bgcolor="#E3F2DB"><strong>Gender</strong></td> 
        <td bgcolor="#E3F2DB"><?php echo $row_Recordset1['Gender']; ?></td>
        </tr>
        <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    <?php
require_once('../Connections/shop.php');
require 'D:/xampp/htdocs/toko pakaian muslim azzahra/tcpdf/tcpdf.php';

// Cek apakah tombol cetak PDF di-klik
if (isset($_GET['cetak_pdf'])) {
    // Koneksi ke database
    $con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");
    if (mysqli_connect_error()) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Query untuk mengambil data penjualan
    $sql = "SELECT 
                user_registration.CustomerId, 
                user_registration.CustomerName, 
                shopping_cart_final.ItemName, 
                shopping_cart_final.Quantity, 
                shopping_cart_final.Price, 
                shopping_cart_final.Total 
            FROM user_registration 
            INNER JOIN shopping_cart_final 
            ON user_registration.CustomerId = shopping_cart_final.CustomerId";

    $result = mysqli_query($con, $sql);

    // Inisialisasi TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Toko Pakaian Muslim Azzahra');
    $pdf->SetTitle('Laporan Data Penjualan');
    $pdf->SetHeaderData('', 0, 'Laporan Data Penjualan', 'Toko Pakaian Muslim Azzahra');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(15, 27, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(TRUE, 25);
    $pdf->SetFont('helvetica', '', 10);

    // Tambahkan halaman
    $pdf->AddPage();

    // Konten PDF
    $html = '<h2 align="center">Laporan Data Penjualan</h2><br>';
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; text-align: left;">
                <thead>
                    <tr>
                        <th style="width: 10%;"><strong>ID</strong></th>
                        <th style="width: 25%;"><strong>Customer Name</strong></th>
                        <th style="width: 25%;"><strong>Item Name</strong></th>
                        <th style="width: 10%;"><strong>Quantity</strong></th>
                        <th style="width: 15%;"><strong>Price</strong></th>
                        <th style="width: 15%;"><strong>Total</strong></th>
                    </tr>
                </thead>
                <tbody>';

    // Memasukkan data ke dalam tabel
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "<tr>
                        <td>{$row['CustomerId']}</td>
                        <td>{$row['CustomerName']}</td>
                        <td>{$row['ItemName']}</td>
                        <td>{$row['Quantity']}</td>
                        <td>Rp " . number_format($row['Price'], 2, ',', '.') . "</td>
                        <td>Rp " . number_format($row['Total'], 2, ',', '.') . "</td>
                      </tr>";
        }
    } else {
        $html .= '<tr><td colspan="6" align="center">Data tidak tersedia</td></tr>';
    }

    $html .= '</tbody></table>';

    // Menulis HTML ke PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output PDF ke browser
    $pdf->Output('Laporan_Data_Penjualan.pdf', 'I');

    // Tutup koneksi database
    mysqli_close($con);
    exit();
}
?>

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
<?php
mysqli_free_result($Recordset1);
?>
