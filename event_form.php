<?php
include 'db_submitevent.php' ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event and Scheduling Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-red-900">
    <nav class="bg-yellow-500 p-4 flex justify-between items-center sticky top-0 z-10">
        <div class="text-black font-bold text-xl">TutorXcells</div>
        <div class="flex space-x-4 justify-center flex-grow">
            <a href="#" class="text-black font-semibold">Home</a>
            <a href="#" class="text-black font-semibold">User list</a>
            <a href="#" class="text-black font-semibold">Registration</a>
            <a href="#" class="text-black font-semibold">Setting</a>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
    <div class="bg-gray-700 p-6 rounded-lg">
        <h2 class="text-center text-white font-bold text-2xl mb-4">Event and Scheduling Form</h2>
        <form action="db_submitevent.php" method="POST" class="bg-gray-300 p-4 rounded-lg space-y-4">
            <!-- Event Name -->
            <div>
                <label for="event-name" class="block text-black mb-2">Event Name</label>
                <input 
                    type="text" 
                    name="eventName" 
                    id="event-name" 
                    placeholder="Enter event name" 
                    required 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Date -->
            <div>
                <label for="event-date" class="block text-black mb-2">Date</label>
                <input 
                    type="date" 
                    name="date" 
                    id="event-date" 
                    required 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Time -->
            <div>
                <label for="event-time" class="block text-black mb-2">Time</label>
                <input 
                    type="time" 
                    name="time" 
                    id="event-time" 
                    required 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Location -->
            <div>
                <label for="event-location" class="block text-black mb-2">Location</label>
                <input 
                    type="text" 
                    name="location" 
                    id="event-location" 
                    placeholder="Enter location" 
                    required 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Speaker Information -->
            <div>
                <label for="event-speaker" class="block text-black mb-2">Speaker Information</label>
                <input 
                    type="text" 
                    name="speakerInformation" 
                    id="event-speaker" 
                    placeholder="Enter speaker information" 
                    required 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Description -->
            <div>
                <label for="event-description" class="block text-black mb-2">Description</label>
                <textarea 
                    name="description" 
                    id="event-description" 
                    placeholder="Enter event description" 
                    required 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Category -->
            <div>
                <label for="event-category" class="block text-black mb-2">Category</label>
                <select 
                    name="category" 
                    id="event-category" 
                    class="w-full p-2 rounded border border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="Academic">Academic</option>
                    <option value="Career-related">Career-related</option>
                    <option value="Skill Development">Skill Development</option>
                </select>
            </div>

            <!-- Recurring Event -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="recurringEvent" 
                    id="event-recurring" 
                    value="1" 
                    class="mr-2"
                >
                <label for="event-recurring" class="text-black">Recurring Event</label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300"
            >
                Create Event
            </button>
        </form>
    </div>
</div>

</body>
</html>
