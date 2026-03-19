self.addEventListener('push', function (event) {
    let data = {
        title: 'Notification',
        body: 'No message received',
    };

    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data = {
                title: 'Notification',
                body: event.data.text(),
            };
        }
    }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
        })
    );
});
