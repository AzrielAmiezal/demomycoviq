// self.addEventListener("install", e => {
//   e.waitUntil(
//     caches.open("static").then(cache => {
//       return cache.addAll(["./", "./css/sb-admin-2.min.css", "logo192.png"]);
//     })
//   );
// });

// self.addEventListener("fetch", e => {
//   // console.log(`Intercepting fetch request for: ${e.request.url}`);
//   e.respondWith(
//     caches.match(e.request).then(response => {
//       return response || fetch(e.request);
//     })
//   );
// });

importScripts(
  'https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js'
);

workbox.routing.registerRoute(
  ({ request }) => request.destination === 'image',
  new workbox.strategies.NetworkFirst()
);
