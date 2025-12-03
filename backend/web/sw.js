const CACHE_NAME = 'bdsdaily-v18'; // Tăng version mỗi khi deploy mới
const STATIC_CACHE = 'static-v18';
const DYNAMIC_CACHE = 'dynamic-v18';


const PRECACHE_URLS = [
    '/',                                            // Trang chủ
    '/site/offline',                                // Trang offline tùy chỉnh (bắt buộc tạo view này)
    '/css/site.css',
    '/js/site.js',
    '/img/logo.webp',
    '/img/icon-192x192.png',
    '/img/icon-512x512.png',
    '/img/offline-banner.jpg',                      // Ảnh hiển thị khi offline
    '/manifest.json',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
];

// ============= INSTALL =============
self.addEventListener('install', event => {
    console.log('[SW] Install');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('[SW] Precaching resources...');
                return cache.addAll(PRECACHE_URLS);
            })
            .then(() => self.skipWaiting()) // Bỏ qua waiting ngay lập tức
    );
});

// ============= ACTIVATE =============
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
        }).then(() => self.clients.claim()) // Lấy quyền điều khiển tất cả tab ngay
    );
});

// ============= FETCH =============
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Bỏ qua các request không phải GET hoặc từ chrome-extension, postMessage, etc.
    if (request.method !== 'GET' || url.protocol !== 'http:' && url.protocol !== 'https:') {
        return;
    }

    // 1. API calls & admin routes → luôn lấy mạng trước (stale-while-revalidate)
    if (url.pathname.startsWith('/api/') ||
        url.pathname.includes('/admin') ||
        url.pathname.includes('/user') ||
        url.pathname.includes('/property/create') ||
        url.pathname.includes('/property/update')) {

        event.respondWith(networkFirst(request));
        return;
    }

    // 2. Trang tĩnh HTML (các route Yii2) → Cache-first + fallback offline
    if (request.headers.get('accept').includes('text/html')) {
        event.respondWith(
            caches.match(request).then(cachedResponse => {
                if (cachedResponse) {
                    // Có cache → trả ngay + cập nhật nền
                    fetch(request).then(networkResponse => {
                        caches.open(DYNAMIC_CACHE).then(cache => {
                            cache.put(request, networkResponse.clone());
                        });
                    }).catch(() => { }); // Lỗi mạng thì thôi
                    return cachedResponse;
                }

                // Không có cache → lấy mạng + cache lại
                return fetch(request).then(networkResponse => {
                    if (networkResponse && networkResponse.status === 200) {
                        caches.open(DYNAMIC_CACHE).then(cache => {
                            cache.put(request, networkResponse.clone());
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    // Không có mạng → trả trang offline
                    return caches.match('/site/offline');
                });
            })
        );
        return;
    }

    // 3. Tài nguyên tĩnh (css, js, img, font) → Cache-first, fallback mạng
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
                // Nếu là hình ảnh → có thể trả placeholder
                if (request.destination === 'image') {
                    return caches.match('/img/offline-banner.jpg');
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