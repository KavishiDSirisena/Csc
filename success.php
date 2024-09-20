<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        img {
            margin-top: 20px;
            width: 300px; /* Adjusted size of the QR code */
            height: 300px; /* Adjusted size of the QR code */
        }
        .btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration Success</h1>
        <p>Welcome to Colombo Swimming Club!</p>
        <?php
        if (isset($_GET['qrimage'])) {
            echo "<img src='" . htmlspecialchars($_GET['qrimage']) . "' alt='QR Code'>";
        }
        ?>
        <br>
        <a href="guest_registration.php" class="btn btn-primary">Back to Guest Form</a>
    </div>
</body>
</html>
