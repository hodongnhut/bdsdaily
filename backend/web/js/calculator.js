function calculateLoan() {
   
    // Get the loan amount, remove commas (if any), and parse it as a number
    var loanAmount = parseFloat(document.getElementById("loan-amount").value.replace(/[^\d]/g, ''));
    console.log(loanAmount);
    var loanTerm = parseInt(document.getElementById("loan-term").value);
    var interestRate = parseFloat(document.getElementById("interest-rate").value) / 100;

    if (isNaN(loanAmount) || isNaN(loanTerm) || isNaN(interestRate) || loanAmount <= 0 || loanTerm <= 0 || interestRate <= 0) {
        alert("Vui lòng nhập đầy đủ thông tin hợp lệ.");
        return;
    }

    // Monthly Interest Rate
    var monthlyInterestRate = interestRate / 12;

    // Calculate Monthly Payment (PMT)
    var monthlyPayment = (loanAmount * monthlyInterestRate) / (1 - Math.pow(1 + monthlyInterestRate, -loanTerm));

    // Initialize loan balance
    var balance = loanAmount;

    var totalPayment = monthlyPayment * loanTerm;
    
    // Set values for loan-interest and total-payment input fields
    document.getElementById("loan-interest").value = formatCurrency(totalPayment - loanAmount); // Total interest to be paid
    document.getElementById("total-payment").value = formatCurrency(totalPayment); // Total payment (principal + interest)

    // Create the amortization table
    var schedule = '';
    for (var i = 1; i <= loanTerm; i++) {
        var interestPayment = balance * monthlyInterestRate;
        var principalPayment = monthlyPayment - interestPayment;
        var totalPaymentForMonth = interestPayment + principalPayment;
        balance -= principalPayment;

        schedule += `<tr>
            <td>${i}</td>
            <td>${new Date(new Date().setMonth(new Date().getMonth() + i)).toLocaleDateString()}</td>
            <td>${formatCurrency(balance)}</td>
            <td>${formatCurrency(principalPayment)}</td>
            <td>${formatCurrency(interestPayment)}</td>
            <td>${formatCurrency(totalPaymentForMonth)}</td>
        </tr>`;
    }

    // Display the amortization table
    document.getElementById("loan-schedule").innerHTML = schedule;
}

function formatCurrency(value) {
    // Format value as VND with commas and VND symbol
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
}

function formatLoanAmount(input) {
    var value = input.value.replace(/[^\d,]/g, '');  // Remove non-numeric characters, except commas

    // Remove commas for calculation
    var numericValue = value.replace(/,/g, '');

    // Format the number with commas (thousands separator)
    var formattedValue = parseInt(numericValue).toLocaleString('vi-VN');

    // Set the formatted value back to the input field
    input.value = formattedValue;
}

function validateInterestRate(input) {
    var value = parseFloat(input.value);
    
    // Check if the value is valid and within the specified range
    if (isNaN(value) || value < 0.1 || value > 100) {
        input.setCustomValidity("Vui lòng nhập lãi suất hợp lệ (từ 0.1% đến 100%)");
        input.style.borderColor = 'red';  // Optional: Highlight the field in red
    } else {
        input.setCustomValidity(""); // Reset the error message if the input is valid
        input.style.borderColor = '';  // Optional: Reset the border color
    }
}


$(document).ready(function() {
    // Set current date for "Ngày giải ngân"
    var currentDate = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
    document.getElementById("disbursement-date").value = currentDate;

    // Hide the nice-select dropdown and show the default select element for loan term
    $(".nice-select").hide();
    $("#loan-term").show();
});
