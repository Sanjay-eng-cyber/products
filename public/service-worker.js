self.addEventListener('push', event => {
    const data = event.data.json();
    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon || '/favicon.ico',
            data: data.data
        })
    );
});

self.addEventListener('notificationclick', event => {
    event.notification.close();
    const orderId = event.notification.data.order_id;
    event.waitUntil(
        clients.openWindow(`/orders/${orderId}`)
    );
});
