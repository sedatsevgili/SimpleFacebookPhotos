<?php
require_once "vendor/facebook/php-sdk/src/facebook.php";

$config = array(
  'appId' => '',
  'secret' => '',
  'fileUpload' => false,
  'allowSignedRequest' => false
);
$facebook = new Facebook($config);

$user = $facebook->getUser();
if($user) {
    try {
        $photos = $facebook->api('/me/photos', 'GET');
        header('Content-Type: application/json');
        echo json_encode($photos);
        exit;
    } catch (FacebookApiException $e) {
        showLoginMessage($facebook);
    }
} else {
    showLoginMessage($facebook);
}


function showLoginMessage($facebook) {
    $loginUrl = $facebook->getLoginUrl(array('scope' => array('user_photos')));
    echo "Please <a href='" . $loginUrl . "'>Log In</a>";
}