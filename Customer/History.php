<?php

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
.style10 {color: #FFFFFF}
-->
</style>
</head>
<body>
<div id="wrapper">
  
<?php
session_start();

// Pastikan pengguna telah login
if (!isset($_SESSION['ID'])) {
    echo "Access denied. Please login first.";
    exit;
}

// Koneksi ke database
$con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");

// Cek koneksi
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Variabel pencarian
$searchTerm = "";
if (isset($_POST['searchTerm'])) {
    $searchTerm = mysqli_real_escape_string($con, $_POST['searchTerm']);
}

// ID pelanggan
$customerId = $_SESSION['ID'];

// Query utama dengan filter pencarian
$sql = "SELECT 
            sc.CustomerId, 
            sc.ItemName, 
            sc.Quantity, 
            sc.Price, 
            sc.Total, 
            im.Image, 
            im.Size 
        FROM 
            shopping_cart_final AS sc
        INNER JOIN 
            item_master AS im 
        ON 
            im.ItemName = sc.ItemName 
        WHERE 
            sc.CustomerId = '$customerId'";

if (!empty($searchTerm)) {
    $sql .= " AND sc.ItemName LIKE '%$searchTerm%'";
}

$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Toko Pakaian Muslim Azzahra</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <style>
        .style9 {font-size: 95%; font-weight: bold; color: #003300; font-family: Verdana, Arial, Helvetica, sans-serif;}
        .style10 {color: #FFFFFF;}
    </style>
</head>
<body>
<div id="wrapper">
    <?php include "Header.php"; ?>

    <div id="content">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['Name']); ?></h2>

        <!-- Form Pencarian -->
        <form method="post" action="">
            <label for="searchTerm">Search by Item Name:</label>
            <input type="text" name="searchTerm" id="searchTerm" value="<?php echo htmlspecialchars($searchTerm); ?>" />
            <button type="submit">Search</button>
        </form>

        <!-- Tabel Hasil -->
        <table width="100%" border="1" bordercolor="#003300">
            <tr>
                <td bgcolor="#4B692D" class="style10"><strong>Item Name</strong></td>
                <td bgcolor="#4B692D" class="style10"><strong>Quantity</strong></td>
                <td bgcolor="#4B692D" class="style10"><strong>Price</strong></td>
                <td bgcolor="#4B692D" class="style10"><strong>Size</strong></td>
                <td bgcolor="#4B692D" class="style10"><strong>Total</strong></td>
                <td bgcolor="#4B692D" class="style10"><strong>Image</strong></td>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ItemName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Size']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
                    echo "<td><img src='../Products/" . htmlspecialchars($row['Image']) . "' height='100' width='100'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No items found.</td></tr>";
            }
            mysqli_close($con);
            ?>
        </table>
    </div>

    <?php include "Right.php"; ?>
    <div style="clear:both;"></div>
    <?php include "Footer.php"; ?>
</div>
</body>
</html>




