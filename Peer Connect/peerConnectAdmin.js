document.addEventListener("DOMContentLoaded", () => {
    fetchSessions();
    fetchDeletedSessions();
});

// Fetch current sessions from the database
function fetchSessions() {
    fetch('fetch_sessions.php')
        .then(response => response.json())
        .then(data => {
            const sessionBody = document.getElementById('session-body');
            sessionBody.innerHTML = ''; // Clear existing data

            data.forEach(session => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${session.id}</td>
                    <td>${session.session_name}</td>
                    <td>${session.experience_level}</td>
                    <td>${session.time}</td>
                    <td>${session.location}</td>
                    <td>${session.max_participants}</td>
                    <td>${session.members}</td>
                    <td><button class="delete-btn" onclick="deleteSession(${session.id})">Delete</button></td>
                `;
                sessionBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching sessions:', error));
}

// Fetch deleted sessions
function fetchDeletedSessions() {
    fetch('fDeletedSessions.php')
        .then(response => response.json())
        .then(data => {
            const deletedBody = document.getElementById('deleted-sessions-body');
            deletedBody.innerHTML = ''; // Clear existing data

            data.forEach(session => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${session.id}</td>
                    <td>${session.session_name}</td>
                    <td>${session.experience_level}</td>
                    <td>${session.time}</td>
                    <td>${session.location}</td>
                    <td>${session.max_participants}</td>
                    <td>${session.members}</td>
                `;
                deletedBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching deleted sessions:', error));
}

// Delete a session
function deleteSession(id) {
    
    fetch('deleteSession.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if ( data.success) {
            alert('Session deleted successfully!');
            fetchSessions(); // Refresh the session list
            fetchDeletedSessions(); // Refresh the deleted sessions list
        } else {
            alert('Error deleting session: ' + data.message);
        }
    })
    .catch(error => console.error('Error deleting session:', error));
}