<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Legs</title>
    <link rel="stylesheet" href="Nonmemberstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for better scrollbar on smaller screens and non-safari browsers */
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5); /* gray-400 with opacity */
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        /* Hide scrollbar for Safari and other browsers that don't support the webkit vendor prefix */
        .no-scrollbar-safari {
            /* For Firefox */
            scrollbar-width: none;
            -ms-overflow-style: none; /* For IE and Edge */
        }

        /* Ensure the main content takes the full available width */
        .main.content {
            width: 100%;
        }

        /* * 🔥 DESKTOP/LARGE SCREEN STYLES (CENTERED AND MAXIMIZED)
         * - This is the default style
         */
        @media (min-width: 1024px) {
            /* 1. Center the flex container (Row layout) */
            .centered-cards-desktop {
                justify-content: center;
                /* Reset mobile vertical behavior */
                flex-direction: row; 
                overflow-x: auto; /* Enable horizontal scroll if needed */
            }

            /* 2. Increase card size for maximization */
            .full-width-cards > a {
                /* Set a very large fixed width to ensure they dominate the screen */
                min-width: 480px; 
            }
            
            /* Override the mobile style that removes scroll padding */
            .full-width-cards {
                /* Restore horizontal spacing */
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
                /* Reset scroll snapping from original mobile configuration */
                snap-x: none;
                snap-mandatory: none;
            }
            .full-width-cards > a {
                /* Restore horizontal margin between cards */
                margin-left: 0;
                margin-right: 1.5rem; /* Space after the card */
            }
            .full-width-cards > a:last-child {
                margin-right: 0; /* No space after the last card */
            }
        }
        
        /* * 🔥 MOBILE STYLES (Vertical Stack and Full Width)
         */
        @media (max-width: 1023px) {
            /* Adjust padding for mobile screens */
            .main.content {
                padding: 1.5rem;
                margin-left: 0; 
            }
            
            /* 🛑 KEY CHANGE: Switch to vertical stacking (column) */
            .full-width-cards {
                /* Change flex direction to column */
                flex-direction: column; 
                /* Remove horizontal scroll and snapping */
                overflow-x: hidden; 
                snap-x: none;
                snap-mandatory: none;
                /* Use vertical scroll naturally with the column layout */
                flex-wrap: nowrap;
                /* Remove scroll padding and margin as it's not needed for a vertical list */
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
                scroll-padding-left: 0 !important;
                scroll-padding-right: 0 !important;
                /* Ensure the container uses the full width for stacking */
                width: 100%;
            }

            .full-width-cards > a {
                /* Make the card use full available width inside its padded container */
                width: 100%;
                min-width: unset; 
                /* Add vertical margin between stacked cards */
                margin-bottom: 1rem; 
                /* Ensure no horizontal margin remains */
                margin-left: 0;
                margin-right: 0;
                /* Remove snap behavior from anchors */
                snap-start: none;
            }
            
            /* Adjust padding inside the main content for better look in vertical layout */
            .main.content {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="sidebar">
    <h2>Non Member Panel</h2>
    <ul>
        <li><a href="#" class="bg-gray-700 text-white"><i class='bx bx-dumbbell'></i> Workouts</a></li>
        <li><a href="Register.php"><i class='bx bxs-user-badge'></i> Membership</a></li>
        <li><a href="Loginpage.php"><i class='bx bx-log-out'></i> Logout</a></li>
    </ul>

</div>


<div class="main content w-full p-8 md:p-10 lg:p-12">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 select-none border-b pb-3">Body Focus </h2>

    <div class="mb-8 flex space-x-4 overflow-x-auto scrollbar-thin no-scrollbar-safari justify-center">

        <button class="flex-shrink-0 px-6 py-2 text-base font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors focus:outline-none" type="button" onclick="window.location.href= 'Nonmember.php'">Abs</button>

        <button class="flex-shrink-0 px-6 py-2 text-base font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors focus:outline-none" type="button" onclick="window.location.href='Arm.php'">Arm</button>

        <button class="flex-shrink-0 px-6 py-2 text-base font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors focus:outline-none" type="button" onclick="window.location.href='Chest.php'">Chest</button>

        <button class="flex-shrink-0 px-6 py-2 text-base font-bold rounded-full text-white bg-blue-600 shadow-lg shadow-blue-500/50 hover:bg-blue-700 transition-colors focus:outline-none" aria-current="true">Leg</button> 

        <button class="flex-shrink-0 px-6 py-2 text-base font-medium rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors focus:outline-none" type="button" onclick="window.location.href='Fullbody.php'">Full body</button>

    </div>

    <div
        class="flex flex-col lg:flex-row space-x-6 pb-4 full-width-cards centered-cards-desktop"
    >

        <a href="Leg-beginner.php" class="no-underline snap-start">
            <div class="min-w-[380px] flex-shrink-0 bg-white rounded-2xl p-4 shadow-2xl hover:ring-4 hover:ring-blue-600 transition-all duration-200 cursor-pointer select-none">
                <div class="relative mb-4">
                    <img
                        src="https://shop.bodybuilding.com/cdn/shop/articles/leg-workouts-for-men-get-thicker-quads-glutes-and-hams-986493.jpg?v=1737673309&width=1080"
                        alt="Legs Beginner"
                        class="w-full h-40 rounded-xl object-cover"
                        loading="lazy"
                    />
                    <span class="absolute top-2 left-2 bg-blue-600 text-white text-md font-extrabold px-3 py-1.5 rounded-full shadow-lg">
                          BEGINNER
                    </span>
                </div>
                <h3 class="font-black text-2xl text-gray-900 leading-tight mb-2">LEG FOUNDATION</h3>
                <p class="text-gray-600 mt-1 text-base">Focus on basic compound lifts and lower body stability.</p>
                
                <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-gray-200">
                    <div class="text-base">
                        <p class="font-bold text-gray-800">⏱️ <span class="text-lg">45 - 50</span> mins</p>
                        <p class="font-semibold text-gray-500">🏋️ 5 Exercises</p>
                    </div>
                    <div class="flex space-x-1 items-center">
                        <span class="text-sm font-bold text-gray-700">Difficulty:</span>
                        <i class='bx bxs-circle text-blue-500 text-xs'></i>
                        <i class='bx bx-circle text-gray-300 text-xs'></i>
                        <i class='bx bx-circle text-gray-300 text-xs'></i>
                    </div>
                </div>
            </div>
        </a>


        <a href="Leg-intermediate.php" class="no-underline snap-start">
            <div class="min-w-[380px] flex-shrink-0 bg-white rounded-2xl p-4 shadow-2xl hover:ring-4 hover:ring-blue-600 transition-all duration-200 cursor-pointer select-none">
                <div class="relative mb-4">
                    <img
                        src="https://i0.wp.com/www.strengthlog.com/wp-content/uploads/2023/09/legs-and-shoulders-workout-scaled.jpg?resize=2048%2C1367&ssl=1"
                        alt="Legs Intermediate"
                        class="w-full h-40 rounded-xl object-cover"
                        loading="lazy"
                    />
                    <span class="absolute top-2 left-2 bg-yellow-500 text-white text-md font-extrabold px-3 py-1.5 rounded-full shadow-lg">
                          INTERMEDIATE
                    </span>
                </div>
                <h3 class="font-black text-2xl text-gray-900 leading-tight mb-2">LOWER POWER UP</h3>
                <p class="text-gray-600 mt-1 text-base">Increased volume, intensity, and focus on muscle separation (quads/hams).</p>
                
                <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-gray-200">
                    <div class="text-base">
                        <p class="font-bold text-gray-800">⏱️ <span class="text-lg">60</span> mins</p>
                        <p class="font-semibold text-gray-500">🏋️ 7 Exercises</p>
                    </div>
                    <div class="flex space-x-1 items-center">
                        <span class="text-sm font-bold text-gray-700">Difficulty:</span>
                        <i class='bx bxs-circle text-blue-500 text-xs'></i>
                        <i class='bx bxs-circle text-blue-500 text-xs'></i>
                        <i class='bx bx-circle text-gray-300 text-xs'></i>
                    </div>
                </div>
            </div>
        </a>


        <a href="Leg-advanced.php" class="no-underline snap-start">
            <div class="min-w-[380px] flex-shrink-0 bg-white rounded-2xl p-4 shadow-2xl hover:ring-4 hover:ring-blue-600 transition-all duration-200 cursor-pointer select-none">
                <div class="relative mb-4">
                    <img
                        src="https://www.mensfitness.com/.image/w_750,q_auto:good,c_fill,ar_4:3/MjEyNzY1MDI4MzU5NjExOTEz/bodybuilder-doing-a-seated-leg-press-exercise-in-a-gym.jpg"
                        alt="Legs Advanced"
                        class="w-full h-40 rounded-xl object-cover"
                        loading="lazy"
                    />
                    <span class="absolute top-2 left-2 bg-red-600 text-white text-md font-extrabold px-3 py-1.5 rounded-full shadow-lg">
                          ADVANCED
                    </span>
                </div>
                <h3 class="font-black text-2xl text-gray-900 leading-tight mb-2">ELITE LEG SHREDDER</h3>
                <p class="text-gray-600 mt-1 text-base">High-frequency, heavy lifting combined with deep isolation techniques.</p>
                
                <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-gray-200">
                    <div class="text-base">
                        <p class="font-bold text-gray-800">⏱️ <span class="text-lg">75 - 90</span> mins</p>
                        <p class="font-semibold text-gray-500">🏋️ 7 Exercises</p>
                    </div>
                    <div class="flex space-x-1 items-center">
                        <span class="text-sm font-bold text-gray-700">Difficulty:</span>
                        <i class='bx bxs-circle text-blue-500 text-xs'></i>
                        <i class='bx bxs-circle text-blue-500 text-xs'></i>
                        <i class='bx bxs-circle text-blue-500 text-xs'></i>
                    </div>
                </div>
            </div>
        </a>


    </div>
    </div>
</body>
</html>