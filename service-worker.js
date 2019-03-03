// var dataCacheName = 'my-app-v2';
var CACHE_NAME = 'my-app2';
var urlsToCache = [
  './',
  './index.php',
  './login.php',
  './profile.php',
  './register.php',
  './terms.php',
  './manifest.json',
  './favicon.ico'
];
self.addEventListener('install', function (event) {
  // Perform install steps
  event.waitUntil(
      caches.open(CACHE_NAME)
          .then(function (cache) {
              console.log('Opened cache');
              return cache.addAll(urlsToCache);
          })
  );
});


self.addEventListener('fetch', function (event) {
  event.respondWith(
      caches.match(event.request)
          .then(function (response) {
              return response || fetch(event.request)
                  .then(function (response) {
                      return caches.open(urlsToCache)
                          .then(function (cache) {
                              cache.put(event.request, response.clone());
                              return response;
                          })
                          .catch(function () {

                              return caches.match('./index.html');
                          });
                  });
          })
  );
});
self.addEventListener('activate', function (e) {
  console.log('[ServiceWorker] Activate');
  e.waitUntil(
      caches.keys().then(function (keyList) {
          return Promise.all(keyList.map(function (key) {
              if (key !== CACHE_NAME) {
                  console.log('[ServiceWorker] Removing old cache', key);
                  return caches.delete(key);
              }
          }));
      })
  );
  return self.clients.claim();
});

// self.addEventListener('install', function(e) {
//   console.log('[ServiceWorker] Install');
//   e.waitUntil(
//     caches.open(cacheName).then(function(cache) {
//       console.log('[ServiceWorker] Caching app shell');
//       return cache.addAll(filesToCache);
//     })
//   );
// });

// self.addEventListener('activate', function(e) {
//   console.log('[ServiceWorker] Activate');
//   e.waitUntil(
//     caches.keys().then(function(keyList) {
//       return Promise.all(keyList.map(function(key) {
//         if (key !== cacheName && key !== dataCacheName) {
//           console.log('[ServiceWorker] Removing old cache', key);
//           return caches.delete(key);
//         }
//       }));
//     })
//   );
//   return self.clients.claim();
// });

// self.addEventListener('fetch', function(e) {
//   console.log('[Service Worker] Fetch', e.request.url);
//     /*
//      * The app is asking for app shell files. In this scenario the app uses the
//      * "Cache, falling back to the network" offline strategy:
//      * https://jakearchibald.com/2014/offline-cookbook/#cache-falling-back-to-network
//      */
//     e.respondWith(
//         caches.match(e.request)
//         .then(function(response) {
//           return response || fetch(e.request)
//           .then(function(response) {
//             return caches.open(filesToCache)
//             .then(function(cache) {
//               cache.put(e.request, response.clone());
//               return response;
//             })
//             .catch(function() {
    
//               return caches.match('./index.php');
//             }); 
//           });
//         })
//       );
// });




