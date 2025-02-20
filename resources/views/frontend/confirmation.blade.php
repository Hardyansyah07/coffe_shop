<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Cafe KuyBrew</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20231024/pngtree-aesthetic-blend-roasted-coffee-beans-atop-a-weathered-concrete-surface-image_13690854.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0; /* Remove default margin */
            font-family: 'Poppins', sans-serif; /* Set font family */
        }

        .container {
            max-width: 600px; /* Set a maximum width for the container */
            background: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
            padding: 40px; /* Add padding */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            text-align: center; /* Center text */
        }

        .confirmation-icon {
            font-size: 60px; /* Increase icon size */
            color: #2ecc71; /* Green color */
            margin-bottom: 20px; /* Space below icon */
        }

        .confirmation-title {
            font-size: 28px; /* Increase title size */
            font-weight: 600; /* Bold font weight */
            margin-bottom: 10px; /* Space below title */
        }

        .confirmation-message {
            font-size: 18px; /* Message font size */
            color: #666; /* Darker gray color */
            margin-bottom: 30px; /* Space below message */
        }

        .back-to-home {
            background: #e67e22; /* Button background color */
            color: white; /* Button text color */
            border: none; /* No border */
            padding: 12px 25px; /* Padding inside the button */
            border-radius: 25px; /* Rounded button */
            cursor: pointer; /* Pointer cursor on hover */
            width: 100%; /* Full width */
            font-weight: 500; /* Semi-bold font weight */
            transition: background 0.3s ease; /* Smooth background transition */
        }

        .back-to-home:hover {
            background: #d35400; /* Darker orange on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <i class="fas fa-check-circle confirmation-icon"></i>
        <h2 class="confirmation-title">Order Confirmed!</h2>
        <p class="confirmation-message">Thank you for your order. We will process your order as soon as possible.</p>
        <a class="back-to-home" href="http://127.0.0.1:8000/">Back To Home</a>
    </div>
</body>
</html>