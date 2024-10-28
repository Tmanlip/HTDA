const body = document.querySelector("body"),
    nav = document.querySelector("nav"),
    modeToggle = document.querySelector(".dark-light"),
    searchToggle = document.querySelector(".searchToggle"),
    sideBarOpen = document.querySelector(".sideBarOpen"),
    sideBarClosed = document.querySelector(".sideBarClosed");

//Js Code for toggle user
const dashToggle = document.querySelector(".home"),
    userToggle = document.querySelector(".home-2"),
    acadToggle = document.querySelector(".home-3"),
    firstItems = document.querySelector(".first-items"),
    secondItems = document.querySelector(".second-items"),
    thirdItems = document.querySelector(".third-items");

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
    })

    userToggle.addEventListener("click", ()=>{
        secondItems.classList.toggle("displayed");
        secondItems.classList.toggle("hidden");
        firstItems.classList.add("hidden"); // Hide dashboard items if user is shown
        firstItems.classList.remove("displayed");
        thirdItems.classList.add("hidden"); // Hide user items if dashboard is shown
        thirdItems.classList.remove("displayed");
    })

    acadToggle.addEventListener("click", ()=>{
        thirdItems.classList.toggle("displayed");
        thirdItems.classList.toggle("hidden");
        firstItems.classList.add("hidden"); // Hide dashboard items if user is shown
        firstItems.classList.remove("displayed");
        secondItems.classList.add("hidden"); // Hide user items if dashboard is shown
        secondItems.classList.remove("displayed");
    })

    

