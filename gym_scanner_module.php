<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Equipment AR Scanner</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* --- START OF CUSTOM SIDEBAR CSS --- */
        .app-container {
            display: flex; /* Enable flex layout for sidebar and main content */
            min-height: 100vh;
            background-color: #f3f4f6; /* bg-gray-100 */
        }

        .sidebar {
            width: 250px;
            background-color: #242424;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.6);
            flex-shrink: 0;
            transition: width 0.3s ease;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #e0e0e0; /* Default text color */
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar li a:hover {
            background-color: #3a3a3a;
            color: #e0e0e0;
        }

        .sidebar li i {
            margin-right: 12px;
            font-size: 22px;
            color: #e0e0e0; /* ICONS: Default light color */
            transition: color 0.3s;
        }
        
        /* Change icon color on hover */
        .sidebar li a:hover i {
            color: #ffcc00; /* Icon turns yellow on hover */
        }
        
        .submenu {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #2e2e2e;
            overflow: hidden;
            max-height: 0; 
            transition: max-height 0.3s ease-in-out; /* Changed to 0.3s for smooth toggle */
        }

        .submenu li a {
            padding-left: 50px;
            font-size: 0.95em;
        }
        
        .toggle-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        /* Highlight for current page */
        .sidebar .more-menu .submenu li .active-link {
            color: #ffcc00; 
            font-weight: bold;
            background-color: #3a3a3a;
        }


        /* --- EXISTING CSS RETAINED AND MODIFIED --- */
        #webcam-container {
            position: relative;
            width: 100%;
            /* MODIFIED: Increased max-width for bigger camera */
            max-width: 800px; 
            margin: auto;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            /* MODIFIED: Aspect ratio updated to 800 / 600 */
            aspect-ratio: 800 / 600; 
        }
        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }
        #label-container div {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        /* --- END OF EXISTING CSS --- */
    </style>
