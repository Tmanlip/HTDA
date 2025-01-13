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

fetch('fResource.php')
  .then(response => response.json()) // Automatically parses JSON
  .then(data => {
    const resourceList = document.querySelector('#shared-folders');

    // Clear existing content
    resourceList.innerHTML = '';

    if (data && Array.isArray(data) && data.length > 0) {
      data.forEach(doc => {
        const resourceItem = document.createElement('li');
        resourceItem.classList.add('resource-item');
        resourceItem.innerHTML = `
          <h3>${doc.document_name}</h3>
          <p>Course: ${doc.course_name}</p>
          <a href="${doc.file_path}" download="${doc.document_name}" class="download-btn">Download</a>`;
        resourceList.appendChild(resourceItem);
      });
    } else {
      resourceList.innerHTML = '<li>No documents found.</li>';
    }
  })
  .catch(error => {
    console.error('Error fetching documents:', error);
  });

