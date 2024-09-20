<?php
require_once 'connection.php';
require_once 'phpqrcode/qrlib.php';

$path = 'images/';
$qrcode = $path . time() . ".png";
$qrimage = time() . ".png";

if (isset($_POST['guest_name']) && isset($_POST['email']) && isset($_POST['member_id']) && isset($_POST['qrtext'])) {
    $guest_name = $_POST['guest_name'];
    $email = $_POST['email'];
    $member_id = $_POST['member_id'];
    $qrtext = $_POST['qrtext'];

    $query = "INSERT INTO qrcode (guest_name, email, member_id, qrtext, qrimage) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssss", $guest_name, $email, $member_id, $qrtext, $qrimage);

    if ($stmt->execute()) {
        $attendance_url = "http://192.168.10.192:8080/Csc/mark_attendance.php?qrtext=" . urlencode($qrtext); 
        QRcode::png($attendance_url, $qrcode, 'H', 10, 2); // Generate QR code with attendance URL
        echo json_encode(['message' => 'QR Code generated successfully.', 'qrimage' => $qrcode]);
    } else {
        echo json_encode(['message' => 'Failed to save guest. Please try again.']);
    }

    $stmt->close();
}

$connection->close();
?>
