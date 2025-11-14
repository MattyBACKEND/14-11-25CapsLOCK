<?php

include 'connection.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment System</title>
    <link rel="stylesheet" href="PaymentPageStyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Payment System</h1>

    <!-- Payment Form -->
    <div class="payment-form">
        <h2>Make a Payment</h2>
        <form id="paymentForm">
            <label>Client Name:</label>
            <input type="text" id="clientName" required>

            <label for="accountNumber">Account Number:</label>
            <input type="text" id="accountNumber" required>


            <label>Training Type:</label>
            <select id="trainingType" required>
                <option value="">Select</option>
                <option value="Boxing">Boxing</option>
                <option value="Muay Thai">Muay Thai</option>
                <option value="Weightlifting">Weightlifting</option>
            </select>

            <label>Amount (PHP):</label>
            <input type="number" id="amount" required>

            <label>Payment Method:</label>
            <select id="paymentMethod" required>
                <option value="Paypal">Paypal</option>
                <option value="GCash">GCash</option>
                <option value="Credit Card">Credit Card</option>
            </select>

            <button type="submit">Pay Now</button>

            <button id="clearHistoryBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg">Clear Transaction History</button>

        </form>
    </div>

    <!-- Transaction History -->
    <div class="history">
        <h2>Transaction History</h2>
        <table id="historyTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Account number</th>
                    <th>Training</th>
                    <th>Amount</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <!-- Transactions will appear here -->
            </tbody>
        </table>
    </div>

</div>

<script>


document.addEventListener("DOMContentLoaded", function() {
    loadTransactions();

    document.getElementById("paymentForm").addEventListener("submit", function(e) {
        e.preventDefault();


        document.getElementById("clearHistoryBtn").addEventListener("click", function() {
    if (confirm("Are you sure you want to clear all transaction history?")) {
        localStorage.removeItem("transactions");
        document.getElementById("historyTable").querySelector("tbody").innerHTML = ""; // clear table
        alert("Transaction history cleared.");
    }
});


        let clientName = document.getElementById("clientName").value;
        let accountNumber= document.getElementById("accountNumber").value;
        let trainingType = document.getElementById("trainingType").value;
        let amount = document.getElementById("amount").value;
        let paymentMethod = document.getElementById("paymentMethod").value;
        let date = new Date().toLocaleString();

        let transaction = {
            clientName,accountNumber, trainingType, amount, paymentMethod, date
        };

        saveTransaction(transaction);
        addTransactionRow(transaction);
        this.reset();
        alert("Payment Successful!");
    });
});

function saveTransaction(transaction) {
    let transactions = JSON.parse(localStorage.getItem("transactions")) || [];
    transactions.push(transaction);
    localStorage.setItem("transactions", JSON.stringify(transactions));
}

function loadTransactions() {
    let transactions = JSON.parse(localStorage.getItem("transactions")) || [];
    transactions.forEach(addTransactionRow);
}

function addTransactionRow(transaction) {
    let table = document.getElementById("historyTable").querySelector("tbody");
    let row = document.createElement("tr");

    row.innerHTML = `
        <td>${transaction.date}</td>
        <td>${transaction.clientName}</td>
        <td>${transaction.accountNumber}</td>
        <td>${transaction.trainingType}</td>
        <td>₱${transaction.amount}</td>
        <td>${transaction.paymentMethod}</td>
    `;

    table.appendChild(row);
}

</script>

</body>
</html>

