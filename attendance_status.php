<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Status</title>
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
            max-width: 600px;
            margin: auto;
        }
        h1 {
            margin-bottom: 20px;
        }
        .btn {
            margin-top: 20px;
        }
        .attendance-exceeded {
            color: red;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($_GET['message']); ?></h1>
        <div class="card">
            <p><strong>Guest Name:</strong> <?php echo htmlspecialchars($_GET['guest_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_GET['email']); ?></p>
            <p><strong>Member ID:</strong> <?php echo htmlspecialchars($_GET['member_id']); ?></p>
            <p><strong>Attendance:</strong> <?php echo htmlspecialchars($_GET['attendance']); ?></p>
            <?php if (isset($_GET['attendance']) && $_GET['attendance'] > 6): ?>
                <p class="attendance-exceeded"><strong>Attendance exceeded</strong></p>
            <?php endif; ?>
        </div>
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>
</body>
</html>
