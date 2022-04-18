importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js');
// Initialize Firebase
const firebaseConfig = {
    apiKey: "AIzaSyB74BndX53ECeXAJ-Iv3bXbMK2282s1afY",
    authDomain: "nava-b0a58.firebaseapp.com",
    projectId: "nava-b0a58",
    storageBucket: "nava-b0a58.appspot.com",
    messagingSenderId: "98674578390",
    appId: "1:98674578390:web:56074e1677f031717d8a77",
    measurementId: "G-QR84766WYP"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
    };
    return self.registration.showNotification(notificationTitle, notificationOptions);
});
self.addEventListener('notificationclick', event => {
    console.log(event)
});
