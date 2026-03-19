<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Plain PHP Push</title>
</head>

<body>

    <button id="subscribe">Enable Push</button>

    <script>
        const publicKey = '<?php echo $_ENV['PUBLIC_KEY']; ?>';

        document.getElementById('subscribe').addEventListener('click', async () => {

            await Notification.requestPermission();

            await navigator.serviceWorker.register('/service-worker.js');

            const registration = await navigator.serviceWorker.ready;

            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(publicKey)
            });

            console.log(subscription)

            await fetch('/subscribe.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(subscription)
            });

            alert('Subscribed!');
        });

        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/-/g, '+')
                .replace(/_/g, '/');

            const rawData = atob(base64);
            return Uint8Array.from([...rawData].map(char => char.charCodeAt(0)));
        }
    </script>

</body>

</html>
