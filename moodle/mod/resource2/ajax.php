<?php
require_once('../../config.php');
require '../../vimeo/vendor/autoload.php';

use Vimeo\Vimeo;

if (isset($_POST['myData'])) {
    try {
        $client = new Vimeo((require __DIR__ . '/../../local_secrets.php')['vimeo_client_id_2'], (require __DIR__ . '/../../local_secrets.php')['vimeo_client_secret_2'], (require __DIR__ . '/../../local_secrets.php')['vimeo_access_token_2']);
        $uri = "/videos/" . $_POST['url'];
        $response = $client->request($uri, [], 'GET');
        // echo sizeof($response['body']['files']);

        for ($i = 0; $i < sizeof($response['body']['files']); $i++) {
            if ($_POST['myData'] == 1) {
                if (strpos($response['body']['files'][$i]['link'], '1080p') !== false) {
                    echo $response['body']['files'][$i]['link'];
                }
            } elseif ($_POST['myData'] == 2) {
                if (strpos($response['body']['files'][$i]['link'], '720p') !== false) {
                    echo $response['body']['files'][$i]['link'];
                }
            } elseif ($_POST['myData'] == 3) {
                if (strpos($response['body']['files'][$i]['link'], '360p') !== false) {
                    echo $response['body']['files'][$i]['link'];
                }
            } elseif ($_POST['myData'] == 4) {
                if (strpos($response['body']['files'][$i]['link'], '540p') !== false) {
                    echo $response['body']['files'][$i]['link'];
                }
            } elseif ($_POST['myData'] == 5) {
                if (strpos($response['body']['files'][$i]['link'], '240p') !== false) {
                    echo $response['body']['files'][$i]['link'];
                }
            }
        }
    } catch (Exception $e) {
        echo "fail " . $e;
    }
}
