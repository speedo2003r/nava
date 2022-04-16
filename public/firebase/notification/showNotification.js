$(document).ready(function () {

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
    window.fcmMessageing = messaging;
    messaging.onMessage((payload) => {
        toastr.success(payload.notification.body, payload.notification.title, {timeOut: 10000});
        console.log('Message received. ', payload);
    });

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
            .then((registration) => {
                messaging.useServiceWorker(registration);
                // request notification permission and get token
                console.log('Registration successful, scope is:',
                    registration.scope);
                //TODO: ask For Permission To Receive Notifications
            }).catch(function(err) {
            console.log('Service worker registration failed, error:', err); });
    }
});
