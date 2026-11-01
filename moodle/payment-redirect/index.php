<?php
$localsecrets = require(__DIR__ . '/../local_secrets.php');
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// تكوين مصنع Firebase باستخدام ملف الخدمة
$factory = (new Factory)->withServiceAccount('./buzzer-dd3cc-firebase-adminsdk-dw1al-d601829988.json');

// احصل على مرجع لقاعدة بيانات Firestore
$firestore = $factory->createFirestore();
$database = $firestore->database();

header('Content-Type: text/html; charset=UTF-8');

// Validate and sanitize the tap_id parameter
if (isset($_GET['tap_id'])) {
    $tap_id = htmlspecialchars($_GET['tap_id']);  // Sanitize input
} else {
    // Handle the case where tap_id parameter is missing
    // You might redirect to an error page or handle it differently
    exit('Error: tap_id parameter is missing.');
}

$apiUrl = 'https://api.tap.company/v2/charges/' . urlencode($tap_id); // Ensure tap_id is properly URL encoded
$authToken = $localsecrets['tap_secret_key'];

// Initialize cURL
$ch = curl_init($apiUrl);

// Set the required options for cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $authToken,
    'Accept: application/json'
));

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Decode the response
    $decodedResponse = json_decode($response, true);

    // Initialize default values
    $status = 'UNKNOWN';
    $message = 'حالة غير معروفة.';
    $color = '#6c757d';
    $icon = '&#63;'; // رمز علامة استفهام

    // Ensure 'status' exists in the response
    if (isset($decodedResponse['status'])) {
        $status = $decodedResponse['status'];
        

        // Determine the message, color, and icon based on the status
        switch ($status) {
            case 'CAPTURED':
                $message = 'تمت عملية الدفع بنجاح.';
                $color = '#28a745';
                $icon = '&#10004;'; // رمز علامة صح

                // إضافة الفئة إلى Firestore
                $categoryRef = $database->collection('Category')->newDocument();
                $categoryRef->set([
                    'product' => $decodedResponse['product'],
                    'tap_id' => $tap_id,
                    'amount' => $decodedResponse['amount'],
                    'currency' => $decodedResponse['currency'],
                    'status' => $status,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'OrderId' => $decodedResponse['order']['id'],
                    'PaymentMethod' => 'Cash on Delivery',
                    'customer' => [
                        'id' => $decodedResponse['customer']['id'],
                        'first_name' => $decodedResponse['customer']['first_name'],
                        'email' => $decodedResponse['customer']['email']
                    ],
                ]);

                break;
            case 'DECLINED':
                $message = 'تم رفض الدفع.';
                $color = '#dc3545';
                $icon = '&#10006;'; // رمز علامة خطأ

                // إضافة الفئة إلى Firestore
                $categoryRef = $database->collection('Category')->newDocument();
                $categoryRef->set([
                    'product' => $decodedResponse['product'],
                    'tap_id' => $tap_id,
                    'amount' => $decodedResponse['amount'],
                    'currency' => $decodedResponse['currency'],
                    'status' => $status,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'OrderId' => $decodedResponse['order']['id'],
                    'PaymentMethod' => 'Cash on Delivery',
                    'customer' => [
                        'id' => $decodedResponse['customer']['id'],
                        'first_name' => $decodedResponse['customer']['first_name'],
                        'email' => $decodedResponse['customer']['email']
                    ],
                ]);

                break;
            case 'CANCELLED':
                $message = 'تم إلغاء الدفع.';
                $color = '#ffc107';
                $icon = '&#9888;'; // رمز تحذير

                // إضافة الفئة إلى Firestore
                $categoryRef = $database->collection('Category')->newDocument();
                $categoryRef->set([
                    'product' => $decodedResponse['product'],
                    'tap_id' => $tap_id,
                    'amount' => $decodedResponse['amount'],
                    'currency' => $decodedResponse['currency'],
                    'status' => $status,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'PaymentMethod' => 'Cash on Delivery',
                    'customer' => [
                        'first_name' => $decodedResponse['customer']['first_name'],
                        'email' => $decodedResponse['customer']['email']
                    ],
                ]);

                break;
            case 'ABANDONED':
                $message = 'عمليه الدفع غير مكتمله.';
                $color = '#ffc107';
                $icon = '&#9888;'; // رمز تحذير

                // إضافة الفئة إلى Firestore
                $categoryRef = $database->collection('Category')->newDocument();
                $categoryRef->set([
                    'product' => $decodedResponse['product'],
                    'tap_id' => $tap_id,
                    'amount' => $decodedResponse['amount'],
                    'currency' => $decodedResponse['currency'],
                    'status' => $status,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'PaymentMethod' => 'Cash on Delivery',
                    'customer' => [
                        'first_name' => $decodedResponse['customer']['first_name'],
                        'email' => $decodedResponse['customer']['email']
                    ],
                ]);

                break;
        }
    }
    /* echo '<pre>';
    print_r($decodedResponse);
    echo '</pre>'; */
}

// Close the cURL session
curl_close($ch);

?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حالة الدفع</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            direction: rtl;
            /* اتجاه النص لليمين للعرض الصحيح في اللغة العربية */
        }

        .status-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        .status-container h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .status-container p {
            font-size: 18px;
            color: #666;
        }

        .status-container .status {
            font-weight: bold;
            font-size: 20px;
            color: <?php echo $color; ?>;
        }

        .status-container .icon {
            font-size: 50px;
            margin-bottom: 20px;
            color: <?php echo $color; ?>;
        }
    </style>
</head>

<body>
    <div class="status-container">
        <div class="icon"><?php echo $icon; ?></div>
        <h1>حالة الدفع</h1>
        <p><?php echo $message; ?></p>
        <p>حالة الدفع الخاصة بك هي: <span class="status"><?php echo htmlspecialchars($status); ?></span></p>
    </div>
</body>

</html>