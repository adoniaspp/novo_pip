self.addEventListener('install', function(event) {
    console.log('[Service Worker] Installing Service Worker ...', event);
    event.waitUntil(
        caches.open('static')
            .then(function(cache) {
                console.log('[Service Worker] Precaching App Shell');
                cache.addAll([
                    '/',
                    '/index.php',
                    '/manifest.json',
                    '/assets/html/index.php',
                    '/assets/html/rodape.php',
                    '/assets/html/cabecalho.php'
                ]);
            })
    )
});
