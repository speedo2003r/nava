$(document).ready(function () {

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
