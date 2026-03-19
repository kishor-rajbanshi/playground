<!DOCTYPE html>
<html>
<head>
    <title>Laravel 13 Broadcasting</title>
    @vite(['resources/js/app.js'])
</head>
<body style="font-family: Arial; padding: 40px;">

<h1>Broadcast Example</h1>

<div id="output">Waiting...</div>

<button onclick="fetch('/send')">Send Message</button>

<script>
document.addEventListener('DOMContentLoaded', function () {

    window.Echo
        .channel('chat-channel')
        .listen('.chat.message', (e) => {
            document.getElementById('output').innerText = e.message;
        });

});
</script>

</body>
</html>
