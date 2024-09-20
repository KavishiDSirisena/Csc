<?php
require_once 'connection.php';

if (isset($_GET['qrtext'])) {
    $qrtext = $_GET['qrtext'];

    // Insert the attendance record into the database
    $query = "INSERT INTO attendance (qrtext) VALUES (?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $qrtext);

    if ($stmt->execute()) {
        // Update the attendance column in the qrcode table
        $update_query = "UPDATE qrcode SET attendance = attendance + 1 WHERE qrtext = ?";
        $update_stmt = $connection->prepare($update_query);
        $update_stmt->bind_param("s", $qrtext);

        if ($update_stmt->execute()) {
            // Retrieve the updated user details
            $details_query = "SELECT * FROM qrcode WHERE qrtext = ?";
            $details_stmt = $connection->prepare($details_query);
            $details_stmt->bind_param("s", $qrtext);
            $details_stmt->execute();
            $result = $details_stmt->get_result();
            $user = $result->fetch_assoc();

            $attendance = $user['attendance'];
            $guest_name = $user['guest_name'];
            $email = $user['email'];
            $member_id = $user['member_id'];
            $message = "Attendance marked successfully.";

            // Check if attendance exceeds 6
            if ($attendance > 6) {
                $message = "Attendance marked successfully. Attendance exceeded.";
            }

            $details_stmt->close();
        } else {
            $message = "Failed to update attendance in qrcode table. Please try again.";
        }

        $update_stmt->close();
    } else {
        $message = "Failed to mark attendance. Please try again.";
    }

    $stmt->close();
} else {
    $message = "Invalid request.";
}

$connection->close();

// Redirect to the attendance status page with user details
header("Location: attendance_status.php?message=" . urlencode($message) . "&guest_name=" . urlencode($guest_name) . "&email=" . urlencode($email) . "&member_id=" . urlencode($member_id) . "&attendance=" . urlencode($attendance));
exit();
?>
