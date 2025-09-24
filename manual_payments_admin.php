<?php
// Fix session issue
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin'])) {
    header('location: ../index');
    exit;
}
include("auth.php");

// Approve / Reject handling with debug
if(isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action']; // 'approve' or 'reject'
    error_log("Action received: $action, ID: $id"); // Debug log

    $sql = mysqli_query($conn, "SELECT * FROM manual_payments WHERE id='$id'");
    if(mysqli_num_rows($sql) == 1) {
        $payment = mysqli_fetch_assoc($sql);
        $user_id = $payment['user_id'];
        $amount = $payment['amount'];
        $status = ($action == 'approve') ? 'approved' : 'rejected';
        error_log("Setting status to: $status for user_id: $user_id"); // Debug log

        $update = mysqli_query($conn, "UPDATE manual_payments SET status='$status' WHERE id='$id'");
        if ($update) {
            error_log("Status updated successfully for ID $id");
        } else {
            error_log("Status update failed for ID $id: " . mysqli_error($conn));
        }

        if($action == 'approve') {
            $current_time = date('Y-m-d H:i:s');
            require_once __DIR__ . '/../include/smtp_config.php';
            // Fetch user details for email
$user_query = mysqli_query($conn, "SELECT username, email FROM user_data WHERE id='$user_id'");
$user_data = mysqli_fetch_assoc($user_query);
$username = $user_data['username'];
$user_email = $user_data['email'];

// Prepare placeholders for email template
$placeholders = [
    'username' => $username,
    'amount' => $amount,
    'request_id' => $id,
    'date' => $current_time,
    'web_name' => $web_name
];

// Send email to customer
sendTemplateMail($user_email, 'Deposit Approved', 'deposit_approved.html', $placeholders);
            // Update user wallet
            $sql_user = mysqli_query($conn, "SELECT * FROM user_wallet WHERE user_id='$user_id'");
            if ($sql_user && mysqli_num_rows($sql_user) == 1) {
                $user_data = mysqli_fetch_assoc($sql_user);
                $new_balance = $user_data['balance'] + $amount;
                $new_total = $user_data['total_recharge'] + $amount;
                $update_wallet = mysqli_query($conn, "UPDATE user_wallet SET balance='$new_balance', total_recharge='$new_total' WHERE user_id='$user_id'");
                if (!$update_wallet) {
                    error_log("Wallet update failed for user_id $user_id: " . mysqli_error($conn));
                } else {
                    error_log("Wallet updated for user_id $user_id, new balance: $new_balance");
                }
            } else {
                error_log("User wallet not found for user_id $user_id, creating new...");
                $default_balance = 0;
                $insert_wallet = mysqli_query($conn, "INSERT INTO user_wallet (user_id, balance, total_recharge) VALUES ('$user_id', '$default_balance', '$amount')");
                if ($insert_wallet) {
                    $new_balance = $amount;
                    $new_total = $amount;
                    mysqli_query($conn, "UPDATE user_wallet SET balance='$new_balance', total_recharge='$new_total' WHERE user_id='$user_id'");
                    error_log("New wallet created for user_id $user_id, balance: $new_balance");
                } else {
                    error_log("Wallet creation failed for user_id $user_id: " . mysqli_error($conn));
                }
            }

            // Insert into user_transaction
            $current_time = date('Y-m-d H:i:s');
            $insert_transaction = mysqli_query($conn, "INSERT INTO user_transaction (user_id, amount, date, type, txn_id, status) VALUES ('$user_id', '$amount', '$current_time', 'Manual Payment', '$id', 'completed')");
            if (!$insert_transaction) {
                error_log("Transaction insert failed: " . mysqli_error($conn));
            }
        }

        header("Location: manual_payments_admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manual Payments - @radiumsahil</title>
  <?php include("include/head.php"); ?>  
</head>

<script>
$(document).ready(function() {
    $('#dashboard').removeClass("active");
    $("#manual_payments").addClass("active");
});
</script>

<body id="page-top">
<div id="wrapper">
    <!-- Sidebar -->
    <?php include ("include/slidebar.php"); ?>
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- TopBar -->
            <?php include ("include/topbar.php"); ?>              
            <!-- Topbar -->

            <div class="container-fluid" id="container-wrapper">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manual Payments</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Recent 200 Manual Payments</h6>
                            </div>
                            <div class="table-responsive p-3">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>User ID</th>
                                            <th>Payment Method</th>
                                            <th>Account Title</th>
                                            <th>Account Number</th>
                                            <th>Amount</th>
                                            <th>Proof</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM manual_payments ORDER BY id DESC LIMIT 200");
                                        if ($sql && mysqli_num_rows($sql) > 0) {
                                            while($data = mysqli_fetch_assoc($sql)){
                                                error_log("Table loop: ID " . $data['id'] . ", Status " . ($data['status'] ?? 'null') . ", User ID " . $data['user_id']);
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($data['user_id']) ?></td>
                                                <td><b><?= htmlspecialchars($data['payment_method']) ?></b></td>
                                                <td><?= htmlspecialchars($data['account_title']) ?></td>
                                                <td><?= htmlspecialchars($data['account_number']) ?></td>
                                                <td><?= htmlspecialchars($data['amount']) ?></td>
                                                <td><a href="view_proof.php?file=<?= urlencode($data['proof_file']) ?>" target="_blank">View</a></td>
                                                <td>
                                                    <?php
                                                    $status = $data['status'] ?? 'pending'; // Force 'pending' if null
                                                    if ($status == 'pending' || $status === '') {
                                                        $badge = 'badge badge-warning';
                                                        $text = 'Pending';
                                                    } elseif ($status == 'approved') {
                                                        $badge = 'badge badge-success';
                                                        $text = 'Approved';
                                                    } else {
                                                        $badge = 'badge badge-danger';
                                                        $text = 'Rejected';
                                                    }
                                                    echo '<span class="' . $badge . '">' . $text . '</span>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    // Force show action buttons if status is pending or blank
                                                    if ($status == 'pending' || $status === '' || $status === null) { ?>
                                                        <a href="?action=approve&id=<?= $data['id'] ?>" class="badge badge-success">Approve</a>
                                                        <a href="?action=reject&id=<?= $data['id'] ?>" class="badge badge-danger">Reject</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        } else {
                                            error_log("No data or query failed: " . mysqli_error($conn));
                                            echo "<tr><td colspan='8'>No payments found. Check logs for errors.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include("include/copyright.php"); ?>
            <!-- Footer -->
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</div>

<?php include("include/script.php"); ?>
</body>
</html>