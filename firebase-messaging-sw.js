// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts("https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js");

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyDSFWFu-rRkxcJZ7-JosSoVoBA1S1uYc-I",
    authDomain: "asclepio-f7668.firebaseapp.com",
    projectId: "asclepio-f7668",
    storageBucket: "asclepio-f7668.appspot.com",
    messagingSenderId: "292416050558",
    appId: "1:292416050558:web:3888c0b4337d23e0c50f2f",
    measurementId: "G-DMLJ2W34J8"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
// messaging.onBackgroundMessage((payload) => {
//     const noteTitle = payload.notification.title;
//     const noteOptions = {
//         body: payload.notification.body,
//         icon: payload.notification.icon,
//     };
//     self.registration.showNotification(noteTitle, noteOptions);
//     document.getElementById('alert-sound').play();
//     if (payload.data.type == "messenger") {}
// });