<?php
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';
// Fetch fee structure details based on the provided ID
// Fetch fee structure details based on the provided ID
$feeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$feeDetailsSql = "SELECT fees.*, classes.class_name, sessions.term
                  FROM fees
                  JOIN classes ON fees.class_id = classes.id
                  JOIN sessions ON fees.session_id = sessions.id
                  WHERE fees.id = $feeId";  // Adjust the table and column names as per your database schema

$feeDetailsResult = $conn->query($feeDetailsSql);

if ($feeDetailsResult->num_rows > 0) {
    $feeDetails = $feeDetailsResult->fetch_assoc();

    // Generate HTML content for the modal
    $htmlContent = '
        <div class="header-section">
            
            <p><strong>Session:</strong> ' . $feeDetails['term'] . '</p>
            <p><strong>Class:</strong> ' . $feeDetails['class_name'] . '</p>
        </div>
        <div class="fee-details-section">
            <table class="table table-bordered">
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>Admission Fee</td>
                    <td>' . $feeDetails['admission'] . '</td>
                </tr>
                <tr>
                    <td>Academic Fee</td>
                    <td>' . $feeDetails['academic'] . '</td>
                </tr>
                <tr>
                    <td>Boarding Fee</td>
                    <td>' . $feeDetails['boarding_fee'] . '</td>
                </tr>
                <tr>
                    <td>Lunch Fee</td>
                    <td>' . $feeDetails['lunch_fee'] . '</td>
                </tr>
                <tr>
                    <td><strong>Total Amount Payable</strong></td>
                    <td><strong>' . ($feeDetails['admission'] + $feeDetails['academic'] + $feeDetails['boarding_fee'] + $feeDetails['lunch_fee']) . '</strong></td>
                </tr>
            </table>
        </div>
        <div class="payment-address-section">
    <h4>Payment Address: MPESA</h4>
    <!-- Include payment address details here -->
    <p>
        PayBill: 522533 <br>
        Account No: 4567890875
    </p>
</div><br>
<div class="notes-section">
    <h4>N/B: Transport Fee</h4>
    <!-- Include additional notes here -->
    <p>Transport Fee varies based on student location. For payment inquiries, contact administration at <a> 0743 2999966</a> or <a>0718 909038</a>.</p>
</div>
    ';

    echo $htmlContent;
} else {
    echo '<p>No fee structure found for the provided ID.</p>';
}


?>
