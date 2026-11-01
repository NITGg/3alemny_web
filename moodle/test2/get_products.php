<?php
$localsecrets = require(__DIR__ . '/../local_secrets.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // السماح لجميع المصادر
header('Access-Control-Allow-Methods: GET, POST'); // السماح بأساليب GET و POST
header('Access-Control-Allow-Headers: Content-Type'); // السماح برؤوس معينة

// تفاصيل الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "i9505651_mo1";
$password = $localsecrets['legacydb_password'];
$dbname = "3alemny";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// استعلام لجلب بيانات المنتجات
$sql = "SELECT id, name, price, image, show_on_homepage FROM products";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo json_encode(['error' => 'No products found']);
    exit;
}

$conn->close();

echo json_encode($products);
?>
