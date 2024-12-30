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
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  // Check if the username and password fields are not empty
  if (username === '' || password === '') {
    alert("Please fill in both username and password fields.");
    return;
  }
      
  // Check in the 'students' and 'lecturers' paths
  const studentRef = ref(db, 'user/Student');
  const lecturerRef = ref(db, 'user/Lecturer');

  const checkCredentials = (userRef, userType) => {
    get(userRef).then((snapshot) => {
      let userFound = false;

      snapshot.forEach((childSnapshot) => {
        const userData = childSnapshot.val();
        if (userData.username === username && userData.password === password) {
          userFound = true;
          alert("Login Successful! Welcome " + userType + "!");
          location.href = "UserDashboard.html"; // Redirect to the user dashboard
        }

        if (userFound == "false") {
          alert("Incorrect username or password. Please try again.");
        }
      });

    }).catch((error) => {
      console.error("Error fetching user data:", error);
      alert("An error occurred. Please try again later.");
    });
};

// Check both student and lecturer references
checkCredentials(studentRef, "Student");
checkCredentials(lecturerRef, "Lecturer");
  
}) 

    

