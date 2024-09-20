<!DOCTYPE html>
<html lang="en">  
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Generation Form</title>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>  
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .box {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h3 {
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>  
  <div class="container">          
    <div class="table-responsive">  
        <h3 align="center">Guest Registration Form</h3><br/>
        <div class="box">
            <form id="qrForm"> 
                <div class="form-group">
                    <label for="guest_name">Guest Name</label>
                    <input type="text" name="guest_name" id="guest_name" placeholder="Enter the guest name" required class="form-control" />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter the email" required class="form-control" />
                </div>
                <div class="form-group">
                    <label for="member_id">Member ID</label>
                    <input type="number" name="member_id" id="member_id" placeholder="Enter the member ID" required class="form-control" />
                </div>
                <div class="form-group">
                    <label for="qrtext">Phone Number</label>
                    <input type="tel" name="qrtext" id="qrtext" placeholder="Enter the phone number" required pattern="^[0-9]{10}$" class="form-control" />
                </div>
                <div class="form-group text-center">
                    <input type="submit" name="sbt-btn" value="Register Guest" class="btn btn-success" />
                </div>
                <div id="error" class="error"></div>
            </form>
            <div class="text-center">
                <a href="index.php" class="btn btn-success">Back to Home</a>
            </div>
        </div>
    </div>  
  </div>
  <script>
    $(document).ready(function() {
        $('#qrForm').on('submit', function(e) {
            e.preventDefault();
            let formData = {
                guest_name: $('#guest_name').val(),
                email: $('#email').val(),
                member_id: $('#member_id').val(),
                qrtext: $('#qrtext').val()
            };
            
            $.ajax({
                url: 'check_email.php',
                type: 'POST',
                data: { email: formData.email, member_id: formData.member_id },
                success: function(response) {
                    if(response === 'email_exists') {
                        $('#error').text('Email already exists in the database.');
                    } else if(response === 'invalid_member_id') {
                        $('#error').text('Invalid Member ID.');
                    } else if(response === 'valid') {
                        $('#error').text('');
                        // Proceed with form submission to generate QR code
                        $.ajax({
                            url: 'qrcode.php',
                            type: 'POST',
                            data: formData,
                            success: function(data) {
                                let result = JSON.parse(data);
                                if(result.message === 'QR Code generated successfully.') {
                                    window.location.href = 'success.php?qrimage=' + result.qrimage;
                                } else {
                                    $('#error').text(result.message);
                                }
                            },
                            error: function(err) {
                                $('#error').text('An error occurred while generating the QR code.');
                            }
                        });
                    }
                },
                error: function(err) {
                    $('#error').text('An error occurred while checking the email.');
                }
            });
        });
    });
  </script>
</body>  
</html>
