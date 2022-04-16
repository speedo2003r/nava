$(document).ready(function (){

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

    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            console.log('Notification permission granted.');
        } else {
            console.log('Unable to get permission to notify.');
        }
    });

    messaging.getToken().then((currentToken) => {
        if (currentToken) {
            console.log(currentToken);
            $('#fcm_token').val(currentToken);
        } else {
            console.log('No Instance ID token available. Request permission to generate one.');
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
    });


    // Callback fired if Instance ID token is updated.
    messaging.onTokenRefresh(() => {
        messaging.getToken().then((refreshedToken) => {
            console.log('Token refreshed.');
        }).catch((err) => {
            console.log('Unable to retrieve refreshed token ', err);
        });
    });

    messaging.onMessage((payload) => {
        toastr.success(payload.data.body, payload.data.title, {timeOut: 10000});
        console.log('Message received. ', payload);
    });

})
