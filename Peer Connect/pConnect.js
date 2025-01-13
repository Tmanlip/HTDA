document.addEventListener('DOMContentLoaded', () => {
    const createSessionForm = document.getElementById('create-session-form');
    const sessionsList = document.getElementById('sessions-list');
    const searchSessionInput = document.getElementById('search-session-input'); // Link to the search input
    const searchButton = document.getElementById('search-button'); // Link to the search button

    // Handle form submission for creating study sessions
    createSessionForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const sessionDetails = {
            session_name: document.getElementById('session_name').value.trim(),
            experience_level: document.getElementById('experience_level').value.trim(),
            time: document.getElementById('time').value.trim(),
            location: document.getElementById('location').value.trim(),
            members: parseInt(document.getElementById('members').value.trim()),
            max_participants: parseInt(document.getElementById('max_participants').value.trim()) // Ensure this value is submitted

        };

        fetch('submit_sessions.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(sessionDetails),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySessions(data.sessions);
            } else {
                alert('Error creating session. Please try again.');
            }
        });
    });

    // Display available study sessions
function displaySessions(sessions) {
    // Clear the session list
    sessionsList.innerHTML = '';

    // Loop through each session and render its details
    sessions.forEach(session => {
        const li = document.createElement('li');

        // Create session HTML
        li.innerHTML = `
            <h3>${session.session_name}</h3>
            <p><strong>Time:</strong> ${session.time}</p>
            <p><strong>Location:</strong> ${session.location}</p>
            <p><strong>Experience:</strong> ${session.experience_level}</p>
            <p><strong>Participants:</strong> ${session.members}/${session.max_participants}</p>
            ${session.members < session.max_participants 
                ? `<button class="join-btn" data-session-id="${session.id}">Join</button>` 
                : '<span>Full</span>'}
            <button class="delete-btn" data-session-id="${session.id}">Delete</button>
        `;

        // Add event listener for the join button (if it exists)
        const joinButton = li.querySelector('.join-btn');
        if (joinButton) {
            joinButton.addEventListener('click', () => joinSession(session.id));
        }

        // Add event listener for the delete button
        const deleteButton = li.querySelector('.delete-btn');
        deleteButton.addEventListener('click', () => deleteSession(session.id));

        // Append the session item to the list
        sessionsList.appendChild(li);
    });
}


     // Handle session search
     searchButton.addEventListener('click', () => {
        const searchQuery = searchSessionInput.value.toLowerCase();
        fetch('fetch_sessions.php')
            .then(response => response.json())
            .then(sessions => {
                const filteredSessions = sessions.filter(session =>
                    session.session_name.toLowerCase().includes(searchQuery) ||
                    session.location.toLowerCase().includes(searchQuery) ||
                    session.time.toLowerCase().includes(searchQuery)
                );
                displaySessions(filteredSessions);
            });
     

    

     // Add this inside your DOMContentLoaded event listener
     function joinSession(sessionId) {
        fetch('join-session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ session_id: sessionId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Successfully joined the session!');
                // Refresh the sessions list
                location.reload();
            } else {
                alert(data.message || 'Error joining session');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to join session');
        });
    }
    
});

});
