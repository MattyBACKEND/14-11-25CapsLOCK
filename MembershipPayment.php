<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plan</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary-blue': '#000000ff',
                        'primary-yellow': '#f7f200',
                        'light-bg': '#f9f6f1',
                        'card-bg': '#ffffff',
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .card-container {
            transition: transform 0.2s, box-shadow 0.2s, border 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .card-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .space-y-6 h2{
            text-align: center;
        }
        .card-container.selected {
            border-color: #3b82f6;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.5);
            transform: translateY(-4px);
        }
        .card-container input[type="radio"] {
            display: none;
        }
        .grid-container {
            max-width: 1200px;
        }
        .back-icon i {
            font-size: 180%;
        }

        /* 🔥 PayPal Animation */
        @keyframes fadeSlideUp {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .fade-slide-up {
            animation: fadeSlideUp 0.4s ease-out forwards;
        }
    </style>
</head>

<body class="bg-light-bg min-h-screen flex flex-col items-center p-4 sm:p-8 font-sans text-gray-800">

    <div class="w-full max-w-7xl mx-auto">

        <a href="Register.php" class="back-icon"><i class='bx bx-arrow-back'></i></a>

        <header class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-primary-blue mb-2">
                Choose Your Membership Plan
            </h1>
            <p class="text-lg text-gray-600 font-medium">
                Select the option that best suits your needs.
            </p>
        </header>

        <form id="membershipForm" action="ProcessPayment.php" method="post" class="space-y-12">

            <!-- Student Membership Section -->
            <section class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-700 border-b pb-2">Student Membership</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Student CARD 1 -->
                    <label for="student_1year" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_1year" name="membership" value="student_1year" required>
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Best Value</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱499</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Year</p>
                            <p class="text-sm text-gray-500 min-h-10">Perfect for academic cycles. Full access for one whole year.</p>
                        </div>
                    </label>

                    <!-- Student CARD 2 -->
                    <label for="student_lifetime" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_lifetime" name="membership" value="student_lifetime">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-yellow-600">Premium Choice</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱1,999</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">Lifetime</p>
                            <p class="text-sm text-gray-500 min-h-10">Pay once, enjoy forever.</p>
                        </div>
                    </label>

                    <!-- Student CARD 3 -->
                    <label for="student_1month" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_1month" name="membership" value="student_1month">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-gray-400">Monthly</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱1,099</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Month</p>
                            <p class="text-sm text-gray-500 min-h-10">Short-term access for focused projects.</p>
                        </div>
                    </label>

                    <!-- Student CARD 4 -->
                    <label for="student_3plus1" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_3plus1" name="membership" value="student_3plus1">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-green-600">Bonus Month!</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱3,799</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 4 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">Get 3 months + 1 month free.</p>
                        </div>
                    </label>

                    <!-- Student CARD 5 -->
                    <label for="student_6months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_6months" name="membership" value="student_6months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-purple-600">Semester Term</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱5,499</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 6 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">Ideal for semester-long commitments.</p>
                        </div>
                    </label>

                    <!-- Student CARD 6 -->
                    <label for="student_12months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="student_12months" name="membership" value="student_12months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Annual Savings</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱9,999</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 12 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">Locked-in yearly rate.</p>
                        </div>
                    </label>

                </div>
            </section>


            <!-- Non-Student Membership Section -->
            <section class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-700 border-b pb-2">Non-Student Membership</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <label for="nonstudent_1year" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_1year" name="membership" value="nonstudent_1year">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Annual Access</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱799</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Year</p>
                            <p class="text-sm text-gray-500 min-h-10">Yearly plan for professionals.</p>
                        </div>
                    </label>

                    <label for="nonstudent_lifetime" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_lifetime" name="membership" value="nonstudent_lifetime">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-yellow-600">The Ultimate Plan</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱3,999</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">Lifetime</p>
                            <p class="text-sm text-gray-500 min-h-10">Unlimited, permanent access.</p>
                        </div>
                    </label>

                    <label for="nonstudent_1month" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_1month" name="membership" value="nonstudent_1month">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-gray-400">Monthly</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱1,399</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 1 Month</p>
                            <p class="text-sm text-gray-500 min-h-10">Cancel anytime.</p>
                        </div>
                    </label>

                    <label for="nonstudent_3plus1" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_3plus1" name="membership" value="nonstudent_3plus1">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-green-600">Bonus Month!</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱4,899</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 4 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">3 months + 1 free.</p>
                        </div>
                    </label>

                    <label for="nonstudent_6months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_6months" name="membership" value="nonstudent_6months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-purple-600">Half-Year Plan</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱6,999</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 6 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">Long-term commitment.</p>
                        </div>
                    </label>

                    <label for="nonstudent_12months" class="card-container rounded-xl shadow-lg bg-card-bg hover:shadow-xl p-6 flex flex-col justify-between">
                        <input type="radio" id="nonstudent_12months" name="membership" value="nonstudent_12months">
                        <div class="text-center">
                            <p class="text-sm font-medium uppercase text-primary-blue">Max Savings</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 my-2">₱12,999</h3>
                            <p class="text-xl font-semibold text-gray-600 mb-4">/ 12 Months</p>
                            <p class="text-sm text-gray-500 min-h-10">Most cost-effective annual package.</p>
                        </div>
                    </label>

                </div>
            </section>


            <!-- PAYPAL BUTTON SECTION (UPDATED: hidden + animated + centered) -->
            <div id="paypalSection" class="mt-12 pt-6 border-t border-gray-300 flex justify-center hidden">
<div id="paypal-container-47WF2C9PU6P2C" class="w-full max-w-xs"></div>
</div>

        </form>
    </div>

    <!-- Card Selection Script (UPDATED WITH ANIMATION + SHOW/HIDE PAYPAL) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('membershipForm');
            const cards = document.querySelectorAll('.card-container');
            const paypalSection = document.getElementById('paypalSection');

            const updateCardSelection = () => {
                cards.forEach(card => {
                    const radio = card.querySelector('input[type="radio"]');
                    radio.checked ? card.classList.add('selected') : card.classList.remove('selected');
                });
            };

            updateCardSelection();

            // CARD CLICK EVENT
            cards.forEach(card => {
                card.addEventListener('click', () => {

                    // Select the radio
                    card.querySelector('input[type="radio"]').checked = true;
                    updateCardSelection();

                    // Reset PayPal visibility first
                    paypalSection.classList.add('hidden');
                    paypalSection.classList.remove('fade-slide-up');

                    // Re-show with animation
                    setTimeout(() => {
                        paypalSection.classList.remove('hidden');
                        paypalSection.classList.add('fade-slide-up');
                    }, 100);
                });
            });
        });
    </script>

    <!-- PAYPAL SDK -->
    <script 
      src="https://www.paypal.com/sdk/js?client-id=BAAw8_HGuKNx5bQqABjtgfVSFBYYCnvdjXDbvkjbgjfGsnT_ktu98RhnLwPo5tcJ7jrN34AC2uB7srIl2U&components=hosted-buttons&disable-funding=venmo&currency=PHP">
    </script>

    <!-- PAYPAL BUTTON RENDER -->
<script>
paypal.HostedButtons({
    hostedButtonId: "47WF2C9PU6P2C",
    onApprove: function(data, actions) {
        // Get selected membership
        const selected = document.querySelector('input[name="membership"]:checked');
        if (!selected) {
            alert("Please select a membership plan first.");
            return;
        }

        // Put the selected value into the hidden form
        document.getElementById('hiddenMembership').value = selected.value;

        // Submit the form to ProcessPayment.php
        document.getElementById('paymentForm').submit();
    }
}).render("#paypal-container-47WF2C9PU6P2C");
</script>

    </script>

</body>
</html>
