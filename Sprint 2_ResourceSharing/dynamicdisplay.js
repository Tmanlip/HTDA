fetch('fResource.php')
  .then(response => response.json()) // Automatically parses JSON
  .then(data => {
    const resourceList = document.querySelector('#shared-folders');

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
