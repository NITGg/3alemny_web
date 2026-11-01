<?php
$localsecrets = require(__DIR__ . '/../local_secrets.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET, POST'); // Allow GET and POST methods
header('Access-Control-Allow-Headers: Content-Type'); // Allow specific headers

// Database connection
$servername = "localhost";
$username = "i9505651_mo1";
$password = $localsecrets['legacydb_password'];
$dbname = "3alemny";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

// Handle file upload
$image = $_POST['currentImage'] ?? ''; // Default to current image if not set
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageDestination = 'images/' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $image);

    // Check if the directory exists
    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    if (!move_uploaded_file($imageTmpName, $imageDestination)) {
        echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
        exit;
    }
}

// Get POST data
$id = $_POST['productId'];
$name = $_POST['name'];
$price = $_POST['price'];
$show_on_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;

// Basic validation
if (empty($id) || empty($name) || !is_numeric($price)) {
    echo json_encode(['success' => false, 'error' => 'Invalid input.']);
    exit;
}

// Update query
$sql = "UPDATE products SET name = ?, price = ?, image = ?, show_on_homepage = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param('sssii', $name, $price, $image, $show_on_homepage, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
