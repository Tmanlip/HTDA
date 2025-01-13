// Initialize event listeners when the page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Dashboard initializing...');
    fetchResources();
    fetchDeletedResources();
});

function fetchResources() {
    console.log('Fetching resources...');
    
    fetch('fResource.php')
        .then(response => {
            console.log('Response status:', response.status);
            // Check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();  // Get the raw text first
        })
        .then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);  // Try to parse it as JSON
            } catch (e) {
                console.error('JSON parse error:', e);
                throw new Error('Invalid JSON response from server');
            }
        })
        .then(data => {
            console.log('Parsed data:', data);
            const resourceBody = document.getElementById('resource-body');
            
            if (!resourceBody) {
                console.error('Resource body element not found');
                return;
            }

            // Clear existing content
            resourceBody.innerHTML = '';

            // Check if we got an error response
            if (data.error) {
                throw new Error(data.message || 'Server error occurred');
            }

            // Check if we have data and it's an array
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(doc => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${doc.id || ''}</td>
                        <td>${doc.course_name || ''}</td>
                        <td>${doc.document_name || ''}</td>
                        <td>${doc.file_path || ''}</td>
                        <td>${doc.upload_date || ''}</td>
                        <td>
                            <button type="button" 
                                    class="delete-btn" 
                                    data-id="${doc.id}"
                                    style="background-color: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                Delete
                            </button>
                        </td>
                    `;
                    resourceBody.appendChild(row);
                });

                // Add event listeners to delete buttons
                addDeleteEventListeners();
            } else {
                resourceBody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No resources found</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const resourceBody = document.getElementById('resource-body');
            if (resourceBody) {
                resourceBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; color: red;">
                            Error loading resources: ${error.message}
                        </td>
                    </tr>
                `;
            }
        });
}

function addDeleteEventListeners() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            console.log('Delete button clicked, ID:', id);

            if (id) {
                deleteResource(id);
            }
        });
    });
}

function deleteResource(id) {
    if (!confirm('Are you sure you want to delete this resource?')) {
        return;
    }

    console.log('Attempting to delete resource:', id);

    fetch('deleteResource.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: parseInt(id)
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Resource deleted successfully');
            fetchResources();
            fetchDeletedResources();
        } else {
            throw new Error(data.error || 'Failed to delete resource');
        }
    })
    .catch(error => {
        console.error('Error deleting resource:', error);
        alert('Error deleting resource: ' + error.message);
    });
}

function fetchDeletedResources() {
    fetch('fDeletedResources.php')
        .then(response => response.json())
        .then(data => {
            const deletedBody = document.getElementById('deleted-resources-body');
            if (deletedBody) {
                deletedBody.innerHTML = '';
                
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(doc => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${doc.id || ''}</td>
                            <td>${doc.course_name || ''}</td>
                            <td>${doc.document_name || ''}</td>
                            <td>${doc.file_path || ''}</td>
                            <td>${doc.upload_date || ''}</td>
                        `;
                        deletedBody.appendChild(row);
                    });
                } else {
                    deletedBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No deleted resources found</td></tr>';
                }
            }
        })
        .catch(error => {
            console.error('Error fetching deleted resources:', error);
            const deletedBody = document.getElementById('deleted-resources-body');
            if (deletedBody) {
                deletedBody.innerHTML = `
                    <tr>
                        <td colspan="5" style="text-align: center; color: red;">
                            Error loading deleted resources: ${error.message}
                        </td>
                    </tr>
                `;
            }
        });
}