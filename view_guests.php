<?php
require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Guests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #f1f1f1;
        }
        .high-attendance {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registered Guests</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Member ID</th>
                    <th>Phone Number</th>
                    <th>QR Code</th>
                    <th>Attendance Count</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                    SELECT 
                        qrcode.guest_name, 
                        qrcode.email, 
                        qrcode.member_id, 
                        qrcode.qrtext, 
                        qrcode.qrimage, 
                        COUNT(attendance.id) AS attendance_count 
                    FROM qrcode 
                    LEFT JOIN attendance 
                    ON qrcode.qrtext = attendance.qrtext 
                    GROUP BY qrcode.guest_name, 
                             qrcode.email, 
                             qrcode.member_id, 
                             qrcode.qrtext, 
                             qrcode.qrimage
                ";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $attendance_count = $row['attendance_count'];
                        $attendance_class = $attendance_count > 6 ? 'high-attendance' : '';
                        echo "<tr>
                                <td>{$row['guest_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['member_id']}</td>
                                <td>{$row['qrtext']}</td>
                                <td><img src='images/{$row['qrimage']}' width='100' height='100'></td>
                                <td class='{$attendance_class}'>{$attendance_count}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No registered guests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
