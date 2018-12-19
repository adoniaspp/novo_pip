if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker
            .register('/serviceWorker.js', {
                scope: '/'
            })
            .then(function() {
                console.log('Service Worker Registered');
            });
    });
}
