<?php
// Define all valid membership options and their corresponding prices
$membershipOptions = [
    "student_1year"       => ["label" => "Student - 1 Year", "price" => 499],
    "student_lifetime"    => ["label" => "Student - Lifetime", "price" => 1999],
    "student_1month"      => ["label" => "Student - 1 Month", "price" => 1099],
    "student_3plus1"      => ["label" => "Student - 3 + 1 Month", "price" => 3799],
    "student_6months"     => ["label" => "Student - 6 Months", "price" => 5499],
    "student_12months"    => ["label" => "Student - 12 Months", "price" => 9999],
    "nonstudent_1year"    => ["label" => "Non-Student - 1 Year", "price" => 799],
    "nonstudent_lifetime" => ["label" => "Non-Student - Lifetime", "price" => 3999],
    "nonstudent_1month"   => ["label" => "Non-Student - 1 Month", "price" => 1399],
    "nonstudent_3plus1"   => ["label" => "Non-Student - 3 + 1 Month", "price" => 4899],
    "nonstudent_6months"  => ["label" => "Non-Student - 6 Months", "price" => 6999],
    "nonstudent_12months" => ["label" => "Non-Student - 12 Months", "price" => 12999],
];

// Check if the form was submitted and a valid membership was selected
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["membership"])) {
    $selected = $_POST["membership"];

    if (array_key_exists($selected, $membershipOptions)) {
        $membershipLabel = $membershipOptions[$selected]["label"];
        $price = $membershipOptions[$selected]["price"];

        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Payment Confirmation</title>
            <style>
                body {
                    background-color: #1e1e1e;
                    color: #f1f1f1;
                    font-family: Arial, sans-serif;
                    padding: 20px;
                }
                .confirmation {
                    background-color: #2c2c2c;
                    border: 1px solid #444;
                    padding: 20px;
                    border-radius: 10px;
                }
                h2 {
                    color:rgb(186,189,52);
                }

                .btn-dashboard {

                    color: rgb(186,189,52);
                }
            </style>
        </head>
        <body>
            <div class='confirmation'>
                <h2>Payment Summary</h2>
                <p><strong>Membership Selected:</strong> {$membershipLabel}</p>
                <p><strong>Price:</strong> ₱{$price}</p>
                <p>Thank you for choosing a membership.</p>
                <a href='loginpage.php' class='btn-dashboard'>Go to Login</a>
            </div>
        </body>
        </html>";
    } else {
        echo "Invalid membership option selected.";
    }
} else {
    echo "No membership option selected. Please go back and choose a plan.";
}
?>