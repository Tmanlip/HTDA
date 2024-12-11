const body = document.querySelector("body"),
    nav = document.querySelector("nav"),
    modeToggle = document.querySelector(".dark-light"),
    searchToggle = document.querySelector(".searchToggle"),
    sideBarOpen = document.querySelector(".sideBarOpen"),
    sideBarClosed = document.querySelector(".sideBarClosed");

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

    /*tinymce.init({
        selector: '#content, #summary', // Apply editor to both content and summary
        menubar: false,
        plugins: 'bold lists',
        toolbar: 'bold italic underline | bullist numlist | undo redo',
        height: 300,
        branding: false,
    });

    document.querySelector('form').addEventListener('submit', function () {
        tinymce.triggerSave(); // Ensures the editor content is synced with the textarea
    }); */

    tinymce.init({
        selector: 'textarea', // Apply to all textareas
        plugins: 'lists link image charmap preview', // Enable plugins
        toolbar: 'undo redo | bold italic underline | bullist numlist | link', // Include bold and other tools
        menubar: false, // Hide the menu bar
        height: 300,
        forced_root_block: false, // Allows line breaks without wrapping in a paragraph
        branding: false, // Optional: Removes "Powered by TinyMCE" branding
        setup: function (editor) {
            editor.on('change', function () {
                editor.save(); // Save changes to the textarea
            });
        }
    });

    // Sync TinyMCE content to textareas before form submission
    document.querySelector('form').addEventListener('submit', function () {
        tinymce.triggerSave();
    });