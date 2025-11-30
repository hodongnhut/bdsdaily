const CACHE_NAME = 'bdsdaily-app-v1';
const urlsToCache = [
    '/',
    '/site/index',
    '/css/site.css',
    '/img/icon-192x192.png',
    '/img/icon-512x512.png'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});