</head>
<body class="font-sans">

    <div class="app-container">
        
        <div class="sidebar">
            <ul>
                <li><a href="Membership.php">
                    <i class='bx bx-user'></i> 
                    <span>User Details</span>
                </a></li>
                <li><a href="WorkoutJournal.php">
                    <i class='bx bx-notepad'></i> 
                    <span>Workout Journal</span>
                </a></li>
                <li><a href="Progress.php">
                    <i class='bx bx-line-chart'></i>
                    <span>Progress</span>
                </a></li>
                <li><a href="TrainerBooking.php">
                    <i class='bx bxs-user-pin'></i> 
                    <span>Trainers</span>
                </a></li>
                
                <li class="more-menu">
                    <a href="#" class="more-toggle">
                        <span>More</span> 
                        <i class='bx bx-chevron-down toggle-icon'></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="#" class="active-link">
                            <i class='bx bx-scan'></i> 
                            <span>Calorie Scanner</span>
                        </a></li>
                        <li><a href="ScanEquipment.php">
                            <i class='bx bx-qr-scan'></i> 
                            <span>Scan Equipment</span>
                        </a></li>
                    </ul>
                </li>
                <li><a href="Loginpage.php">
                    <i class='bx bx-log-out'></i> 
                    <span>Logout</span>
                </a></li>
            </ul>
        </div>
        <div class="flex-grow p-4 flex flex-col items-center">
            <div class="w-full max-w-3xl bg-white p-6 md:p-8 rounded-2xl shadow-xl">
                <h1 class="text-3xl font-bold text-black text-center mb-2">Equipment Recognition Scanner</h1>
                
                <div id="webcam-container" class="mb-6">
                    <div id="webcam" class="w-full rounded-xl"></div>
                </div>

                <div id="status-message" class="text-center p-3 mb-4 rounded-lg bg-yellow-100 text-yellow-700 font-semibold">
                    Loading model and setting up webcam...
                </div>
                
                <div id="ar-info" class="p-4 bg-indigo border border-indigo rounded-lg text-black hidden">
                    <h2 class="font-bold text-xl mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Equipment Details & Instructions
                    </h2>
                    
                    <p class="mb-1"><strong>Detected Class:</strong> <span id="detected-item-name"></span></p>
                    
                    <p class="mb-2 text-xl font-bold">Equipment Name: <span id="equipment-display-name"></span></p>
                    
                    <p class="font-medium text-lg text-black">Recommended Exercise: <span id="recommended-exercise" class="font-extrabold"></span></p>
                    
                    <p class="text-sm mt-3 font-semibold border-t pt-2 border-black">Execution Instructions:</p>
                    <ul class="list-disc list-inside mt-2 space-y-1 text-sm">
                    </ul>
                </div>

                <div id="label-container" class="mt-4">
                </div>

                <button id="start-button" onclick="init()" disabled
                    class="w-full py-3 mt-6 bg-black text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition duration-300 disabled:opacity-50">
                    Start Recognition
                </button>
            </div>
        </div>
    </div> <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script> 

    <script>
        // --- CONFIGURATION ONLY ONE LINK CAN WORK BUT YOU CAN MAKE 20 EQUIPMENTS IN ONE LINK CUZ ITS CLOUD---
        const MODEL_URL = "https://teachablemachine.withgoogle.com/models/IyyvLoaFo/"; 
        const MAX_PREDICTIONS = 3; 
        const MIN_CONFIDENCE_THRESHOLD = 0.85; // 85% confidence required for AR activation

        // --- EQUIPMENT AND EXERCISE MAPPING ---
        const EXERCISE_MAPPING = {
            "red-dumbell-2kg": {
                displayName: "Red Dumbbell 2kg",
                recommendedExercise: "Biceps Curl",
                instructions: [
                    "Stand tall, chest up, and shoulders back.",
                    "Keep your elbows close to your torso.",
                    "Curl the weights while contracting your biceps.",
                    "Focus on a controlled, smooth descent to complete the repetition.",
                ]
            },
            "yoga-mat": {
                displayName: "Yoga Mat",
                recommendedExercise: "Plank Hold",
                instructions: [
                    "Start on your hands and knees, then extend your legs back.",
                    "Keep your body in a straight line from head to heels.",
                    "Engage your core and glutes tightly.",
                    "Hold for 30-60 seconds, maintaining proper form.",
                ]
            },
            "equipment-example": {
                displayName: "Powerbank",
                recommendedExercise: "KUNWARE EQUIPMENT",
                instructions: [
                    "testing testing",
                    "testtttt",
                    "testtttt",
                    "testttt",
                ]
            },
            "background": {
                displayName: "No Equipment Detected",
                recommendedExercise: "Please focus on an item.",
                instructions: [
                    "Ensure the equipment is well-lit.",
                    "The camera view should be steady and clear.",
                    "The model requires at least 85% confidence for detection.",
                ]
            }
        };
        // -------------------------------------------

        let model, webcam, maxPredictions;
        let isSetup = false;
        
        // Utility function to display messages
        function updateStatus(message, color = 'yellow') {
            const statusDiv = document.getElementById('status-message');
            statusDiv.textContent = message;
            statusDiv.className = `text-center p-3 mb-4 rounded-lg font-semibold bg-${color}-100 text-${color}-700`;
        }
        
        async function init() {
            if (isSetup) {
                updateStatus("Already running!", 'indigo');
                return;
            }

            console.log("LOG 1: Initializing TensorFlow backend...");
            await tf.ready();
            console.log("LOG 2: TensorFlow ready. Starting model load...");
            
            updateStatus("Loading...", 'yellow');
            try {
                const modelURL = MODEL_URL + "model.json";
                const metadataURL = MODEL_URL + "metadata.json";
                model = await tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();
                console.log("LOG 3: Model loaded successfully.");
            } catch (error) {
                console.error("Critical Model Loading Error:", error); 
                updateStatus("Failed to load model! Error: " + (error.message || "Unknown model loading failure."), 'red');
                return;
            }

            updateStatus("Setting up webcam...", 'yellow');
            try {
                const flip = false; 
                
                console.log("LOG 4: Attempting webcam setup (tmImage.Webcam.setup())...");
                // MODIFIED: Increased resolution to 800x600
                webcam = new tmImage.Webcam(800, 600, flip); // width, height, flip 
                await webcam.setup();
                await webcam.play();
                console.log("LOG 5: Webcam setup successful. Stream running.");
                
                document.getElementById("webcam").appendChild(webcam.canvas); 

                isSetup = true;
                document.getElementById('start-button').style.display = 'none'; 
                updateStatus("Model loaded and webcam running! Classifying...", 'green');
                
                // Start the prediction loop
                window.requestAnimationFrame(loop);

            } catch (error) {
                console.error("Critical Webcam Setup Error:", error); 
                const errorMessage = error.message || "Webcam access failed. Possible issues: device conflict, browser policy (despite permission), or iframe initialization failure.";
                updateStatus("Failed to set up webcam. Error: " + errorMessage, 'red');
            }
        }

        async function loop() {
            if (webcam && isSetup) {
                webcam.update();
                await predict();
            }
            // Only continue the loop if the webcam is still running
            if (isSetup) {
                window.requestAnimationFrame(loop);
            }
        }

        async function predict() {
            const prediction = await model.predict(webcam.canvas);
            const labelContainer = document.getElementById("label-container");
            const arInfo = document.getElementById("ar-info");

            prediction.sort((a, b) => b.probability - a.probability);

            let targetDetected = false;
            let topPrediction = prediction[0];
            let topClassName = topPrediction.className.toLowerCase(); 
            
            const currentEquipment = EXERCISE_MAPPING[topClassName] || EXERCISE_MAPPING["background"];

            // --- Determine Target Detection Status ---
            if (
                topPrediction.probability >= MIN_CONFIDENCE_THRESHOLD && 
                topClassName !== 'background'
            ) {
                targetDetected = true;
            }

            // --- Control Prediction Bars (#label-container) ---
            // Clear content and hide the container at all times for a clean AR view.
            labelContainer.innerHTML = '';
            labelContainer.classList.add('hidden'); 
            
            // Note: If you need to debug the classification values, you can remove 
            // labelContainer.classList.add('hidden');

            // --- AR Logic (Details Box) ---
            if (targetDetected) {
                
                const details = currentEquipment;
                
                // NEW ELEMENT: Equipment Name (User-friendly)
                document.getElementById('equipment-display-name').textContent = details.displayName; 
                
                // EXISTING ELEMENT: Detected Class (Raw Model Class)
                document.getElementById('detected-item-name').textContent = topClassName; 
                
                // UPDATED ELEMENT: Recommended Exercise
                document.getElementById('recommended-exercise').textContent = details.recommendedExercise;
                
                // UPDATED: Instructions List
                const instructionsList = document.querySelector('#ar-info ul');
                instructionsList.innerHTML = details.instructions.map(instruction => `<li>${instruction}</li>`).join('');
                
                arInfo.classList.remove('hidden');
                updateStatus(`Equipment Recognized! Viewing details for ${details.displayName}.`, 'green');
            } else {
                // When nothing is detected, hide the AR info box
                arInfo.classList.add('hidden');
                updateStatus("Place the camera on a piece of equipment to view the details.", 'gray');
            }
        }

        // Initial check and setup to enable the button if the user clicks
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('start-button').disabled = false;
            updateStatus("Ready! Click 'Start Recognition' and allow camera access.", 'green');
            
            // --- Sidebar Toggle Logic ---
            const moreToggle = document.querySelector('.more-toggle');
            const submenu = document.querySelector('.more-menu .submenu');
            const toggleIcon = document.querySelector('.more-menu .toggle-icon');

            if (moreToggle && submenu && toggleIcon) {
                // Initial state is set in CSS, but this ensures JS consistency.
                submenu.style.maxHeight = '0px'; 
                
                moreToggle.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    
                    if (submenu.style.maxHeight === '0px') {
                        // Dynamically calculate the height of the content to ensure smooth opening
                        submenu.style.maxHeight = submenu.scrollHeight + 'px'; 
                        toggleIcon.style.transform = 'rotate(180deg)';
                    } else {
                        // Set to 0px to close
                        submenu.style.maxHeight = '0px';
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                });
            }
        });
        
    </script>
</body>
</html>