importScripts("https://js.pusher.com/beams/service-worker.js");


self.addEventListener('push', function(event) {
    let data = event.data ? event.data.json() : { title: 'No Title', body: 'No Body' };

    const options = {
        body: data.body,
        icon: 'https://adonai-eyecare.online/adonai/public/uploads/logo-adonai.png', // replace with actual icon path
        vibrate: [100, 50, 100], // Optional: vibration pattern
        data: {
            url: 'https://adonai-eyecare.online/' // URL to open when clicked
        }
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close(); // Close the notification
    event.waitUntil(
        clients.openWindow(event.notification.data.url) // Opens the URL when clicked
    );
});
