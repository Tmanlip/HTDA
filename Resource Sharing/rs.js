document.addEventListener('DOMContentLoaded', () => {
  // Initial load of resources
  loadResources();

  // Search functionality
  const searchBar = document.querySelector(".search-bar");
  searchBar.addEventListener("input", () => {
    const keyword = searchBar.value.toLowerCase();
    filterResources(keyword);
  });
});

// Function to load resources
function loadResources() {
  console.log('Fetching resources...');
  fetch('fResource.php')
    .then(response => response.json())
    .then(data => {
      const resourceList = document.querySelector('#shared-folders');
      resourceList.innerHTML = ''; // Clear existing content

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
}

// Function to filter resources
function filterResources(keyword) {
  const resourceItems = document.querySelectorAll('.resource-item');
  
  resourceItems.forEach(item => {
    const title = item.querySelector('h3').textContent.toLowerCase();
    const course = item.querySelector('p').textContent.toLowerCase();
    
    if (title.includes(keyword) || course.includes(keyword)) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });

  // Show "No results found" message if all items are hidden
  const visibleItems = Array.from(resourceItems).filter(item => item.style.display !== 'none');
  const resourceList = document.querySelector('#shared-folders');
  
  if (visibleItems.length === 0 && keyword !== '') {
    const noResults = document.createElement('li');
    noResults.classList.add('no-results');
    noResults.textContent = 'No matching resources found.';
    resourceList.appendChild(noResults);
  } else {
    const noResultsMsg = resourceList.querySelector('.no-results');
    if (noResultsMsg) {
      noResultsMsg.remove();
    }
  }
}

// Add category filter functionality
document.querySelectorAll('.category-btn').forEach(button => {
  button.addEventListener('click', () => {
    const category = button.textContent;
    const resourceItems = document.querySelectorAll('.resource-item');
    
    resourceItems.forEach(item => {
      const course = item.querySelector('p').textContent;
      if (category === 'All' || course.includes(category)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });
});