<?php

require __DIR__.'/vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$publicKey = $_ENV['PUBLIC_KEY'];
$privateKey = $_ENV['PRIVATE_KEY'];

$auth = [
    'VAPID' => [
        'subject' => 'mailto:your@email.com',
        'publicKey' => $publicKey,
        'privateKey' => $privateKey,
    ],
];

$webPush = new WebPush($auth);

$subscriptionData = json_decode(file_get_contents('subscription.json'), true);

$subscription = Subscription::create($subscriptionData);

$payload = json_encode([
    'title' => 'Plain PHP Push',
    'body' => 'Hello from plain PHP!'
]);

$webPush->queueNotification($subscription, $payload);

foreach ($webPush->flush() as $report) {
    if ($report->isSuccess()) {
        echo "Success for " . $report->getEndpoint();
    } else {
        echo "Failure: " . $report->getReason();
    }
}
