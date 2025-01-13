// Function to handle posting the question
async function postQuestion(title, description, tags, matric_no) {
    const data = { title, description, tags, matric_no };

    try {
        const response = await fetch('post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(data)
        });

        if (response.ok) {
            const result = await response.json();
            if (result.status === "success") {
                alert(result.message); // Success message
                document.getElementById("questionForm").reset(); // Reset form fields
                fetchQuestions(); // Optionally reload the list of questions
            } else {
                alert(result.message); // Server-side error message
            }
        } else {
            alert("Failed to post the question. Please try again.");
        }
    } catch (error) {
        console.error("Error submitting the form:", error);
        alert("An error occurred while posting the question.");
    }
}

// Function to handle form submission via AJAX
async function handleFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission

    // Collect form data
    const title = document.getElementById("question-title").value;
    const description = document.getElementById("question-description").value;
    const tags = document.getElementById("question-tags").value;
    const matric_no = document.querySelector("input[name='matric_no']").value;  // Get matric_no from hidden field

    console.log("Form Data:", { title, description, tags, matric_no }); // Log form data for debugging

    // Call the function to post the question
    if (title && description && tags) {
        postQuestion(title, description, tags, matric_no);
    } else {
        alert("All fields are required!");
    }
}

// Attach the handleFormSubmission function to the form submit event
document.getElementById("questionForm").addEventListener("submit", handleFormSubmission);