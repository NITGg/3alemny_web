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

// Initialize variables
$imagePath = '';

// Handle file upload
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];

    // Sanitize file name
    $image = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $image);

    $imageDestination = 'images/' . $image;

    // Check if the directory exists
    if (!is_dir('images')) {
        mkdir('images', 0777, true);
    }

    if (move_uploaded_file($imageTmpName, $imageDestination)) {
        $imagePath = $image;
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Image upload error or no image uploaded.']);
    exit;
}

// Get POST data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$price = isset($_POST['price']) ? trim($_POST['price']) : 0;
$show_on_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;

// Basic validation
if (empty($name) || !is_numeric($price)) {
    echo json_encode(['success' => false, 'error' => 'Invalid input.']);
    exit;
}

// Insert query
$sql = "INSERT INTO products (name, price, image, show_on_homepage) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param('sssi', $name, $price, $imagePath, $show_on_homepage);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
