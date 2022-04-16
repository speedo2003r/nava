$(document).ready(function (){

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
