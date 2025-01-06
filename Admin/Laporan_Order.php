<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load autoload (Composer) atau include DOMPDF manual
require_once '../vendor/autoload.php'; // Jika pakai Composer
// require_once '../libs/dompdf/autoload.inc.php'; // Jika manual

use Dompdf\Dompdf;

// Koneksi ke database
$con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");
if (mysqli_connect_error()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$filter = $_GET['filter'] ?? '';
$queryConditions = '';

if ($filter === 'perhari' && !empty($_GET['tanggal'])) {
    $tanggal = mysqli_real_escape_string($con, $_GET['tanggal']);
    $queryConditions = "AND DATE(OrderDate) = '$tanggal'";
} elseif ($filter === 'perbulan' && !empty($_GET['bulan'])) {
    $bulan = mysqli_real_escape_string($con, $_GET['bulan']);
    $queryConditions = "AND DATE_FORMAT(OrderDate, '%Y-%m') = '$bulan'";
} elseif ($filter === 'pertahun' && !empty($_GET['tahun'])) {
    $tahun = intval($_GET['tahun']);
    $queryConditions = "AND YEAR(OrderDate) = $tahun";
}

$sql = "SELECT ... FROM ... WHERE 1=1 $queryConditions";


// Query data orders
$sql = "SELECT 
            user_registration.CustomerId, 
            user_registration.CustomerName, 
            shopping_cart_final.ItemName, 
            shopping_cart_final.Quantity, 
            shopping_cart_final.Price, 
            shopping_cart_final.Total, 
            shopping_cart_final.OrderDate 
        FROM 
            user_registration 
        INNER JOIN 
            shopping_cart_final 
        ON 
            user_registration.CustomerId = shopping_cart_final.CustomerId";

$result = mysqli_query($con, $sql);

// Membuat konten HTML untuk PDF
$html = '
<h2 style="text-align: center;">Laporan Orders - Toko Azzahra</h2>
<hr>
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #4CAF50; color: white;">
            <th>ID</th>
            <th>Customer Name</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Order Date</th>
        </tr>
    </thead>
    <tbody>
';


// Loop data untuk ditampilkan
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "
        <tr>
            <td>{$row['CustomerId']}</td>
            <td>{$row['CustomerName']}</td>
            <td>{$row['ItemName']}</td>
            <td>{$row['Quantity']}</td>
            <td>{$row['Price']}</td>
            <td>{$row['Total']}</td>
            <td>{$row['OrderDate']}</td>
        </tr>
    ";
}

// Tutup tabel
$html .= '
    </tbody>
</table>
';

// Tutup koneksi database
mysqli_close($con);

// Inisialisasi DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html); // Memuat konten HTML
$dompdf->setPaper('A4', 'landscape'); // Set ukuran dan orientasi kertas
$dompdf->render(); // Render menjadi PDF

// Output PDF ke browser
$dompdf->stream("Laporan_Orders.pdf", ["Attachment" => false]);
exit();
?>
