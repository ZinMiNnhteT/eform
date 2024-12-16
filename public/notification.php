<?php 
define('API_ACCESS_KEY','AAAAmtcTBos:APA91bF-8Y5BAFdnUAM6omIXAzHCSXEg0lOiJmir-XTZDNuq5iykZiEXDWXpcTXegic9xzyG10py7_3w6LaKpX1wwf0uvubLnPgHLHdBsSa2D8C243dVzrmHgmC4M8cTdTSmt8L5LonB');

$fcmUrl = 'https://fcm.googleapis.com/fcm/send';

$token = $_POST['token'];

$notification = [
    'title' => 'title',
    'body' => 'body of message',
    'icon' => 'myIcon',
    'sound' => 'mySound'
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

print($result);
?>