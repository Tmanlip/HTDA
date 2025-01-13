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

