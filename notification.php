<?php 
define('API_ACCESS_KEY','BAKMQ7emJ2svL5P9GrwPfdUybJYEvc2wK10-ZKjlKRwL_6ai8yu8Q11qUWddWOpB8O3RI34lIJYuzMh1K4Yb51U');

$fcmUrl = 'https://fcm.googleapis.com/fcm/send';

$token = $_POST['token'];

$notification = [
    'title' => 'title',
    'body' => 'body of message',
    'icon' => 'myIcon',
    'sound' => 'mysound'
];

$extraNotificationData = ['message' => $notification, 'moredata' => 'dd'];

$fcmNotification = [
    'to' => $token,
    'notification' => $notification,
    'data' => $extraNotificationData
];

$headers = [
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $fcmUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>