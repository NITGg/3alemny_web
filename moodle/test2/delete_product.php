<?php
$localsecrets = require(__DIR__ . '/../local_secrets.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // السماح لجميع المصادر
header('Access-Control-Allow-Methods: GET, POST'); // السماح بأساليب GET و POST
header('Access-Control-Allow-Headers: Content-Type'); // السماح برؤوس معينة


// Database connection
$servername = "localhost";
$username = "i9505651_mo1";
$password = $localsecrets['legacydb_password'];
$dbname = "3alemny";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get POST data
$id = $_POST['id'];

// Delete query
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
