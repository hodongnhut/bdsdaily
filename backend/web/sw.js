const CACHE_NAME = 'bdsdaily-v21';
const STATIC_CACHE = 'static-v21';
const DYNAMIC_CACHE = 'dynamic-v21';


const PRECACHE_URLS = [
    '/',
    '/offline',
    '/css/site.css',
    '/js/site.js',
    '/img/logo.webp',
    '/img/icon-192x192.png',
    '/img/icon-512x512.png',
    '/img/offline-banner.jpg',
    '/manifest.json',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
];

self.addEventListener('install', event => {
    console.log('[SW] Install');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('[SW] Precaching resources...');
                return cache.addAll(PRECACHE_URLS);
            })
            .then(() => self.skipWaiting())
    );
});


self.addEventListener('activate', event => {
    console.log('[SW] Activate');
    const expectedCaches = [STATIC_CACHE, DYNAMIC_CACHE];

    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (!expectedCaches.includes(cacheName)) {
                        console.log('[SW] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);


    if (request.method !== 'GET' || url.protocol !== 'http:' && url.protocol !== 'https:') {
        return;
    }


    if (url.pathname.startsWith('/api/') ||
        url.pathname.includes('/admin') ||
        url.pathname.includes('/user') ||
        url.pathname.includes('/property/create') ||
        url.pathname.includes('/property/update')) {

        event.respondWith(networkFirst(request));
        return;
    }

    if (request.headers.get('accept').includes('text/html')) {
        event.respondWith(
            caches.match(request).then(cachedResponse => {
                if (cachedResponse) {
                    fetch(request).then(networkResponse => {
                        caches.open(DYNAMIC_CACHE).then(cache => {
                            cache.put(request, networkResponse.clone());
                        });
                    }).catch(() => { });
                    return cachedResponse;
                }

                return fetch(request).then(networkResponse => {
                    if (networkResponse && networkResponse.status === 200) {
                        caches.open(DYNAMIC_CACHE).then(cache => {
                            cache.put(request, networkResponse.clone());
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    return caches.match('/offline');
                });
            })
        );
        return;
    }

    event.respondWith(
        caches.match(request).then(cachedResponse => {
            if (cachedResponse) {
                return cachedResponse;
            }
            return fetch(request).then(networkResponse => {
                if (networkResponse && networkResponse.status === 200) {
                    caches.open(DYNAMIC_CACHE).then(cache => {
                        cache.put(request, networkResponse.clone());
                    });
                }
                return networkResponse;
            }).catch(() => {
                if (request.destination === 'image') {
                    return caches.match('/img/offline-banner.png');
                }
            });
        })
    );
});

// Hàm Network First (dành cho API)
async function networkFirst(request) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse && networkResponse.status === 200) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (err) {
        const cachedResponse = await caches.match(request);
        return cachedResponse || caches.match('/site/offline');
    }
}