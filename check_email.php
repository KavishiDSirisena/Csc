<?php
require_once 'connection.php';

$email = $_POST['email'];
$member_id = $_POST['member_id'];

// Check if the email exists in the qrcode table
$email_query = "SELECT * FROM qrcode WHERE email = ?";
$email_stmt = $connection->prepare($email_query);
$email_stmt->bind_param("s", $email);
$email_stmt->execute();
$email_result = $email_stmt->get_result();
$email_stmt->close();

if ($email_result->num_rows > 0) {
    echo 'email_exists';
} else {
    // Check if the member ID exists in the members table
    $member_query = "SELECT * FROM members WHERE member_id = ?";
    $member_stmt = $connection->prepare($member_query);
    $member_stmt->bind_param("i", $member_id);
    $member_stmt->execute();
    $member_result = $member_stmt->get_result();
    $member_stmt->close();

    if ($member_result->num_rows > 0) {
        echo 'valid';
    } else {
        echo 'invalid_member_id';
    }
}

$connection->close();
?>
