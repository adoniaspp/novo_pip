self.addEventListener('install', function(event) {
    console.log('[Service Worker] Installing Service Worker ...', event);
    event.waitUntil(
        caches.open('static')
            .then(function(cache) {
                console.log('[Service Worker] Precaching App Shell');
                cache.addAll([
                    '/assets/bundle.css',
                    '/assets/bundle.js',
                ]);
            })
    )
});

self.addEventListener('activate', function(event) {
    console.log('[Service Worker] Activating Service Worker ....', event);
    return self.clients.claim();
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                if (response) {
                    return response;
                }
                else {
                    if (event.request.cache === 'only-if-cached' && event.request.mode !== 'same-origin') return;
                    //console.log(event.request);
                    return fetch(event.request).then(res =>{
                        return res.clone();
                    }).catch(err=>console.error(event.request.url));
                }
            })
    );
});