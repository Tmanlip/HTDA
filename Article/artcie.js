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

    /* var input = document.querySelector('tags');

    var predefinedTags = [
        { value: "Cybersecurity" },
        { value: "C++ Languange" },
        { value: "Machine Languange" },
        { value: "Adobe Illustrator" },
        { value: "Iris Scanning" }
    ];

    // Initialize Tagify with predefined tags
        new Tagify(input, {
            whitelist: predefinedTags,      
            enforceWhitelist: false,        
            dropdown: {
                maxItems: 10,               
                enabled: 0,                
                closeOnSelect: false        
            }
        }); */

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Tagify
            const input = document.querySelector('#tags');
            if (input) {
                new Tagify(input, {
                    whitelist: ["Cybersecurity", "C++ Languange", "Machine Languange", "Adobe Illustrator", "Iris Scanning"], // Tag options
                    dropdown: {
                        enabled: 0, // Show dropdown immediately on focus
                        maxItems: 5, // Limit dropdown items
                    }
                });
                console.log("Tagify initialized");
            } 
        
            // Initialize TinyMCE
            tinymce.init({
                selector: '#content, #summary', // Only target <textarea> elements
                plugins: 'lists link image charmap preview', // Plugins
                toolbar: 'undo redo | bold italic underline | bullist numlist | link', // Toolbar options
                menubar: false, // Disable the menu bar
                height: 300, // Set editor height
                forced_root_block: false, // Allow line breaks without wrapping in a paragraph
                branding: false, // Remove branding
                setup: function (editor) {
                    editor.on('init', function () {
                        console.log('TinyMCE initialized on:', editor.id);
                    });
                    editor.on('change', function () {
                        editor.save(); // Save content back to <textarea>
                    });
                }
            });
        });
        
    

    // Sync TinyMCE content to textareas before form submission
    document.querySelector('form').addEventListener('submit', function () {
        tinymce.triggerSave();
    });