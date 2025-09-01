import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
}

window.Echo.join('admin.presence')
    .here(users => {
        const customers = users.filter(u => u.role === 'customer');
        renderOnlineUsers(customers);
        customers.forEach(u => markUserOnline(u.id));
    })
    .joining(user => {
        if (user.role === 'customer') {
            addUserOnline(user);
            markUserOnline(user.id);
        }
    })
    .leaving(user => {
        if (user.role === 'customer') {
            removeUserOnline(user);
            markUserOffline(user.id);
        }
    });

function renderOnlineUsers(users) {
    const container = document.getElementById('online-users');
    container.innerHTML = '';
    users.forEach(addUserOnline);
}

function addUserOnline(user) {
    const container = document.getElementById('online-users');
    if (!document.getElementById(`user-${user.id}`)) {
        const li = document.createElement('li');
        li.id = `user-${user.id}`;
        li.textContent = `${user.name}`;
        container.appendChild(li);
    }
}

function removeUserOnline(user) {
    const el = document.getElementById(`user-${user.id}`);
    if (el) el.remove();
}

// --- Update database ---
function markUserOnline(userId) {
    fetch(`/users/${userId}/online`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
    });
}

function markUserOffline(userId) {
    fetch(`/users/${userId}/offline`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
    });
}

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');

    navigator.serviceWorker.ready.then(async registration => {
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(import.meta.env.VITE_PUSHER_APP_VAPID_PUBLIC)
        });

        // Send subscription to server
        await fetch('/push-subscribe', {
            method: 'POST',
            body: JSON.stringify(subscription),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    });
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
}

