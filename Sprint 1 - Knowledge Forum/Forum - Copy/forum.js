

// Function to handle form submission via AJAX
async function handleFormSubmission() {
    const form = document.querySelector(".question-form form");
    form.addEventListener("submit", async (event) => {
        event.preventDefault(); // Prevent the default form submission

        // Collect form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        console.log("Form Data:", data); // Log form data

        try {
            // Send data to post.php via AJAX
            const response = await fetch('post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(data)
            });

             // Check if the response is okay
             if (!response.ok) {
                console.error("Network response was not ok", response.statusText);
                alert("Failed to post the question. Please try again.");
                return;
            }

            const result = await response.json();

            if (result.status === "success") {
                alert(result.message); // Show success message
                form.reset(); // Clear the form
                fetchQuestions(); // Refresh the questions list
            } else {
                alert(result.message); // Show error message
                console.error("Server error:", result.message);

            }
        } catch (error) {
            console.error("Error submitting the form:", error);
            alert("An error occurred while posting the question.");
        }
    });
}

async function handleReplySubmission(event) {
    event.preventDefault();

    const form = event.target;
    const questionId = form.getAttribute("data-question-id");
    const replyContent = form.querySelector("textarea[name='reply_text']").value;

    if (!replyContent) {
        alert("Reply content cannot be empty.");
        return;
    }

    const replyData = {
        question_id: questionId,
        user_id: 1, // Hardcode for now; replace with dynamic user ID
        content: replyContent,
    };

    try {
        const response = await fetch("reply.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams(replyData),
        });

        const result = await response.json();

        if (result.status === "success") {
            alert("Reply posted successfully!");
            form.reset(); // Clear the reply form
            fetchReplies(questionId); // Fetch and display updated replies
        } else {
            alert("Failed to post reply: " + result.message);        }
    } catch (error) {
        console.error("Error submitting reply:", error);
        alert("An error occurred while submitting the reply.");
    }
}


// Function to fetch and display questions
async function fetchQuestions() {
    console.log("fetchQuestions called"); // Log that the function is called

    try {
        const response = await fetch("fetch_questions.php");
        if (!response.ok) throw new Error("Network response was not ok");

        const questions = await response.json();
        console.log("Raw response from fetch.php:", questions);

        if (Array.isArray(questions)) {
            console.log("Parsed questions:", questions);
            displayQuestions(questions);
        } else {
            throw new Error("Invalid response format");
        }
    } catch (error) {
        console.error("Error fetching questions:", error);
    }
}

// Function to display questions and their replies
function displayQuestions(questions) {
    const questionsList = document.querySelector("#questions-list");
    if (!questionsList) {
        console.error("Element with ID 'questions-list' not found in HTML.");
        return;
    }
    questionsList.innerHTML = ""; // Clear existing questions
    
    questions.forEach((question) => {
        console.log(question.id);
        const listItem = document.createElement("li");
        listItem.innerHTML = `
            <h3>${question.title}</h3>
            <p>${question.description}</p>
            <small>Tags: ${question.tags}</small>
            <div class="replies">
                <ul id="replies-${question.id}">
                    <!-- Replies will be dynamically loaded here -->
                </ul>
                <form class="reply-form" data-question-id="${question.id}">
                    <textarea name="reply_text" placeholder="Write a reply..." required></textarea>
                    <button type="submit">Reply</button>
                </form>


            </div>

        `;
        questionsList.appendChild(listItem);

        // Load replies for this question
        fetchReplies(question.id);
   

    // Attach event listeners to reply forms
    const replyForm = listItem.querySelector(".reply-form");
        replyForm.addEventListener("submit", (event) => {
            event.preventDefault();
            postReply(replyForm);
    });

});
}

document.addEventListener("DOMContentLoaded", () => {
    fetchQuestions(); // Load the questions
    handleFormSubmission(); // Set up form submission handling
});

async function postQuestion() {
    const title = document.getElementById("question-title").value;
    const description = document.getElementById("question-description").value;
    const tags = document.getElementById("question-tags").value;

    if (title && description && tags) {
        try {
            const response = await fetch('post.php', {  // PHP script to handle question posting
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title, description, tags })
            });

            if (response.ok) {
                alert("Question posted successfully!");
                fetchQuestions(); // Reload questions to show the newly added one
                document.getElementById("question-title").value = "";
                document.getElementById("question-description").value = "";
                document.getElementById("question-tags").value = "";
            } else {
                alert("Error posting the question.");
            }
        } catch (error) {
            console.error('Error posting question:', error);
        }
    } else {
        alert("All fields are required!");
    }
}

async function fetchReplies(questionId) {
    try {
        const response = await fetch(`fetch_replies.php?question_id=${questionId}`);
        const replies = await response.json();

        console.log(`Replies for Question ${questionId}:`, replies);

        const repliesList = document.querySelector(`#replies-${questionId}`);
        if (repliesList) {

        repliesList.innerHTML = ""; // Clear existing replies

        replies.forEach((reply) => {
            const replyItem = document.createElement("li");
            replyItem.textContent = reply.reply_text;
            repliesList.appendChild(replyItem);
        });
     } 

            
    } catch (error) {
        console.error("Error fetching replies:", error);
    }
}

async function postReply(form) {
    const formData = new FormData(form);
    const questionId = form.dataset.questionId;

    if (!questionId) {
        console.error("Question ID is missing in the form dataset.");
        alert("Failed to post reply: Missing question ID.");
        return;
    }

    formData.append("question_id", questionId);
    formData.append("user_id", 1); // Replace with dynamic user ID

    console.log("Posting reply with data:", Object.fromEntries(formData.entries())); // Log the form data


    try {
        const response = await fetch("reply.php", {
            method: "POST",
            body: formData,
        });

        const result = await response.json();
        if (result.status === "success") {
            alert(result.message);
            form.reset(); // Clear the reply form
            fetchReplies(questionId); // Refresh replies
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error("Error posting reply:", error);
    }
}

function searchQuestions() {
    const searchQuery = document.getElementById("search-input").value.toLowerCase();

    fetch('fetch_questions.php')
        .then(response => response.json())
        .then(data => {
            const filteredQuestions = data.filter(question => 
                question.title.toLowerCase().includes(searchQuery) ||
                question.description.toLowerCase().includes(searchQuery) ||
                question.tags.toLowerCase().includes(searchQuery)
            );
            displayQuestions(filteredQuestions);
        })
        .catch(error => console.error('Error fetching questions:', error));
}


