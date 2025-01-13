const body = document.querySelector("body"),
    nav = document.querySelector("nav"),
    modeToggle = document.querySelector(".dark-light"),
    searchToggle = document.querySelector(".searchToggle"),
    sideBarOpen = document.querySelector(".sideBarOpen"),
    sideBarClosed = document.querySelector(".sideBarClosed");

//Js Code for toggle user
const dashToggle = document.querySelector(".home"),
    userToggle = document.querySelector(".home-2"),
    histToggle = document.querySelector(".home-3"),
    reportToggle = document.querySelector(".home-4"),
    firstItems = document.querySelector(".first-items"),
    secondItems = document.querySelector(".second-items"),
    thirdItems = document.querySelector(".third-items");

//Js Code for content
const dashcont = document.querySelector(".one-box-dash"),
    dashcont2 = document.querySelector(".two-box-dash"),
    usrcont = document.querySelector(".one-box-usr"),
    histcont = document.querySelector(".one-box-hist");

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

    async function fetchQuestions() {
        console.log("fetchQuestions called"); // Log that the function is called
    
        try {
            const response = await fetch("fetch_questions.php");
            if (!response.ok) throw new Error("Network response was not ok");
    
            const questions = await response.json();
            console.log("Raw response from fetch_questions.php:", questions);
    
            if (Array.isArray(questions) && questions.length > 0) {
                console.log("Parsed questions:", questions);
                displayQuestions(questions);
            } else {
                console.error("No questions returned or invalid format.");
                alert("No questions to display.");
            }
        } catch (error) {
            console.error("Error fetching questions:", error);
            alert("An error occurred while fetching questions.");
        }
    }
    
// Function to display questions and their replies
async function displayQuestions(questions) {
    const questionsList = document.querySelector("#questions-list");
    if (!questionsList) {
        console.error("Element with ID 'questions-list' not found.");
        return;
    }
    questionsList.innerHTML = ""; // Clear existing questions

    const repliesMap = {}; // Map to store replies for each question

    // First, fetch all replies for the questions
    for (const question of questions) {
        console.log(`Fetching replies for question ID: ${question.id}`);
        const replies = await fetchReplies(question.id); // Fetch replies for each question
        repliesMap[question.id] = replies; // Store replies in the map
    }

    console.log("All replies fetched:", repliesMap); // Log all fetched replies

    // Now render the questions and their replies
    for (const question of questions) {
        console.log(`Rendering question with ID: ${question.id}`);

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
                    <input type="hidden" name="matric_no" value="${question.matric_no}">
                    <button type="submit">Reply</button>
                </form>
            </div>`;
        questionsList.appendChild(listItem);

        const repliesList = document.querySelector(`#replies-${question.id}`);
        const replies = repliesMap[question.id]; // Get the replies from the map

        // Log what is stored in the map for this question ID
        console.log(`Rendering replies for question ${question.id}:`, replies);

        // Check if `replies` is an object and inspect its properties
        if (replies) {
            console.log("Replies object found for question:", replies);

            // Assuming replies is an object that contains a property like `data` that holds the array of replies
            // Update based on your actual data structure
            const replyArray = replies.data || []; // Adjust 'data' if it's different

            console.log("Replies array from object:", replyArray);

            if (Array.isArray(replyArray) && replyArray.length > 0) {
                console.log("Rendering replies:", replyArray);
                replyArray.forEach((reply, index) => {
                    console.log(`Rendering reply ${index + 1}:`, reply);  // Log each reply
                    const replyItem = document.createElement("li");
                    replyItem.textContent = reply.reply_text;  // Ensure this is the correct field
                    repliesList.appendChild(replyItem);
                });
            } else {
                console.log("Replies array is empty or invalid.");
                repliesList.innerHTML = "<li>No replies yet.</li>";
            }
        } else {
            console.log("No replies data for question:", question.id);
            repliesList.innerHTML = "<li>No replies yet.</li>";
        }


        // Attach event listeners to reply forms
        const replyForm = listItem.querySelector(".reply-form");
        replyForm.addEventListener("submit", handleReplySubmission);
    }
}

// Function to fetch replies for a specific question
async function fetchReplies(questionId) {
    console.log(`Fetching replies for question ID: ${questionId}`);

    try {
        // Replace with your actual fetch logic to get replies
        const formData = new FormData();
        formData.append('question_id', questionId);
        
        const response = await fetch('fetch_replies.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error("Network response was not ok");

        const replies = await response.json();
        console.log(`Replies for Question ${questionId}:`, replies);

        return replies; // Return the fetched replies
    } catch (error) {
        console.error(`Error fetching replies for question ${questionId}:`, error);
        return []; // Return an empty array in case of error
    }
}
    
    async function handleReplySubmission(event) {
        event.preventDefault();

        const form = event.target;
        const questionId = form.getAttribute("data-question-id"); // Get the question ID from the data attribute
        const replyContent = form.querySelector("textarea[name='reply_text']").value; // Get the reply text
        const matricNo = form.querySelector("input[name='matric_no']").value; // Get the student matric number from the hidden input field

        // Check if the reply content is empty
        if (!replyContent) {
            alert("Reply content cannot be empty.");
            return;
        }

        // Prepare the data to send in the POST request
        const replyData = {
            question_id: questionId,
            matric_no: matricNo, // Use the dynamic student ID
            reply_text: replyContent,
        };

        try {
            // Send the reply data to the server using fetch
            const response = await fetch("reply.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams(replyData),
            });

            // Parse the response as JSON
            const result = await response.json();

            if (result.status === "success") {
                alert("Reply posted successfully!");
                form.reset(); // Clear the reply form
                fetchReplies(questionId); // Optionally fetch and display updated replies
            } else {
                alert("Failed to post reply: " + result.message);
            }
        } catch (error) {
            console.error("Error submitting reply:", error);
            alert("An error occurred while submitting the reply.");
        }
    }

    
    document.addEventListener("DOMContentLoaded", () => {
        fetchQuestions(); // Load the questions when the page is ready
    });
    

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
