<?php
$localsecrets = require(__DIR__ . '/../local_secrets.php');
$tap_id = filter_input(INPUT_GET, 'tap_id', FILTER_SANITIZE_STRING);

if (!$tap_id) {
    die('Invalid Tap ID');
}

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.tap.company/v2/charges/" . $tap_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $localsecrets['tap_secret_key'],
        "accept: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$status = $amount = '';

if ($err) {
    $error_message = "cURL Error #: " . $err;
} else {
    $data = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $status = htmlspecialchars($data['status']);
        $amount = htmlspecialchars($data['amount']);
    } else {
        $error_message = 'Error decoding JSON';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Payment Redirect</title>
    <script type="text/javascript">
        function redirectToApp() {
            const urlParams = new URLSearchParams(window.location.search);

            // Default fallback redirect link if no redirectUrl parameter is provided
            const fallbackLink = `https://buzzersupplier.page.link?apn=com.mycompany.buzzer&ibi=com.mycompany.buzzer&isi=6503939586&link=https%3A%2F%2Fbuzzersupplier.page.link%2FtestPayment%2F<?php echo $tap_id; ?>%2F<?php echo $status; ?>%2F<?php echo $amount; ?>`;
            window.location.href = fallbackLink;
        }

        window.onload = redirectToApp;
    </script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .loader {
            border: 16px solid #e6e6e6;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        p {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
            position: absolute;
        }
    </style>
</head>

<body>
    <div class="loader"></div>
    <p>Loading...</p>
</body>

</html>
