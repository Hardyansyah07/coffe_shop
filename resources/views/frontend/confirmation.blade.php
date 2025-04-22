<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Confirmed - CAFFE BrewTopia</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(to bottom right, #f6f1e7, #ddd0c8);
    }

    .container {
      max-width: 400px;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      border-radius: 1.5rem;
      padding: 2.5rem;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .confirmation-icon {
      font-size: 4rem;
      color: #27ae60;
      animation: pop 0.4s ease;
    }

    @keyframes pop {
      0% {
        transform: scale(0);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    .confirmation-title {
      font-size: 1.75rem;
      font-weight: 600;
      margin-top: 1rem;
      margin-bottom: 0.5rem;
      color: #2c1810;
    }

    .confirmation-message {
      font-size: 1rem;
      color: #666;
      margin-bottom: 1.5rem;
    }

    .back-to-home {
      background: #e67e22;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 9999px;
      cursor: pointer;
      width: 100%;
      font-weight: 500;
      transition: background 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .back-to-home:hover {
      background: #d35400;
    }
  </style>

  <script>
    // Redirect to /menu after 5 seconds
    setTimeout(() => {
      window.location.href = "/";
    }, 5000);
  </script>
</head>
<body>
  <div class="container">
    <i class="fas fa-check-circle confirmation-icon"></i>
    <h2 class="confirmation-title">Order Confirmed!</h2>
    <p class="confirmation-message">Thank you for your order. We’ll start preparing it shortly.</p>
    <a href="{{ route('frontend.menu') }}" class="back-to-home">Back to Home</a>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js" defer></script>
</body>
</html>
