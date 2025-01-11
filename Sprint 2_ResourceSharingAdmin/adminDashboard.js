document.addEventListener("DOMContentLoaded", () => {
    fetchResources();
    fetchDeletedResources();
});

// Fetch current resources from the database
function fetchResources() {
    fetch('fResource.php')
        .then(response => response.json())
        .then(data => {
            const resourceBody = document.getElementById('resource-body');
            resourceBody.innerHTML = ''; // Clear existing data

            data.forEach(doc => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${doc.id}</td>
                    <td>${doc.course_name}</td>
                    <td>${doc.document_name}</td>
                    <td>${doc.file_path}</td>
                    <td>${doc.upload_date}</td>
                    <td><button class="delete-btn" onclick="deleteResource(${doc.id})">Delete</button></td>
                `;
                resourceBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching resources:', error));
}

// Fetch deleted resources
function fetchDeletedResources() {
    fetch('fDeletedResources.php') // Create this PHP file to fetch deleted resources
        .then(response => response.json())
        .then(data => {
            const deletedBody = document.getElementById('deleted-resources-body');
            deletedBody.innerHTML = ''; // Clear existing data

            data.forEach(doc => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${doc.id}</td>
                    <td>${doc.course_name}</td>
                    <td>${doc.document_name}</td>
                    <td>${doc.file_path}</td>
                    <td>${doc.upload_date}</td>
                `;
                deletedBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching deleted resources:', error));
}

// Delete a resource
function deleteResource(id) {
    fetch('deleteResource.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Resource deleted successfully.');
            fetchResources(); // Refresh the resource list
            fetchDeletedResources(); // Refresh the deleted resources list
        } else {
            alert('Error deleting resource.');
        }
    })
    .catch(error => console.error('Error deleting resource:', error));
}