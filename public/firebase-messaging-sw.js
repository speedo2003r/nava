importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js');
// Initialize Firebase
const firebaseConfig = {
    apiKey: "AIzaSyDn57H3eeVrxSD08vwYccMlADb0Vv9gs0E",
    authDomain: "greep-148ec.firebaseapp.com",
    databaseURL: "https://greep-148ec-default-rtdb.europe-west1.firebasedatabase.app",
    projectId: "greep-148ec",
    storageBucket: "greep-148ec.appspot.com",
    messagingSenderId: "688067032294",
    appId: "1:688067032294:web:e2fe8ff187e881d78f7727",
    measurementId: "G-Y7Y2ERWRJG"
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
