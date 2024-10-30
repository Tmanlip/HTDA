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

const body = document.querySelector("body"),
    nav = document.querySelector("nav"),
    modeToggle = document.querySelector(".dark-light"),
    searchToggle = document.querySelector(".searchToggle"),
    sideBarOpen = document.querySelector(".sideBarOpen"),
    sideBarClosed = document.querySelector(".sideBarClosed");

//Js Code for toggle user
const dashToggle = document.querySelector(".home"),
    userToggle = document.querySelector(".home-2"),
    histToggle = document.querySelector(".home-3"),
    firstItems = document.querySelector(".first-items"),
    secondItems = document.querySelector(".second-items"),
    thirdItems = document.querySelector(".third-items");

//Js Code for content
const dashcont = document.querySelector(".one-box-dash"),
    dashcont2 = document.querySelector(".two-box-dash"),
    usrcont = document.querySelector(".one-box-usr"),
    histcont = document.querySelector(".one-box-hist");

    let getMode = localStorage.getItem("mode") ;
    if (getMode && getMode == "dark-mode"){
        body.classList.add("dark");
    }



    //Js code to toggle dark and light mode
    modeToggle.addEventListener("click", () =>{
        modeToggle.classList.toggle("active");
        body.classList.toggle("dark");

        if(!body.classList.contains("dark")){
            localStorage.setItem("mode", "light-mode");
        }else{
            localStorage.setItem("mode", "dark-mode");
        }
    })

    //Js code to toggle search box
    searchToggle.addEventListener("click", () =>{
        searchToggle.classList.toggle("active");
    })


    //Js code to toggle sidebar
    sideBarOpen.addEventListener("click", () =>{
        nav.classList.add("active");
    })

    body.addEventListener("click", e =>{
        let clickedElm = e.target;

        if (!clickedElm.classList.contains("sideBarOpen") && !clickedElm.classList.contains("menu")){
            nav.classList.remove("active");
        }
    })

    //Js Code to toggle visibility of content
    dashToggle.addEventListener("click", ()=>{
        firstItems.classList.toggle("displayed");
        firstItems.classList.toggle("hidden");    
        secondItems.classList.add("hidden"); // Hide user items if dashboard is shown
        secondItems.classList.remove("displayed");
        thirdItems.classList.add("hidden"); // Hide user items if dashboard is shown
        thirdItems.classList.remove("displayed");

        dashcont.classList.toggle("displayed");
        dashcont.classList.toggle("hidden");   
        dashcont2.classList.toggle("displayed");
        dashcont2.classList.toggle("hidden");    
        usrcont.classList.add("hidden");
        usrcont.classList.remove("displayed");
        histcont.classList.add("hidden");
        histcont.classList.remove("displayed");
    })

    userToggle.addEventListener("click", ()=>{
        secondItems.classList.toggle("displayed");
        secondItems.classList.toggle("hidden");
        firstItems.classList.add("hidden"); // Hide dashboard items if user is shown
        firstItems.classList.remove("displayed");
        thirdItems.classList.add("hidden"); // Hide user items if dashboard is shown
        thirdItems.classList.remove("displayed");

        dashcont.classList.remove("displayed");
        dashcont.classList.add("hidden");   
        dashcont2.classList.remove("displayed");
        dashcont2.classList.add("hidden");    
        usrcont.classList.toggle("hidden");
        usrcont.classList.toggle("displayed");
        histcont.classList.add("hidden");
        histcont.classList.remove("displayed");
    })

    histToggle.addEventListener("click", ()=>{
        thirdItems.classList.toggle("displayed");
        thirdItems.classList.toggle("hidden");
        firstItems.classList.add("hidden"); // Hide dashboard items if user is shown
        firstItems.classList.remove("displayed");
        secondItems.classList.add("hidden"); // Hide user items if dashboard is shown
        secondItems.classList.remove("displayed");

        dashcont.classList.remove("displayed");
        dashcont.classList.add("hidden");   
        dashcont2.classList.remove("displayed");
        dashcont2.classList.add("hidden");    
        usrcont.classList.add("hidden");
        usrcont.classList.remove("displayed");
        histcont.classList.toggle("hidden");
        histcont.classList.toggle("displayed");
    })

    function login() {
        const email = document.getElementById('email').value;
        const studentEmail = 'student@example.com';  // Dummy student email
        const lecturerEmail = 'lecturer@example.com'; // Dummy lecturer email
        const errorMsg = document.getElementById('errorMsg');

        // Clear previous error message
        errorMsg.textContent = '';

        // Hide both dashboards initially
        document.getElementById('studentDashboard').classList.remove('active');
        document.getElementById('lecturerDashboard').classList.remove('active');

        if (email === studentEmail) {
            // Show student dashboard
            document.getElementById('.studentDashboard').classList.add('active');
        } else if (email === lecturerEmail) {
            // Show lecturer dashboard
            document.getElementById('.lecturerDashboard').classList.add('active');
        } else {
            // Show error message if email doesn't match
            errorMsg.textContent = 'Invalid email. Please enter a valid email.';
        }
    }
