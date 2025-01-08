document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".search-bar");
    const searchButton = document.querySelector(".search-btn");
    const resourceCards = document.querySelectorAll(".resource-card");
    const categoryButtons = document.querySelectorAll(".category-btn");
  
    // Search functionality
    searchButton.addEventListener("click", () => {
      const query = searchInput.value.toLowerCase();
      resourceCards.forEach(card => {
        const title = card.querySelector("h3").textContent.toLowerCase();
        card.style.display = title.includes(query) ? "block" : "none";
      });
    });
  
    // Filter by category
    categoryButtons.forEach(button => {
      button.addEventListener("click", () => {
        const category = button.textContent.toLowerCase();
        resourceCards.forEach(card => {
          // Assuming resources have a data-category attribute
          const cardCategory = card.getAttribute("data-category").toLowerCase();
          card.style.display = category === "all" || cardCategory === category ? "block" : "none";
        });
      });
    });
  
    // Shared folder interaction (example: alert or open folder view)
    const folderButtons = document.querySelectorAll(".open-folder-btn");
    folderButtons.forEach(button => {
      button.addEventListener("click", () => {
        const folderName = button.previousElementSibling.textContent;
        alert(`Opening folder: ${folderName}`);
        // Replace alert with actual folder navigation logic
      });
    });
  });
  
  // Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.querySelector(".search-bar");
    const resourceCards = document.querySelectorAll(".resource-card");
  
    // Filter resources based on search input
    searchBar.addEventListener("input", () => {
      const keyword = searchBar.value.toLowerCase();
  
      resourceCards.forEach(card => {
        const title = card.querySelector("h3").textContent.toLowerCase();
        const uploader = card.querySelector("p").textContent.toLowerCase();
  
        // Show or hide card based on keyword match
        if (title.includes(keyword) || uploader.includes(keyword)) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  });

  
  