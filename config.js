// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import { getDatabase, ref, set, get, child } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-database.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyDiifxo89o8jbOxunvfwmlTlojG7d-njDk",
  authDomain: "tutorxcell.firebaseapp.com",
  databaseURL: "https://tutorxcell-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "tutorxcell",
  storageBucket: "tutorxcell.appspot.com",
  messagingSenderId: "746081975059",
  appId: "1:746081975059:web:31213eb5696ffb62eeb8e6",
  measurementId: "G-GSKZLLN711"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

//get ref to database services
const db = getDatabase(app);

document.getElementById("submit").addEventListener('click', function(e){
  e.preventDefault();
  set(ref(db, 'user/' + document.getElementById("username").value),
{

  username: document.getElementById("username").value,
  email: document.getElementById("password").value
})

alert("Login Succesfull  !")

})