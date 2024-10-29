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

    

